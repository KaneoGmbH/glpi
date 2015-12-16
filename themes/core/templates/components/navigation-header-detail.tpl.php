<strong><a href="<?php echo $this->listUrl; ?>"><i class="glyphicon glyphicon-arrow-left"></i> Zurück</a></strong>

<h4><?php echo $this->entityName; ?></h4>

<p><?php echo __('Item') ?>: <?php echo $this->itemsCurrent; ?> / <?php echo $this->itemsTotal; ?></p>
<nav>
    <ul class="pager">
        <?php foreach($this->buttons as $button): ?>
            <li class="<?php echo $button['class']; ?> btn-xs"><a href="<?php echo $button['href']; ?>"><?php echo $button['title']; ?></a></li>
        <?php endforeach; ?>
    </ul>
</nav>