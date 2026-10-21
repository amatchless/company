<!-- ============ BLOG TEASER ============ -->
<?php
$thumbs   = require get_template_directory() . '/inc/blog-thumbs.php';
$blog_url = amatchless_blog_url();
// Real posts once there are any (the default "Hello world!" post doesn't count).
$posts_q  = new WP_Query([
    'posts_per_page'      => 3,
    'post_status'         => 'publish',
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
    'post__not_in'        => amatchless_hidden_post_ids(),
]);
// Shown until the first real articles are published.
$fallback = [
    ['cat' => 'Automation', 'read' => '6 min read', 'title' => '5 marketing tasks you should automate this month',      'text' => 'The quick wins that free up hours every week without losing the human touch.'],
    ['cat' => 'Branding',   'read' => '5 min read', 'title' => 'Why your brand feels forgettable (and how to fix it)',  'text' => 'A simple framework to make your business instantly recognisable.'],
    ['cat' => 'Paid Ads',   'read' => '7 min read', 'title' => 'The creator\'s guide to your first profitable ad',      'text' => 'From offer to targeting to creative — a beginner-friendly walkthrough.'],
];
?>
<section class="sec sec-tight" id="blog">
  <div class="sec-in">
    <div class="sec-split reveal">
      <div class="sec-head">
        <span class="label" style="color:#FF4F9A">FROM THE BLOG</span>
        <h2 class="h2">Ideas on brand, growth and automation.</h2>
      </div>
      <?php if ($blog_url && $posts_q->post_count) : ?>
      <a href="<?php echo esc_url($blog_url); ?>" class="btn btn-white btn-lg">Visit the blog →</a>
      <?php endif; ?>
    </div>
    <div class="posts">
      <?php if ($posts_q->have_posts()) : $n = 0; while ($posts_q->have_posts()) : $posts_q->the_post(); $t = $thumbs[$n++ % 3];
        $cats  = get_the_category();
        $words = str_word_count(wp_strip_all_tags(get_the_content()));
      ?>
      <a class="pcard reveal" href="<?php the_permalink(); ?>">
        <div class="pcard-media <?php echo esc_attr($t['class']); ?>">
          <?php if (has_post_thumbnail()) : the_post_thumbnail('medium_large', ['alt' => '']); else : ?><span class="bthumb"><?php echo $t['svg']; ?></span><?php endif; ?>
        </div>
        <div class="pcard-body">
          <div class="pmeta"><span class="cat"><?php echo esc_html($cats ? $cats[0]->name : 'Blog'); ?></span><span><?php echo esc_html(max(1, (int) ceil($words / 220))); ?> min read</span></div>
          <h3><?php the_title(); ?></h3>
          <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 18, '…')); ?></p>
          <span class="rd">Read article →</span>
        </div>
      </a>
      <?php endwhile; wp_reset_postdata(); else : foreach ($fallback as $i => $p) : $t = $thumbs[$i]; ?>
      <div class="pcard reveal">
        <div class="pcard-media <?php echo esc_attr($t['class']); ?>"><span class="bthumb"><?php echo $t['svg']; ?></span></div>
        <div class="pcard-body">
          <div class="pmeta"><span class="cat"><?php echo esc_html($p['cat']); ?></span><span><?php echo esc_html($p['read']); ?></span></div>
          <h3><?php echo esc_html($p['title']); ?></h3>
          <p><?php echo esc_html($p['text']); ?></p>
          <span class="rd">Coming soon</span>
        </div>
      </div>
      <?php endforeach; endif; ?>
    </div>
  </div>
</section>
