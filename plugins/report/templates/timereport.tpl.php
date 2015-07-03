

<div class="panel panel-default">
    <div class="panel-heading">

        <a href="#records_<?php echo $this->customer_id; ?>" data-toggle="collapse" aria-expanded="false" aria-controls="records_<?php echo $this->customer_id; ?>">
            Timerecords for <?php echo $this->customer; ?>
        </a>
    </div>
    <div class="panel-body collapse" id="records_<?php echo $this->customer_id; ?>">
        <?php if($this->solvedTickets): ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a data-toggle="collapse" href="#records_<?php echo $this->customer_id; ?>_solved" aria-expanded="false" aria-controls="records_<?php echo $this->customer_id; ?>_solved">Solved Tickets</a>
                    </div>
                    <div class="collapse" id="records_<?php echo $this->customer_id; ?>_solved">
                        <?php foreach($this->solvedTickets as $item): ?>
                            <div class="panel-body">
                                <strong><?php echo $item->fields['name']; ?></strong>
                            </div>
                            <?php TicketCost::showForObject($item); ?>
                        <?php endforeach; ?>
                    </div>
                </div>
        <?php endif; ?>
        <?php if($this->openTickets): ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a data-toggle="collapse" href="#records_<?php echo $this->customer_id; ?>_open" aria-expanded="false" aria-controls="records_<?php echo $this->customer_id; ?>_open">Open Tickets</a>
                    </div>
                    <div class="collapse" id="records_<?php echo $this->customer_id; ?>_open">

                        <?php foreach($this->openTickets as $item): ?>
                            <div class="panel-body">
                                <strong><?php echo $item->fields['name']; ?></strong>
                            </div>
                            <?php TicketCost::showForObject($item); ?>
                        <?php endforeach; ?>
                    </div>
                </div>
        <?php endif; ?>

    </div>
</div>
