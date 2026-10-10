<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-N5F7RG6V');</script>
<!-- End Google Tag Manager -->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N5F7RG6V"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#top">Skip to content</a>
<div class="grain" aria-hidden="true"></div>
<?php $blog_url = amatchless_blog_url(); ?>

<header class="nav" id="nav">
  <div class="wrap nav-in">
    <a class="brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="Amatchless home">
      <img class="mark" src="<?php echo esc_url(amatchless_img('logo.png')); ?>" alt="" width="30" height="23">
      <span><b>Amatchless</b></span>
    </a>
    <nav class="navlinks" aria-label="Primary">
      <a href="<?php echo esc_url(amatchless_page_url('services')); ?>">Services</a>
      <a href="<?php echo esc_url(amatchless_page_url('work')); ?>">Work</a>
      <a href="<?php echo esc_url(amatchless_page_url('about')); ?>">About</a>
      <a href="<?php echo esc_url(amatchless_page_url('ai-automation')); ?>">AI</a>
      <a href="<?php echo esc_url($blog_url ?: amatchless_anchor('blog')); ?>">Blog</a>
    </nav>
    <div class="nav-cta">
      <a href="<?php echo esc_url(amatchless_anchor('book')); ?>" class="btn btn-primary">Book a discovery call <span class="arw" aria-hidden="true">↗</span></a>
      <button class="menu-btn" id="menuBtn" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="mobileMenu">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
      </button>
    </div>
  </div>
  <div class="mobile-menu" id="mobileMenu">
    <a href="<?php echo esc_url(amatchless_page_url('services')); ?>">Services</a>
    <a href="<?php echo esc_url(amatchless_page_url('work')); ?>">Work</a>
    <a href="<?php echo esc_url(amatchless_page_url('about')); ?>">About</a>
    <a href="<?php echo esc_url(amatchless_page_url('ai-automation')); ?>">AI Automation</a>
    <a href="<?php echo esc_url($blog_url ?: amatchless_anchor('blog')); ?>">Blog</a>
    <a href="<?php echo esc_url(amatchless_anchor('book')); ?>" class="btn btn-primary">Book a discovery call ↗</a>
  </div>
</header>

<main id="top">
