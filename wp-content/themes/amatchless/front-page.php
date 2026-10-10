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

<!-- ============ SERVICES ============ -->
<section class="band band-line" id="services">
  <div class="wrap">
    <div class="sec-head up">
      <span class="eyebrow">What we do</span>
      <h2>Eight services. One accountable team.</h2>
      <p class="lede">Everything you need to grow, grouped into three things we're obsessed with: your <em>brand</em>, your <em>growth</em>, and the <em>systems</em> that hold it all together.</p>
    </div>
    <div class="svc-grid up">
      <article class="svc"><span class="plus" aria-hidden="true">+</span><span class="tag">Brand &amp; Content</span><h3>Branding</h3><p>Identity, positioning and visual systems that make you unmistakable in a crowded feed.</p></article>
      <article class="svc"><span class="plus" aria-hidden="true">+</span><span class="tag">Brand &amp; Content</span><h3>Content Marketing</h3><p>Stories and assets that earn attention and compound — from strategy through production.</p></article>
      <article class="svc"><span class="plus" aria-hidden="true">+</span><span class="tag">Brand &amp; Content</span><h3>Social Media Marketing</h3><p>Full-funnel social that turns followers into community, and community into revenue.</p></article>
      <article class="svc"><span class="plus" aria-hidden="true">+</span><span class="tag">Growth &amp; Ads</span><h3>SEO</h3><p>Rank where your buyers search — technical, on-page and content engineered to last.</p></article>
      <article class="svc"><span class="plus" aria-hidden="true">+</span><span class="tag">Growth &amp; Ads</span><h3>Google &amp; Meta Ads</h3><p>Performance campaigns built for return on ad spend across Search, Social and Shopping.</p></article>
      <article class="svc"><span class="plus" aria-hidden="true">+</span><span class="tag">Build &amp; Automate</span><h3>Web Development</h3><p>Fast, beautiful, conversion-first websites and stores that feel as premium as your brand.</p></article>
      <article class="svc"><span class="plus" aria-hidden="true">+</span><span class="tag">Build &amp; Automate</span><h3>Automations</h3><p>Connect your tools and let the busywork run itself — leads, follow-ups and reporting.</p></article>
      <article class="svc"><span class="plus" aria-hidden="true">+</span><span class="tag">Build &amp; Automate</span><h3>Custom Software</h3><p>Bespoke apps, dashboards and AI tools built around exactly how your business works.</p></article>
    </div>
  </div>
</section>

<!-- ============ PORTFOLIO / WORK ============ -->
<section class="band band-line" id="work">
  <div class="wrap">
    <div class="sec-head up">
      <span class="eyebrow">Selected work</span>
      <h2>Projects we're proud to put our name on.</h2>
      <p class="lede">Live work across fashion, beauty, wellness, tourism and agri-tech — for <strong>Isola</strong>, <strong>AleuCo</strong>, <strong>Bailey's Blossoms</strong>, the Shark Tank–featured <strong>Moment</strong>, <strong>Haliburton Forest</strong> and <strong>MD Biocoals</strong>.</p>
    </div>
    <div class="work-grid up">
      <a class="work-card" href="https://isolabysk.com" target="_blank" rel="noopener">
        <div class="media coast"><span class="badge-live">Live project</span><span class="lockup"><span class="wm">ISOLA</span><span class="tl">Somewhere, always.</span><span class="live">isolabysk.com ↗</span></span></div>
        <div class="info"><div><h3>Isola by SK</h3><div class="cat">Web Development · Social Media</div></div><span class="go" aria-hidden="true">↗</span></div>
      </a>
      <a class="work-card" href="https://aleuco.com" target="_blank" rel="noopener">
        <div class="media blush"><span class="badge-live">Live project</span><span class="lockup"><span class="wm">ALEUCO</span><span class="tl">Beauty on demand.</span><span class="live">aleuco.com ↗</span></span></div>
        <div class="info"><div><h3>AleuCo Beauty Studio</h3><div class="cat">SEO · AEO/GEO · Branding</div></div><span class="go" aria-hidden="true">↗</span></div>
      </a>
      <a class="work-card" href="https://www.baileysblossoms.com" target="_blank" rel="noopener">
        <div class="media bloom"><span class="badge-live">Live project</span><span class="badge-metric">4× ROAS</span><span class="lockup"><span class="wm">BAILEY'S BLOSSOMS</span><span class="tl">Loved by 1M+ moms.</span><span class="live">baileysblossoms.com ↗</span></span></div>
        <div class="info"><div><h3>Bailey's Blossoms</h3><div class="cat">Meta Ads · 4× ROAS</div></div><span class="go" aria-hidden="true">↗</span></div>
      </a>
      <a class="work-card" href="https://drinkmoment.com" target="_blank" rel="noopener">
        <div class="media calm"><span class="badge-live">Live project</span><span class="badge-metric">★ Shark Tank</span><span class="lockup"><span class="wm">MOMENT</span><span class="tl">Drink your meditation.</span><span class="live">drinkmoment.com ↗</span></span></div>
        <div class="info"><div><h3>Moment</h3><div class="cat">SEO · Branding · Ads</div></div><span class="go" aria-hidden="true">↗</span></div>
      </a>
      <a class="work-card" href="https://www.mdbiocoals.com" target="_blank" rel="noopener">
        <div class="media leaf"><span class="badge-live">Live project</span><span class="lockup"><span class="wm">MD BIOCOALS</span><span class="tl">For nature.</span><span class="live">mdbiocoals.com ↗</span></span></div>
        <div class="info"><div><h3>MD Biocoals</h3><div class="cat">Web · Branding · SEO/AEO/GEO</div></div><span class="go" aria-hidden="true">↗</span></div>
      </a>
      <a class="work-card" href="https://www.haliburtonforest.com" target="_blank" rel="noopener">
        <div class="media forest"><span class="badge-live">Live project</span><span class="lockup"><span class="wm">HALIBURTON FOREST</span><span class="tl">Ontario's outdoor paradise.</span><span class="live">haliburtonforest.com ↗</span></span></div>
        <div class="info"><div><h3>Haliburton Forest</h3><div class="cat">Web Development · Booking System</div></div><span class="go" aria-hidden="true">↗</span></div>
      </a>
    </div>
    <div class="work-more"><a href="<?php echo esc_url(amatchless_anchor('contact')); ?>" class="btn btn-ghost">Start your project ↗</a></div>
  </div>
</section>

<!-- ============ CASE STUDIES ============ -->
<section class="band band-line" id="cases">
  <div class="wrap">
    <div class="sec-head up">
      <span class="eyebrow">Case studies</span>
      <h2>The work, and the numbers behind it.</h2>
      <p class="lede">Deep-dives into how we solve real problems for real brands — from building a store to being found across search and AI.</p>
    </div>

    <div class="case up">
      <div class="case-media media coast"><span class="lockup"><span class="wm">ISOLA</span><span class="tl">Somewhere, always.</span><span class="live">isolabysk.com ↗</span></span></div>
      <div class="case-body">
        <span class="eyebrow">Creator brand · E-commerce</span>
        <h3>Isola — a resort-wear label, built end to end</h3>
        <p>For influencer Saanya Khatter, we designed and developed <strong>Isola</strong>, a luxury resort-wear and swimwear store — “cut for the water, worn to dinner” — and we run the brand's social media day to day. From storefront to feed, one team turned an engaged audience into a premium direct-to-consumer label.</p>
        <div class="case-metrics">
          <div class="metric"><div class="v">Web</div><div class="l">E-commerce store, designed &amp; built</div></div>
          <div class="metric"><div class="v">Social</div><div class="l">Ongoing social media management</div></div>
          <div class="metric"><div class="v">DTC</div><div class="l">Full brand launch, India-wide</div></div>
        </div>
        <a href="https://isolabysk.com" target="_blank" rel="noopener" class="btn btn-ghost" style="margin-top:26px">Visit isolabysk.com ↗</a>
      </div>
    </div>

    <div class="case up">
      <div class="case-media media blush"><span class="lockup"><span class="wm">ALEUCO</span><span class="tl">Beauty on demand.</span><span class="live">aleuco.com ↗</span></span></div>
      <div class="case-body">
        <span class="eyebrow">Beauty · US market</span>
        <h3>AleuCo — getting a beauty brand found, everywhere</h3>
        <p><strong>AleuCo</strong> is a luxury mobile hair-and-makeup studio bringing services straight to clients' doors across the US. We're sharpening the brand and building its visibility — optimising for classic search (SEO) and for the AI answers and local results buyers now rely on (AEO &amp; GEO), so the right clients find AleuCo first.</p>
        <div class="case-metrics">
          <div class="metric"><div class="v">SEO</div><div class="l">Search visibility &amp; local reach</div></div>
          <div class="metric"><div class="v">AEO<span style="opacity:.5">/</span>GEO</div><div class="l">Found in AI &amp; map answers</div></div>
          <div class="metric"><div class="v">Brand</div><div class="l">Positioning &amp; identity</div></div>
        </div>
        <a href="https://aleuco.com" target="_blank" rel="noopener" class="btn btn-ghost" style="margin-top:26px">Visit aleuco.com ↗</a>
      </div>
    </div>

    <div class="case up">
      <div class="case-media media bloom"><span class="lockup"><span class="wm">BAILEY'S BLOSSOMS</span><span class="tl">Loved by 1M+ moms.</span><span class="live">baileysblossoms.com ↗</span></span></div>
      <div class="case-body">
        <span class="eyebrow">E-commerce · Kids &amp; family</span>
        <h3>Bailey's Blossoms — 4× return from Meta ads</h3>
        <p><strong>Bailey's Blossoms</strong> is a much-loved boutique for girls' and “Mommy &amp; Me” clothing, trusted by over a million moms. We run their Meta (Facebook &amp; Instagram) advertising — building the creative and campaigns that turn ad spend into profitable, repeatable sales.</p>
        <div class="case-metrics">
          <div class="metric"><div class="v">4×</div><div class="l">Return on ad spend</div></div>
          <div class="metric"><div class="v">Meta</div><div class="l">Facebook &amp; Instagram ads</div></div>
          <div class="metric"><div class="v">Scaled</div><div class="l">Profitable, repeatable spend</div></div>
        </div>
        <a href="https://www.baileysblossoms.com" target="_blank" rel="noopener" class="btn btn-ghost" style="margin-top:26px">Visit baileysblossoms.com ↗</a>
      </div>
    </div>

    <div class="case up">
      <div class="case-media media calm"><span class="badge-metric">★ Shark Tank</span><span class="lockup"><span class="wm">MOMENT</span><span class="tl">Drink your meditation.</span><span class="live">drinkmoment.com ↗</span></span></div>
      <div class="case-body">
        <span class="eyebrow">Wellness · Functional beverages</span>
        <h3>Moment — growth for a Shark Tank wellness brand</h3>
        <p><strong>Moment</strong> makes functional, meditation-inspired drinks and has been featured on <em>Shark Tank</em>. We support the brand across three fronts — sharpening the branding, growing organic visibility through SEO, and running paid ads — so a standout product reaches the people looking for it.</p>
        <div class="case-metrics">
          <div class="metric"><div class="v">SEO</div><div class="l">Organic search growth</div></div>
          <div class="metric"><div class="v">Brand</div><div class="l">Positioning &amp; identity</div></div>
          <div class="metric"><div class="v">Ads</div><div class="l">Paid acquisition</div></div>
        </div>
        <a href="https://drinkmoment.com" target="_blank" rel="noopener" class="btn btn-ghost" style="margin-top:26px">Visit drinkmoment.com ↗</a>
      </div>
    </div>

    <div class="case up">
      <div class="case-media media forest"><span class="lockup"><span class="wm">HALIBURTON FOREST</span><span class="tl">Ontario's outdoor paradise.</span><span class="live">haliburtonforest.com ↗</span></span></div>
      <div class="case-body">
        <span class="eyebrow">Tourism · Web &amp; booking</span>
        <h3>Haliburton Forest — a 100,000-acre destination, online</h3>
        <p><strong>Haliburton Forest &amp; Wild Life Reserve</strong> is one of Ontario's largest outdoor adventure destinations — 100,000 acres and 100 lakes. We designed and developed their website and built the booking system that lets visitors reserve stays and activities right through the year.</p>
        <div class="case-metrics">
          <div class="metric"><div class="v">Web</div><div class="l">Full website, designed &amp; built</div></div>
          <div class="metric"><div class="v">Booking</div><div class="l">Custom reservation system</div></div>
          <div class="metric"><div class="v">4-season</div><div class="l">Stays &amp; activities online</div></div>
        </div>
        <a href="https://www.haliburtonforest.com" target="_blank" rel="noopener" class="btn btn-ghost" style="margin-top:26px">Visit haliburtonforest.com ↗</a>
      </div>
    </div>

    <div class="case up">
      <div class="case-media media leaf"><span class="lockup"><span class="wm">MD BIOCOALS</span><span class="tl">For nature.</span><span class="live">mdbiocoals.com ↗</span></span></div>
      <div class="case-body">
        <span class="eyebrow">Agri-tech · Organic farming</span>
        <h3>MD Biocoals — a 25-year agri brand, brought online</h3>
        <p><strong>MD Biocoals</strong> makes organic fertilizers and biofertilizers for farmers across India — “for nature.” We developed their website and support the brand with identity work and visibility across search and AI answers (SEO, AEO &amp; GEO), so a trusted 25-year name is easy to find and easy to believe.</p>
        <div class="case-metrics">
          <div class="metric"><div class="v">Web</div><div class="l">Website, designed &amp; built</div></div>
          <div class="metric"><div class="v">Brand</div><div class="l">Identity &amp; positioning</div></div>
          <div class="metric"><div class="v">AEO<span style="opacity:.5">/</span>GEO</div><div class="l">Found in search &amp; AI</div></div>
        </div>
        <a href="https://www.mdbiocoals.com" target="_blank" rel="noopener" class="btn btn-ghost" style="margin-top:26px">Visit mdbiocoals.com ↗</a>
      </div>
    </div>
  </div>
</section>

<!-- ============ AI AUTOMATION ============ -->
<section class="band band-line" id="automation">
  <div class="wrap">
    <div class="ai up">
      <div class="ai-top">
        <div>
          <span class="eyebrow">The Amatchless edge</span>
          <h2>Marketing that keeps working after you log off.</h2>
        </div>
      </div>
      <p class="lede">We wire AI and automation into the work itself — so leads get answered, content ships, and reports write themselves. Fewer hours on admin, more compounding on what actually moves revenue.</p>
      <div class="ai-list">
        <div class="ai-item"><span class="n">01</span><h4>Leads on autopilot</h4><p>Capture, qualify and follow up with every enquiry the moment it lands — across DMs, forms and ads.</p></div>
        <div class="ai-item"><span class="n">02</span><h4>Content &amp; reporting pipelines</h4><p>Repeatable systems that turn one idea into a week of posts and turn raw data into clear dashboards.</p></div>
        <div class="ai-item"><span class="n">03</span><h4>Custom AI assistants</h4><p>Tools trained on your brand and your data — answering, drafting and operating the way you would.</p></div>
      </div>
    </div>
  </div>
</section>

<!-- ============ PROCESS ============ -->
<section class="band band-line" id="process">
  <div class="wrap">
    <div class="sec-head up">
      <span class="eyebrow">How we work</span>
      <h2>A clear path from idea to compounding growth.</h2>
    </div>
    <div class="steps up">
      <div class="step"><span class="num">01 — Discover</span><h3>Understand</h3><p>We learn your market, your goals and your real numbers before touching a single design.</p></div>
      <div class="step"><span class="num">02 — Strategy</span><h3>Plan</h3><p>A focused plan tied to revenue and outcomes — not vanity metrics or busywork.</p></div>
      <div class="step"><span class="num">03 — Build</span><h3>Launch</h3><p>Creative, campaigns and systems go live, built to the standard your brand deserves.</p></div>
      <div class="step"><span class="num">04 — Scale</span><h3>Compound</h3><p>We measure, optimise and automate what works, so results build on themselves.</p></div>
    </div>
  </div>
</section>

<!-- ============ ABOUT ============ -->
<section class="band band-line" id="about">
  <div class="wrap">
    <div class="about-grid">
      <div class="about-art up">
        <div class="media"><span class="ph"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-6.5 8-6.5S20 17 20 21"/></svg><span>Team / founder photo</span></span></div>
        <div class="stamp"><div class="q">“Peerless by name. Relentless by nature.”</div></div>
      </div>
      <div class="about-body up">
        <span class="eyebrow">About us</span>
        <h2>We started Amatchless to close the gap between good marketing and real growth.</h2>
        <p class="lede">Too many brands juggle a designer here, an ads freelancer there, and a developer who never talks to either. We built one team that does it all — creative, media and code — so nothing falls through the cracks and everything pulls in the same direction.</p>
        <p class="lede">Based in India and working with clients around the world, we bring the craft of a boutique studio with the systems of a modern, AI-first agency.</p>
        <div class="values">
          <div class="value"><h4><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2l2.4 7.4H22l-6 4.4 2.3 7.2-6.3-4.6L5.7 21 8 13.8 2 9.4h7.6z"/></svg>Outcomes over output</h4><p>We're measured by your growth, not by how many posts we shipped.</p></div>
          <div class="value"><h4><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="3"/><path d="M8 12l3 3 5-6"/></svg>One accountable team</h4><p>Strategy, creative and engineering in one room — one point of contact.</p></div>
          <div class="value"><h4><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>Systems that scale</h4><p>We automate the repeatable so your growth doesn't depend on hustle.</p></div>
          <div class="value"><h4><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 3C7 3 3 6.5 3 11c0 2.4 1.3 4.5 3.3 6L6 21l4-2.2c.6.1 1.3.2 2 .2 5 0 9-3.5 9-8s-4-8-9-8z"/></svg>Honest partnership</h4><p>Clear reporting, straight talk, and no jargon to hide behind.</p></div>
        </div>
      </div>
    </div>
    </div>
</section>

<!-- ============ STATS ============ -->
<section>
  <div class="wrap">
    <div class="stats up">
      <div class="stat"><div class="v">4×</div><div class="l">Return on ad spend delivered</div></div>
      <div class="stat"><div class="v">08</div><div class="l">Core services under one roof</div></div>
      <div class="stat"><div class="v">3</div><div class="l">Countries served — India, US &amp; Canada</div></div>
      <div class="stat"><div class="v">1:1</div><div class="l">Senior team, direct access</div></div>
    </div>
  </div>
</section>

<!-- ============ TESTIMONIALS ============ -->
<section class="band" id="testimonials">
  <div class="wrap">
    <div class="sec-head center up">
      <span class="eyebrow">What clients say</span>
      <h2>Trusted by the people who bet on their name.</h2>
    </div>
    <div class="tgrid up">
      <article class="tcard">
        <div class="stars" aria-label="5 out of 5">★★★★★</div>
        <blockquote>“They didn't just run our ads — they rebuilt how our whole business finds and follows up with customers. It runs on its own now.”</blockquote>
        <div class="who"><span class="av"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-6.5 8-6.5S20 17 20 21"/></svg></span><div><div class="nm">Client name</div><div class="rl">Role, Company</div></div></div>
      </article>
      <article class="tcard">
        <div class="stars" aria-label="5 out of 5">★★★★★</div>
        <blockquote>“The branding finally looks like the business I always wanted to run. Enquiries went up almost immediately.”</blockquote>
        <div class="who"><span class="av"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-6.5 8-6.5S20 17 20 21"/></svg></span><div><div class="nm">Client name</div><div class="rl">Role, Company</div></div></div>
      </article>
      <article class="tcard">
        <div class="stars" aria-label="5 out of 5">★★★★★</div>
        <blockquote>“As a creator, I finally have a team that treats my channel like a business. Better deals, less burnout.”</blockquote>
        <div class="who"><span class="av"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-6.5 8-6.5S20 17 20 21"/></svg></span><div><div class="nm">Creator name</div><div class="rl">Content creator</div></div></div>
      </article>
    </div>
    <p class="placeholder-note">// Placeholder quotes — send real testimonials and we'll drop them in with client photos.</p>
  </div>
</section>

<!-- ============ AUDIENCE ============ -->
<section class="band band-line" id="who">
  <div class="wrap">
    <div class="sec-head up">
      <span class="eyebrow">Who we help</span>
      <h2>Built for the two people who bet on their name.</h2>
    </div>
    <div class="aud up">
      <article class="aud-card">
        <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-6.5 8-6.5S20 17 20 21"/><path d="M18.5 4.5l1 2 2 .8-2 .8-1 2-1-2-2-.8 2-.8z"/></svg>
        <h3>Creators &amp; Influencers</h3>
        <p>Grow your audience, land better brand deals and launch your own products — with a team that treats your name like the asset it is.</p>
        <div class="k"><b>Audience growth</b><b>Brand deals</b><b>Own products</b><b>Personal brand</b></div>
      </article>
      <article class="aud-card">
        <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M3 21h18"/><path d="M5 21V8l7-4 7 4v13"/><path d="M9 21v-6h6v6"/><path d="M9 11h.01M15 11h.01"/></svg>
        <h3>Businesses &amp; Founders</h3>
        <p>From local shops to funded startups — more qualified leads, more revenue per customer, and less time lost to manual work.</p>
        <div class="k"><b>Lead generation</b><b>E-commerce</b><b>Automation</b><b>Custom software</b></div>
      </article>
    </div>
  </div>
</section>

<!-- ============ BLOG TEASER ============ -->
<?php
$thumbs   = require get_template_directory() . '/inc/blog-thumbs.php';
$blog_url = amatchless_blog_url();
// Real posts once there are any (the default "Hello world!" post doesn't count).
$hello    = get_page_by_path('hello-world', OBJECT, 'post');
$posts_q  = new WP_Query([
    'posts_per_page'      => 3,
    'post_status'         => 'publish',
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
    'post__not_in'        => $hello ? [$hello->ID] : [],
]);
// Shown until the first real articles are published.
$fallback = [
    ['cat' => 'Automation', 'read' => '6 min read', 'title' => '5 marketing tasks you should automate this month',      'text' => 'The quick wins that free up hours every week without losing the human touch.'],
    ['cat' => 'Branding',   'read' => '5 min read', 'title' => 'Why your brand feels forgettable (and how to fix it)',  'text' => 'A simple framework to make your business instantly recognisable.'],
    ['cat' => 'Paid Ads',   'read' => '7 min read', 'title' => 'The creator\'s guide to your first profitable ad',      'text' => 'From offer to targeting to creative — a beginner-friendly walkthrough.'],
];
?>
<section class="band band-line" id="blog">
  <div class="wrap">
    <div class="sec-head up">
      <span class="eyebrow">From the journal</span>
      <h2>Ideas on brand, growth and automation.</h2>
      <p class="lede">Practical thinking for creators and founders — the same playbooks we use for clients.</p>
    </div>
    <div class="posts up">
      <?php if ($posts_q->have_posts()) : $n = 0; while ($posts_q->have_posts()) : $posts_q->the_post(); $t = $thumbs[$n++ % 3];
        $cats  = get_the_category();
        $words = str_word_count(wp_strip_all_tags(get_the_content()));
      ?>
      <a class="pcard" href="<?php the_permalink(); ?>">
        <div class="media <?php echo esc_attr($t['class']); ?>">
          <?php if (has_post_thumbnail()) : the_post_thumbnail('medium_large', ['alt' => '']); else : ?><span class="bthumb"><?php echo $t['svg']; ?></span><?php endif; ?>
        </div>
        <div class="pmeta"><span class="cat"><?php echo esc_html($cats ? $cats[0]->name : 'Journal'); ?></span><span>·</span><span><?php echo esc_html(max(1, (int) ceil($words / 220))); ?> min read</span></div>
        <h3><?php the_title(); ?></h3>
        <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 18, '…')); ?></p>
        <span class="rd">Read article →</span>
      </a>
      <?php endwhile; wp_reset_postdata(); else : foreach ($fallback as $i => $p) : $t = $thumbs[$i]; ?>
      <div class="pcard">
        <div class="media <?php echo esc_attr($t['class']); ?>"><span class="bthumb"><?php echo $t['svg']; ?></span></div>
        <div class="pmeta"><span class="cat"><?php echo esc_html($p['cat']); ?></span><span>·</span><span><?php echo esc_html($p['read']); ?></span></div>
        <h3><?php echo esc_html($p['title']); ?></h3>
        <p><?php echo esc_html($p['text']); ?></p>
        <span class="rd">Coming soon</span>
      </div>
      <?php endforeach; endif; ?>
    </div>
    <?php if ($blog_url && $posts_q->post_count) : ?>
    <div class="work-more"><a href="<?php echo esc_url($blog_url); ?>" class="btn btn-ghost">Visit the blog ↗</a></div>
    <?php endif; ?>
  </div>
</section>

<!-- ============ CTA / CONTACT ============ -->
<section class="band band-line" id="contact">
  <div class="wrap">
    <div class="cta up">
      <span class="eyebrow" style="justify-content:center">Let's talk</span>
      <h2 style="margin-top:20px">Let's build something <span class="flame">matchless.</span></h2>
      <p>Tell us where you want to be in twelve months. We'll show you the brand, the campaigns and the systems to get there.</p>
      <div class="cta-actions">
        <a href="#book" class="btn btn-primary" id="ctaBook">Book a strategy call <span class="arw" aria-hidden="true">↗</span></a>
        <a href="#services" class="btn btn-ghost">See what we do</a>
      </div>
      <div class="email-row">
        <span>Prefer email?</span>
        <span class="em" id="email"><?php echo esc_html(AMATCHLESS_EMAIL); ?></span>
        <button class="copy" id="copyEmail" type="button">Copy</button>
      </div>
    </div>

    <div class="lead up" id="book">
      <div class="lead-info">
        <span class="eyebrow">Book a strategy call</span>
        <h3>30 minutes. Zero commitment. Real ideas for your brand.</h3>
        <p class="lede">Tell us about your business and we'll reply within 24 hours with honest thoughts — no sales pitch, no pressure.</p>
        <div class="lead-contacts">
          <a href="mailto:<?php echo esc_attr(AMATCHLESS_EMAIL); ?>"><span class="k">Email</span><span class="v"><?php echo esc_html(AMATCHLESS_EMAIL); ?></span></a>
          <a href="tel:<?php echo esc_attr(AMATCHLESS_PHONE_E164); ?>"><span class="k">Call</span><span class="v"><?php echo esc_html(AMATCHLESS_PHONE); ?></span></a>
          <a href="<?php echo esc_url(AMATCHLESS_WHATSAPP); ?>" target="_blank" rel="noopener"><span class="k">WhatsApp</span><span class="v">Chat with the team ↗</span></a>
        </div>
      </div>
      <div class="lead-form">
        <form id="leadForm" novalidate>
          <div class="form-row">
            <div class="form-grp">
              <label class="form-lbl" for="f-name">Your name *</label>
              <input class="form-ctrl" type="text" id="f-name" name="name" placeholder="Full name" required autocomplete="name">
            </div>
            <div class="form-grp">
              <label class="form-lbl" for="f-co">Business name *</label>
              <input class="form-ctrl" type="text" id="f-co" name="company" placeholder="Company / brand" required autocomplete="organization">
            </div>
          </div>
          <div class="form-row">
            <div class="form-grp">
              <label class="form-lbl" for="f-email">Email *</label>
              <input class="form-ctrl" type="email" id="f-email" name="email" placeholder="you@company.com" required autocomplete="email">
            </div>
            <div class="form-grp">
              <label class="form-lbl" for="f-phone">Phone</label>
              <input class="form-ctrl" type="tel" id="f-phone" name="phone" placeholder="+91 98765 43210" autocomplete="tel">
            </div>
          </div>
          <div class="form-row">
            <div class="form-grp">
              <label class="form-lbl" for="f-service">Service</label>
              <select class="form-ctrl" id="f-service" name="service">
                <option value="">Select a service</option>
                <option>Branding</option>
                <option>Content Marketing</option>
                <option>Social Media Marketing</option>
                <option>SEO</option>
                <option>Google &amp; Meta Ads</option>
                <option>Web Development</option>
                <option>Automations</option>
                <option>Custom Software</option>
                <option>Not sure yet</option>
              </select>
            </div>
            <div class="form-grp">
              <label class="form-lbl" for="f-budget">Monthly budget</label>
              <select class="form-ctrl" id="f-budget" name="budget">
                <option value="">Select a range</option>
                <option>Under ₹40,000/month</option>
                <option>₹40,000 – ₹80,000/month</option>
                <option>₹80,000 – ₹2,00,000/month</option>
                <option>₹2,00,000+/month</option>
                <option>Prefer to discuss</option>
              </select>
            </div>
          </div>
          <div class="form-grp">
            <label class="form-lbl" for="f-msg">Your goals</label>
            <textarea class="form-ctrl" id="f-msg" name="message" placeholder="Where do you want to be in twelve months? What's not working today?"></textarea>
          </div>
          <button type="submit" class="btn btn-primary form-submit">Book my strategy call <span class="arw" aria-hidden="true">↗</span></button>
          <p class="form-note">Confidential. No spam. We reply within 24 hours.</p>
        </form>
        <div class="form-success" id="formOk" tabindex="-1" hidden>
          <div class="tick" aria-hidden="true">✓</div>
          <h3>You're all set.</h3>
          <p>We've got your details. Expect to hear from the Amatchless team within 24 hours.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
