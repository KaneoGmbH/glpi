<nav>
    <ul class="pagination">
        <?php foreach($this->pagination as $item): ?>
            <li <?php echo $item['class'] ? 'class="'.$item['class'].'"' : '' ?>>
                <a href="<?php echo $item['href']; ?>"><?php echo $item['icon'] ? '<span aria-hidden="true" class="'.$item['icon'].'"></span>' : $item['title']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

