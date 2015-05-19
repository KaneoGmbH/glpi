<h4><?php echo sprintf(__('Sons of %s'),$this->class->getTreeLink()); ?></h4>

    <table class="table">
        <thead>
            <?php foreach($this->tableHeader as $header): ?>
              <th><?php echo $header; ?></th>
            <?php endforeach; ?>
        </thead>

        <?php foreach ($this->data as $data): ?>
         
         <tr>
            <td><a href='<?php echo $this->class->getFormURL().'?id='.$data['id'] ?>'><?php echo $data['name']; ?></a></td>
            <?php if ($this->entity_assign): ?>
               <td><?php Dropdown::getDropdownName("glpi_entities", $data["entities_id"]); ?></td>
            <?php endif; ?>

            <?php foreach ($this->fields as $field): ?>
               <?php if ($field['list']): ?>
                  <td>
                  <?php switch ($field['type']) { 
                     case 'UserDropdown' : 
                        echo getUserName($data[$field['name']]);
                        break;

                     case 'bool' :
                        echo Dropdown::getYesNo($data[$field['name']]);
                        break;

                     case 'dropdownValue' :
                        echo Dropdown::getDropdownName(getTableNameForForeignKeyField($field['name']),
                                                       $data[$field['name']]);
                        break;

                     default:
                        echo $data[$field['name']];
                  }
                 ?>
               <?php endif; ?>
            <?php endforeach; ?>
            <td><?php echo $data['comment']; ?></td>
         </tr>
         <?php endforeach; ?>
         
    </table>