<?php get_header(); ?>

<!-- ============ HERO ============ -->
<section class="hero">
  <div class="hero-glow" aria-hidden="true"></div>
  <div class="wrap">
    <div class="hero-grid">
      <div class="hero-inner">
        <span class="eyebrow reveal">Digital Marketing × AI Automation</span>
        <h1 class="reveal d1">Make your brand<br><span class="flame">matchless.</span></h1>
        <p class="lede reveal d2">Full-stack marketing and AI automation for creators and businesses — brand, content, ads and custom software built under one roof. Made in India, delivered worldwide.</p>
        <div class="hero-cta reveal d3">
          <a href="<?php echo esc_url(amatchless_anchor('contact')); ?>" class="btn btn-primary">Book a strategy call <span class="arw">↗</span></a>
          <a href="<?php echo esc_url(amatchless_anchor('work')); ?>" class="btn btn-ghost">See our work</a>
        </div>
        <div class="hero-meta reveal d4">
          <span><i class="dot"></i>Creators &amp; influencers</span>
          <span><i class="dot"></i>Founders &amp; businesses</span>
          <span><i class="dot"></i>India &amp; international</span>
        </div>
      </div>
      <div class="hero-art reveal d2" aria-hidden="true">
        <div class="media tint-c m1"><span class="badge-metric" style="left:14px;right:auto">★ Moment</span><img src="<?php echo esc_url(amatchless_img('hero-moment.jpg')); ?>" loading="eager" decoding="async" alt="Moment × Barbie strawberry rose campaign" style="object-position:center"></div>
        <div class="media tint-b m2"><span class="badge-metric" style="left:14px;right:auto">★ Bailey's</span><img src="<?php echo esc_url(amatchless_img('hero-baileys.jpg')); ?>" loading="eager" decoding="async" alt="Bailey's Blossoms reel" style="object-position:center"></div>
        <div class="media m3"><img src="<?php echo esc_url(amatchless_img('hero-haliburton.jpg')); ?>" loading="eager" decoding="async" alt="Haliburton Forest website" style="object-position:top"></div>
        <div class="hero-badge"><div class="v">↗ ROI</div><div class="l">Built to perform</div></div>
      </div>
    </div>
  </div>
</section>

<!-- ============ CLIENT LOGOS ============ -->
<section class="logos" id="clients">
  <div class="wrap">
    <p class="cap">The brands and creators we work with</p>
    <?php
    $clients = [
        ['ISOLA',                 'https://isolabysk.com',           ''],
        ['ALEUCO',                'https://aleuco.com',              ''],
        ['BAILEY\'S<br>BLOSSOMS',   'https://www.baileysblossoms.com', 'font-size:14px;line-height:1.1;letter-spacing:.1em;padding-left:.1em'],
        ['MOMENT',                'https://drinkmoment.com',         ''],
        ['HALIBURTON<br>FOREST',  'https://www.haliburtonforest.com','font-size:13px;line-height:1.1;letter-spacing:.08em;padding-left:.08em'],
        ['MD BIOCOALS',           'https://www.mdbiocoals.com',      'font-size:15px;letter-spacing:.12em;padding-left:.12em'],
    ];
    // Scrolling strip: each set repeats the logos so it is wider than any screen; the
    // track holds two identical sets and slides by exactly one. Copies are hidden from
    // screen readers and keyboard focus, and reduced-motion visitors get one static row.
    ?>
    <div class="marquee">
      <div class="marquee-track">
        <?php for ($set = 0; $set < 2; $set++) : ?>
        <div class="marquee-set"<?php echo $set ? ' aria-hidden="true"' : ''; ?>>
          <?php for ($rep = 0; $rep < 2; $rep++) : foreach ($clients as [$label, $url, $style]) : $copy = $set || $rep; ?>
          <a class="logo-slot real<?php echo $rep ? ' dup' : ''; ?>" href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener"<?php echo $style ? ' style="' . esc_attr($style) . '"' : ''; ?><?php echo $copy ? ' tabindex="-1"' . ($set ? '' : ' aria-hidden="true"') : ''; ?>><?php echo wp_kses($label, ['br' => []]); ?></a>
          <?php endforeach; endfor; ?>
        </div>
        <?php endfor; ?>
      </div>
    </div>
    <p class="note">A growing roster across India, the US and Canada — fashion, beauty, wellness and tourism.</p>
  </div>
</section>

<!-- ============ MANIFESTO ============ -->
<section>
  <div class="wrap manifesto">
    <p>Most agencies run campaigns. We build growth <span class="flame">engines.</span></p>
    <p class="sub">Creative, media and code, working as one system — so your brand gets seen, your pipeline stays full, and the busywork runs itself. That's the difference between hiring an agency and having an unfair advantage.</p>
  </div>
</section>

<?php get_template_part('template-parts/section', 'services'); ?>

<?php get_template_part('template-parts/section', 'work'); ?>

<?php get_template_part('template-parts/section', 'cases'); ?>

<?php get_template_part('template-parts/section', 'automation'); ?>

<?php get_template_part('template-parts/section', 'process'); ?>

<?php get_template_part('template-parts/section', 'about'); ?>

<?php get_template_part('template-parts/section', 'stats'); ?>

<?php get_template_part('template-parts/section', 'testimonials'); ?>

<?php get_template_part('template-parts/section', 'who'); ?>

<?php get_template_part('template-parts/section', 'blog'); ?>

<?php get_template_part('template-parts/section', 'contact'); ?>

<?php get_footer(); ?>
