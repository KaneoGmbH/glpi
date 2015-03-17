<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="shortcut icon" type="images/x-icon" href="<?php echo $this->CFG_GLPI["root_doc"]; ?>/pics/favicon.ico">

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
                <form method="post" action="#" role="login">
                    <img src="/pics/login_logo_glpi.png" class="img-responsive" alt=""/>
                    <input type="email" name="email" placeholder="Email" required class="form-control input-lg"
                           value="joestudent@gmail.com"/>
                    <input type="password" class="form-control input-lg" id="password" placeholder="Password"
                           required=""/>

                    <div class="pwstrength_viewport_progress"></div>
                    <button type="submit" name="go" class="btn btn-lg btn-primary btn-block">Sign in</button>
                    <div>
                        <a href="#">Create account</a> or <a href="#">reset password</a>
                    </div>
                </form>
                <div class="form-links">
                    <a href="#">www.website.com</a>
                </div>
            </section>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>
</body>
</html>