<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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

<nav class="nav" id="mainNav" aria-label="Main navigation">
  <div class="container nav-inner">
    <a class="nav-logo" href="<?php echo esc_url(home_url('/')); ?>">A<em>M</em>ATCHLESS</a>
    <ul class="nav-links">
      <li><a href="<?php echo esc_url(home_url('/#services')); ?>">Services</a></li>
      <li><a href="<?php echo esc_url(home_url('/#about')); ?>">About</a></li>
      <li><a href="<?php echo esc_url(home_url('/#process')); ?>">Process</a></li>
      <li><a href="<?php echo esc_url(home_url('/#results')); ?>">Results</a></li>
      <li><a href="<?php echo esc_url(home_url('/blog/')); ?>">Insights</a></li>
    </ul>
    <div class="nav-cta">
      <a class="btn btn-outline" href="<?php echo esc_url(home_url('/#contact')); ?>">Get Free Audit</a>
    </div>
    <button class="nav-hamburger" id="hamburgerBtn" aria-label="Open navigation" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<div class="mobile-menu" id="mobileMenu" role="dialog" aria-label="Navigation">
  <button class="mobile-close" id="mobileClose" aria-label="Close navigation">&#x2715;</button>
  <a href="<?php echo esc_url(home_url('/#services')); ?>">Services</a>
  <a href="<?php echo esc_url(home_url('/#about')); ?>">About</a>
  <a href="<?php echo esc_url(home_url('/#process')); ?>">Process</a>
  <a href="<?php echo esc_url(home_url('/#results')); ?>">Results</a>
  <a href="<?php echo esc_url(home_url('/blog/')); ?>">Insights</a>
  <a href="<?php echo esc_url(home_url('/#contact')); ?>" style="color:var(--gold)">Book a Call &#8594;</a>
</div>
