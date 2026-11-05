<?php
/* The ad lead form, shared by both landing pages. $args['slug'] is the landing page; $args['lp'] its content.
   Posts to amatchless_lp_submit() (inc/landing.php) via assets/js/landing.js. */
$slug = $args['slug'];
$lp   = $args['lp'];
$web_req = $lp['website_required'];
?>
<div class="lead-card lp-card" id="lp-form-card">
  <form id="lpForm" class="lp-form" novalidate data-lp="<?php echo esc_attr($slug); ?>">
    <p class="lead-title"><?php echo esc_html($lp['form_h']); ?></p>
    <p class="lp-form-sub"><?php echo esc_html($lp['form_sub']); ?></p>

    <div class="form-row">
      <div class="form-grp">
        <label class="form-lbl" for="lp-name">Full name *</label>
        <input class="form-ctrl" type="text" id="lp-name" name="name" required autocomplete="name" maxlength="120">
      </div>
      <div class="form-grp">
        <label class="form-lbl" for="lp-phone">Phone *</label>
        <div class="lp-phone">
          <span class="lp-cc" aria-hidden="true">+91</span>
          <input class="form-ctrl" type="tel" id="lp-phone" name="phone" required autocomplete="tel-national" inputmode="numeric" placeholder="98765 43210" maxlength="16" aria-describedby="lp-phone-msg">
        </div>
        <p class="lp-msg" id="lp-phone-msg" hidden></p>
      </div>
    </div>

    <div class="form-row">
      <div class="form-grp">
        <label class="form-lbl" for="lp-email">Work email *</label>
        <input class="form-ctrl" type="email" id="lp-email" name="email" required autocomplete="email" placeholder="you@yourbrand.com" maxlength="160" aria-describedby="lp-email-msg">
        <p class="lp-msg lp-warn" id="lp-email-msg" hidden></p>
      </div>
      <div class="form-grp">
        <label class="form-lbl" for="lp-company">Brand / company *</label>
        <input class="form-ctrl" type="text" id="lp-company" name="company" required autocomplete="organization" maxlength="120">
      </div>
    </div>

    <div class="form-grp">
      <label class="form-lbl" for="lp-website">Website or Instagram<?php echo $web_req ? ' *' : ' <span class="lp-opt">(optional)</span>'; ?></label>
      <input class="form-ctrl" type="text" id="lp-website" name="website" <?php echo $web_req ? 'required' : ''; ?> placeholder="yourbrand.com or @yourbrand" maxlength="200" autocapitalize="off" spellcheck="false">
    </div>

    <fieldset class="form-grp lp-roles" id="lp-role">
      <legend class="form-lbl">I am *</legend>
      <div class="lp-radio-row">
        <?php foreach (amatchless_lp_roles() as $val => $label) : ?>
        <label class="lp-radio"><input type="radio" name="role" value="<?php echo esc_attr($val); ?>" required> <span><?php echo esc_html($label); ?></span></label>
        <?php endforeach; ?>
      </div>
      <p class="lp-creator" id="lp-creator" hidden>We work with brands. For collaborations, email <a href="mailto:<?php echo esc_attr(AMATCHLESS_EMAIL); ?>"><?php echo esc_html(AMATCHLESS_EMAIL); ?></a></p>
    </fieldset>

    <div class="form-row">
      <div class="form-grp">
        <label class="form-lbl" for="lp-budget"><?php echo esc_html($lp['budget_lbl']); ?> *</label>
        <select class="form-ctrl" id="lp-budget" name="budget" required>
          <option value="">Choose a budget</option>
          <?php foreach ($lp['budgets'] as $b) : ?><option><?php echo esc_html($b); ?></option><?php endforeach; ?>
        </select>
      </div>
      <div class="form-grp">
        <label class="form-lbl" for="lp-city">City *</label>
        <select class="form-ctrl" id="lp-city" name="city" required>
          <option value="">Choose your city</option>
          <?php foreach (amatchless_lp_cities() as $c) : ?><option><?php echo esc_html($c); ?></option><?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="form-grp">
      <label class="form-lbl" for="lp-msg">What do you want to achieve in the next 3 months? <span class="lp-opt">(optional)</span></label>
      <textarea class="form-ctrl" id="lp-msg" name="message" rows="3" maxlength="2000"></textarea>
    </div>

    <label class="lp-consent" id="lp-consent-wrap">
      <input type="checkbox" name="consent" id="lp-consent" value="1" required>
      <span>I agree to the <a href="<?php echo esc_url(amatchless_privacy_url()); ?>" target="_blank" rel="noopener">Privacy Policy</a> *</span>
    </label>

    <!-- Hidden: filled in by landing.js -->
    <input type="hidden" name="lp" value="<?php echo esc_attr($slug); ?>">
    <input type="hidden" name="service" value="<?php echo esc_attr($lp['service']); ?>">
    <?php foreach (['page_url', 'utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term', 'fbclid', 'gclid', 'referrer'] as $h) : ?>
    <input type="hidden" name="<?php echo esc_attr($h); ?>" value="">
    <?php endforeach; ?>
    <!-- Honeypot: people never see or fill this -->
    <div class="lp-hp" aria-hidden="true"><label for="lp-hp">Leave this empty</label><input type="text" id="lp-hp" name="amx_hp" tabindex="-1" autocomplete="off"></div>
    <div class="lp-turnstile" id="lp-turnstile"></div>

    <p class="lp-error" id="lp-error" role="alert" hidden></p>
    <button type="submit" class="btn btn-pink btn-lg form-submit"><?php echo esc_html($lp['cta']); ?> <span aria-hidden="true">↗</span></button>
    <p class="form-legal">We use your details only to reply to you. <a href="<?php echo esc_url(amatchless_privacy_url()); ?>">Privacy Policy</a> · <a href="<?php echo esc_url(amatchless_terms_url()); ?>">Terms</a></p>
  </form>
  <div class="form-success" id="lpCreatorOk" tabindex="-1" hidden>
    <div class="tick" aria-hidden="true">✓</div>
    <h3>Thanks, we've saved your details.</h3>
    <p>We work with brands on these campaigns. For creator collaborations, email <a href="mailto:<?php echo esc_attr(AMATCHLESS_EMAIL); ?>"><?php echo esc_html(AMATCHLESS_EMAIL); ?></a> and the team will get back to you.</p>
  </div>
</div>
