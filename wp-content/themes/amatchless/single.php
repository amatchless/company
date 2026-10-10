<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

<div class="post-hero">
  <div class="container">
    <?php
    $cats = get_the_category();
    if ($cats) echo '<div class="post-cat">' . esc_html($cats[0]->name) . '</div>';
    ?>
    <h1 class="post-h1"><?php the_title(); ?></h1>
    <div class="post-meta">
      <span><?php echo get_the_date(); ?></span>
      <span>By <?php the_author(); ?></span>
      <span><?php echo get_the_time('g:i A'); ?></span>
    </div>
  </div>
</div>

<div class="post-body container">
  <?php if (has_post_thumbnail()) : ?>
  <div style="margin-bottom:40px;border-radius:12px;overflow:hidden"><?php the_post_thumbnail('large', ['style' => 'width:100%;height:auto']); ?></div>
  <?php endif; ?>
  <?php the_content(); ?>

  <div style="margin-top:48px;padding-top:32px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px">
    <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="btn btn-ghost" style="font-size:13px">&larr; All Insights</a>
    <div style="display:flex;gap:12px;flex-wrap:wrap">
      <?php
      $prev = get_previous_post();
      $next = get_next_post();
      if ($prev) echo '<a href="' . esc_url(get_permalink($prev)) . '" class="btn btn-ghost" style="font-size:13px">&larr; Previous</a>';
      if ($next) echo '<a href="' . esc_url(get_permalink($next)) . '" class="btn btn-outline" style="font-size:13px">Next &rarr;</a>';
      ?>
    </div>
  </div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
