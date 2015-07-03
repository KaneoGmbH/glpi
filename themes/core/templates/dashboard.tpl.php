<div class="row spacer">
    <div class="col-md-12">
        <?php echo $this->central->showSecurityMessages(); ?>
    </div>
</div>

<div class="row spacer">
    <div class="col-md-8">

        <div role="tabpanel" class="spacer">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#personal" aria-controls="personal" role="tab" data-toggle="tab">Personal view</a></li>
                <li role="presentation"><a href="#group" aria-controls="group" role="tab" data-toggle="tab">Group view</a></li>
                <li role="presentation"><a href="#global" aria-controls="global" role="tab" data-toggle="tab">Global view</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="personal">
                      <?php echo $this->central->showMyView(); ?>   
                </div>
                <div role="tabpanel" class="tab-pane" id="group">
                    <?php echo $this->central->showGroupView(); ?>
                </div>
                <div role="tabpanel" class="tab-pane" id="global">
                    <?php echo $this->central->showGlobalView(); ?>
                </div>
            </div>
        </div>
           <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">News</h3>
            </div>
            <div class="panel-body">
            <?php echo $this->central->showRSSView(); ?>
                </div>
        </div>
        
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Planning</h3>
            </div>
            <?php Planning::showCentral(Session::getLoginUserID()); ?>
            <?php Reminder::showListForCentral(); ?>
            <?php if (Session::haveRight("reminder_public", READ)): ?>
                <?php Reminder::showListForCentral(false); ?>
            <?php endif; ?>
        </div>
        <?php if (Session::haveRight('knowbase', KnowbaseItem::READFAQ)): ?>
            <div class="panel panel-default">
                <div class="panel-heading panel-title">
                    <?php echo __('Knowledge base'); ?>
                </div>
                <?php KnowbaseItem::showRecentPopular("popular"); ?>
                <?php // KnowbaseItem::showRecentPopular("recent"); ?>
                <?php // KnowbaseItem::showRecentPopular("lastupdate"); ?>
            </div>
        <?php endif; ?> 
    </div>
</div>