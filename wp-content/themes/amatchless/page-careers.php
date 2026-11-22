<?php get_header(); ?>
<?php
$team = get_template_directory_uri() . '/assets/img/team/';
$ver  = '?ver=' . AMATCHLESS_VERSION;

// Open roles. Empty = the "no open roles" card. To post a role, add a row:
// ['title' => 'Social Media Executive', 'type' => 'Full-time', 'where' => 'Delhi / hybrid', 'text' => 'One or two sentences on the role.'],
$roles = [];

// Why work here: [colour, title, text]
$reasons = [
  ['#FFE14D', 'Work on live brands',      'You\'ll plan content and run Meta ad campaigns for real businesses, from fashion and wellness to toys and tourism. No mock briefs.'],
  ['#3DEBB0', 'Learn from the leads',     'A small team with no layers. You work right beside the people who pitch, plan and report, and you get straight feedback on your work.'],
  ['#FF4F9A', 'Own your numbers',         'We report reach, leads and return on ad spend to clients in plain language. You\'ll see exactly how your work moves those numbers.'],
  ['#FFFFFF', 'Grow as we grow',          'New clients keep coming on board. The people who join early help shape how we work, and take on more as the team grows.'],
];

// The kind of work roles here involve (shown on the openings card)
$skills = ['Social media management', 'Content calendars', 'Reels & short video', 'Graphic design', 'Copywriting', 'Meta ads', 'Reporting & analytics', 'Client servicing'];

$apply_mail = 'mailto:' . AMATCHLESS_EMAIL . '?subject=' . rawurlencode('Careers: [the role you\'re interested in]');
$contact    = amatchless_page_url('contact');
$contact    = $contact . (str_contains($contact, '#') ? '' : '#contact');
?>

<!-- ============ CAREERS HERO ============ -->
<section class="page-head ct-head">
  <div class="blob page-blob" aria-hidden="true"></div>
  <svg class="float2 hide-sm ct-spark" aria-hidden="true" width="64" height="64" viewBox="0 0 40 40"><path d="M20 0 L24 16 L40 20 L24 24 L20 40 L16 24 L0 20 L16 16 Z" fill="#3DEBB0"/></svg>
  <div class="sec-in ct-head-in">
    <div class="ct-head-copy">
      <span class="pill-dark pop"><span class="pulse-dot" aria-hidden="true"></span>CAREERS</span>
      <h1 class="h1 rise d1">Grow brands. Grow <span class="hl-purple">with them.</span></h1>
      <p class="hero-lede rise d2">Amatchless is a growing digital marketing team. We run social media and Meta ads for brands across India, the US and Canada. We keep the team small on purpose, so everyone who joins does work that matters from week one.</p>
      <div class="btn-row rise d3">
        <a class="btn btn-pink btn-lg" href="#openings">See open roles</a>
        <a class="btn btn-white btn-lg" href="#apply">Send your CV <span aria-hidden="true">↗</span></a>
      </div>
    </div>

    <figure class="ct-hotline cr-hotline pop d4">
      <figcaption class="ch-caption">Creative Head, scouting</figcaption>
      <img class="ct-kim" src="<?php echo esc_url($team . 'blossom.svg' . $ver); ?>" width="320" height="300" decoding="async" alt="Cartoon of Blossom, our Creative Head">
      <p class="bubble bubble-solo has-tail"><b class="bubble-who" style="background:#FF4F9A">Blossom</b>We look for people who care about the work as much as the numbers.</p>
    </figure>
  </div>
</section>

<!-- ============ WHY WORK WITH US ============ -->
<section class="sec sec-tight" id="why" aria-labelledby="cr-why-title">
  <div class="sec-in">
    <div class="sec-split reveal">
      <div class="sec-head">
        <span class="label" style="color:#5B2EFF">WHY AMATCHLESS</span>
        <h2 class="h2" id="cr-why-title">Real brands. Real budgets. <span class="mark-yellow">Real responsibility.</span></h2>
      </div>
      <p class="sec-aside">The same standards we promise clients apply to how we work together: clear goals, honest feedback and nothing hidden behind jargon.</p>
    </div>
    <div class="value-grid">
      <?php foreach ($reasons as [$bg, $title, $text]) : ?>
      <div class="value reveal" style="background:<?php echo esc_attr($bg); ?>"><h3><?php echo esc_html($title); ?></h3><p><?php echo esc_html($text); ?></p></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ CURRENT OPENINGS ============ -->
<section class="sec sec-yellow cr-open" id="openings" aria-labelledby="cr-open-title">
  <div class="sec-in">
    <div class="sec-split reveal">
      <div class="sec-head">
        <span class="label" style="color:#5B2EFF">CURRENT OPENINGS</span>
        <h2 class="h2" id="cr-open-title">Open roles</h2>
      </div>
      <p class="sec-aside">We hire as our client list grows. New roles are posted here first.</p>
    </div>

    <?php if ($roles) : ?>
    <ul class="cr-roles">
      <?php foreach ($roles as $r) : ?>
      <li class="cr-role reveal">
        <div class="cr-role-body">
          <h3><?php echo esc_html($r['title']); ?></h3>
          <p class="work-svc"><?php echo esc_html(strtoupper($r['type'] . ' · ' . $r['where'])); ?></p>
          <p><?php echo esc_html($r['text']); ?></p>
        </div>
        <a class="btn btn-ink" href="<?php echo esc_attr('mailto:' . AMATCHLESS_EMAIL . '?subject=' . rawurlencode('Careers: ' . $r['title'])); ?>">Apply <span aria-hidden="true">↗</span></a>
      </li>
      <?php endforeach; ?>
    </ul>
    <?php else : ?>
    <div class="cr-empty reveal">
      <div class="cr-empty-art" aria-hidden="true"><img src="<?php echo esc_url($team . 'kim.svg' . $ver); ?>" width="320" height="300" loading="lazy" decoding="async" alt=""></div>
      <div class="cr-empty-body">
        <span class="sx-tag" style="--c:#FF4F9A">NO OPEN ROLES RIGHT NOW</span>
        <h3>Nothing open today. Check back soon.</h3>
        <p>We don't have a position open at the moment, but we're always glad to hear from good people. When a role opens up, we look at the speculative applications on file first.</p>
        <div class="cr-skills">
          <span class="label">Roles here usually involve</span>
          <ul class="chips">
            <?php foreach ($skills as $s) : ?><li><span><?php echo esc_html($s); ?></span></li><?php endforeach; ?>
          </ul>
        </div>
        <a class="btn btn-pink" href="#apply">Send a speculative application <span aria-hidden="true">↓</span></a>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- ============ SPECULATIVE APPLICATIONS ============ -->
<section class="cta-sec cr-apply" id="apply">
  <div class="cta">
    <div class="blob cta-blob" aria-hidden="true"></div>
    <svg class="float hide-sm cta-star" aria-hidden="true" width="110" height="110" viewBox="0 0 40 40"><path d="M20 0 L24 16 L40 20 L24 24 L20 40 L16 24 L0 20 L16 16 Z" fill="#FFE14D"/></svg>
    <div class="cta-grid">
      <div class="cta-copy">
        <span class="label" style="color:#FFE14D">SPECULATIVE APPLICATIONS</span>
        <h2 class="h2 h2-xl reveal">Don't see your role? <span style="color:#FFE14D">Pitch us.</span></h2>
        <p class="cta-lede">Email us or use the contact form, and tell us which role you're interested in. We read every application and keep strong ones on file for the next opening.</p>
        <div class="btn-row">
          <a class="btn btn-yellow btn-lg" href="<?php echo esc_attr($apply_mail); ?>" data-careers="email">Email your application <span aria-hidden="true">↗</span></a>
          <a class="btn btn-outline-white btn-lg" href="<?php echo esc_url($contact); ?>" data-careers="form">Use the contact form</a>
        </div>
        <p class="cr-note">Using the form? Choose <b>"Careers / joining the team"</b> under Service and name the role in your message.</p>
      </div>

      <div class="lead-card cr-checklist">
        <p class="lead-title">What to include</p>
        <ol class="cr-list">
          <li><b>The role you're after.</b> Put it in the email subject, for example "Careers: Meta Ads Executive".</li>
          <li><b>Your CV or LinkedIn profile.</b> A short one is fine.</li>
          <li><b>Two or three pieces of work.</b> Posts, campaigns, reels, designs or a portfolio link. Tell us what you did and how it performed.</li>
          <li><b>Why Amatchless.</b> One or two lines is plenty.</li>
        </ol>
        <p class="form-note">Applications go to <a href="mailto:<?php echo esc_attr(AMATCHLESS_EMAIL); ?>"><?php echo esc_html(AMATCHLESS_EMAIL); ?></a>.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ HERE AS A CLIENT? ============ -->
<section class="sec sec-tight cr-clients" aria-labelledby="cr-clients-title">
  <div class="sec-in">
    <div class="sec-split reveal">
      <div class="sec-head">
        <span class="label" style="color:#5B2EFF">HERE AS A CLIENT?</span>
        <h2 class="h2" id="cr-clients-title">This is the team that would run your <span class="hl-purple">brand.</span></h2>
      </div>
      <p class="sec-aside">We hire for care and craft because that's what our clients get. Brands we work with today:</p>
    </div>
    <ul class="chips cr-brands reveal">
      <?php foreach (amatchless_client_names() as $name) : ?><li><span><?php echo esc_html($name); ?></span></li><?php endforeach; ?>
    </ul>
    <div class="btn-row reveal">
      <a class="btn btn-pink btn-lg" <?php echo amatchless_calendly_attrs(); ?>>Book a discovery call <span aria-hidden="true">↗</span></a>
      <a class="btn btn-white btn-lg" href="<?php echo esc_url(amatchless_page_url('work')); ?>">See our work</a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
