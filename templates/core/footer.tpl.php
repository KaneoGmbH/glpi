</div>
<footer>
    <div class="row">
        <div class="container-fluid">
            <div class=""></div>
            <div class=""></div>
        </div>
    </div>
    <div class="row">
        <div class="container-fluid">

            <a href='http://glpi-project.org/'><span class="copyright">GLPI <?php echo $this->CFG_GLPI["version"] ?> Copyright (C) 2003-<?php echo date("Y") ?> by the INDEPNET Development Team.</span></a>
        </div>
    </div>

    <div class="row">
        <div class="container-fluid">
            <?php if (isset($this->maintenance_mode) && $this->maintenance_mode === true): ?>
                GLPI MAINTENANCE MODE
            <?php endif; ?>
        </div>
    </div>
    <?php if ($this->glpi_use_mode == Session::DEBUG_MODE): ?>
        <div class="row">
            <div class="container-fluid">
                <?php Html::displayDebugInfos(); ?>
            </div>
        </div>
    <?php endif; ?>
</footer>

</body>
</html>

