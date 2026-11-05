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


  /* ── Click tracking ───────────────────────────────────────
     One delegated listener, and each click sends exactly one event, picked in
     this order: WhatsApp, email, phone, social, other outbound, CTA button,
     card, navigation. So a WhatsApp button is a whatsapp_click (not also a
     cta_click, social_click and outbound_click), and a social link is a
     social_click (not also an outbound_click). */
  var clip = function(s) { return (s || '').replace(/\s+/g, ' ').trim().substring(0, 80); };
  var where = function(el) {
    var s = el.closest('section, header, footer, aside');
    return s ? (s.id || s.className.split(' ')[0] || 'unknown') : 'unknown';
  };
  var cardTitle = function(el) {
    var t = el.querySelector('.work-name, .ct-title, h2, h3, h4');
    return clip(t ? t.textContent : (el.getAttribute('aria-label') || el.textContent));
  };
  var cardType = function(el) {
    if (el.matches('.work, .cs-next')) return 'case_study';
    if (el.matches('.tm-link')) return 'testimonial';
    if (el.matches('.pcard')) return 'blog_post';
    if (el.matches('.chip, .pill-link')) return 'blog_topic';
    if (el.matches('.ct-card')) return 'contact_card';
    return '';
  };

  document.addEventListener('click', function(e) {
    var el = e.target.closest ? e.target.closest('a[href], button') : null;
    if (!el) return;
    var href = el.getAttribute('href') || '';
    var type = cardType(el);
    var text = type ? cardTitle(el) : clip(el.textContent.trim() ? el.textContent : el.getAttribute('aria-label'));
    var source = el.matches('.wa-float') ? 'floating_button' : where(el);

    if (el.hasAttribute('data-calendly')) {
      dataLayer.push({ event: 'calendly_click', click_source: source, link_text: text });
    } else if (/^https?:\/\/(wa\.me|api\.whatsapp\.com|chat\.whatsapp\.com)\//i.test(href)) {
      dataLayer.push({ event: 'whatsapp_click', click_source: source, link_text: text });
    } else if (href.indexOf('mailto:') === 0) {
      dataLayer.push({ event: 'email_click', click_source: source, link_text: text });
    } else if (href.indexOf('tel:') === 0) {
      dataLayer.push({ event: 'phone_call_click', click_source: source, phone_number: href.replace('tel:', '') });
    } else if (el.hasAttribute('data-social')) {
      dataLayer.push({ event: 'social_click', social_platform: el.getAttribute('data-social'), click_source: source });
    } else if (/^https?:\/\//i.test(href) && el.hostname && el.hostname.replace(/^www\./, '') !== location.hostname.replace(/^www\./, '')) {
      dataLayer.push({ event: 'outbound_click', outbound_url: href, link_text: text, click_source: source });
    } else if (el.matches('.btn') && !el.matches('[data-cookie], .form-submit')) {
      dataLayer.push({ event: 'cta_click', cta_text: text, cta_location: source, cta_href: href || 'button' });
    } else if (type) {
      dataLayer.push({ event: 'card_click', card_type: type, card_title: text, card_url: href, click_source: source });
    } else if (el.matches('.navlinks a, .mobile-menu a, .foot-links a, .brand')) {
      dataLayer.push({ event: 'nav_click', nav_link_text: el.matches('.brand') ? 'Logo' : text, nav_link_url: href, nav_location: el.matches('.foot-links a') ? 'footer' : (el.closest('.mobile-menu') ? 'mobile_menu' : 'header') });
    }
  });

  /* ── Calendly booking popup ───────────────────────────────
     Links with data-calendly point at the Calendly page (new tab without JS).
     With JS, the first click loads Calendly's widget and opens it as a popup
     over the page; if the widget can't load, the Calendly page opens instead.
     Name and email typed into the lead form are passed on as prefill. */
  var CAL_JS = 'https://assets.calendly.com/assets/external/widget.js';
  var CAL_CSS = 'https://assets.calendly.com/assets/external/widget.css';
  var calReady = null;
  function loadCalendly() {
    if (calReady) return calReady;
    calReady = new Promise(function(resolve, reject) {
      if (window.Calendly) return resolve();
      var css = document.createElement('link');
      css.rel = 'stylesheet'; css.href = CAL_CSS;
      document.head.appendChild(css);
      var s = document.createElement('script');
      s.src = CAL_JS; s.async = true;
      s.onload = function() { window.Calendly ? resolve() : reject(); };
      s.onerror = reject;
      document.head.appendChild(s);
      setTimeout(reject, 8000);
    });
    calReady.catch(function() { calReady = null; });
    return calReady;
  }
  function calField(id) {
    var f = document.getElementById(id);
    return f && f.value ? f.value.trim().substring(0, 200) : '';
  }
  document.querySelectorAll('[data-calendly]').forEach(function(a) {
    // Start loading on hover / focus so the popup opens quickly on click.
    ['mouseenter', 'focus', 'touchstart'].forEach(function(ev) {
      a.addEventListener(ev, function() { loadCalendly().catch(function() {}); }, { once: true, passive: true });
    });
    a.addEventListener('click', function(e) {
      if (e.metaKey || e.ctrlKey || e.shiftKey || e.button > 0) return; // let "open in new tab" work
      e.preventDefault();
      var url = a.getAttribute('href') + '?hide_gdpr_banner=1&primary_color=5b2eff';
      var fallback = function() { location.href = a.getAttribute('href'); }; // same tab: a late window.open would be blocked
      loadCalendly().then(function() {
        var prefill = {}, n = calField('f-name'), m = calField('f-email');
        if (n) prefill.name = n;
        if (m) prefill.email = m;
        try { window.Calendly.initPopupWidget({ url: url, prefill: prefill }); } catch (err) { fallback(); }
      }, fallback);
    });
  });
  window.addEventListener('message', function(e) {
    if (e.origin !== 'https://calendly.com' || !e.data || e.data.event !== 'calendly.event_scheduled') return;
    dataLayer.push({ event: 'calendly_scheduled', click_source: 'popup' });
  });

  /* ── FAQ opens ────────────────────────────────────────────── */
  // 'toggle' doesn't bubble, so listen in the capture phase.
  document.addEventListener('toggle', function(e) {
    var d = e.target;
    if (!d.matches || !d.matches('details.faq-item') || !d.open) return;
    var q = d.querySelector('summary');
    var all = Array.prototype.slice.call(document.querySelectorAll('details.faq-item'));
    dataLayer.push({ event: 'faq_open', faq_question: clip(q ? q.textContent : ''), faq_position: all.indexOf(d) + 1 });
  }, true);

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
