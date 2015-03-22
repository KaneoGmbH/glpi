<h2><?php echo $this->entityName; ?></h2>
<p><?php echo __('Back to'); ?>: <a href="<?php echo $this->listUrl; ?>"><?php echo $this->listTitle; ?></a><br>
<?php echo __('Item') ?>: <?php echo $this->itemsCurrent; ?> / <?php echo $this->itemsTotal; ?></p>
<nav>
    <ul class="pager">
        <?php foreach($this->buttons as $button): ?>
            <li class="<?php echo $button['class']; ?>"><a href="<?php echo $button['href']; ?>"><?php echo $button['title']; ?></a></li>
        <?php endforeach; ?>
    </ul>
</nav>
<hr>