<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
<div style="padding-block:140px 80px">
  <div class="container" style="max-width:800px;margin:0 auto">
    <h1 style="font-family:'Cormorant Garamond',serif;font-size:clamp(32px,5vw,60px);font-weight:300;margin-bottom:32px"><?php the_title(); ?></h1>
    <div class="post-body" style="padding-block:0">
      <?php the_content(); ?>
    </div>
  </div>
</div>
<?php endwhile; ?>

<?php get_footer(); ?>
