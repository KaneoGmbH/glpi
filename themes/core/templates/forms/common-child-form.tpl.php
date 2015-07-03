<form action='<?php echo $this->action; ?>' method='post'>
    
    <h4><?php echo __('New child heading'); ?></h4>
    
    <div class="form-group">
        <label><?php echo __('Name'); ?></label>
        <?php Html::autocompletionTextField($this, "name", array('value' => '')); ?>
    </div>

<input type='submit' name='add' value="<?php echo _sx('button', 'Add'); ?>" class='btn btn-primary'>


<?php if ($this->entity_assign && ($this->class->getForeignKeyField() != 'entities_id')): ?>
   <input type='hidden' name='entities_id' value='<?php echo $_SESSION['glpiactive_entity']; ?>'>
<?php endif; ?>

<?php if  ($this->class->entity_assign && $this->isRecursive()): ?>
   <input type='hidden' name='is_recursive' value='1'>
<?php endif; ?>
<input type='hidden' name='<?php echo $this->class->getForeignKeyField(); ?>' value='<?php echo $this->id; ?>'>

<?php Html::closeForm(); ?>