<?php get_header(); ?>
<?php
$team = get_template_directory_uri() . '/assets/img/team/';
$ver  = '?ver=' . AMATCHLESS_VERSION;

// Open roles. Empty = the "no open roles" card. To post a role, add a row with:
// title, openings (number), type ('Internship' or 'Full-time'), pay ([min, max] rupees a month, or null for
// "Salary based on experience"), length (internships only, e.g. '3 months, extendable to 6'), text (one or two sentences),
// do / need / learn (short bullet lists for the full description), posted (Y-m-d, for Google's job schema).
// To close a role, delete its row. Location is the office address in functions.php (AMATCHLESS_ADDRESS).
$roles = [
  [
    'title'    => 'Social Media Intern',
    'openings' => 2,
    'type'     => 'Internship',
    'pay'      => [2000, 3000],
    'length'   => '3 months, extendable to 6',
    'posted'   => '2026-11-22',
    'text'     => 'Learn how an agency runs social media for real brands. You\'ll help plan, write and schedule content, and see how SMM, SMO and ORM work day to day.',
    'do'       => [
      'Help build monthly content calendars for client brands on Instagram, Facebook and LinkedIn',
      'Write captions, research hashtags and find trending audio and reel ideas',
      'Schedule posts and keep an eye on comments, messages and reviews',
      'Track reach, engagement and follower growth, and help put together monthly client reports',
      'Support the team on shoots and influencer outreach',
    ],
    'need'     => [
      'You use social media every day and notice what makes a post work',
      'Good written English (Hindi is a plus)',
      'Basic Canva skills, or happy to learn them in week one',
      'A student or recent graduate in marketing, mass communication or a related field. Any background is welcome if you can show us your work',
    ],
    'learn'    => [
      'How SMM, SMO, ORM and Meta ads fit together on a live brand',
      'Writing content briefs and calendars that clients approve',
      'Reading Meta Business Suite insights and turning them into a clear report',
      'Real work for real brands to put in your portfolio',
    ],
  ],
  [
    'title'    => 'Social Media Manager',
    'openings' => 1,
    'type'     => 'Full-time',
    'pay'      => null,
    'posted'   => '2026-11-22',
    'text'     => 'Own social media for a set of client brands, from strategy and content calendars to community management, online reputation and monthly reporting.',
    'do'       => [
      'Build social media strategies and monthly content calendars that match each client\'s business goals',
      'Lead content production with our designer and video editor: write briefs and copy, review work and get client approval',
      'Run publishing, community management and online reputation (comments, DMs and reviews) across platforms',
      'Work with our Meta ads team so organic posts and paid campaigns pull in the same direction',
      'Report on reach, engagement, leads and growth every month, and walk clients through the results',
      'Guide and review the work of our social media interns',
    ],
    'need'     => [
      '2+ years managing social media for brands, at an agency or in-house',
      'Strong copywriting and a steady flow of reel and content ideas',
      'Confident with Meta Business Suite, Instagram, Facebook, LinkedIn and YouTube',
      'Comfortable with analytics, and on calls with clients',
      'Working knowledge of Meta Ads Manager, SEO or ORM tools is a plus',
    ],
    'learn'    => [
      'Run accounts end to end, with direct client contact from day one',
      'Work across SEO, SMO, ORM and paid ads, not only organic posting',
      'Help shape how the team works and lead the interns as we grow',
    ],
  ],
  [
    'title'    => 'Graphic Designer',
    'openings' => 1,
    'type'     => 'Full-time',
    'pay'      => null,
    'posted'   => '2026-11-22',
    'text'     => 'Design posts, carousels, ad creatives and brand assets for our clients, and keep every brand looking consistent across platforms.',
    'do'       => [
      'Design social posts, carousels, stories and reel covers from content briefs',
      'Create Meta ad creatives in several sizes and variants for testing',
      'Build brand guidelines and templates for each client, and stick to them',
      'Take on brand work when it comes up: logos, brochures, banners and website graphics',
      'Turn feedback from the social team and clients into quick revisions',
    ],
    'need'     => [
      'A portfolio with social media or digital work',
      'Strong in Adobe Photoshop and Illustrator. Canva and Figma are a plus',
      'A good eye for typography, layout and colour',
      'Basic motion design (After Effects or similar) is a bonus',
      '1+ year of experience. Freshers with a strong portfolio are welcome to apply',
    ],
    'learn'    => [
      'See how your ad creatives perform (clicks, cost per lead) and design with the numbers',
      'Work across fashion, wellness, toys, tourism and more',
    ],
  ],
  [
    'title'    => 'Video Editor',
    'openings' => 1,
    'type'     => 'Full-time',
    'pay'      => null,
    'posted'   => '2026-11-22',
    'text'     => 'Edit reels, shorts, ads and brand videos for our clients. Turn raw footage into short videos that hold attention and get results.',
    'do'       => [
      'Edit Instagram Reels, YouTube Shorts and video ads from raw footage, stock and creator content',
      'Add captions, motion text, transitions, sound design and colour correction',
      'Cut versions and sizes (9:16, 1:1, 16:9) for organic posts and paid campaigns',
      'Keep up with trends, hooks and audio, and pitch ideas to the social team',
      'Keep project files organised and deliver on time across several clients',
      'Guide our video editing interns',
    ],
    'need'     => [
      'A portfolio of short-form edits: reels, shorts or ads',
      'Strong in Premiere Pro or DaVinci Resolve. After Effects and CapCut are a plus',
      'A feel for hooks, pacing and keeping viewers watching',
      '1+ year of editing experience',
    ],
    'learn'    => [
      'Edit ads for Meta campaigns and see which cuts bring in leads',
      'Work on shoots and help plan video content with the social team',
    ],
  ],
  [
    'title'    => 'Video Editor Intern',
    'openings' => 2,
    'type'     => 'Internship',
    'pay'      => [2000, 3000],
    'length'   => '3 months, extendable to 6',
    'posted'   => '2026-11-22',
    'text'     => 'Learn short-form video editing on real client work. You\'ll cut reels, add captions and music, and learn what makes a video perform on social media.',
    'do'       => [
      'Edit reels and stories from raw footage, guided by our video editor',
      'Add captions, text animation, music and simple transitions',
      'Resize and export videos for each platform',
      'Organise footage and project files',
      'Help on shoots and capture behind-the-scenes content',
      'Research trending formats and audio',
    ],
    'need'     => [
      'Basic editing skills in Premiere Pro, CapCut, DaVinci Resolve or similar',
      'A few sample edits. College or personal projects count',
      'An eye for detail and timing',
      'Keen to learn and happy to take feedback',
    ],
    'learn'    => [
      'A professional editing workflow, from raw footage to final export',
      'Hooks, pacing and how to keep viewers watching',
      'How video ads are cut and tested for Meta campaigns',
      'Real work for real brands to put in your showreel',
    ],
  ],
];
$where    = AMATCHLESS_SHOW_ADDRESS ? AMATCHLESS_ADDRESS : 'Rohini, Delhi';
$hours    = '9:30 AM to 6:00 PM';   // office hours, shown on every role
$openings = array_sum(array_column($roles, 'openings'));

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

// Apply links for one role: an email with the subject and a short checklist, or the contact form with the
// role filled in (assets/js/site.js reads ?role= and picks "Careers / joining the team").
if (!function_exists('amatchless_role_mail')) : function amatchless_role_mail($title) {
    $body = "Hi Amatchless team,\n\nI'd like to apply for the {$title} role.\n\nCV / LinkedIn:\nPortfolio or work samples:\nWhy Amatchless:\n";
    return 'mailto:' . AMATCHLESS_EMAIL . '?subject=' . rawurlencode('Careers: ' . $title) . '&body=' . rawurlencode($body);
} endif;

if (!function_exists('amatchless_role_pay')) : function amatchless_role_pay($r) {
    if (empty($r['pay'])) return 'Salary based on experience';
    [$lo, $hi] = $r['pay'];
    $label = $r['type'] === 'Internship' ? 'Stipend' : 'Salary';
    return $label . ' ₹' . number_format($lo) . ($hi && $hi !== $lo ? ' to ₹' . number_format($hi) : '') . ' a month';
} endif;

// Google job listing schema, one JobPosting per role
if ($roles) {
    $jobs = [];
    foreach ($roles as $r) {
        $desc = '<p>' . esc_html($r['text']) . '</p><p>' . esc_html((!empty($r['length']) ? 'Internship: ' . $r['length'] . ' months. ' : '') . amatchless_role_pay($r) . '. Office hours ' . $hours . ', work from office.') . '</p>';
        foreach (['do' => 'What you\'ll do', 'need' => 'What you\'ll need', 'learn' => ($r['type'] === 'Internship' ? 'What you\'ll learn' : 'How you\'ll grow')] as $k => $h) {
            $desc .= '<p><strong>' . esc_html($h) . '</strong></p><ul><li>' . implode('</li><li>', array_map('esc_html', $r[$k])) . '</li></ul>';
        }
        $job = [
            '@type'              => 'JobPosting',
            'title'              => $r['title'],
            'description'        => $desc,
            'datePosted'         => $r['posted'],
            'employmentType'     => $r['type'] === 'Internship' ? 'INTERN' : 'FULL_TIME',
            'totalJobOpenings'   => $r['openings'],
            'workHours'          => $hours,
            'directApply'        => false,
            'hiringOrganization' => ['@type' => 'Organization', 'name' => 'Amatchless', 'sameAs' => home_url('/')],
            'jobLocation'        => ['@type' => 'Place', 'address' => array_filter([
                '@type'           => 'PostalAddress',
                'streetAddress'   => AMATCHLESS_SHOW_ADDRESS ? preg_replace('/,\s*Delhi\s*\d{6}$/', '', AMATCHLESS_ADDRESS) : null,
                'addressLocality' => 'Delhi',
                'addressRegion'   => 'Delhi',
                'postalCode'      => AMATCHLESS_SHOW_ADDRESS && preg_match('/(\d{6})$/', AMATCHLESS_ADDRESS, $pin) ? $pin[1] : null,
                'addressCountry'  => 'IN',
            ])],
        ];
        if (!empty($r['pay'])) {
            $job['baseSalary'] = ['@type' => 'MonetaryAmount', 'currency' => 'INR', 'value' => [
                '@type' => 'QuantitativeValue', 'minValue' => $r['pay'][0], 'maxValue' => $r['pay'][1], 'unitText' => 'MONTH']];
        }
        $jobs[] = $job;
    }
    echo '<script type="application/ld+json">' . wp_json_encode(['@context' => 'https://schema.org', '@graph' => $jobs], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
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
      <p class="sec-aside"><?php if ($roles) : ?><b><?php echo esc_html($openings . ' openings across ' . count($roles) . ' roles.'); ?></b> All roles are work from office at our Rohini, Delhi office, <?php echo esc_html($hours); ?>. Open a role for the full description, then apply by email or the form.<?php else : ?>We hire as our client list grows. New roles are posted here first.<?php endif; ?></p>
    </div>

    <?php if ($roles) : ?>
    <ul class="cr-roles">
      <?php foreach ($roles as $r) :
        $n     = (int) $r['openings'];
        $intern = $r['type'] === 'Internship';
        $form  = add_query_arg('role', rawurlencode($r['title']), $contact); ?>
      <li class="cr-role reveal">
        <div class="cr-role-top">
          <h3><?php echo esc_html($r['title']); ?></h3>
          <ul class="cr-tags">
            <li><span class="sx-tag" style="--c:<?php echo $intern ? '#3DEBB0' : '#5B2EFF'; ?>"><?php echo esc_html(strtoupper($r['type'])); ?></span></li>
            <li><span class="sx-tag" style="--c:#FF4F9A"><?php echo esc_html($n . ($n === 1 ? ' OPENING' : ' OPENINGS')); ?></span></li>
            <li><span class="sx-tag" style="--c:#FFE14D">WORK FROM OFFICE</span></li>
          </ul>
        </div>
        <ul class="cr-facts">
          <li><svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24"><path d="M12 2a7 7 0 0 0-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 0 0-7-7zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z" fill="currentColor"/></svg><span><?php echo esc_html($where); ?></span></li>
          <li><svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20zm1 10.4 3.2 3.2-1.4 1.4L11 13.2V6h2z" fill="currentColor"/></svg><span><?php echo esc_html($hours); ?></span></li>
          <li><svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24"><path d="M6 3h12v2h-4.3c.5.6.9 1.3 1.1 2H18v2h-3.2a5 5 0 0 1-4.6 4H9.4l6.3 7h-2.7l-6.3-7v-2h3.5a3 3 0 0 0 2.8-2H6V7h6.8a3 3 0 0 0-2.8-2H6z" fill="currentColor"/></svg><span><?php echo esc_html(amatchless_role_pay($r)); ?></span></li>
          <?php if (!empty($r['length'])) : ?><li><svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24"><path d="M7 2h2v2h6V2h2v2h3v18H4V4h3zm-1 8v10h12V10z" fill="currentColor"/></svg><span><?php echo esc_html($r['length'] . ' months'); ?></span></li><?php endif; ?>
        </ul>
        <p class="cr-role-text"><?php echo esc_html($r['text']); ?></p>
        <details class="cr-more">
          <summary>Full job description</summary>
          <div class="cr-more-grid">
            <?php foreach (['do' => 'What you\'ll do', 'need' => 'What you\'ll need', 'learn' => ($intern ? 'What you\'ll learn' : 'How you\'ll grow')] as $k => $h) : ?>
            <div>
              <h4><?php echo esc_html($h); ?></h4>
              <ul><?php foreach ($r[$k] as $line) : ?><li><?php echo esc_html($line); ?></li><?php endforeach; ?></ul>
            </div>
            <?php endforeach; ?>
          </div>
        </details>
        <div class="btn-row cr-role-btns">
          <a class="btn btn-ink" href="<?php echo esc_attr(amatchless_role_mail($r['title'])); ?>" data-careers="email">Apply by email <span aria-hidden="true">↗</span></a>
          <a class="btn btn-white" href="<?php echo esc_url($form); ?>" data-careers="form">Apply with the form</a>
        </div>
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
