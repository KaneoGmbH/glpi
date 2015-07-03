<div class="row">
    <div class="col-md-<?php echo $this->isTech ? '8' : '12' ?>">
        <div class="form-group">
          <label><?php echo __('Description'); ?></label>
          <textarea class='form-control'  name='content' cols='80' rows='6'><?php echo $this->class->fields["content"]; ?></textarea>
        </div>      
    </div>


<?php if ($this->isTech) : ?>
    <div class="col-md-4">
        <?php if ($this->class->fields["date"]): ?>
            <div class="form-group">
               <label><?php echo __('Date'); ?></label>
               <?php echo Html::convDateTime($this->class->fields["date"]); ?>
            </div>
        <?php endif; ?>

        <div class="form-group">
            <label><?php echo __('Source of followup'); ?></label>
            <?php RequestType::dropdown(array('value' => $this->class->fields["requesttypes_id"])); ?>
        </div>
        <div class="form-group">
            <label><?php echo __('Private'); ?></label>
            <?php Dropdown::showYesNo('is_private', $this->class->fields["is_private"]); ?>
        </div>
    </div>
<?php else: ?>
    <input type='hidden' name='requesttypes_id' value='<?php RequestType::getDefault('helpdesk'); ?>'>
<?php endif; ?>
       
<?php if ($this->reopen_case): ?>
    <input type='hidden' name='add_reopen' value='1'>
<?php endif; ?> 
    
<input type='hidden' name='tickets_id' value='<?php echo $this->class->fields["tickets_id"]; ?>'>

</div>