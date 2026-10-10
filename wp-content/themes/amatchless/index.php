<?php get_header(); ?>

<main style="padding-block:140px 80px" class="container">
  <div style="max-width:800px;margin:0 auto">
    <span class="gold-line"></span>
    <p class="eyebrow">Insights &amp; Resources</p>
    <h1 class="section-title" style="margin-top:12px;margin-bottom:48px">The Amatchless<br><em>Growth Blog</em></h1>

    <?php if (have_posts()) : ?>
    <div style="display:flex;flex-direction:column;gap:32px">
      <?php while (have_posts()) : the_post(); ?>
      <article style="border-bottom:1px solid var(--border);padding-bottom:32px">
        <?php
        $cats = get_the_category();
        $cat_name = $cats ? esc_html($cats[0]->name) : 'Insights';
        ?>
        <div class="blog-cat" style="margin-bottom:10px"><?php echo $cat_name; ?></div>
        <h2 style="font-family:'Cormorant Garamond',serif;font-size:clamp(22px,3vw,34px);font-weight:300;margin-bottom:12px">
          <a href="<?php the_permalink(); ?>" style="transition:color 0.2s" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color=''"><?php the_title(); ?></a>
        </h2>
        <p style="color:var(--t2);font-size:15px;line-height:1.7;margin-bottom:16px"><?php echo wp_trim_words(get_the_excerpt(), 30, '&hellip;'); ?></p>
        <div style="display:flex;align-items:center;justify-content:space-between;font-size:12px;color:var(--t3)">
          <span><?php echo get_the_date(); ?></span>
          <a href="<?php the_permalink(); ?>" class="btn btn-ghost" style="font-size:12px;padding:8px 16px">Read More &#8594;</a>
        </div>
      </article>
      <?php endwhile; ?>
    </div>

    <div style="margin-top:48px;display:flex;justify-content:center;gap:12px">
      <?php
      $prev_link = get_previous_posts_link('&larr; Newer Posts');
      $next_link = get_next_posts_link('Older Posts &rarr;');
      if ($prev_link) echo '<span class="btn btn-ghost" style="font-size:13px;padding:10px 20px">' . $prev_link . '</span>';
      if ($next_link) echo '<span class="btn btn-ghost" style="font-size:13px;padding:10px 20px">' . $next_link . '</span>';
      ?>
    </div>

    <?php else : ?>
    <p style="color:var(--t2);text-align:center;padding:60px 0">No posts found. Check back soon.</p>
    <?php endif; ?>
  </div>
</main>

<?php get_footer(); ?>
