<div class="panel panel-default">
  <div class="panel-body">
    <form class="form-inline">
      <div class="form-group">
        <?php Html::showDateField('startdate',array('value' => $this->startdate->format('Y-m-d H:i:s'))); ?>
      </div>
      <div class="form-group">
        <?php Html::showDateField('enddate',array('value' => $this->enddate->format('Y-m-d H:i:s'))); ?>
      </div>
      <button type="submit" class="btn btn-primary">Absenden</button>
    </form>
  </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h2>Tickets für <?php echo $this->customer; ?> <small>vom <?php echo $this->startdate->format('d.m.Y'); ?> bis <?php echo $this->enddate->format('d.m.Y'); ?></small></h2>
    </div>
      <?php foreach(array('getTicketNotInvoiced','getTicktsToBeInvoived','getTicktsMayBeInvoiced') as $method): ?>
        <?php $data = $this->reports->{$method}(); ?>

          <div class="panel-body">
          <h3><?php echo $data['headline']; ?></h3>
          <p><?php echo $data['description']; ?></p>
          </div>
          <?php if($data['items']->tickets): ?>
          <table class="table table-striped">
            <thead>
              <tr>
                <th class="col-md-6">Name</th>
                <th class="col-md-1">Eingeganen</th>
                <th class="col-md-1">Erledigt</th>
                <th class="col-md-1">Geschlossen</th>
                <th class="col-md-1">Status</th>
                <th class="col-md-1">Typ</th>
                <!-- <th class="col-md-1">SLA</th> -->
                <!-- <th class="col-md-1 text-right">Kosten</th> -->
                <th class="col-md-1 text-right">Aufwand</th>

              </tr>
            </thead>
            <tfoot>
              <tr class="summary" style="border-top:1px double black;">
                <th colspan="6" class="">Total</th>
                <th colspan="1" class="text-right"><?php echo $data['items']->actiontime; ?></th>
              </tr>
            </tfoot>
            <tbody>
            <?php foreach($data['items']->tickets as $item): ?>
              <tr>
                <td><a href="<?php echo $this->CFG_GLPI["root_doc"] ?>/front/ticket.form.php?id=<?php echo $item->fields['id']; ?>"><?php echo $item->fields['name']; ?></a></td>
                <td><?php echo Html::convDate($item->fields['date']); ?></td>
                <td><?php echo Html::convDate($item->fields['solvedate']); ?></td>
                <td><?php echo Html::convDate($item->fields['closedate']); ?></td>
                <td><?php echo Ticket::getStatus($item->fields['status']); ?></td>
                <td><?php echo Ticket::getTicketTypeName( $item->fields['type']); ?></td>
                <!-- <td><?php // echo $item->fields['slas_id']; ?></td> -->
                <!-- <td class="text-right"><?php echo round($item->fields['costs']['actiontime'] / (60 * 60),2); ?></td> -->
                <td class="text-right"><?php echo round($item->fields['actiontime'] / (60 * 60),2); ?></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
            </table>
            <?php else: ?>
              <div class="panel-body">
              <p class="alert alert-success">Keine Tickets vorhanden</p>
            </div>
            <?php endif; ?>

      <?php endforeach; ?>
</div>
