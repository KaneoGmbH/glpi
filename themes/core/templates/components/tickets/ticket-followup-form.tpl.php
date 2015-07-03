<?php if ($this->caneditall || $this->canadd): ?>
       <div id='viewfollowup<?php echo $this->tID.$this->rand; ?>'></div>
<?php endif; ?>

      <?php if ($this->canadd): ?>
         <script type='text/javascript'>
         <?php 
         echo "function viewAddFollowup" . $this->ticket->fields['id'] . "$this->rand() {\n";
         $params = array('type'       => $this->CLASS,
                         'parenttype' => 'Ticket',
                         'tickets_id' => $this->ticket->fields['id'],
                         'id'         => -1);
         Ajax::updateItemJsCode("viewfollowup" . $this->ticket->fields['id'] . "$this->rand",
                                $this->CFG_GLPI["root_doc"]."/ajax/viewsubitem.php", $params);
         echo Html::jsHide('addbutton'.$this->ticket->fields['id'] . "$this->rand");
         echo "};";
         ?>
         </script>
   
         <?php if (!in_array($this->ticket->fields["status"], array_merge($this->ticket->getSolvedStatusArray(), $this->ticket->getClosedStatusArray())) || $this->reopen_case): ?>
            
         <?php
            if (isset($_GET['_openfollowup']) && $_GET['_openfollowup']) {
               echo Html::scriptBlock("viewAddFollowup".$this->ticket->fields['id']."$this->rand()");
            } else {
               echo "<div id='addbutton".$this->ticket->fields['id'] . "$this->rand' class='center firstbloc'>".
                    "<a class='btn btn-info btn-xs' href='javascript:viewAddFollowup".$this->ticket->fields['id'].
                                              "$this->rand();'>";
               if ($reopen_case) {
                  _e('Reopen the ticket');
               } else {
                  _e('Add a new followup');
               }
               echo "</a></div>\n";
            }
            ?>
         <?php endif; ?>
    
      <?php endif; ?>