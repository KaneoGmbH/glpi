<div class="row spacer">
    <div class="col-md-8">
        <div class="panel panel-default">   
            <?php if (Session::haveRight('ticket', CREATE)): ?>
                <?php Ticket::showCentralCount(true); ?>
                <?php Ticket::showCentralList(0, "survey", false); ?>
            <?php endif; ?>
        </div>
        <?php if (Session::haveRight("rssfeed_public", READ)): ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">News</h3>
                </div>
                <div class="panel-body">
                    <?php RSSFeed::showListForCentral(false); ?>
                </div>
            </div>
        <?php endif; ?>
        
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
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

