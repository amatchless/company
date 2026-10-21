<!-- ============ PROCESS ============ -->
<section class="sec sec-ink" id="process">
  <div class="sec-in">
    <div class="sec-head reveal">
      <span class="label" style="color:#3DEBB0">HOW WE WORK</span>
      <h2 class="h2">From pain points to <span style="color:#FF4F9A">measurable</span> results.</h2>
    </div>
    <div class="step-grid">
      <?php
      $steps = [
          ['01', '#5B2EFF', 'UNDERSTAND', 'Listen',  'We learn your business, your customers and where time and money leak — before suggesting anything.'],
          ['02', '#E0307F', 'RECOMMEND',  'Advise',  'A clear plan: what to build, automate and market, ranked by its impact on revenue and efficiency.'],
          ['03', '#0E9F6E', 'BUILD',      'Deliver', 'Software, AI, automations and campaigns go live, built by one team to one plan.'],
          ['04', '#FF7A1A', 'SCALE',      'Improve', 'We measure, refine and automate what works, so results build on themselves.'],
      ];
      foreach ($steps as [$n, $c, $tag, $title, $text]) : ?>
      <div class="step reveal">
        <span class="step-num" style="color:<?php echo esc_attr($c); ?>"><?php echo esc_html($n); ?></span>
        <span class="step-tag"><?php echo esc_html($tag); ?></span>
        <h3><?php echo esc_html($title); ?></h3>
        <p><?php echo esc_html($text); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
