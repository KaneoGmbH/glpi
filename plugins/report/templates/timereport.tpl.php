
<a href="#records_<?php echo $this->customer_id; ?>" data-toggle="collapse" aria-expanded="false" aria-controls="records_<?php echo $this->customer_id; ?>">
    <h3>Timerecords for <?php echo $this->customer; ?></h3>
</a>

<div class="row collapse" id="records_<?php echo $this->customer_id; ?>">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">Solved Tickets</div>

                <?php if($this->solvedTickets): ?>
                    <?php foreach($this->solvedTickets as $item): ?>

                        <?php if(isset($item['time-records'])): ?>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th colspan="2"><?php echo $item['name']; ?></th>
                                </tr>
                                </thead>
                                <?php foreach($item['time-records'] as $timeRecord): ?>
                                    <tr>
                                        <td class="col-md-2"><?php echo date('d.m.Y h:i',  strtotime($timeRecord['task_date'])); ?></td>
                                        <td class="col-md-2"><?php echo $timeRecord['task_actiontime']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php endif; ?>
                    <?php endforeach; ?>

                <?php else: ?>
                    Keine Tickets in diesem Zeitraum vorhanden
                <?php endif; ?>

        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">Open Tickets</div>

                <?php if($this->openTickets): ?>
                    <?php foreach($this->openTickets as $item): ?>

                        <?php if(isset($item['time-records'])): ?>


                            <table class="table">
                                <thead>
                                <tr>
                                    <th colspan="2"><?php echo $item['name']; ?></th>
                                </tr>
                                </thead>
                                <?php foreach($item['time-records'] as $timeRecord): ?>
                                    <tr>
                                        <td class="col-md-2"><?php echo date('d.m.Y h:i',  strtotime($timeRecord['task_date'])); ?></td>
                                        <td class="col-md-2"><?php echo $timeRecord['task_actiontime']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php endif; ?>
                    <?php endforeach; ?>

                <?php else: ?>
                    Keine Tickets in diesem Zeitraum vorhanden
                <?php endif; ?>
        </div>
    </div>
</div>