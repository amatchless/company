<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="theme-color" content="#FBFAFF">
<!-- Google Tag Manager -->
<script>window.dataLayer=window.dataLayer||[];
// Load Tag Manager on first interaction (or after 3.5s) so it doesn't compete with the first paint.
(function(w,d,s,l,i){var go=false;function load(){if(go)return;go=true;w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});
var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;
j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);}
['scroll','click','touchstart','keydown','mousemove'].forEach(function(e){w.addEventListener(e,load,{once:true,passive:true});});
setTimeout(load,3500);})(window,document,'script','dataLayer','GTM-N5F7RG6V');</script>
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
<?php $blog_url = amatchless_blog_url(); ?>

<header class="nav" id="nav">
  <nav class="nav-pill" aria-label="Primary">
    <a class="brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="Amatchless home">
      <svg class="spin" width="30" height="30" viewBox="0 0 40 40" aria-hidden="true"><path d="M20 0 L24 16 L40 20 L24 24 L20 40 L16 24 L0 20 L16 16 Z" fill="#5B2EFF"/></svg>
      <span>amatchless</span>
    </a>
    <div class="navlinks">
      <a href="<?php echo esc_url(amatchless_page_url('services')); ?>">Services</a>
      <a href="<?php echo esc_url(is_front_page() ? '#process' : home_url('/#process')); ?>">How we work</a>
      <a href="<?php echo esc_url(amatchless_page_url('work')); ?>">Work</a>
      <a href="<?php echo esc_url(amatchless_page_url('about')); ?>">About</a>
      <a href="<?php echo esc_url($blog_url ?: amatchless_anchor('blog')); ?>">Blog</a>
      <a href="<?php echo esc_url(amatchless_page_url('contact')); ?>">Contact</a>
    </div>
    <div class="nav-cta">
      <a href="<?php echo esc_url(amatchless_anchor('book')); ?>" class="btn btn-ink">Book a call <span aria-hidden="true">↗</span></a>
      <button class="menu-btn" id="menuBtn" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="mobileMenu">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
      </button>
    </div>
  </nav>
  <div class="mobile-menu" id="mobileMenu">
    <a href="<?php echo esc_url(amatchless_page_url('services')); ?>">Services</a>
    <a href="<?php echo esc_url(is_front_page() ? '#process' : home_url('/#process')); ?>">How we work</a>
    <a href="<?php echo esc_url(amatchless_page_url('work')); ?>">Work</a>
    <a href="<?php echo esc_url(amatchless_page_url('about')); ?>">About</a>
    <a href="<?php echo esc_url(amatchless_page_url('ai-automation')); ?>">AI Automation</a>
    <a href="<?php echo esc_url($blog_url ?: amatchless_anchor('blog')); ?>">Blog</a>
    <a href="<?php echo esc_url(amatchless_page_url('contact')); ?>">Contact</a>
  </div>
</header>

<main id="top">
