<!-- cdn for modernizr, if you haven't included it already -->
<script src="http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>
<!-- polyfiller file to detect and load polyfills -->
<script src="http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js"></script>
<script>
    webshims.setOptions('waitReady', false);
    webshims.setOptions('forms-ext', {types: 'date'});
    webshims.polyfill('forms forms-ext');
</script>

<h1>Timereport <small><?php echo $this->startDate->format('d.m.Y'); ?> to <?php echo $this->endDate->format('d.m.Y'); ?></small>
</h1>
<div class="panel panel-default">
    <div class="panel-body">

        <form class="form-inline">
            <div class="form-group">
                <label>From</label>
                <input type="date" class="form-control" name="startDate" value="<?php echo $this->startDate->format('m/d/Y'); ?>">
            </div>
            <div class="form-group">
                <label>To</label>
                <input type="date" class="form-control" name="endDate" value="<?php echo $this->endDate->format('m/d/Y'); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Show reports</button>
        </form>

    </div>
</div>
<small></small>
