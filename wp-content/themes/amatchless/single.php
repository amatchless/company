<?php get_header(); ?>

<?php while (have_posts()) : the_post();
  $cats     = get_the_category();
  $words    = str_word_count(wp_strip_all_tags(get_the_content()));
  $blog_url = amatchless_blog_url();
?>
<article>
  <section class="page-head page-head-sm">
    <div class="blob page-blob" aria-hidden="true"></div>
    <div class="sec-in">
      <span class="pill-dark"><?php echo esc_html($cats ? $cats[0]->name : 'Journal'); ?></span>
      <h1 class="h1 h1-post"><?php the_title(); ?></h1>
      <div class="pmeta">
        <span><?php echo esc_html(get_the_date()); ?></span><span>·</span>
        <span>By <?php echo esc_html(amatchless_author_name()); ?></span><span>·</span>
        <span><?php echo esc_html(max(1, (int) ceil($words / 220))); ?> min read</span>
      </div>
      <?php if (has_post_thumbnail()) : ?>
      <div class="post-thumb"><?php the_post_thumbnail('large'); ?></div>
      <?php endif; ?>
    </div>
  </section>
  <div class="sec-in">
    <div class="prose">
      <?php the_content(); ?>
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

<?php get_footer(); ?>
