<?php get_header(); ?>
<?php $thumbs = require get_template_directory() . '/inc/blog-thumbs.php'; ?>

<section class="page-head">
  <div class="blob page-blob" aria-hidden="true"></div>
  <div class="sec-in">
    <span class="pill-dark"><?php echo is_search() ? 'Search' : (is_archive() ? 'Archive' : 'From the journal'); ?></span>
    <h1 class="h1">
      <?php
      if (is_search())      printf('Results for “%s”', esc_html(get_search_query()));
      elseif (is_archive()) echo esc_html(wp_strip_all_tags(get_the_archive_title()));
      else                  echo 'Ideas on brand, growth and <span class="hl-purple">automation.</span>';
      ?>
    </h1>
    <?php if (!is_search() && !is_archive()) : ?>
    <p class="hero-lede">Practical thinking for creators and founders — the same playbooks we use for clients.</p>
    <?php endif; ?>
  </div>
</section>

<section class="sec sec-tight post-list">
  <div class="sec-in">
    <?php if (have_posts()) : ?>
    <div class="posts">
      <?php $n = 0; while (have_posts()) : the_post(); $t = $thumbs[$n++ % 3];
        $cats  = get_the_category();
        $words = str_word_count(wp_strip_all_tags(get_the_content()));
      ?>
      <a class="pcard" href="<?php the_permalink(); ?>">
        <div class="pcard-media <?php echo esc_attr($t['class']); ?>">
          <?php if (has_post_thumbnail()) : the_post_thumbnail('medium_large', ['alt' => '']); else : ?><span class="bthumb"><?php echo $t['svg']; ?></span><?php endif; ?>
        </div>
        <div class="pcard-body">
          <div class="pmeta"><span class="cat"><?php echo esc_html($cats ? $cats[0]->name : 'Journal'); ?></span><span><?php echo esc_html(get_the_date()); ?></span><span><?php echo esc_html(max(1, (int) ceil($words / 220))); ?> min read</span></div>
          <h3><?php the_title(); ?></h3>
          <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 22, '…')); ?></p>
          <span class="rd">Read article →</span>
        </div>
      </a>
      <?php endwhile; ?>
    </div>
    <?php
    $prev = get_previous_posts_link('← Newer posts');
    $next = get_next_posts_link('Older posts →');
    if ($prev || $next) : ?>
    <nav class="pager" aria-label="Posts">
      <?php if ($prev) echo str_replace('<a ', '<a class="btn btn-white" ', $prev); ?>
      <?php if ($next) echo str_replace('<a ', '<a class="btn btn-white" ', $next); ?>
    </nav>
    <?php endif; ?>
    <?php else : ?>
    <p class="hero-lede">Nothing here yet. New articles are on the way.</p>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>
