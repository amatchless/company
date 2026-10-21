<?php
// One article card. $args: thumb (from inc/blog-thumbs.php), wide (lead card), class (extra classes).
$t     = $args['thumb'];
$wide  = !empty($args['wide']);
$cats  = get_the_category();
?>
<a class="pcard<?php echo $wide ? ' pcard-wide' : ''; ?><?php echo !empty($args['class']) ? ' ' . esc_attr($args['class']) : ''; ?>" href="<?php the_permalink(); ?>">
  <div class="pcard-media <?php echo esc_attr($t['class']); ?>">
    <?php if (has_post_thumbnail()) : the_post_thumbnail($wide ? 'large' : 'medium_large', ['alt' => '', 'sizes' => $wide ? '(min-width: 900px) 640px, 100vw' : '(min-width: 1100px) 384px, (min-width: 700px) 50vw, 100vw']); else : ?><span class="bthumb"><?php echo $t['svg']; ?></span><?php endif; ?>
  </div>
  <div class="pcard-body">
    <div class="pmeta"><span class="cat"><?php echo esc_html($cats ? $cats[0]->name : 'Blog'); ?></span><span><?php echo esc_html(get_the_date()); ?></span><span><?php echo esc_html(amatchless_read_time()); ?></span></div>
    <<?php echo $wide ? 'h2' : 'h3'; ?>><?php the_title(); ?></<?php echo $wide ? 'h2' : 'h3'; ?>>
    <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), $wide ? 40 : 22, '…')); ?></p>
    <span class="rd">Read article →</span>
  </div>
</a>
