<?php

/**
* 
* Plugin to generate an <img ... /> tag.
* 
* @package Savant3
* 
* @author Paul M. Jones <pmjones@ciaweb.net>
* 
* @license http://www.gnu.org/copyleft/lesser.html LGPL
* 
* @version $Id: Savant3_Plugin_image.php,v 1.7 2005/08/12 14:34:09 pmjones Exp $
*
*/

/**
* 
* Plugin to generate an <img ... /> tag.
*
* Support for alpha transparency of PNG files in Microsoft IE added by
* Edward Ritter; thanks, Edward.
* 
* @package Savant3
* 
* @author Paul M. Jones <pmjones@ciaweb.net>
* 
*/

class Savant3_Plugin_img extends Savant3_Plugin {
	
	
	protected $documentRoot = null;
	
	protected $imageDir = null;
	
	public function img($file){
		// is the document root set?
		if (is_null($this->documentRoot) && isset($_SERVER['DOCUMENT_ROOT'])) {
			// no, so set it
			$this->documentRoot = $_SERVER['DOCUMENT_ROOT'];
		}
		
		// make sure there's a DIRECTORY_SEPARATOR between the docroot
		// and the image dir
		if (substr($this->documentRoot, -1) != DIRECTORY_SEPARATOR &&
			substr($this->imageDir, 0, 1) != DIRECTORY_SEPARATOR) {
			$this->documentRoot .= DIRECTORY_SEPARATOR;
		}
		
		// make sure there's a separator between the imageDir and the
		// file name
		if (substr($this->imageDir, -1) != DIRECTORY_SEPARATOR &&
			substr($file, 0, 1) != DIRECTORY_SEPARATOR) {
			$this->imageDir .= DIRECTORY_SEPARATOR;
		}
		
		// the image file type code (PNG = 3)
		$type = null;
		
		// get the file information
		$info = false;
		
		if (strpos($file, '://') === false) {
			// no "://" in the file, so it's local
			$file = $this->imageDir . $file;
			$tmp = $this->documentRoot . $file;
			$info = @getimagesize($tmp);
		} else {
			// don't attempt to get file info from streams, it takes
			// way too long.
			$info = false;
		}
		return htmlspecialchars($file);
                
	}
}