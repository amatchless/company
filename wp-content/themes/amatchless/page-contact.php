<?php get_header(); ?>
<?php
$team = get_template_directory_uri() . '/assets/img/team/';
$ver  = '?ver=' . AMATCHLESS_VERSION;

// Ways to reach us: [colour, tag, title, text, link text, href, external, data attribute, icon]
$channels = [
  ['#5B2EFF', 'NEW PROJECT', 'Book a discovery call', 'Tell us where it hurts. 30 minutes, zero commitment, and a clear plan at the end.', 'Fill in the form', '#book', false, '',
   '<path d="M6 10h36v30H6z M6 18h36 M15 6v8 M33 6v8" fill="none"/><path d="M16 28l6 6 11-11" fill="none"/>'],
  ['#FFE14D', 'EMAIL', AMATCHLESS_EMAIL, 'For briefs, decks and anything with attachments. Every email lands with the whole team.', 'Write to us', 'mailto:' . AMATCHLESS_EMAIL, false, '',
   '<path d="M5 11h38v27H5z" fill="none"/><path d="M5 12l19 15 19-15" fill="none"/>'],
  ['#3DEBB0', 'WHATSAPP', 'Message the team', 'Quick question or a voice note on the go? Ping us on WhatsApp and a real person answers.', 'Open WhatsApp', AMATCHLESS_WHATSAPP, true, 'WhatsApp',
   '<path d="M24 5a19 19 0 0 0-16.4 28.6L5 43l9.7-2.5A19 19 0 1 0 24 5z" fill="none"/><path d="M17 16c0 8 7 15 15 15l2.5-4-5-2.5-2 2c-2-1-4.5-3.5-5.5-5.5l2-2L21.5 14z" fill="none"/>'],
  ['#FF4F9A', 'SOCIAL', '@amatchless_', 'See what we\'re building, say hi in the DMs, or follow along on Instagram, Facebook and LinkedIn.', 'Instagram', 'https://www.instagram.com/amatchless_/', true, 'Instagram',
   '<rect x="7" y="7" width="34" height="34" rx="10" fill="none"/><circle cx="24" cy="24" r="8" fill="none"/><circle cx="34" cy="14" r="1.5"/>'],
];

// What happens after the form: [character, colour, step title, speech bubble]
$steps = [
  ['kim',    '#3DEBB0', 'You hit send',                'Got it! Someone from the team gets back to you within 24 hours. Usually much sooner.'],
  ['bravo',  '#FFE14D', 'A 30-minute discovery call',  'No pitch deck, no jargon. Just good questions about how your business runs today.'],
  ['dexter', '#5B2EFF', 'A clear plan, with a price',  'Here\'s what we\'d fix first, what we\'d build, and what it takes. You decide from there.'],
];
?>

<!-- ============ CONTACT HERO ============ -->
<section class="page-head ct-head">
  <div class="blob page-blob" aria-hidden="true"></div>
  <svg class="float2 hide-sm ct-spark" aria-hidden="true" width="64" height="64" viewBox="0 0 40 40"><path d="M20 0 L24 16 L40 20 L24 24 L20 40 L16 24 L0 20 L16 16 Z" fill="#FF4F9A"/></svg>
  <div class="sec-in ct-head-in">
    <div class="ct-head-copy">
      <span class="pill-dark pop"><span class="pulse-dot" aria-hidden="true"></span>CONTACT</span>
      <h1 class="h1 rise d1">Say hi. We'll take it from <span class="hl-purple">here.</span></h1>
      <p class="hero-lede rise d2">Tell us what's slowing your business down and where you want it to be in twelve months. One team for software, AI and marketing reads every message.</p>
      <div class="btn-row rise d3">
        <a class="btn btn-pink btn-lg" href="#book">Book a discovery call <span aria-hidden="true">↗</span></a>
        <a class="btn btn-white btn-lg" href="<?php echo esc_url(AMATCHLESS_WHATSAPP); ?>" target="_blank" rel="noopener" data-social="WhatsApp">WhatsApp us</a>
      </div>
    </div>

    <figure class="ct-hotline pop d4">
      <figcaption class="ch-caption">Client Head, on duty</figcaption>
      <svg class="ch-sfx" viewBox="0 0 120 120" aria-hidden="true"><polygon points="60,4 71,32 101,19 88,48 116,60 88,72 101,101 71,88 60,116 49,88 19,101 32,72 4,60 32,48 19,19 49,32" fill="#FFE14D" stroke="#0E0B1F" stroke-width="3" stroke-linejoin="round"/><text x="60" y="66" text-anchor="middle">RING!</text></svg>
      <img class="ct-kim" src="<?php echo esc_url($team . 'kim.svg' . $ver); ?>" width="320" height="300" decoding="async" alt="Cartoon of Kim, our Client Head, holding a phone">
      <p class="bubble bubble-solo has-tail"><b class="bubble-who" style="background:#3DEBB0">Kim</b>Ring me, message me… or just fill in the form. I'm on it either way.</p>
    </figure>

    <div class="hero-seal ct-seal pop d6" aria-hidden="true">
      <svg class="spin" viewBox="0 0 200 200" width="150" height="150">
        <defs><path id="amxCircleCt" d="M100,100 m-78,0 a78,78 0 1,1 156,0 a78,78 0 1,1 -156,0"/></defs>
        <circle cx="100" cy="100" r="99" fill="#0E0B1F"/>
        <text font-family="DM Sans, sans-serif" font-weight="700" font-size="15" letter-spacing="3.2" fill="#FFFFFF"><textPath href="#amxCircleCt">REPLY WITHIN 24 HOURS ✦ ZERO COMMITMENT ✦</textPath></text>
      </svg>
      <span class="hero-seal-core">24h</span>
    </div>
  </div>
</section>

<!-- ============ CHANNELS ============ -->
<section class="sec sec-tight ct-channels" aria-labelledby="ct-channels-title">
  <div class="sec-in">
    <div class="sec-split reveal">
      <div class="sec-head">
        <span class="label" style="color:#5B2EFF">PICK YOUR CHANNEL</span>
        <h2 class="h2" id="ct-channels-title">However you like to talk, <span class="mark-yellow">we're there.</span></h2>
      </div>
      <p class="sec-aside">Based in Rohini, Delhi. Working with businesses across India, the US and Canada.</p>
    </div>

    <div class="ct-grid reveal">
      <?php foreach ($channels as $i => [$c, $tag, $title, $text, $cta, $href, $ext, $social, $icon]) : ?>
      <a class="sx-card ct-card<?php echo $i === 0 ? ' ct-card-main' : ''; ?>" style="--c:<?php echo esc_attr($c); ?>" href="<?php echo esc_url($href); ?>"<?php echo $ext ? ' target="_blank" rel="noopener"' : ''; ?><?php echo $social ? ' data-social="' . esc_attr($social) . '"' : ''; ?>>
        <span class="sx-icon" aria-hidden="true"><svg width="40" height="40" viewBox="0 0 48 48" fill="currentColor" stroke="currentColor" stroke-width="3.6" stroke-linecap="round" stroke-linejoin="round"><?php echo $icon; // static markup above ?></svg></span>
        <span class="sx-body">
          <span class="sx-tag"><?php echo esc_html($tag); ?></span>
          <span class="ct-title<?php echo str_contains($title, '@') && strlen($title) > 14 ? ' ct-title-sm' : ''; ?>"><?php echo esc_html($title); ?></span>
          <span class="ct-text"><?php echo esc_html($text); ?></span>
        </span>
        <span class="ct-go"><?php echo esc_html($cta); ?> <span aria-hidden="true">↗</span></span>
      </a>
      <?php endforeach; ?>
    </div>
    <p class="ct-also ct-office reveal"><span class="sx-tag">OFFICE</span> <a href="<?php echo esc_url(AMATCHLESS_MAP); ?>" target="_blank" rel="noopener"><?php echo esc_html(AMATCHLESS_ADDRESS); ?> ↗</a></p>
    <p class="ct-also reveal">Also on <a href="https://www.linkedin.com/company/amatchless" target="_blank" rel="noopener" data-social="LinkedIn">LinkedIn ↗</a> and <a href="https://www.facebook.com/amatchless" target="_blank" rel="noopener" data-social="Facebook">Facebook ↗</a></p>
  </div>
</section>

<!-- ============ FORM + WHAT HAPPENS NEXT ============ -->
<section class="sec sec-yellow ct-book" id="contact">
  <svg class="spin hide-sm ct-book-star" aria-hidden="true" width="120" height="120" viewBox="0 0 40 40"><path d="M20 0 L24 16 L40 20 L24 24 L20 40 L16 24 L0 20 L16 16 Z" fill="#5B2EFF"/></svg>
  <div class="sec-in ct-book-grid">
    <div class="ct-next">
      <div class="sec-head reveal">
        <span class="label" style="color:#5B2EFF">WHAT HAPPENS NEXT</span>
        <h2 class="h2">Three steps. <span class="ct-zero">Zero</span> runaround.</h2>
      </div>
      <ol class="ct-steps">
        <?php foreach ($steps as $n => [$who, $bg, $title, $line]) : ?>
        <li class="ct-step reveal" style="--c:<?php echo esc_attr($bg); ?>">
          <div class="ct-step-art"><img src="<?php echo esc_url($team . $who . '.svg' . $ver); ?>" width="320" height="300" loading="lazy" decoding="async" alt=""></div>
          <div class="ct-step-body">
            <span class="label ct-step-n">Step <?php echo $n + 1; ?></span>
            <h3><?php echo esc_html($title); ?></h3>
            <p class="bubble bubble-left"><b class="bubble-who" style="background:<?php echo esc_attr($bg); ?>;color:<?php echo $bg === '#5B2EFF' ? '#FFFFFF' : '#0E0B1F'; ?>"><?php echo esc_html(ucfirst($who)); ?></b><?php echo esc_html($line); ?></p>
          </div>
        </li>
        <?php endforeach; ?>
      </ol>
    </div>

    <div class="ct-form reveal">
      <?php get_template_part('template-parts/lead-form'); ?>
    </div>
  </div>
</section>

<?php get_template_part('template-parts/section', 'faq'); ?>

<?php get_footer(); ?>
