<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
<article>
  <section class="page-head">
    <div class="wrap">
      <h1><?php the_title(); ?></h1>
    </div>
  </section>
  <div class="wrap">
    <div class="prose"><?php the_content(); ?></div>
  </div>
</article>
<?php endwhile; ?>

<?php get_footer(); ?>
