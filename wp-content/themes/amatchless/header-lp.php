<?php
/* Header for the ad landing pages and /thank-you/: the logo (not a link), phone and WhatsApp. No main menu. */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<?php get_template_part('template-parts/head-tags', null, ['gtm_delay' => amatchless_is_thank_you() ? 0 : 3500]); ?>
<?php wp_head(); ?>
</head>
<body <?php body_class('lp-body'); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N5F7RG6V"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#top">Skip to content</a>

<header class="lp-head">
  <div class="lp-head-in">
    <span class="brand lp-brand">
      <svg width="30" height="30" viewBox="0 0 40 40" aria-hidden="true"><path d="M20 0 L24 16 L40 20 L24 24 L20 40 L16 24 L0 20 L16 16 Z" fill="#5B2EFF"/></svg>
      <span>amatchless</span>
    </span>
    <div class="lp-head-cta">
      <a class="lp-tel" href="tel:<?php echo esc_attr(AMATCHLESS_PHONE_TEL); ?>"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg><span><?php echo esc_html(AMATCHLESS_PHONE); ?></span></a>
      <a class="btn btn-ink lp-wa" href="<?php echo esc_url(AMATCHLESS_WHATSAPP); ?>" target="_blank" rel="noopener">WhatsApp<span class="hide-xs">&nbsp;us</span></a>
    </div>
  </div>
</header>

<main id="top">
