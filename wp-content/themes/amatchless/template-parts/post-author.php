<?php // "About the author" box at the end of an article, with a nudge to get in touch. ?>
<aside class="author-box" aria-label="About the author">
  <span class="author-mark" aria-hidden="true"><svg width="34" height="34" viewBox="0 0 40 40"><path d="M20 0 L24 16 L40 20 L24 24 L20 40 L16 24 L0 20 L16 16 Z" fill="#FFE14D"/></svg></span>
  <div>
    <p class="author-name">Written by <?php echo esc_html(amatchless_author_name()); ?></p>
    <p>We are the software, AI and marketing team behind brands like Moment, Bailey's Blossoms and Haliburton Forest. Every article is a playbook we use with clients.</p>
    <div class="author-links">
      <a class="btn btn-ink" href="#book">Talk to us about your business <span aria-hidden="true">↗</span></a>
      <a class="btn btn-white" href="<?php echo esc_url(amatchless_page_url('work')); ?>">See our work</a>
    </div>
  </div>
</aside>
