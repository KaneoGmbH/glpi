<?php if($this->items): ?>
    <?php foreach($this->items as $item): ?>
        <div class="media">
          <div class="media-body">
              <h4 class="media-heading">
                  <?php echo $item->get_title(); ?><br />
                  <small><?php echo HTML::convDateTime($item->get_date('Y-m-d H:i:s')); ?></small>
              </h4>
            <?php echo Html::resume_text(Html::clean(Toolbox::unclean_cross_side_scripting_deep($item->get_content())), 300); ?>
            <?php if($item->feed->get_permalink()): ?>
                <a href="<?php echo $item->get_permalink(); ?>">more..</a>
            <?php endif; ?>
          </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>