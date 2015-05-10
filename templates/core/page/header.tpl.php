<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="shortcut icon" type="images/x-icon" href="<?php echo $this->img('favicon.ico'); ?>" >

        <title>GLPI - <?php echo $this->pageTitle; ?></title>

        <?php foreach (Html::getCssFiles() as $cssFile): ?>
            <?php echo Html::css($cssFile); ?>
        <?php endforeach; ?>

        <?php foreach (Html::getJsFiles() as $jsFile): ?>
            <?php echo Html::script($jsFile); ?>
        <?php endforeach; ?>


        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <?php if(isset($this->ajaxContainerEntities)): ?>
            <?php echo $this->ajaxContainerEntities; ?>
        <?php endif; ?>
        
        <?php if(isset($this->ajaxContainerBookmark)): ?>
            <?php echo $this->ajaxContainerBookmark; ?>
        <?php endif; ?>

        <div class="container-search">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?php echo $this->homePage; ?>"><img src="<?php echo $this->img('logo.png'); ?>" height="34" alt=""/></a>
                </div>
                <div class="navbar-form navbar-left">
                    <div class="btn-group" role="group" aria-label="...">
                        <?php if(isset($this->ajaxContainerEntities)): ?>
                            <button type="button" class="btn btn-default" onclick="entity_window.dialog('open');"><?php echo $this->currentEntityName; ?></button>
                        <?php endif; ?>
                        <?php if($this->profileSelect): ?>
                            <div class="btn-group" role="group">
                                <?php echo $this->profileSelect; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
                <?php if(isset($this->showSearch) && $this->showSearch !== false): ?>
                <form class="navbar-form navbar-right" role="search" action="<?php echo $this->CFG_GLPI["root_doc"]; ?>/front/search.php" methode="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" name="globalsearch" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
        <nav class="navbar navbar-default <?php if(!$this->breadcrumbItems): ?> spacer<?php endif; ?>">
            <div class="container">
                <ul class="nav navbar-nav">
                    <?php foreach ($this->mainMenu as $part => $data) : ?>
                        <?php if (isset($data['content']) && count($data['content'])): ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $data['title'] ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <?php foreach ($data['content'] as $key => $val): ?>
                                        <?php if (isset($val['page']) && isset($val['title'])): ?>
                                            <li>
                                                <a href="<?php echo $this->CFG_GLPI["root_doc"] . $val['page']; ?>"><?php echo $val['title']; ?></a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="glyphicon glyphicon-user"></i> <?php echo $this->currentUserName; ?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <?php foreach ($this->metaMenu as $part => $data) : ?>
                                <li role="presentation"><a role="menuitem" href="<?php echo $data['href']; ?>"><?php echo $data['title']; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        
        <?php if($this->breadcrumbItems): ?>
        <div class="glpi-breadcrumb">
             <div class="container">
                <ol class="breadcrumb">
                    <?php foreach ($this->breadcrumbItems as $item): ?>
                    <li><a href="<?php echo $item['href']; ?>"><?php echo $item['title']; ?></a></li>
                    <?php endforeach; ?>
                </ol>
             </div>
        </div>
        <?php endif; ?>
        <div class="container">
           <?php if (isset($this->isSlave) && $this->isSlave === true): ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-warning" role="alert"><?php echo __('MySQL replica: read only') ?></div>
                </div>
            </div>
            <?php endif; ?>
            <div class="row">
                <?php if($this->actionMenu): ?>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                    <div class="panel-heading"><?php echo $this->pageTitle; ?></div>
                    <div class="panel-body">
                        <div class="btn-toolbar" role="toolbar" aria-label="...">
                            <div class="btn-group" role="group" aria-label="...">
                                <?php foreach ($this->actionMenu as $item): ?>
                                    <a href="<?php echo $item['href'] ?>" class="btn btn-default" <?php echo isset($item['onClick']) && $item['onClick'] ? 'onClick="' . $item['onClick'] . '"' : '' ?>>
                                        <span class="glyphicon glyphicon-<?php echo $item['class'] ?>" aria-hidden="true"></span>
                                        <?php echo $item['title']; ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                <?php endif; ?>
            </div>