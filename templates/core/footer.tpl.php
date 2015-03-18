</div>
<footer>
    <div class="row">
        <div class="container">
            <div class=""></div>
            <div class=""></div>
        </div>
    </div>
    <div class="row">
        <div class="container">

            <a href='http://glpi-project.org/'><span class="copyright">GLPI <?php echo $this->CFG_GLPI["version"] ?> Copyright (C) 2003-<?php echo date("Y") ?> by the INDEPNET Development Team.</span></a>
        </div>
    </div>

    <div class="row">
        <div class="container">

            <?php if ($this->glpi_use_mode == Session::TRANSLATION_MODE): ?>
                GLPI TRANSLATION MODE
            <?php elseif ($this->glpi_use_mode == Session::DEBUG_MODE): ?>
                GLPI DEBUG MODE
            <?php elseif ($this->maintenance_mode === true): ?>
                GLPI MAINTENANCE MODE
            <?php endif; ?>
        </div>
    </div>
</footer>

</body>
</html>


<?php
// Html::displayDebugInfos(); ?>