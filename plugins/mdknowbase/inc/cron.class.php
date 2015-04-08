<?php

include (dirname(__FILE__)."/lib/parsedown.php");


class PluginMdknowbaseCron extends CronTask {

    /**
     * @var string string to the file based document root
     */
    static $documentPath;
    static $documentPathWeb;
    
    static $currentCategories;
    static $currentItems;
    /**
     * @return int error level
     */
    static function cronParser(){

        self::$documentPath = GLPI_ROOT.'/files/_plugins/mdknowbase/';
        self::$documentPathWeb = '/files/_plugins/mdknowbase/';
        
        try{
            
            $currentItems = new KnowbaseItem();
            self::$currentItems = $currentItems->find();
            
            $dir_iterator = new RecursiveDirectoryIterator(self::$documentPath);
            $iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);

            /** @var $file SplFileInfo */
            foreach ($iterator as $file) {
                if ($file->isFile() && ($file->getExtension() == 'md' || $file->getExtension() == 'markdown')) {
                    self::createItemInCategory($file);
                }
            }
            return 1;
        }catch (Exception $e){
            die($e->getMessage());
        }

    }

    static function createCategory($path){
        $glpiCategory = new KnowbaseItemCategory();
   
        $relPath = str_replace(self::$documentPath, '', $path) ;
        $categoriesPath = explode('/', $relPath);
        $completename = implode(' > ',$categoriesPath);      
        
      
        
        /**
         * Create categories
         */
        $parent = 0;
        $level = 1;
        $categoryId = 0;
   
        /**
         * Check if already there
         */
        $query = 'WHERE completename = "'.$completename .'" and level = '.$level;
        $exists = $glpiCategory->getFromDBByQuery($query);
   
        if($exists){
            return $glpiCategory->fields['id'];
        }
        
        if(count($categoriesPath)){
           
            foreach($categoriesPath as $category){
                $createdPath[] = $category;
               
                $glpiCategory = new KnowbaseItemCategory();
                $conditions = ' WHERE completename = "'.implode(' > ',$createdPath) .'" and level = '.count($createdPath);

                $exists = $glpiCategory->getFromDBByQuery($conditions);
                if($exists){
                    $categoryId = $glpiCategory->fields['id'];
                    continue;
                }
                $item = array(
                    'knowbaseitemcategories_id' => $categoryId,
                    'name' => $category,
                    'completename' => implode(' > ',$createdPath),
                    'level' => count($createdPath)
                );  

                $newCategory = new KnowbaseItemCategory();
                $categoryId = $newCategory->add($item);         
            }

            
        }else{
            
            $categoryName = array_pop($categoriesPath);
            $conditions = 'WHERE completename = "'.$categoryName .'" and level = '.$level; 
            $exists = $glpiCategory->getFromDBByQuery($conditions);
            if($exists){
                return $glpiCategory->fields['id'];
            }else{
                $item = array(
                    'knowbaseitemcategories_id' => $parent,
                    'name' => $categoryName,
                    'completename' => $categoryName,
                    'level' => $level
                );    
                $newCategory = new KnowbaseItemCategory();
                $categoryId = $newCategory->add($item); 
                
            }
        }
        
        return $categoryId;
    }
    /**
     * @param $file SplFileInfo
     * @throws Exception
     */
    static function createItemInCategory($file){


        if($file->isReadable()){
            
            /**
             * Create category
             */
            $categoryId = self::createCategory($file->getPath());
            
            /**
             * Convert Markdown to html
             */
            $content = file_get_contents($file->getRealPath());
            $parser = new Parsedown();
            $content = $parser->text($content);
            $content = str_replace('_IMG_',self::$documentPathWeb,$content);
            
            $newKnowbaseItem = new KnowbaseItem();
            
            $itemName = $file->getBasename('.md');
            $itemName = str_replace(array('-','_'),' ',$itemName);
            $itemName = preg_replace('/\s+/', ' ',$itemName);
            
            /**
             * check if exists
             */
            

            $conditions = 'WHERE knowbaseitemcategories_id = '.$categoryId .' and name like "'.$itemName.'" LIMIT 1'; 
            
            $exists = $newKnowbaseItem->getFromDBByQuery($conditions);
            
            if($exists){
                
                $id = $newKnowbaseItem->fields['id'];
                $newKnowbaseItem->fields['answer'] = $content;
                $newKnowbaseItem->updateInDB(array('answer'));
                unset(self::$currentItems[$id]);
        
            }else{
                $itemData = array(
                        'knowbaseitemcategories_id' => $categoryId,
                        'name' => $itemName,
                        'answer' => $content,
                        'is_faq' => '0',
                        'view' => '0',
                        'date' => '',
                        'date_mod' => ''
                    );    
                $id = $newKnowbaseItem->add($itemData);
            }
            
            /**
             * add default visibility to root
             */
            $_visibility = array(
                '_type' => 'Entity',
                'knowbaseitems_id' => $id,
                'entities_id' => 0
            );
            $item = new Entity_KnowbaseItem();
            $item->add($_visibility);  
            
            
        }else{
            throw new Exception('File is not readable: '.$file->getPathInfo());
        }
        
        
    }
}