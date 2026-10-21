<!-- ============ ALL SERVICES ============ -->
<section class="sec sx" id="services-list">
  <div class="blob sx-blob" aria-hidden="true"></div>
  <svg class="spin hide-sm sx-star" aria-hidden="true" width="84" height="84" viewBox="0 0 40 40"><path d="M20 0 L24 16 L40 20 L24 24 L20 40 L16 24 L0 20 L16 16 Z" fill="#FF4F9A"/></svg>
  <div class="sec-in">
    <div class="sec-split reveal">
      <div class="sec-head">
        <span class="label" style="color:#5B2EFF">EIGHT SERVICES, ONE TEAM</span>
        <h2 class="h2">Everything it takes to run <span class="mark-yellow">leaner</span> and grow <span class="sx-faster">faster.<svg aria-hidden="true" viewBox="0 0 400 40" preserveAspectRatio="none"><path class="draw" d="M4 30 C 80 6, 160 6, 220 22 S 340 36, 396 10" fill="none" stroke="#FF4F9A" stroke-width="8" stroke-linecap="round"/></svg></span></h2>
      </div>
      <p class="sec-aside">Three things, one accountable team: we understand your business, build the systems that make it efficient, and market it so more of the right people find you.</p>
    </div>

    <ul class="sx-key reveal" aria-label="Service groups">
      <li class="sx-key-understand"><span class="sx-dot" aria-hidden="true"></span>Understand <b>1</b></li>
      <li class="sx-key-build"><span class="sx-dot" aria-hidden="true"></span>Build &amp; Automate <b>3</b></li>
      <li class="sx-key-grow"><span class="sx-dot" aria-hidden="true"></span>Market &amp; Grow <b>4</b></li>
    </ul>

    <div class="sx-grid">
      <?php
      // Line icons drawn on a 48×48 grid in ink; each sits on a sticker in its group colour.
      $ic = [
          'discovery'  => '<circle cx="20" cy="20" r="12"/><path d="M29 29 L42 42"/><path d="M14 22 L18 17 L22 20 L27 14"/>',
          'software'   => '<rect x="5" y="8" width="38" height="32" rx="5"/><path d="M5 16 H43"/><path d="M19 23 L14 28 L19 33 M29 23 L34 28 L29 33"/>',
          'ai'         => '<path d="M20 6 L23 17 L34 20 L23 23 L20 34 L17 23 L6 20 L17 17 Z"/><path d="M37 30 L38.5 35.5 L44 37 L38.5 38.5 L37 44 L35.5 38.5 L30 37 L35.5 35.5 Z"/>',
          'automation' => '<path d="M38 18 A15 15 0 0 0 10 16"/><path d="M10 8 V16 H18"/><path d="M10 30 A15 15 0 0 0 38 32"/><path d="M38 40 V32 H30"/><path d="M26 15 L20 25 H28 L22 34"/>',
          'seo'        => '<path d="M8 40 V30 M18 40 V24 M28 40 V18"/><path d="M6 14 L18 10 L26 12 L40 4"/><path d="M33 4 H40 V11"/><circle cx="37" cy="33" r="6"/><path d="M41.5 37.5 L45 41"/>',
          'ads'        => '<path d="M6 19 V29 H13 L30 38 V10 L13 19 Z"/><path d="M13 29 L16 41 H21 L19 30"/><path d="M36 17 Q40 24 36 31 M41 13 Q47 24 41 35"/>',
          'influencer' => '<circle cx="18" cy="15" r="7"/><path d="M5 40 C5 30, 31 30, 31 40"/><path d="M38 28 C33 23, 33 18, 37 17 C39 16.5, 40 18, 40 18 C40 18, 41 16.5, 43 17 C47 18, 47 23, 40 28"/>',
          'content'    => '<path d="M30 6 L42 18 L22 38 L8 42 L12 28 Z"/><path d="M26 10 L38 22"/><path d="M12 28 L22 38"/><circle cx="19" cy="31" r="2.5"/>',
      ];
      // group, size, icon, title, text
      $svcs = [
          ['understand', 'feature', 'discovery',  'Business Discovery &amp; Strategy', 'We learn how you operate, find the pain points and bottlenecks, and hand you a clear plan to run leaner and grow faster.'],
          ['build',      'wide',    'software',   'Custom Software &amp; Web',         'Software, apps, dashboards, websites and stores built around exactly how your business works, not the other way round.'],
          ['build',      'dark',    'ai',         'AI Solutions',                      'AI assistants and tools put to work where they save the most time or win the most business.'],
          ['build',      '',        'automation', 'Process Automation',                'Connect your tools and automate the repeatable work — leads, follow-ups, reporting and operations.'],
          ['grow',       '',        'seo',        'SEO',                               'Rank where your buyers search — technical, on-page and content engineered to last, including visibility in AI answers.'],
          ['grow',       '',        'ads',        'Digital Marketing &amp; Ads',       'Google and Meta campaigns built for return on ad spend across Search, Social and Shopping.'],
          ['grow',       '',        'influencer', 'Influencer Marketing',              'Creators and campaigns matched to your brand, so the right audiences hear about you from voices they trust.'],
          ['grow',       'wide',    'content',    'Content, Social &amp; Branding',    'Identity, stories and social that earn attention and compound, from strategy through production.'],
      ];
      $groups = ['understand' => 'UNDERSTAND', 'build' => 'BUILD &amp; AUTOMATE', 'grow' => 'MARKET &amp; GROW'];
      foreach ($svcs as $i => [$grp, $size, $icon, $title, $text]) : ?>
      <article class="sx-card sx-<?php echo $grp; ?><?php echo $size ? ' sx-' . $size : ''; ?> reveal">
        <span class="sx-num" aria-hidden="true"><?php echo sprintf('%02d', $i + 1); ?></span>
        <span class="sx-icon" aria-hidden="true"><svg viewBox="0 0 48 48" width="40" height="40" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><?php echo $ic[$icon]; ?></svg></span>
        <div class="sx-body">
          <span class="sx-tag"><?php echo $groups[$grp]; ?></span>
          <h3><?php echo $title; ?></h3>
          <p><?php echo esc_html($text); ?></p>
        </div>
        <?php if ($size === 'feature') : ?>
        <span class="sx-start" aria-hidden="true">Start here</span>
        <?php endif; ?>
      </article>
      <?php endforeach; ?>

      <aside class="sx-card sx-cta reveal">
        <span class="sx-tag">NOT SURE YET?</span>
        <h3>Tell us what's slowing you down. We'll tell you where to start.</h3>
        <a class="btn btn-yellow" href="<?php echo esc_url(amatchless_anchor('book')); ?>">Book a discovery call <span aria-hidden="true">↗</span></a>
      </aside>
    </div>
  </div>
</section>
