<!-- ============ ALL SERVICES ============ -->
<section class="sec" id="services-list">
  <div class="sec-in">
    <div class="sec-split reveal">
      <div class="sec-head">
        <span class="label" style="color:#5B2EFF">EIGHT SERVICES, ONE TEAM</span>
        <h2 class="h2">Everything it takes to run leaner and grow faster.</h2>
      </div>
      <p class="sec-aside">Three things, one accountable team: we understand your business, build the systems that make it efficient, and market it so more of the right people find you.</p>
    </div>
    <div class="pain-grid">
      <?php
      $svcs = [
          ['UNDERSTAND',       'Business Discovery &amp; Strategy', 'We learn how you operate, find the pain points and bottlenecks, and hand you a clear plan to run leaner and grow faster.'],
          ['BUILD &amp; AUTOMATE', 'Custom Software &amp; Web',     'Software, apps, dashboards, websites and stores built around exactly how your business works, not the other way round.'],
          ['BUILD &amp; AUTOMATE', 'AI Solutions',                  'AI assistants and tools put to work where they save the most time or win the most business.'],
          ['BUILD &amp; AUTOMATE', 'Process Automation',            'Connect your tools and automate the repeatable work — leads, follow-ups, reporting and operations.'],
          ['MARKET &amp; GROW',    'SEO',                           'Rank where your buyers search — technical, on-page and content engineered to last, including visibility in AI answers.'],
          ['MARKET &amp; GROW',    'Digital Marketing &amp; Ads',   'Google and Meta campaigns built for return on ad spend across Search, Social and Shopping.'],
          ['MARKET &amp; GROW',    'Influencer Marketing',          'Creators and campaigns matched to your brand, so the right audiences hear about you from voices they trust.'],
          ['MARKET &amp; GROW',    'Content, Social &amp; Branding', 'Identity, stories and social that earn attention and compound, from strategy through production.'],
      ];
      foreach ($svcs as [$tag, $title, $text]) : ?>
      <article class="pain svc reveal">
        <span class="pain-label"><?php echo $tag; ?></span>
        <h3 class="pain-text"><?php echo $title; ?></h3>
        <p class="svc-text"><?php echo esc_html($text); ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
