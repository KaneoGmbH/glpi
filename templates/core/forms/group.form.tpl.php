<div class="form-group">
    <label><?php echo __('Name'); ?></label>
    <?php Html::autocompletionTextField($this->GroupClass, "name"); ?>
</div>

<div class="form-group">
    <label><?php echo __('Comments'); ?></label>
    <?php echo "<textarea class='form-control'  cols='45' rows='8' name='comment' >" . $this->GroupClass->fields["comment"] . "</textarea>"; ?>
</div>

<div class="form-group">
    <label> <?php echo __('As child of'); ?></label>
    <?php
    $this->GroupClass->dropdown(array('value' => $this->GroupClass->fields['groups_id'],
        'name' => 'groups_id',
        'entity' => $this->GroupClass->fields['entities_id'],
        'used' => (($this->id > 0) ? getSonsOf($this->GroupClass->getTable(), $this->id) : array())));
    ?>
</div>

<div class="row">
   <div class="col-md-6">
   <h4><?php echo __('Visible in a ticket'); ?></h4>

<div class="form-group">
    <label><?php echo __('Requester'); ?></label>
    <?php Dropdown::showYesNo('is_requester', $this->GroupClass->fields['is_requester']); ?>
</div>

<div class="form-group">
    <label><?php echo __('Assigned to'); ?></label>
    <?php Dropdown::showYesNo('is_assign', $this->GroupClass->fields['is_assign']); ?>
</div>

<div class="form-group">
    <label><?php echo __('Can be notified'); ?></label>
    <?php Dropdown::showYesNo('is_notify', $this->GroupClass->fields['is_notify']); ?>
</div>

<div class="form-group">
    <label><?php echo __('Requester'); ?></label>
    <?php Dropdown::showYesNo('is_requester', $this->GroupClass->fields['is_requester']); ?>
</div>
 
</div>
<div class="col-md-6">
    
<h4><?php echo __('Visible in a project'); ?></h4>


<div class="form-group">
    <label><?php echo __('Can be manager'); ?></label>
    <?php Dropdown::showYesNo('is_manager', $this->GroupClass->fields['is_manager']); ?>
</div>

<div class="form-group">
    <label><?php echo __('Can contain'); ?> <?php echo _n('Item', 'Items', Session::getPluralNumber()); ?></label>
    <?php Dropdown::showYesNo('is_itemgroup', $this->GroupClass->fields['is_itemgroup']); ?>
</div>

<div class="form-group">
    <label> <?php echo __('Can contain'); ?> <?php echo _n('User', 'Users', Session::getPluralNumber()); ?></label>
<?php Dropdown::showYesNo('is_usergroup', $this->GroupClass->fields['is_usergroup']); ?>
</div>

</div> 
</div>


