<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
<article>
  <section class="page-head page-head-sm">
    <div class="blob page-blob" aria-hidden="true"></div>
    <div class="sec-in">
      <h1 class="h1"><?php the_title(); ?></h1>
    </div>
  </section>
  <div class="sec-in">
    <div class="prose"><?php the_content(); ?></div>
  </div>
</article>
<?php endwhile; ?>

<?php get_footer(); ?>
