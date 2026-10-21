<?php
/* A project's case study, told as a four-chapter comic story. Content: inc/cases.php. */
$case  = amatchless_current_case();
$cases = amatchless_cases();
$cast  = amatchless_case_cast($case);
$slugs = array_keys($cases);
$pos   = array_search($case['slug'], $slugs, true);
$next_slug = $slugs[($pos + 1) % count($slugs)];
$next  = $cases[$next_slug];
$host  = preg_replace('#^https?://(www\.)?#', '', $case['site']);
$word_html = ['br' => [], 'i' => []];

// Panel colours per chapter: the brand, Bravo's yellow, lab lavender, a fresh mint.
$tints   = [$case['bg'], $case['bg'] === '#FFE14D' ? '#FFC2DD' : '#FFE14D', '#E9E2FF', '#C9F7E6'];
$kickers = ['The situation', 'The conversation', 'The work', 'The result'];
$on_dark = fn($c) => in_array(strtoupper($c), ['#5B2EFF', '#0E0B1F'], true);

// Comic "sound effect" starburst outline.
$burst = [];
for ($k = 0; $k < 28; $k++) {
    $r = $k % 2 ? 40 : 58;
    $a = M_PI * $k / 14;
    $burst[] = round(60 + $r * cos($a), 1) . ',' . round(60 + $r * sin($a), 1);
}
$burst = implode(' ', $burst);

get_header();
?>

<section class="page-head cs-head">
  <div class="blob page-blob" aria-hidden="true"></div>
  <div class="sec-in cs-head-in">
    <div class="cs-head-copy">
      <a class="cs-back" href="<?php echo esc_url(amatchless_page_url('work')); ?>">← All work</a>
      <span class="pill-dark pop"><span class="pulse-dot" aria-hidden="true"></span>Case study · <?php echo esc_html($case['label']); ?></span>
      <h1 class="h1 h1-post rise d1"><?php echo esc_html($case['title']); ?></h1>
      <p class="hero-lede rise d2"><?php echo esc_html($case['lede']); ?></p>
      <div class="chips rise d3"><?php foreach ($case['services'] as $s) : ?><span><?php echo esc_html($s); ?></span><?php endforeach; ?></div>
      <div class="btn-row rise d3">
        <a class="btn btn-ink btn-lg" href="#story">Read the story <span aria-hidden="true">↓</span></a>
        <a class="btn btn-white btn-lg" href="<?php echo esc_url($case['site']); ?>" target="_blank" rel="noopener">Visit <?php echo esc_html($host); ?> <span aria-hidden="true">↗</span></a>
      </div>
    </div>
    <div class="cs-cover pop d2" style="background:<?php echo esc_attr($case['bg']); ?>">
      <span class="wbadge tilt" style="background:#FFFFFF"><?php echo esc_html($case['badge']); ?></span>
      <span class="work-word<?php echo strpos($case['word'], '<br>') ? ' is-long' : ''; ?>" style="color:<?php echo esc_attr($case['fg']); ?>"><?php echo wp_kses($case['word'], $word_html); ?></span>
      <img src="<?php echo esc_url($cast['client']['img']); ?>" width="320" height="300" decoding="async" alt="<?php echo esc_attr('Cartoon of ' . $case['client']['name']); ?>">
      <span class="cs-cover-tag">A story in four chapters</span>
    </div>
  </div>
</section>

<section class="sec sec-tight" id="story">
  <div class="sec-in">
    <div class="sec-split reveal">
      <div class="sec-head">
        <span class="label" style="color:#5B2EFF">STARRING</span>
        <h2 class="h2">The cast.</h2>
      </div>
      <p class="sec-aside">One client with a challenge, and the part of our crew that took it on. Cartoon versions, naturally.</p>
    </div>
    <ul class="cs-cast reveal">
      <?php foreach ($cast as $who => $c) : ?>
      <li class="cast<?php echo $who === 'client' ? ' cast-client' : ''; ?>">
        <div class="cast-art" style="background:<?php echo esc_attr($c['bg']); ?>"><img src="<?php echo esc_url($c['img']); ?>" width="320" height="300" loading="lazy" decoding="async" alt=""></div>
        <b><?php echo esc_html($c['name']); ?></b>
        <span><?php echo esc_html($c['role']); ?></span>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

<section class="sec sec-tight cs-story">
  <div class="sec-in">
    <?php foreach ($case['chapters'] as $n => $ch) :
        $speakers = array_values(array_unique(array_column($ch['say'], 0)));
        $tint = $tints[$n % count($tints)];
        $last = $n === count($case['chapters']) - 1;
    ?>
    <article class="chapter reveal" id="chapter-<?php echo $n + 1; ?>">
      <div class="ch-copy">
        <div class="ch-top">
          <span class="ch-num" aria-hidden="true"><?php echo $n + 1; ?></span>
          <span class="label ch-kicker">Chapter <?php echo $n + 1; ?> · <?php echo esc_html($kickers[$n] ?? ''); ?></span>
        </div>
        <h2 class="ch-title"><?php echo esc_html($ch['title']); ?></h2>
        <p><?php echo esc_html($ch['text']); ?></p>
        <?php if (!empty($ch['built'])) : ?>
        <ul class="ch-built" aria-label="What we built">
          <?php foreach ($ch['built'] as $b) : ?><li><?php echo esc_html($b); ?></li><?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <?php if ($last) : ?>
        <div class="metrics">
          <?php foreach ($case['metrics'] as [$v, $l]) : ?>
          <div class="metric"><span class="metric-v"><?php echo esc_html($v); ?></span><span class="metric-l"><?php echo wp_kses($l, []); ?></span></div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>

      <figure class="ch-panel<?php echo $on_dark($tint) ? ' is-dark' : ''; ?>" style="background-color:<?php echo esc_attr($tint); ?>">
        <figcaption class="ch-caption"><?php echo esc_html($ch['caption']); ?></figcaption>
        <svg class="ch-sfx" viewBox="0 0 120 120" aria-hidden="true"><polygon points="<?php echo esc_attr($burst); ?>" fill="#FFE14D" stroke="#0E0B1F" stroke-width="3" stroke-linejoin="round"/><text x="60" y="66" text-anchor="middle"><?php echo esc_html($ch['sfx']); ?></text></svg>
        <div class="ch-stage<?php echo count($speakers) === 1 ? ' is-solo' : ''; ?>">
          <?php foreach ($speakers as $who) : ?>
          <img class="ch-char" src="<?php echo esc_url($cast[$who]['img']); ?>" width="320" height="300" loading="lazy" decoding="async" alt="<?php echo esc_attr('Cartoon of ' . $cast[$who]['name']); ?>">
          <?php endforeach; ?>
        </div>
        <div class="ch-talk">
          <?php $tailed = []; foreach ($ch['say'] as [$who, $line]) :
              $side = count($speakers) === 1 ? 'solo' : (array_search($who, $speakers, true) ? 'right' : 'left');
              $bg = $cast[$who]['bg'];
              $tail = !isset($tailed[$who]) ? ' has-tail' : '';
              $tailed[$who] = true;
          ?>
          <p class="bubble bubble-<?php echo $side . $tail; ?>"><b class="bubble-who" style="background:<?php echo esc_attr($bg); ?>;color:<?php echo $on_dark($bg) ? '#FFFFFF' : '#0E0B1F'; ?>"><?php echo esc_html($cast[$who]['name']); ?></b><?php echo esc_html($line); ?></p>
          <?php endforeach; ?>
        </div>
      </figure>
    </article>
    <?php endforeach; ?>
  </div>
</section>

<section class="sec sec-tight cs-end">
  <div class="sec-in cs-end-in">
    <div class="cs-fin reveal">
      <p class="cs-fin-mark">The end… <span>for now.</span></p>
      <p class="cs-fin-text">See how <?php echo esc_html($case['name']); ?> looks today, or tell us about your business and we'll start writing your story.</p>
      <div class="btn-row">
        <a class="btn btn-yellow btn-lg" href="<?php echo esc_url($case['site']); ?>" target="_blank" rel="noopener">Visit their website <span aria-hidden="true">→</span></a>
        <a class="btn btn-outline-white btn-lg" href="#book">Start your story</a>
      </div>
    </div>
    <a class="work cs-next reveal" href="<?php echo esc_url(amatchless_case_url($next_slug)); ?>">
      <div class="work-panel" style="background:<?php echo esc_attr($next['bg']); ?>">
        <span class="wbadge tilt" style="background:#FFFFFF">NEXT STORY</span>
        <span class="work-word" style="color:<?php echo esc_attr($next['fg']); ?>"><?php echo wp_kses($next['word'], $word_html); ?></span>
      </div>
      <div class="work-info">
        <div><span class="work-name"><?php echo esc_html($next['title']); ?></span><span class="work-svc"><?php echo esc_html(strtoupper($next['name'])); ?></span></div>
        <span class="work-arrow" aria-hidden="true">→</span>
      </div>
    </a>
  </div>
</section>

<?php get_template_part('template-parts/section', 'contact'); ?>

<?php get_footer(); ?>
