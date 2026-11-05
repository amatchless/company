# Ad landing pages: setup after deploying theme 3.16.0

Theme 3.16.0 adds `/lp/influencer-marketing/`, `/lp/seo-check/` and `/thank-you/`, and one lead form for both
landing pages. The pages are created automatically the first time any page loads after the deploy. Everything
below is done once, in this order. None of the keys or tokens go into git or chat: they are pasted into
**wp-admin → Settings → Ad leads**.

## 1. Google Sheet (Amatchless Ad Leads Tracker)

1. Open the sheet → **Extensions → Apps Script**. Replace the code with `docs/ad-leads-apps-script.gs`.
2. Change `SECRET` at the top to a long random value. Save.
3. **Deploy → New deployment → Web app**. Execute as: *Me*. Who has access: *Anyone*. Deploy and allow access.
4. In **Settings → Ad leads**, paste the web app URL (ends in `/exec`) and the secret. Save.
5. Click **Send a test row to the Google Sheet**. A row named "TEST: delete me" should appear. Delete it.

What lands in the sheet: Date and time received (IST), Source = Website, Campaign = `utm_campaign`,
Ad set = `utm_term`, Ad name = `utm_content`, every form field, Status = New. Columns the sheet does not have yet
(`utm_source`, `utm_medium`, `fbclid`, `gclid`, `referrer`, `page_url`, `event_id`, WordPress lead ID) are added at
the right-hand end on the first lead. Creators are saved too, with "I am" = Creator and a note.

For the Campaign / Ad set / Ad name columns to fill in, set the URL parameters on every Meta ad to:
`utm_source=facebook&utm_medium=paid_social&utm_campaign={{campaign.name}}&utm_term={{adset.name}}&utm_content={{ad.name}}`

If the sheet is unreachable, the lead is still saved in **wp-admin → Leads** and emailed, and the theme
retries the sheet 10 minutes later (then hourly). Each lead shows "Google Sheet: Added / Failed" in wp-admin.

## 2. Cloudflare Turnstile (spam check)

1. In Cloudflare (free account is fine) → **Turnstile → Add widget**. Hostname: `amatchless.com`. Mode: *Managed*.
2. Paste the **site key** and **secret key** into **Settings → Ad leads**. Save.

Without keys, the form still works with the honeypot only. Visitors normally never see Turnstile; it only shows a
checkbox if Cloudflare is unsure.

## 3. Meta Pixel and Conversions API

**Conversions API** is sent by WordPress itself (no extra plugin, no server-side GTM): when a brand or agency
submits the form, the server sends a `Lead` event to Meta with hashed email, phone, name and city, the `_fbp` /
`_fbc` cookies, IP and browser. `/thank-you/` sends the same `event_id` to GTM, so Meta removes the duplicate.
Creators are not sent to Meta, so ads don't learn to find creators.

The Pixel ID (1660633172287249) is already set in the theme. Only the token is needed:

1. Events Manager → your Pixel → **Settings → Conversions API → Generate access token**.
2. Paste the **access token** into **Settings → Ad leads**. Save.
3. While testing, also paste the **test event code** from Events Manager → Test events. Empty it before ads go live.

**GTM (container GTM-N5F7RG6V): Meta Pixel tags, ready to import**

1. Tag Manager → **Admin → Import container** → choose `docs/gtm-meta-pixel-import.json`.
2. Workspace: *Existing* (Default Workspace). Option: **Merge → Rename conflicting tags, triggers and variables**.
   This only adds items; nothing already in the container is changed. Confirm.
3. Check the import added 5 tags (Meta Pixel Base + PageView, ViewContent, Lead, Contact, Schedule), 4 triggers
   and 6 variables. If the container already has a Meta Pixel tag, pause the old one so PageView isn't counted twice.
4. **Preview** on `https://amatchless.com/lp/seo-check/` to see the tags fire, then **Submit → Publish**.

What it sets up: PageView on every page, ViewContent on `lp_view`, Lead on `generate_lead` from the landing pages
(with the same `eventID` the server sends, so Meta dedupes), Contact on WhatsApp and phone clicks, Schedule on a
Calendly booking. The Lead and other event tags wait for the base tag to load first.

**GA4 events (add by hand, they need your GA4 Measurement ID):** three GA4 Event tags on the imported triggers:

| Tag | Event name and parameters | Trigger |
|---|---|---|
| GA4 generate_lead | `generate_lead`, `service` = `{{DLV - lead_service}}`, `budget_band` = `{{DLV - lead_budget}}` | Meta - Ad lead (thank-you) |
| GA4 contact | `contact`, `method` = `{{Event}}` | Meta - Contact click |
| GA4 schedule | `schedule_call` | Meta - Calendly booked |

GA4 page views already come from your existing GA4 configuration tag.

**Consent**: the site's cookie banner keeps ad storage off until a visitor clicks Accept. The brief allows
tags to fire on page load; if you want that, leave "Additional consent checks" off on the Meta tags. If you want
Meta tags to wait for Accept, set "Require additional consent: ad_storage". The Conversions API Lead is sent either
way (the visitor ticked the Privacy Policy box), which is why the Privacy Policy addition below matters.

## 4. Privacy Policy: three additions (wp-admin → Pages → Privacy Policy)

Under **Who we share it with**, add to the service providers list: "Cloudflare (spam protection on our forms) and
Calendly (call bookings)."

Under **Cookies and tracking**, add: "When you send a form on our ad landing pages, we send Meta a scrambled
(hashed) copy of your email address, phone number, name and city, and a code that identifies the visit, so Meta can
measure which ads lead to enquiries. Meta cannot read the original details from the scrambled copy."

Under **Who we are**, change the phone to **+91 85869 29882**, the number the landing pages now show. The Terms page
also lists +91 90508 20042; change it there too. (The theme's number is `AMATCHLESS_PHONE` in `functions.php`.)

## 5. Test on a real phone (the brief's acceptance checklist)

1. Open `https://amatchless.com/lp/influencer-marketing/?utm_source=test&utm_campaign=test` on Android Chrome and
   iPhone Safari. Submit the form as "A brand".
2. Within a minute: a row in the sheet with `test` in Campaign and utm_source, an email at info@amatchless.com, a
   lead in wp-admin → Leads (it also shows Google Sheet and Conversions API status).
3. `/thank-you/` loads with Calendly and the WhatsApp button.
4. Events Manager → Test events shows PageView, ViewContent and Lead, with Lead from both Browser and Server,
   marked deduplicated.
5. Choose "A creator": the creator message appears, and after sending you see a thank-you note on the same page.
6. Repeat on `/lp/seo-check/` (the website field is required there).
7. PageSpeed Insights (mobile) on both pages.
8. View source on each page: `<meta name='robots' content='noindex, nofollow'>`. The pages are not in
   `/page-sitemap.xml`.
