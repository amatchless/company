<!-- ============ TEAM (cartoon alter egos) ============ -->
<?php
$team = [
  ['name' => 'Bravo',   'role' => 'Sales Director',         'img' => 'bravo',   'bg' => '#FFE14D', 'r' => '-1.5deg', 'from' => 'Johnny Bravo',            'line' => 'Never met a handshake he couldn\'t turn into a plan. Smooth talker, straight shooter.'],
  ['name' => 'Blossom', 'role' => 'Creative Head',          'img' => 'blossom', 'bg' => '#FF4F9A', 'r' => '1deg',    'from' => 'The Powerpuff Girls',     'line' => 'Turns a blank page into a brand people remember. Sugar, spice and a lot of colour.'],
  ['name' => 'Dexter',  'role' => 'Director of Technology', 'img' => 'dexter',  'bg' => '#5B2EFF', 'r' => '-1deg',   'from' => 'Dexter\'s Laboratory',    'line' => 'Runs the secret lab where the software, AI and automations get built. Keep out of the lab.'],
  ['name' => 'Kim',     'role' => 'Client Head',            'img' => 'kim',     'bg' => '#3DEBB0', 'r' => '1.5deg',  'from' => 'Kim Possible',            'line' => 'Call her, beep her, she\'s already on it. Nothing your project needs is impossible.'],
];
$img_base = get_template_directory_uri() . '/assets/img/team/';
?>
<section class="sec sec-tight" id="team">
  <div class="sec-in">
    <div class="sec-split reveal">
      <div class="sec-head">
        <span class="label" style="color:#5B2EFF">THE CREW</span>
        <h2 class="h2">Meet the <span class="hl-purple">matchless</span> four.</h2>
      </div>
      <p class="sec-aside">Four leads, one team. We'd rather you meet our cartoon alter egos first. The real faces come with the discovery call.</p>
    </div>
    <div class="team-grid reveal">
      <?php foreach ($team as $i => $m) : ?>
      <article class="member" style="--r:<?php echo esc_attr($m['r']); ?>">
        <div class="member-art" style="background:<?php echo esc_attr($m['bg']); ?>">
          <img src="<?php echo esc_url($img_base . $m['img'] . '.svg?ver=' . AMATCHLESS_VERSION); ?>" width="320" height="300" loading="lazy" decoding="async" alt="<?php echo esc_attr('Cartoon of ' . $m['name'] . ', our ' . $m['role']); ?>">
        </div>
        <div class="member-body">
          <span class="label member-role"><?php echo esc_html($m['role']); ?></span>
          <h3><?php echo esc_html($m['name']); ?></h3>
          <p><?php echo esc_html($m['line']); ?></p>
          <span class="member-from">Alter ego inspired by <?php echo esc_html($m['from']); ?></span>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
