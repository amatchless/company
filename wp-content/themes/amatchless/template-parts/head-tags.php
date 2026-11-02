<?php
/* Shared <head> start for the main site (header.php) and the ad landing pages (header-lp.php).
   $args['gtm_delay']: ms before Tag Manager loads if the visitor doesn't interact first (0 = load at once). */
$gtm_delay = isset($args['gtm_delay']) ? (int) $args['gtm_delay'] : 3500;
?>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="theme-color" content="#FBFAFF">
<!-- Meta (Facebook) domain verification: must stay plain HTML in the <head>, not in Tag Manager -->
<meta name="facebook-domain-verification" content="3qz4csx5tyaqf2irotm4jtqstmemi9" />
<!-- Google Tag Manager -->
<script>window.dataLayer=window.dataLayer||[];
// Consent mode: analytics and ad cookies stay off until the visitor accepts the cookie banner (choice kept in localStorage 'amx-consent').
function gtag(){dataLayer.push(arguments);}
(function(){var c=null;try{c=localStorage.getItem('amx-consent');}catch(e){}
var v=c==='granted'?'granted':'denied';
gtag('consent','default',{analytics_storage:v,ad_storage:v,ad_user_data:v,ad_personalization:v,functionality_storage:'granted',security_storage:'granted',wait_for_update:500});
if(c)dataLayer.push({event:'consent_ready',consent_choice:c});})();
// Load Tag Manager on first interaction (or after a short delay) so it doesn't compete with the first paint.
(function(w,d,s,l,i,t){var go=false;function load(){if(go)return;go=true;w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});
var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;
j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);}
if(!t){load();return;}
['scroll','click','touchstart','keydown','mousemove'].forEach(function(e){w.addEventListener(e,load,{once:true,passive:true});});
setTimeout(load,t);})(window,document,'script','dataLayer','GTM-N5F7RG6V',<?php echo $gtm_delay; ?>);</script>
<!-- End Google Tag Manager -->
