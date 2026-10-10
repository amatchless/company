/* Amatchless Theme JS v2.0 — with GTM dataLayer tracking */
(function() {
  'use strict';

  window.dataLayer = window.dataLayer || [];

  /* ── Nav scroll ───────────────────────────────────────────── */
  var nav = document.getElementById('mainNav');
  if (nav) {
    window.addEventListener('scroll', function() {
      nav.classList.toggle('scrolled', window.scrollY > 40);
    }, { passive: true });
  }

  /* ── Mobile menu ──────────────────────────────────────────── */
  var hamburger = document.getElementById('hamburgerBtn');
  var mobileMenu = document.getElementById('mobileMenu');
  var mobileClose = document.getElementById('mobileClose');
  if (hamburger && mobileMenu) {
    function closeMobileMenu() {
      mobileMenu.classList.remove('open');
      hamburger.setAttribute('aria-expanded', 'false');
    }
    hamburger.addEventListener('click', function() {
      mobileMenu.classList.add('open');
      hamburger.setAttribute('aria-expanded', 'true');
    });
    if (mobileClose) mobileClose.addEventListener('click', closeMobileMenu);
    mobileMenu.querySelectorAll('a').forEach(function(a) {
      a.addEventListener('click', closeMobileMenu);
    });
  }

  /* ── FAQ accordion ────────────────────────────────────────── */
  document.querySelectorAll('.faq-trigger').forEach(function(btn) {
    btn.addEventListener('click', function() {
      var item = btn.closest('.faq-item');
      var wasOpen = item.classList.contains('open');
      document.querySelectorAll('.faq-item').forEach(function(i) {
        i.classList.remove('open');
        i.querySelector('.faq-trigger').setAttribute('aria-expanded', 'false');
      });
      if (!wasOpen) {
        item.classList.add('open');
        btn.setAttribute('aria-expanded', 'true');
        // Track FAQ open
        dataLayer.push({
          event: 'faq_open',
          faq_question: btn.textContent.trim().substring(0, 100)
        });
      }
    });
  });

  /* ── Stats counter ────────────────────────────────────────── */
  var prefReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function countUp(el, target, dec) {
    if (prefReduced) { el.textContent = dec ? target.toFixed(dec) : target; return; }
    var dur = 1800, start = performance.now();
    (function tick(now) {
      var p = Math.min((now - start) / dur, 1);
      var e = 1 - Math.pow(1 - p, 3);
      el.textContent = dec ? (target * e).toFixed(dec) : Math.floor(target * e);
      if (p < 1) requestAnimationFrame(tick);
    })(start);
  }

  var statsEl = document.querySelector('.stats');
  if (statsEl) {
    var statsObserved = false;
    new IntersectionObserver(function(entries) {
      if (entries[0].isIntersecting && !statsObserved) {
        statsObserved = true;
        statsEl.querySelectorAll('.scount').forEach(function(el) {
          countUp(el, parseFloat(el.dataset.target), parseInt(el.dataset.dec || '0') || 0);
        });
      }
    }, { threshold: 0.4 }).observe(statsEl);
  }

  /* ── Contact form — AJAX submission ──────────────────────── */
  var leadForm = document.getElementById('leadForm');
  var formOk   = document.getElementById('formOk');
  var submitBtn = leadForm ? leadForm.querySelector('.form-submit') : null;
  var formStartFired = false;

  if (leadForm && formOk && typeof amatchlessAjax !== 'undefined') {

    // Track form start (first field interaction)
    leadForm.querySelectorAll('input, select, textarea').forEach(function(field) {
      field.addEventListener('focus', function() {
        if (!formStartFired) {
          formStartFired = true;
          dataLayer.push({ event: 'form_start', form_name: 'contact_lead_form' });
        }
      }, { once: true });
    });

    leadForm.addEventListener('submit', function(e) {
      e.preventDefault();

      var nameEl    = document.getElementById('f-name');
      var emailEl   = document.getElementById('f-email');
      var companyEl = document.getElementById('f-co');
      var valid = true;

      [nameEl, emailEl, companyEl].forEach(function(el) {
        if (!el || !el.value.trim()) {
          if (el) {
            el.style.borderColor = 'var(--magenta)';
            el.addEventListener('input', function() { el.style.borderColor = ''; }, { once: true });
          }
          valid = false;
        }
      });

      if (!valid) {
        dataLayer.push({ event: 'form_error', form_name: 'contact_lead_form', error_type: 'validation_failed' });
        return;
      }

      // Track form submit attempt
      dataLayer.push({ event: 'form_submit_attempt', form_name: 'contact_lead_form' });

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Sending…';
      }

      var serviceEl = document.getElementById('f-service');
      var budgetEl  = document.getElementById('f-budget');
      var fd = new FormData();
      fd.append('action', 'amatchless_contact');
      fd.append('nonce',  amatchlessAjax.nonce);
      fd.append('name',    nameEl.value.trim());
      fd.append('email',   emailEl.value.trim());
      fd.append('company', companyEl.value.trim());

      var phoneEl = document.getElementById('f-phone');
      var msgEl   = document.getElementById('f-msg');
      if (phoneEl)   fd.append('phone',   phoneEl.value.trim());
      if (serviceEl) fd.append('service', serviceEl.value);
      if (budgetEl)  fd.append('budget',  budgetEl.value);
      if (msgEl)     fd.append('message', msgEl.value.trim());

      fetch(amatchlessAjax.url, { method: 'POST', body: fd, credentials: 'same-origin' })
        .then(function(r) { return r.json(); })
        .then(function(data) {
          if (data.success) {
            leadForm.hidden = true;
            formOk.hidden   = false;
            // Track successful form submission
            dataLayer.push({
              event: 'form_submit_success',
              form_name: 'contact_lead_form',
              service_interest: serviceEl ? serviceEl.value : 'not_specified',
              budget_range: budgetEl ? budgetEl.value : 'not_specified'
            });
            // GA4 generate_lead event
            dataLayer.push({ event: 'generate_lead', currency: 'INR', value: 1 });
          } else {
            if (submitBtn) {
              submitBtn.disabled = false;
              submitBtn.textContent = 'Book My Free Strategy Call';
            }
            dataLayer.push({ event: 'form_error', form_name: 'contact_lead_form', error_type: 'server_error' });
            alert(data.data && data.data.message ? data.data.message : 'Something went wrong. Please try again.');
          }
        })
        .catch(function() {
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Book My Free Strategy Call';
          }
          dataLayer.push({ event: 'form_error', form_name: 'contact_lead_form', error_type: 'network_error' });
          alert('Connection error. Please email us directly at info@amatchless.com');
        });
    });
  }

  /* ── CTA button click tracking ────────────────────────────── */
  document.querySelectorAll('a.btn, button.btn, .form-submit').forEach(function(el) {
    el.addEventListener('click', function() {
      dataLayer.push({
        event: 'cta_click',
        cta_text: el.textContent.trim().substring(0, 80),
        cta_location: (function() {
          var section = el.closest('section, header, footer, nav, .sticky-cta, .hero');
          return section ? (section.id || section.className.split(' ')[0] || 'unknown') : 'unknown';
        })(),
        cta_href: el.getAttribute('href') || 'button'
      });
    });
  });

  /* ── WhatsApp float click ─────────────────────────────────── */
  var waBtn = document.querySelector('.wa-float');
  if (waBtn) {
    waBtn.addEventListener('click', function() {
      dataLayer.push({ event: 'whatsapp_click', click_source: 'floating_button' });
    });
  }

  /* ── Phone click tracking ─────────────────────────────────── */
  document.querySelectorAll('a[href^="tel:"]').forEach(function(el) {
    el.addEventListener('click', function() {
      dataLayer.push({ event: 'phone_call_click', phone_number: el.getAttribute('href').replace('tel:', '') });
    });
  });

  /* ── Navigation link tracking ─────────────────────────────── */
  document.querySelectorAll('.nav-links a, .mobile-menu a').forEach(function(el) {
    el.addEventListener('click', function() {
      dataLayer.push({
        event: 'nav_click',
        nav_link_text: el.textContent.trim(),
        nav_link_url: el.getAttribute('href')
      });
    });
  });

  /* ── Outbound link tracking ───────────────────────────────── */
  document.querySelectorAll('a[href]').forEach(function(el) {
    var href = el.getAttribute('href') || '';
    if (href.startsWith('http') && href.indexOf('amatchless.com') === -1) {
      el.addEventListener('click', function() {
        dataLayer.push({
          event: 'outbound_click',
          outbound_url: href,
          link_text: el.textContent.trim().substring(0, 80)
        });
      });
    }
  });

  /* ── Social link tracking ─────────────────────────────────── */
  document.querySelectorAll('.footer-soc-link').forEach(function(el) {
    el.addEventListener('click', function() {
      dataLayer.push({
        event: 'social_click',
        social_platform: el.getAttribute('aria-label') || el.textContent.trim()
      });
    });
  });

  /* ── Scroll depth tracking (25 / 50 / 75 / 90%) ──────────── */
  var scrollMilestones = [25, 50, 75, 90];
  var scrollFired = {};
  window.addEventListener('scroll', function() {
    var scrollPct = Math.round(
      (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100
    );
    scrollMilestones.forEach(function(milestone) {
      if (!scrollFired[milestone] && scrollPct >= milestone) {
        scrollFired[milestone] = true;
        dataLayer.push({ event: 'scroll_depth', scroll_percentage: milestone });
      }
    });
  }, { passive: true });

  /* ── Section visibility tracking ─────────────────────────── */
  var sectionsSeen = {};
  if ('IntersectionObserver' in window) {
    var sectionObserver = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          var id = entry.target.id;
          if (id && !sectionsSeen[id]) {
            sectionsSeen[id] = true;
            dataLayer.push({ event: 'section_view', section_id: id });
          }
        }
      });
    }, { threshold: 0.3 });

    ['hero', 'services', 'about', 'process', 'results', 'faq', 'contact'].forEach(function(id) {
      var el = document.getElementById(id);
      if (el) sectionObserver.observe(el);
    });
  }

  /* ── Exit intent tracking ─────────────────────────────────── */
  var exitFired = false;
  document.addEventListener('mouseleave', function(e) {
    if (!exitFired && e.clientY < 5) {
      exitFired = true;
      dataLayer.push({ event: 'exit_intent', page_scroll_pct: Math.round(
        (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100
      )});
    }
  });

  /* ── Time on page milestones (30s / 60s / 3min) ──────────── */
  [30, 60, 180].forEach(function(seconds) {
    setTimeout(function() {
      dataLayer.push({ event: 'time_on_page', seconds_on_page: seconds });
    }, seconds * 1000);
  });

  /* ── Sticky mobile CTA bar — show after scrolling past hero ─ */
  var stickyCta = document.getElementById('stickyCta');
  var heroSection = document.getElementById('hero');
  if (stickyCta && heroSection) {
    var stickyVisible = false;
    window.addEventListener('scroll', function() {
      var heroBottom = heroSection.getBoundingClientRect().bottom;
      if (heroBottom < 0 && !stickyVisible) {
        stickyVisible = true;
        stickyCta.classList.add('sticky-cta-visible');
      } else if (heroBottom >= 0 && stickyVisible) {
        stickyVisible = false;
        stickyCta.classList.remove('sticky-cta-visible');
      }
    }, { passive: true });
  }

})();
