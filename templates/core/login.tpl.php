<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="shortcut icon" type="images/x-icon" href="<?php echo $this->img('favicon.ico'); ?>">

    <title><?php echo $this->pageTitle; ?></title>

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
<div class="container">
    <div class="row" id="pwd-container">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <section class="login-form">

                <noscript>
                    <p><?php echo __('You must activate the JavaScript function of your browser'); ?></p>
                </noscript>

                <form method="post" action="<?php echo $this->formAction; ?>" role="login">

                    <img src="<?php echo $this->img('logo.png'); ?>" class="img-responsive" alt=""/>
                     

                    <?php if ($this->loginText): ?>
                        <?php echo $this->loginText; ?>
                    <?php endif; ?>

                    <input type="text" name="login_name" placeholder="<?php echo __('Username') ?>" required
                           class="form-control input-lg" value=""/>
                    <input type="password" class="form-control input-lg" id="password"
                           placeholder="<?php echo __('Password') ?>" name="login_password" required=""/>

                    <button type="submit" name="submit" value="<?php echo _sx('button', 'Login'); ?>" class="btn btn-lg btn-primary btn-block"><?php echo _sx('button', 'Login'); ?></button>
                    <?php if ($this->lostPassword): ?>
                        <div>
                            <a href="<?php echo $this->lostPasswordLink; ?>"><?php echo __('Forgotten password?'); ?></a>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->publicFAQ): ?>
                        <div>
                            <a href="<?php echo $this->publicFAQLink; ?>"><?php echo __('Access to the Frequently Asked Questions'); ?></a>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->hiddenInputs): ?>
                        <?php foreach ($this->hiddenInputs as $input): ?>
                            <?php echo $input; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>

                <?php Html::closeForm(); ?>

                <small>
                    <a href='http://glpi-project.org/' title='Powered By Indepnet'>
                        GLPI <?php echo isset($this->CFG_GLPI["version"]) ? 'version ' . $this->CFG_GLPI["version"] : "" ?>
                        Copyright (C) 2003-<?php echo date("Y"); ?> INDEPNET Development Team.
                    </a>
                </small>

            </section>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>
</body>
</html>

