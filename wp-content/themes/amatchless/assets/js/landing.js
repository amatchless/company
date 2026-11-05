/* Ad landing pages and /thank-you/: lead form, UTM capture, Turnstile, Calendly and the GTM events
   lp_view (Meta ViewContent), generate_lead (Meta Lead + GA4) and calendly_scheduled (Meta Schedule).
   Contact (wa.me / tel: clicks) is already sent by site.js as whatsapp_click / phone_call_click. */
(function () {
  'use strict';
  var cfg = window.amxLanding;
  if (!cfg) return;
  var dl = window.dataLayer = window.dataLayer || [];
  var ss = {
    get: function (k) { try { return JSON.parse(sessionStorage.getItem(k) || 'null'); } catch (e) { return null; } },
    set: function (k, v) { try { sessionStorage.setItem(k, JSON.stringify(v)); } catch (e) {} },
    del: function (k) { try { sessionStorage.removeItem(k); } catch (e) {} }
  };

  /* ── Attribution: keep the first UTMs / click IDs / referrer of this visit ── */
  var KEYS = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term', 'fbclid', 'gclid'];
  var params = new URLSearchParams(location.search);
  var attr = ss.get('amx-attr') || {};
  var fresh = KEYS.some(function (k) { return params.get(k); });
  if (fresh) {
    attr = {};
    KEYS.forEach(function (k) { if (params.get(k)) attr[k] = params.get(k).slice(0, 300); });
  }
  if (!('referrer' in attr) || fresh) {
    var ref = document.referrer || '';
    attr.referrer = ref && ref.indexOf(location.origin) !== 0 ? ref.slice(0, 300) : (attr.referrer || '');
  }
  ss.set('amx-attr', attr);

  if (cfg.page === 'landing') initLanding();
  else initThankYou();

  /* ═════════════ Landing page ═════════════ */
  function initLanding() {
    dl.push({ event: 'lp_view', lp_service: cfg.service, lp_path: location.pathname });

    var form = document.getElementById('lpForm');
    if (!form) return;
    var $ = function (id) { return document.getElementById(id); };
    var btn = form.querySelector('.form-submit');
    var btnLabel = btn.innerHTML;
    var errBox = $('lp-error');

    // Hidden fields
    form.elements.page_url.value = location.href.split('#')[0].slice(0, 500);
    KEYS.concat('referrer').forEach(function (k) { if (form.elements[k]) form.elements[k].value = attr[k] || ''; });

    // First interaction: form_start + load Turnstile
    var started = false;
    form.addEventListener('focusin', function () {
      if (started) return;
      started = true;
      dl.push({ event: 'form_start', form_name: 'ad_lead_form', lp_service: cfg.service });
      loadTurnstile();
    });

    // Phone: digits only, 10 digits for India
    var phone = $('lp-phone'), phoneMsg = $('lp-phone-msg');
    var digits = function () {
      var d = phone.value.replace(/\D/g, '');
      if (d.length === 12 && d.indexOf('91') === 0) d = d.slice(2);
      if (d.length === 11 && d[0] === '0') d = d.slice(1);
      return d;
    };
    var phoneOk = function () { return /^[6-9]\d{9}$/.test(digits()); };
    phone.addEventListener('blur', function () {
      if (!phone.value.trim()) return;
      var ok = phoneOk();
      phoneMsg.hidden = ok;
      phoneMsg.textContent = ok ? '' : 'Please enter a 10-digit mobile number.';
      mark(phone, !ok);
    });

    // Email: warn (never block) on personal addresses
    var email = $('lp-email'), emailMsg = $('lp-email-msg');
    email.addEventListener('blur', function () {
      var personal = /@(gmail|googlemail|yahoo|ymail|rocketmail)\.[a-z.]+$/i.test(email.value.trim());
      emailMsg.hidden = !personal;
      emailMsg.textContent = personal ? 'A work email helps us find your brand faster, but this one is fine too.' : '';
    });

    // "A creator" message
    var creatorMsg = $('lp-creator');
    form.querySelectorAll('input[name="role"]').forEach(function (r) {
      r.addEventListener('change', function () {
        var c = form.querySelector('input[name="role"]:checked');
        creatorMsg.hidden = !(c && c.value === 'Creator');
        $('lp-role').classList.remove('err');
      });
    });

    function mark(el, bad) {
      el.classList.toggle('err', bad);
      if (bad) el.setAttribute('aria-invalid', 'true'); else el.removeAttribute('aria-invalid');
    }
    form.addEventListener('input', function (e) {
      if (e.target.classList.contains('err')) mark(e.target, false);
      if (e.target.id === 'lp-phone') phoneMsg.hidden = true;
      if (e.target.id === 'lp-consent') $('lp-consent-wrap').classList.remove('err');
    });

    function validate() {
      var first = null;
      var need = function (el, ok) { mark(el, !ok); if (!ok && !first) first = el; };
      need($('lp-name'), !!$('lp-name').value.trim());
      var pOk = phoneOk(); need(phone, pOk);
      if (!pOk) { phoneMsg.hidden = false; phoneMsg.textContent = 'Please enter a 10-digit mobile number.'; }
      need(email, !!email.value.trim() && email.checkValidity());
      need($('lp-company'), !!$('lp-company').value.trim());
      var web = $('lp-website');
      if (web.required) need(web, !!web.value.trim());
      var role = form.querySelector('input[name="role"]:checked');
      $('lp-role').classList.toggle('err', !role);
      if (!role && !first) first = form.querySelector('input[name="role"]');
      need($('lp-budget'), !!$('lp-budget').value);
      need($('lp-city'), !!$('lp-city').value);
      var consent = $('lp-consent');
      $('lp-consent-wrap').classList.toggle('err', !consent.checked);
      if (!consent.checked && !first) first = consent;
      return first;
    }

    function showError(html) {
      errBox.innerHTML = html;
      errBox.hidden = false;
    }
    var fallback = ' You can also <a href="' + cfg.whatsapp + '" target="_blank" rel="noopener">WhatsApp us</a> or email <a href="mailto:' + cfg.email + '">' + cfg.email + '</a>.';

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      errBox.hidden = true;
      var bad = validate();
      if (bad) {
        bad.focus();
        dl.push({ event: 'form_error', form_name: 'ad_lead_form', error_type: 'validation_failed' });
        return;
      }
      btn.disabled = true;
      btn.textContent = 'Sending…';
      getToken().then(function (token) {
        var fd = new FormData(form);
        fd.append('action', 'amatchless_lp');
        if (token) fd.set('cf-turnstile-response', token);
        return fetch(cfg.ajax, { method: 'POST', body: fd, credentials: 'same-origin' }).then(function (r) { return r.json(); });
      }).then(function (res) {
        if (res && res.success) {
          var d = res.data || {};
          dl.push({ event: 'form_submit_success', form_name: 'ad_lead_form', lp_service: cfg.service, lead_type: d.creator ? 'Creator' : 'Brand' });
          if (d.creator) {
            form.hidden = true;
            var ok = $('lpCreatorOk'); ok.hidden = false; ok.focus();
            return;
          }
          ss.set('amx-lead', {
            event_id: d.event_id, service: d.service, budget: d.budget,
            name: $('lp-name').value.trim(), email: email.value.trim()
          });
          location.href = d.redirect || cfg.thankYou;
          return;
        }
        var data = (res && res.data) || {};
        resetBtn();
        if (data.field && form.elements[data.field] && form.elements[data.field].focus) {
          var f = form.elements[data.field];
          if (f.classList) mark(f, true);
          f.focus();
        }
        showError((data.message || 'Something went wrong.') + fallback);
        if (window.turnstile && cfg.turnstile) { try { window.turnstile.reset('#lp-turnstile'); } catch (x) {} token = ''; }
        dl.push({ event: 'form_error', form_name: 'ad_lead_form', error_type: 'server_error' });
      }).catch(function () {
        resetBtn();
        showError('Connection problem, your details were not sent.' + fallback);
        dl.push({ event: 'form_error', form_name: 'ad_lead_form', error_type: 'network_error' });
      });
    });
    function resetBtn() { btn.disabled = false; btn.innerHTML = btnLabel; }

    /* Turnstile: loaded on first focus, invisible unless Cloudflare needs a click */
    var token = '', tsLoading = null;
    function loadTurnstile() {
      if (!cfg.turnstile || tsLoading) return tsLoading;
      tsLoading = new Promise(function (resolve) {
        window.amxTurnstileReady = function () {
          window.turnstile.render('#lp-turnstile', {
            sitekey: cfg.turnstile,
            appearance: 'interaction-only',
            action: 'ad_lead',
            callback: function (t) { token = t; },
            'expired-callback': function () { token = ''; },
            'error-callback': function () { token = ''; }
          });
          resolve();
        };
        var s = document.createElement('script');
        s.src = 'https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit&onload=amxTurnstileReady';
        s.async = true; s.defer = true;
        s.onerror = function () { resolve(); };
        document.head.appendChild(s);
      });
      return tsLoading;
    }
    function getToken() {
      if (!cfg.turnstile) return Promise.resolve('');
      return (loadTurnstile() || Promise.resolve()).then(function () {
        return new Promise(function (resolve) {
          var waited = 0;
          (function check() {
            if (token || waited >= 12000) return resolve(token);
            waited += 250; setTimeout(check, 250);
          })();
        });
      });
    }

    // CTA buttons that scroll to the form focus the first field after scrolling
    document.querySelectorAll('[data-lp-cta]').forEach(function (a) {
      a.addEventListener('click', function () {
        setTimeout(function () { var n = $('lp-name'); if (n) n.focus({ preventScroll: true }); }, 500);
      });
    });
  }

  /* ═════════════ /thank-you/ ═════════════ */
  function initThankYou() {
    var lead = ss.get('amx-lead');
    if (lead && lead.event_id) {
      // Pushed once per submission; a reload doesn't count a second lead.
      dl.push({
        event: 'generate_lead',
        lead_form: 'ad_landing_page',
        lead_event_id: lead.event_id,
        lead_service: lead.service,
        lead_budget: lead.budget,
        currency: 'INR',
        value: 1
      });
      ss.del('amx-lead');
    }

    // Calendly inline embed, loaded when the section comes near the screen
    var box = document.getElementById('lpCalendly');
    if (!box) return;
    var loaded = false;
    function loadCal() {
      if (loaded) return; loaded = true;
      var url = box.getAttribute('data-url');
      if (lead && lead.name) url += '&name=' + encodeURIComponent(lead.name);
      if (lead && lead.email) url += '&email=' + encodeURIComponent(lead.email);
      var w = document.createElement('div');
      w.className = 'calendly-inline-widget';
      w.setAttribute('data-url', url);
      box.innerHTML = '';
      box.appendChild(w);
      var s = document.createElement('script');
      s.src = 'https://assets.calendly.com/assets/external/widget.js';
      s.async = true;
      s.onerror = function () { box.innerHTML = '<p class="lp-cal-fallback"><a href="https://calendly.com/amatchless" target="_blank" rel="noopener">Open Calendly to book a call</a></p>'; };
      document.body.appendChild(s);
    }
    if ('IntersectionObserver' in window) {
      var io = new IntersectionObserver(function (en) { if (en[0].isIntersecting) { io.disconnect(); loadCal(); } }, { rootMargin: '400px' });
      io.observe(box);
    } else { loadCal(); }

    window.addEventListener('message', function (e) {
      if (e.origin !== 'https://calendly.com' || !e.data || e.data.event !== 'calendly.event_scheduled') return;
      dl.push({ event: 'calendly_scheduled', lead_service: lead ? lead.service : '' });
    });
  }
})();
