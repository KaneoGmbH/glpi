<div class="row">
    <div class="col-md-6">
        <?php if($this->pagerText): ?>
            <span class="label label-default"><?php echo $this->pagerText; ?></span>
        <?php endif; ?>
        <?php if($this->additionanInfo): ?>
            <?php echo $this->additionanInfo; ?>
        <?php endif; ?>
       
      <?php Html::printPagerForm($this->printPageFormParam); ?>
    </div>

    <div class="col-md-6 text-right">
        <?php if($this->pagination): ?>
        <nav>
            <ul class="pagination">
                <?php foreach($this->pagination as $item): ?>
                    <li <?php echo $item['class'] ? 'class="'.$item['class'].'"' : '' ?>>
                        <a href="<?php echo $item['href']; ?>"><?php echo isset($item['icon']) ? '<span aria-hidden="true" class="'.$item['icon'].'"></span>' : $item['title']; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
</div>