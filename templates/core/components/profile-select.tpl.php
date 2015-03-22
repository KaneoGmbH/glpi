<?php if ($this->profiles): ?>
    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">Profile <?php echo $this->currentProfile ? '( '.$this->currentProfile.' )' : '' ?>
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <?php foreach ($this->profiles as $profile): ?>
            <li role="presentation" <?php echo $profile['class'] ? 'class="' . $profile['class'] . '"' : ''; ?>><a href="<?php echo $profile['href']; ?>"><?php echo $profile['title']; ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

