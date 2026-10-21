<?php get_header(); ?>
<?php $thumbs = require get_template_directory() . '/inc/blog-thumbs.php'; ?>

<section class="page-head">
  <div class="blob page-blob" aria-hidden="true"></div>
  <div class="sec-in">
    <span class="pill-dark"><?php echo is_search() ? 'Search' : (is_category() ? 'Category' : (is_tag() ? 'Topic' : (is_archive() ? 'Archive' : 'The Amatchless blog'))); ?></span>
    <h1 class="h1">
      <?php
      if (is_search())                       printf('Results for “%s”', esc_html(get_search_query()));
      elseif (is_category() || is_tag())     echo esc_html(single_term_title('', false));
      elseif (is_archive())                  echo esc_html(wp_strip_all_tags(get_the_archive_title()));
      else                                   echo 'Ideas on brand, growth and <span class="hl-purple">automation.</span>';
      ?>
    </h1>
    <?php if ((is_category() || is_tag()) && term_description()) : ?>
    <p class="hero-lede"><?php echo esc_html(wp_strip_all_tags(term_description())); ?></p>
    <?php elseif (!is_search() && !is_archive()) : ?>
    <p class="hero-lede">Practical thinking for creators and founders — the same playbooks we use for clients. New articles every week.</p>
    <?php endif; ?>
    <?php if (is_home() || is_category()) amatchless_category_chips(); ?>
  </div>
</section>

<section class="sec sec-tight post-list">
  <div class="sec-in">
    <?php if (have_posts()) : $n = 0; ?>
    <?php the_post(); get_template_part('template-parts/post-card', null, ['thumb' => $thumbs[$n++ % 3], 'wide' => true]); ?>
    <?php if (have_posts()) : ?>
    <div class="posts">
      <?php while (have_posts()) : the_post(); get_template_part('template-parts/post-card', null, ['thumb' => $thumbs[$n++ % 3]]); endwhile; ?>
    </div>
    <?php endif; ?>
    <?php
    $links = paginate_links(['type' => 'array', 'prev_text' => '← Newer', 'next_text' => 'Older →', 'mid_size' => 1]);
    if ($links) : ?>
    <nav class="pager" aria-label="More articles">
      <?php foreach ($links as $l) echo $l; ?>
    </nav>
    <?php endif; ?>
    <?php else : ?>
    <p class="hero-lede">Nothing here yet. New articles are on the way.</p>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>
