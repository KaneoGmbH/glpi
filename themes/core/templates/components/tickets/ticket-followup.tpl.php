<?php

            echo "<div class='media $this->color' id='view$this->id'>";

            echo "<div class='media-left'>";
            echo "<img class='media-object img-circle' alt=\"".__s('Picture')."\" src='".
                User::getThumbnailURLForPicture($this->data['picture'])."'>";
            echo "</div>"; // boxnoteleft

            echo "<div class='media-body'>";
            
            echo '<div class="row">';
            echo '<div class="col-md-8">';
            echo "<h4 class='media-heading'><small>";

            echo $this->name;
            echo "</small></h4>"; // floatright
            echo '</div>';
            echo '<div class="col-md-4 text-right">';
            if ($this->candelete) {
               Html::showSimpleForm(Toolbox::getItemTypeFormURL('TicketFollowup'),
                                    array('purge' => 'purge'),
                                    _x('button', 'Delete permanently'),
                                    array('id' => $this->data['id']),
                                    'glyphicon glyphicon-remove',
                                    '',
                                     __('Confirm the final deletion?'));
            }
            if ($this->canedit) {
                echo "<button type='button' class='btn btn-default btn-xs' onClick=\"viewEditFollowup".$this->ticket->fields['id'].$this->data['id']."$this->rand(); ".Html::jsHide("view$this->id")." ".Html::jsShow("viewfollowup" . $this->ticket->fields['id'].$this->data["id"]."$this->rand")."\">";
                echo '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit';
                echo '</button>';                        
            }
            echo '</div>';
            echo '</div>';
            

            $content = nl2br($this->data['content']);
            if (empty($content)) $content = NOT_AVAILABLE;
            
            echo $content;

            echo "</div>"; // boxnotecontent
            echo "</div>"; // boxnote
            if ($this->canedit) {
               echo "<div id='viewfollowup" . $this->ticket->fields['id'].$this->data["id"]."$this->rand' class='starthidden'></div>\n";

               echo "\n<script type='text/javascript' >\n";
               echo "function viewEditFollowup". $this->ticket->fields['id'].$this->data["id"]."$this->rand() {\n";
               $params = array('type'       => $this->CLASS,
                              'parenttype' => 'Ticket',
                              'tickets_id' => $data["tickets_id"],
                              'id'         => $data["id"]);
               Ajax::updateItemJsCode("viewfollowup" . $this->ticket->fields['id'].$this->data["id"]."$this->rand",
                                    $this->CFG_GLPI["root_doc"]."/ajax/viewsubitem.php", $params);
               echo "};";
               echo "</script>\n";
            }
            