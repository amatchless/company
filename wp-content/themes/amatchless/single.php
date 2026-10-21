<?php get_header(); ?>

<?php while (have_posts()) : the_post();
  $cats     = get_the_category();
  $blog_url = amatchless_blog_url();
?>
<article>
  <section class="page-head page-head-sm">
    <div class="blob page-blob" aria-hidden="true"></div>
    <div class="sec-in">
      <?php if ($cats) : ?>
      <a class="pill-dark pill-link" href="<?php echo esc_url(get_category_link($cats[0])); ?>"><?php echo esc_html($cats[0]->name); ?></a>
      <?php else : ?>
      <span class="pill-dark">Blog</span>
      <?php endif; ?>
      <h1 class="h1 h1-post"><?php the_title(); ?></h1>
      <div class="pmeta">
        <span><?php echo esc_html(get_the_date()); ?></span><span>·</span>
        <span>By <?php echo esc_html(amatchless_author_name()); ?></span><span>·</span>
        <span><?php echo esc_html(amatchless_read_time()); ?></span>
      </div>
      <?php if (has_post_thumbnail()) : ?>
      <div class="post-thumb"><?php the_post_thumbnail('large'); ?></div>
      <?php endif; ?>
    </div>
  </section>
  <div class="sec-in">
    <div class="prose">
      <?php the_content(); ?>
      <?php $tags = get_the_tags(); if ($tags) : ?>
      <nav class="chips post-tags" aria-label="Topics">
        <?php foreach ($tags as $tag) : ?><a class="chip" href="<?php echo esc_url(get_tag_link($tag)); ?>">#<?php echo esc_html($tag->name); ?></a><?php endforeach; ?>
      </nav>
      <?php endif; ?>
      <?php get_template_part('template-parts/post-author'); ?>
      <nav class="post-nav" aria-label="Post">
        <a class="btn btn-white" href="<?php echo esc_url($blog_url ?: home_url('/')); ?>">← <?php echo $blog_url ? 'All articles' : 'Home'; ?></a>
        <?php $next = get_next_post(); $prev = get_previous_post(); $other = $next ?: $prev; if ($other) : ?>
        <a class="btn btn-white" href="<?php echo esc_url(get_permalink($other)); ?>"><?php echo $next ? 'Next' : 'Previous'; ?> article →</a>
        <?php endif; ?>
      </nav>
    </div>
  </div>
</article>
<?php endwhile; ?>

<?php get_template_part('template-parts/blog-trust'); ?>

<?php get_template_part('template-parts/section', 'contact'); ?>

<?php get_footer(); ?>
