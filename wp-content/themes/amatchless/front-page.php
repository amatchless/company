<?php get_header(); ?>

<!-- ============ HERO ============ -->
<section class="hero">
  <div class="hero-glow" aria-hidden="true"></div>
  <div class="wrap">
    <div class="hero-grid">
      <div class="hero-inner">
        <span class="eyebrow reveal">Software × AI × Marketing</span>
        <h1 class="reveal d1">Your business,<br><span class="flame">made matchless.</span></h1>
        <p class="lede reveal d2">One team for the whole job. We start by understanding your business and its pain points, then show you how to run more efficiently — with custom software, AI and automation — and grow faster with SEO, digital, influencer and content marketing.</p>
        <div class="hero-cta reveal d3">
          <a href="<?php echo esc_url(amatchless_anchor('contact')); ?>" class="btn btn-primary">Book a discovery call <span class="arw">↗</span></a>
          <a href="<?php echo esc_url(amatchless_anchor('work')); ?>" class="btn btn-ghost">See our work</a>
        </div>
        <div class="hero-meta reveal d4">
          <span><i class="dot"></i>Custom software</span>
          <span><i class="dot"></i>AI &amp; automation</span>
          <span><i class="dot"></i>Marketing &amp; growth</span>
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
  <div class="wrap manifesto manifesto-grid">
    <div class="manifesto-copy up">
      <p>Most agencies sell you a service. We start with your <span class="flame">business.</span></p>
      <p class="sub">We dig into how you operate and where it hurts: slow processes, missed leads, manual work, a brand nobody notices. Then we recommend the fix and build it ourselves — software made for your business, AI and automation that cut the busywork, and marketing that fills your pipeline. One team, one plan, nothing lost between vendors.</p>
    </div>
    <aside class="pain-card up" aria-label="Common business problems and how we fix them">
      <div class="pain-head"><span>What we hear</span><span>What we do</span></div>
      <ul class="pain-list">
        <li><span class="pain">Leads slip through the cracks</span><span class="fix">Automated capture and follow-up</span></li>
        <li><span class="pain">Too much manual, repetitive work</span><span class="fix">Process automation and AI</span></li>
        <li><span class="pain">Tools that don't talk to each other</span><span class="fix">Custom software that joins them up</span></li>
        <li><span class="pain">Customers can't find us online</span><span class="fix">SEO and content marketing</span></li>
        <li><span class="pain">Ad spend that doesn't pay back</span><span class="fix">Performance campaigns built for ROAS</span></li>
        <li><span class="pain">Our brand has no reach</span><span class="fix">Influencer and social marketing</span></li>
      </ul>
      <a class="pain-cta" href="<?php echo esc_url(amatchless_anchor('contact')); ?>">Tell us what's slowing you down <span aria-hidden="true">↗</span></a>
    </aside>
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
