/* Amatchless theme JS — header, mobile menu, lead form and GTM dataLayer tracking */
(function() {
  'use strict';

  window.dataLayer = window.dataLayer || [];
  var dataLayer = window.dataLayer;

  /* ── Header border on scroll ──────────────────────────────── */
  var nav = document.getElementById('nav');
  if (nav) {
    var onScroll = function() { nav.classList.toggle('scrolled', window.scrollY > 8); };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  /* ── Mobile menu ──────────────────────────────────────────── */
  var mb = document.getElementById('menuBtn');
  var mm = document.getElementById('mobileMenu');
  if (mb && mm) {
    var open = false;
    var setMenu = function(v) {
      open = v;
      mm.style.display = v ? 'block' : 'none';
      mb.setAttribute('aria-expanded', v ? 'true' : 'false');
      mb.setAttribute('aria-label', v ? 'Close menu' : 'Open menu');
    };
    mb.addEventListener('click', function() { setMenu(!open); });
    mm.addEventListener('click', function(e) { if (e.target.closest('a')) setMenu(false); });
    document.addEventListener('keydown', function(e) { if (open && e.key === 'Escape') { setMenu(false); mb.focus(); } });
    window.addEventListener('resize', function() { if (open && window.innerWidth > 860) setMenu(false); });
  }

  /* ── Lead form — AJAX submission ──────────────────────────── */
  var leadForm  = document.getElementById('leadForm');
  var formOk    = document.getElementById('formOk');
  var submitBtn = leadForm ? leadForm.querySelector('.form-submit') : null;
  var submitLabel = submitBtn ? submitBtn.innerHTML : '';

  if (leadForm && formOk && typeof amatchlessAjax !== 'undefined') {
    var formStartFired = false;
    leadForm.querySelectorAll('input, select, textarea').forEach(function(field) {
      field.addEventListener('focus', function() {
        if (!formStartFired) {
          formStartFired = true;
          dataLayer.push({ event: 'form_start', form_name: 'contact_lead_form' });
        }
      }, { once: true });
    });

    var resetBtn = function() {
      if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = submitLabel; }
    };
    var val = function(id) { var el = document.getElementById(id); return el ? el.value.trim() : ''; };

    leadForm.addEventListener('submit', function(e) {
      e.preventDefault();

      var required = ['f-name', 'f-email', 'f-msg'].map(function(id) { return document.getElementById(id); });
      var firstBad = null;
      required.forEach(function(el) {
        var bad = !el.value.trim() || (el.type === 'email' && !el.checkValidity());
        el.classList.toggle('err', bad);
        el.setAttribute('aria-invalid', bad ? 'true' : 'false');
        if (bad) {
          firstBad = firstBad || el;
          el.addEventListener('input', function() { el.classList.remove('err'); el.removeAttribute('aria-invalid'); }, { once: true });
        }
      });
      if (firstBad) {
        firstBad.focus();
        dataLayer.push({ event: 'form_error', form_name: 'contact_lead_form', error_type: 'validation_failed' });
        return;
      }

      dataLayer.push({ event: 'form_submit_attempt', form_name: 'contact_lead_form' });
      if (submitBtn) { submitBtn.disabled = true; submitBtn.textContent = 'Sending…'; }

      var fd = new FormData();
      fd.append('action',  'amatchless_contact');
      fd.append('nonce',   amatchlessAjax.nonce);
      fd.append('name',    val('f-name'));
      fd.append('email',   val('f-email'));
      fd.append('company', val('f-co'));
      fd.append('phone',   val('f-phone'));
      fd.append('service', val('f-service'));
      fd.append('message', val('f-msg'));

      fetch(amatchlessAjax.url, { method: 'POST', body: fd, credentials: 'same-origin' })
        .then(function(r) { return r.json(); })
        .then(function(data) {
          if (data.success) {
            leadForm.hidden = true;
            formOk.hidden = false;
            formOk.focus();
            dataLayer.push({
              event: 'form_submit_success',
              form_name: 'contact_lead_form',
              service_interest: val('f-service') || 'not_specified'
            });
            dataLayer.push({ event: 'generate_lead', currency: 'INR', value: 1 });
          } else {
            resetBtn();
            dataLayer.push({ event: 'form_error', form_name: 'contact_lead_form', error_type: 'server_error' });
            alert(data.data && data.data.message ? data.data.message : 'Something went wrong. Please try again.');
          }
        })
        .catch(function() {
          resetBtn();
          dataLayer.push({ event: 'form_error', form_name: 'contact_lead_form', error_type: 'network_error' });
          alert('Connection error. Please email us directly at ' + (amatchlessAjax.email || 'info@amatchless.com'));
        });
    });
  }


  /* ── CTA click tracking ───────────────────────────────────── */
  document.querySelectorAll('a.btn, button.btn').forEach(function(el) {
    el.addEventListener('click', function() {
      var section = el.closest('section, header, footer');
      dataLayer.push({
        event: 'cta_click',
        cta_text: el.textContent.trim().substring(0, 80),
        cta_location: section ? (section.id || section.className.split(' ')[0] || 'unknown') : 'unknown',
        cta_href: el.getAttribute('href') || 'button'
      });
    });
  });

  /* ── WhatsApp, phone, nav, social and outbound tracking ──── */
  var wa = document.querySelector('.wa-float');
  if (wa) wa.addEventListener('click', function() { dataLayer.push({ event: 'whatsapp_click', click_source: 'floating_button' }); });

  document.querySelectorAll('a[href^="tel:"]').forEach(function(el) {
    el.addEventListener('click', function() {
      dataLayer.push({ event: 'phone_call_click', phone_number: el.getAttribute('href').replace('tel:', '') });
    });
  });

  document.querySelectorAll('.navlinks a, .mobile-menu a').forEach(function(el) {
    el.addEventListener('click', function() {
      dataLayer.push({ event: 'nav_click', nav_link_text: el.textContent.trim(), nav_link_url: el.getAttribute('href') });
    });
  });

  document.querySelectorAll('[data-social]').forEach(function(el) {
    el.addEventListener('click', function() { dataLayer.push({ event: 'social_click', social_platform: el.getAttribute('data-social') }); });
  });

  document.querySelectorAll('a[href]').forEach(function(el) {
    var href = el.getAttribute('href') || '';
    if (href.indexOf('http') === 0 && href.indexOf(location.hostname) === -1) {
      el.addEventListener('click', function() {
        dataLayer.push({ event: 'outbound_click', outbound_url: href, link_text: el.textContent.trim().substring(0, 80) });
      });
    }
  });

  /* ── Scroll depth (25 / 50 / 75 / 90%) ────────────────────── */
  var milestones = [25, 50, 75, 90], fired = {};
  var scrollQueued = false;
  window.addEventListener('scroll', function() {
    if (scrollQueued) return;
    scrollQueued = true;
    requestAnimationFrame(function() {
      scrollQueued = false;
      var max = document.documentElement.scrollHeight - window.innerHeight;
      if (max <= 0) return;
      var pct = Math.round(window.scrollY / max * 100);
      milestones.forEach(function(m) {
        if (!fired[m] && pct >= m) { fired[m] = true; dataLayer.push({ event: 'scroll_depth', scroll_percentage: m }); }
      });
    });
  }, { passive: true });

  /* ── Section views ────────────────────────────────────────── */
  if ('IntersectionObserver' in window) {
    var seen = {};
    var so = new IntersectionObserver(function(entries) {
      entries.forEach(function(en) {
        var id = en.target.id;
        if (en.isIntersecting && id && !seen[id]) { seen[id] = true; dataLayer.push({ event: 'section_view', section_id: id }); }
      });
    }, { threshold: 0.3 });
    document.querySelectorAll('main section[id]').forEach(function(el) { so.observe(el); });
  }

  /* ── Exit intent and time on page ─────────────────────────── */
  var exitFired = false;
  document.addEventListener('mouseleave', function(e) {
    if (!exitFired && e.clientY < 5) {
      exitFired = true;
      var max = document.documentElement.scrollHeight - window.innerHeight;
      dataLayer.push({ event: 'exit_intent', page_scroll_pct: max > 0 ? Math.round(window.scrollY / max * 100) : 100 });
    }
  });
  [30, 60, 180].forEach(function(s) {
    setTimeout(function() { dataLayer.push({ event: 'time_on_page', seconds_on_page: s }); }, s * 1000);
  });

  /* ── Cookie consent (consent mode defaults are set in header.php) ── */
  var cookie = document.getElementById('cookieBanner');
  if (cookie) {
    var choice = null;
    try { choice = localStorage.getItem('amx-consent'); } catch (e) {}
    if (!choice) cookie.hidden = false;
    cookie.querySelectorAll('[data-cookie]').forEach(function(btn) {
      btn.addEventListener('click', function() {
        var v = btn.getAttribute('data-cookie');
        try { localStorage.setItem('amx-consent', v); } catch (e) {}
        if (typeof window.gtag === 'function') {
          window.gtag('consent', 'update', { analytics_storage: v, ad_storage: v, ad_user_data: v, ad_personalization: v });
        }
        dataLayer.push({ event: 'consent_update', consent_choice: v });
        cookie.hidden = true;
      });
    });
    document.querySelectorAll('[data-cookie-open]').forEach(function(el) {
      el.addEventListener('click', function() {
        cookie.hidden = false;
        var first = cookie.querySelector('[data-cookie]');
        if (first) first.focus();
      });
    });
  }
})();
