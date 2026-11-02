<?php
/**
 * Ad landing pages: /lp/influencer-marketing/, /lp/seo-check/ and /thank-you/.
 *
 * - The pages are created once (see amatchless_create_landing_pages) and drawn by templates/landing.php
 *   and templates/thank-you.php, from the content in amatchless_landing_pages() below.
 * - All three are noindex and left out of the sitemap. /lp/ itself redirects to the home page.
 * - The form posts to amatchless_lp_submit(): honeypot + Cloudflare Turnstile, save to wp-admin → Leads,
 *   append a row to the "Amatchless Ad Leads Tracker" Google Sheet (Apps Script web app), email
 *   info@amatchless.com, and send the Lead event to the Meta Conversions API with the same event_id
 *   the browser sends from /thank-you/, so Meta removes the duplicate.
 * - Keys and tokens are entered in wp-admin → Settings → Ad leads. They are never stored in git.
 */
defined('ABSPATH') || exit;

const AMATCHLESS_LP_PARENT = 'lp';
const AMATCHLESS_GRAPH_VERSION = 'v24.0'; // Meta Graph API version for the Conversions API
const AMATCHLESS_META_PIXEL_ID = '1660633172287249'; // public ID (it is in every page's Pixel code); Settings → Ad leads can override it

/* ── Content ─────────────────────────────────────────────────── */
function amatchless_landing_pages() {
    $rohini = AMATCHLESS_SHOW_ADDRESS ? 'Based in Rohini, Delhi' : 'Based in Delhi';
    $near   = AMATCHLESS_SHOW_ADDRESS ? 'Our team works from Rohini, so we meet NCR clients in person when it helps.' : 'Our team is in Delhi, so we meet NCR clients in person when it helps.';
    return [
        'influencer-marketing' => [
            'service'    => 'Influencer marketing',
            'seo_title'  => 'Free Creator Campaign Plan for NCR Brands | Amatchless',
            'seo_desc'   => 'Influencer campaigns that sell, not just trend. Get a free creator plan: 10 creator matches, expected reach and cost, a content brief and sales tracking.',
            'h1'         => 'Influencer campaigns that sell, not just trend.',
            'sub'        => 'For consumer brands in Delhi NCR: the right creators, clear briefs and tracking codes on every post, so you can see which creator brought in sales.',
            'cta'        => 'Get my free creator plan',
            'note'       => 'Campaigns from ₹1 lakh. Reply within 2 working hours.',
            'problem_h'  => 'Sound familiar?',
            'problems'   => [
                ['Paid creators, no sales', 'The posts went up and got likes, but the orders never came.'],
                ['No idea which creator worked', 'Five creators, one discount code, and no way to tell who sold what.'],
                ['Fake followers and wasted fees', 'Big follower counts that turned out to be bots, or audiences in the wrong city.'],
            ],
            'get_h'      => 'What you get in the free plan',
            'gets'       => [
                ['10 creator matches', 'Creators who fit your brand, product and audience, checked for real engagement.'],
                ['Expected reach and cost', 'A realistic range for reach and fees, so you can set a budget before you commit.'],
                ['A content brief outline', 'What each creator should show and say, and what to avoid.'],
                ['How sales will be tracked', 'Unique codes and links per creator, so every sale has a name on it.'],
            ],
            'steps_h'    => 'How a campaign works',
            'steps'      => [
                ['Plan', 'We agree the goal, the budget and how we will measure sales.'],
                ['Creator shortlist and contracts', 'We shortlist, negotiate and sign the creators you approve.'],
                ['Content and posting', 'Creators make the content to the brief; we check it before it goes live.'],
                ['Tracking and report', 'Codes and links on every post, and a report on what each creator sold.'],
            ],
            'why'        => [
                ['One team for creators, content and ads', 'The same team plans the creators, edits the content and boosts the best posts as ads.'],
                ['Tracking codes on every creator', 'Every creator gets their own code and link, so results are never a guess.'],
                ['Budgets from ₹1 lakh to ₹1 Cr', 'From a first test with a few creators to a national campaign.'],
                [$rohini, $near],
            ],
            'form_h'     => 'Get your free creator plan',
            'form_sub'   => 'Tell us about your brand. We reply within 2 working hours.',
            'website_required' => false,
            'budgets'    => ['₹1–5 lakh', '₹5–25 lakh', '₹25 lakh–1 Cr', '₹1 Cr+', 'Not decided'],
            'budget_lbl' => 'Campaign budget',
            'faqs'       => [
                ['How much does an influencer campaign cost?', 'Campaigns start from ₹1 lakh. The total depends on how many creators you want, their size and how much content they make. The free plan gives you a cost range before you decide anything.'],
                ['How long does a campaign take?', 'Planning and creator sign-ups usually take two to three weeks, then posting runs over the weeks you choose. We give you a dated plan once the brief is agreed.'],
                ['How do you choose the creators?', 'We look at who follows them, where those followers live, real engagement (not just follower count) and whether their content fits your brand. You approve every creator before we sign them.'],
                ['How do you measure results?', 'Every creator gets a unique discount code and tracked link. We report reach, clicks and sales per creator, so you can see who paid for themselves.'],
                ['What are the contract and payment terms?', 'You sign one agreement with us that covers the plan, the creators and our fee. Payment terms are set out in the proposal before you commit, and creators are paid through us.'],
            ],
        ],
        'seo-check' => [
            'service'    => 'SEO',
            'seo_title'  => 'Free Google and AI Visibility Check for NCR Businesses | Amatchless',
            'seo_desc'   => 'When customers search, do they find you or your competitor? Free check of your Google ranking, Google Maps listing and whether ChatGPT recommends you.',
            'h1'         => 'When customers search, do they find you or your competitor?',
            'sub'        => 'We check your Google ranking, Google Maps listing and whether ChatGPT recommends you.',
            'cta'        => 'Get my free visibility check',
            'note'       => 'SEO plans from ₹25,000/month. Reply within 2 working hours.',
            'problem_h'  => 'Sound familiar?',
            'problems'   => [
                ['Not on page 1 for your main service', 'Customers search for exactly what you sell, and find someone else first.'],
                ['Competitors show up on Google Maps', 'Nearby searches show three businesses on the map, and yours is not one of them.'],
                ['AI assistants recommend someone else', 'Ask ChatGPT or Gemini for the best option in your city, and your name never comes up.'],
            ],
            'get_h'      => 'What the free check covers',
            'gets'       => [
                ['Your top 10 keywords', 'The searches that matter most for your business, and where you rank for each.'],
                ['Google Business Profile review', 'What is missing or holding your Maps listing back.'],
                ['Website speed and technical issues', 'The problems that stop Google from ranking your pages.'],
                ['AI-search visibility', 'Whether ChatGPT, Gemini and Google AI Overviews mention you, and who they mention instead.'],
            ],
            'steps_h'    => 'How SEO with us works',
            'steps'      => [
                ['Audit', 'We find what is stopping you from ranking, in order of impact.'],
                ['Fix the website', 'Speed, structure and technical fixes, done by our own developers.'],
                ['Content and local SEO', 'Pages and posts for the searches you want, and a stronger Google Maps listing.'],
                ['Monthly report', 'Rankings, traffic and enquiries, in plain language, every month.'],
            ],
            'why'        => [
                ['One team for SEO, website and ads', 'The people who find the problems can fix them on your website too.'],
                ['Tracking on every enquiry', 'Calls, forms and WhatsApp messages from search are counted, not guessed.'],
                ['Plans from ₹25,000 a month', 'Start with the fixes that matter most and grow from there.'],
                [$rohini, $near],
            ],
            'form_h'     => 'Get your free visibility check',
            'form_sub'   => 'Tell us about your business. We reply within 2 working hours.',
            'website_required' => true,
            'budgets'    => ['Under ₹25,000', '₹25,000–50,000', '₹50,000–1 lakh', '₹1 lakh+'],
            'budget_lbl' => 'Monthly budget',
            'faqs'       => [
                ['How much does SEO cost?', 'SEO plans start from ₹25,000 a month. The free check shows what needs doing, and the proposal gives you a fixed monthly price before you commit.'],
                ['How long until we see results?', 'Technical fixes and Google Maps improvements can show within weeks. Rankings for competitive searches usually take a few months of steady work. We tell you what to expect for your keywords after the check.'],
                ['How do you choose the keywords?', 'We start from what your customers actually search for, how many people search it and how likely they are to buy, then check which ones you can realistically win.'],
                ['How do you measure results?', 'Every month you get your rankings, website visits from search, Google Maps views and the calls, forms and WhatsApp messages they brought in.'],
                ['What are the contract and payment terms?', 'Plans are billed monthly. The minimum term and payment terms are set out in the proposal before you sign anything.'],
            ],
        ],
    ];
}

function amatchless_lp_cities() {
    return ['Delhi', 'Gurugram', 'Noida', 'Faridabad', 'Ghaziabad', 'Other'];
}
function amatchless_lp_roles() {
    return ['Brand' => 'A brand', 'Agency' => 'An agency', 'Creator' => 'A creator'];
}

/* ── Which page are we on? ───────────────────────────────────── */
// The landing page's slug ('influencer-marketing' / 'seo-check') when viewing one, otherwise ''.
function amatchless_current_lp() {
    static $slug = null;
    if ($slug !== null) return $slug;
    if (!did_action('wp')) return ''; // the query isn't known yet; don't cache a guess
    $slug = '';
    if (is_page()) {
        $post   = get_queried_object();
        $parent = $post && $post->post_parent ? get_post($post->post_parent) : null;
        if ($parent && $parent->post_name === AMATCHLESS_LP_PARENT && isset(amatchless_landing_pages()[$post->post_name])) {
            $slug = $post->post_name;
        }
    }
    return $slug;
}
function amatchless_is_thank_you() {
    return is_page('thank-you');
}
// True on the pages that use the stripped-down ad layout.
function amatchless_is_ad_page() {
    return amatchless_current_lp() !== '' || amatchless_is_thank_you();
}

/* ── Create the pages once ───────────────────────────────────── */
function amatchless_create_landing_pages() {
    if (get_option('amatchless_lp_pages_created') === '1') return;
    $parent = get_page_by_path(AMATCHLESS_LP_PARENT);
    $parent_id = $parent ? $parent->ID : wp_insert_post([
        'post_type' => 'page', 'post_status' => 'publish', 'post_name' => AMATCHLESS_LP_PARENT, 'post_title' => 'Landing pages',
    ]);
    if (!$parent_id || is_wp_error($parent_id)) return;
    foreach (amatchless_landing_pages() as $slug => $lp) {
        if (get_page_by_path(AMATCHLESS_LP_PARENT . '/' . $slug)) continue;
        wp_insert_post([
            'post_type' => 'page', 'post_status' => 'publish', 'post_parent' => $parent_id,
            'post_name' => $slug, 'post_title' => $lp['service'], 'post_excerpt' => $lp['seo_desc'],
        ]);
    }
    if (!get_page_by_path('thank-you')) {
        wp_insert_post(['post_type' => 'page', 'post_status' => 'publish', 'post_name' => 'thank-you', 'post_title' => 'Thank you']);
    }
    update_option('amatchless_lp_pages_created', '1');
}
add_action('init', 'amatchless_create_landing_pages', 21);

// IDs of the parent /lp/ page, the landing pages and /thank-you/ (for noindex and the sitemap).
function amatchless_ad_page_ids() {
    $ids = [];
    $parent = get_page_by_path(AMATCHLESS_LP_PARENT);
    if ($parent) $ids[] = $parent->ID;
    foreach (array_keys(amatchless_landing_pages()) as $slug) {
        $p = get_page_by_path(AMATCHLESS_LP_PARENT . '/' . $slug);
        if ($p) $ids[] = $p->ID;
    }
    $ty = get_page_by_path('thank-you');
    if ($ty) $ids[] = $ty->ID;
    return $ids;
}

/* ── Templates ───────────────────────────────────────────────── */
add_filter('template_include', function ($template) {
    if (amatchless_current_lp()) return get_template_directory() . '/templates/landing.php';
    if (amatchless_is_thank_you()) return get_template_directory() . '/templates/thank-you.php';
    return $template;
}, 20);

// /lp/ on its own has nothing to show.
add_action('template_redirect', function () {
    if (is_page(AMATCHLESS_LP_PARENT) && !get_post_field('post_parent', get_queried_object_id())) {
        wp_safe_redirect(home_url('/'), 302);
        exit;
    }
});

/* ── noindex and sitemap ─────────────────────────────────────── */
function amatchless_ad_page_noindex() {
    return amatchless_is_ad_page() || is_page(AMATCHLESS_LP_PARENT);
}
add_filter('wpseo_robots', fn($v) => amatchless_ad_page_noindex() ? 'noindex, nofollow' : $v);
add_filter('wp_robots', function ($robots) {
    if (amatchless_ad_page_noindex()) { $robots['noindex'] = true; $robots['nofollow'] = true; unset($robots['max-image-preview']); }
    return $robots;
});
add_filter('wpseo_exclude_from_sitemap_by_post_ids', fn($ids) => array_merge((array) $ids, amatchless_ad_page_ids()));
add_filter('wp_sitemaps_posts_query_args', function ($args, $type) {
    if ($type === 'page') $args['post__not_in'] = array_merge($args['post__not_in'] ?? [], amatchless_ad_page_ids());
    return $args;
}, 10, 2);
// Yoast's canonical would point Google at a page we don't want indexed; leave it off.
add_filter('wpseo_canonical', fn($v) => amatchless_ad_page_noindex() ? false : $v);

/* ── Titles and descriptions ─────────────────────────────────── */
function amatchless_lp_seo($field, $fallback) {
    $slug = amatchless_current_lp();
    if ($slug) return amatchless_landing_pages()[$slug][$field === 'title' ? 'seo_title' : 'seo_desc'];
    if (amatchless_is_thank_you()) return $field === 'title' ? 'Thank you | Amatchless' : "We'll call you within 2 working hours.";
    return $fallback;
}
foreach (['wpseo_title', 'wpseo_opengraph_title', 'wpseo_twitter_title'] as $f) {
    add_filter($f, fn($v) => amatchless_lp_seo('title', $v), 20);
}
foreach (['wpseo_metadesc', 'wpseo_opengraph_desc', 'wpseo_twitter_description'] as $f) {
    add_filter($f, fn($v) => amatchless_lp_seo('desc', $v), 20);
}
add_filter('pre_get_document_title', fn($t) => function_exists('wpseo_init') ? $t : amatchless_lp_seo('title', $t), 20);

/* ── FAQ schema on each landing page ─────────────────────────── */
add_action('wp_head', function () {
    $slug = amatchless_current_lp();
    if (!$slug) return;
    $url = get_permalink(get_queried_object_id());
    echo '<script type="application/ld+json">' . wp_json_encode([
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        '@id'        => $url . '#faq',
        'url'        => $url,
        'inLanguage' => 'en-IN',
        'mainEntity' => array_map(fn($qa) => ['@type' => 'Question', 'name' => $qa[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $qa[1]]], amatchless_landing_pages()[$slug]['faqs']),
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
});

/* ── Assets ──────────────────────────────────────────────────── */
add_action('wp_enqueue_scripts', function () {
    if (!amatchless_is_ad_page()) return;
    $uri = get_template_directory_uri();
    wp_enqueue_style('amatchless-landing', $uri . '/assets/css/landing.css', ['amatchless-site'], AMATCHLESS_VERSION);
    wp_enqueue_script('amatchless-landing', $uri . '/assets/js/landing.js', [], AMATCHLESS_VERSION, true);
    $slug = amatchless_current_lp();
    wp_localize_script('amatchless-landing', 'amxLanding', [
        'ajax'      => admin_url('admin-ajax.php'),
        'thankYou'  => home_url('/thank-you/'),
        'turnstile' => amatchless_ads_option('turnstile_site'),
        'page'      => $slug ? 'landing' : 'thank_you',
        'service'   => $slug ? amatchless_landing_pages()[$slug]['service'] : '',
        'email'     => AMATCHLESS_EMAIL,
        'whatsapp'  => AMATCHLESS_WHATSAPP,
    ]);
}, 20);

/* ── Settings → Ad leads (keys and tokens, kept out of git) ──── */
function amatchless_ads_fields() {
    return [
        'sheet_url'        => ['Google Sheet web app URL', 'The Apps Script web app URL (ends in /exec). See docs/ad-landing-pages-setup.md.', false],
        'sheet_secret'     => ['Google Sheet shared secret', 'The same value as SECRET at the top of the Apps Script.', true],
        'turnstile_site'   => ['Cloudflare Turnstile site key', 'Public key. Leave empty to run with the honeypot only.', false],
        'turnstile_secret' => ['Cloudflare Turnstile secret key', '', true],
        'pixel_id'         => ['Meta Pixel ID', 'Already set to 1660633172287249. Only change it if you move to another Pixel.', false],
        'capi_token'       => ['Conversions API access token', 'From Events Manager → your Pixel → Settings → Conversions API → Generate access token.', true],
        'capi_test_code'   => ['Conversions API test event code', 'Only while testing in Events Manager → Test events (e.g. TEST12345). Empty it before ads go live.', false],
    ];
}
function amatchless_ads_option($key) {
    $o = get_option('amatchless_ads', []);
    $v = is_array($o) && isset($o[$key]) ? (string) $o[$key] : '';
    return ($v === '' && $key === 'pixel_id') ? AMATCHLESS_META_PIXEL_ID : $v;
}

add_action('admin_menu', function () {
    add_options_page('Ad leads', 'Ad leads', 'manage_options', 'amatchless-ads', 'amatchless_ads_settings_page');
});
add_action('admin_init', function () {
    register_setting('amatchless_ads', 'amatchless_ads', [
        'type' => 'array',
        'sanitize_callback' => function ($in) {
            $old = get_option('amatchless_ads', []);
            $out = [];
            foreach (amatchless_ads_fields() as $key => [$label, $help, $secret]) {
                $v = isset($in[$key]) ? trim(sanitize_text_field(wp_unslash($in[$key]))) : '';
                // Secret fields are never shown again; an empty box keeps the saved value. Tick "clear" to remove it.
                if ($secret && $v === '' && empty($in[$key . '_clear'])) $v = $old[$key] ?? '';
                $out[$key] = $v;
            }
            $out['pixel_id'] = preg_replace('/\D/', '', $out['pixel_id']);
            if ($out['sheet_url'] !== '' && !preg_match('#^https://script\.google\.com/#', $out['sheet_url'])) {
                add_settings_error('amatchless_ads', 'sheet', 'The Google Sheet URL must start with https://script.google.com/');
                $out['sheet_url'] = $old['sheet_url'] ?? '';
            }
            return $out;
        },
    ]);
});

function amatchless_ads_settings_page() {
    if (!current_user_can('manage_options')) return;
    echo '<div class="wrap"><h1>Ad leads</h1>';
    echo '<p>Settings for the lead form on the ad landing pages (<a href="' . esc_url(home_url('/lp/influencer-marketing/')) . '" target="_blank">influencer</a>, <a href="' . esc_url(home_url('/lp/seo-check/')) . '" target="_blank">SEO</a>). Secret values are hidden once saved; leave a secret box empty to keep it.</p>';
    if (isset($_GET['amx_test']) && check_admin_referer('amx_sheet_test')) {
        $r = amatchless_sheet_send(amatchless_sheet_row(['name' => 'TEST: delete me', 'role' => 'Brand', 'service' => 'Test', 'message' => 'Test row from wp-admin → Settings → Ad leads.', 'utm_source' => 'test', 'utm_campaign' => 'test']));
        printf('<div class="notice notice-%s"><p>Google Sheet test: %s</p></div>', $r === true ? 'success' : 'error', esc_html($r === true ? 'a test row was added. Delete it from the sheet.' : $r));
    }
    settings_errors('amatchless_ads');
    echo '<form method="post" action="options.php">';
    settings_fields('amatchless_ads');
    echo '<table class="form-table" role="presentation"><tbody>';
    foreach (amatchless_ads_fields() as $key => [$label, $help, $secret]) {
        $val = amatchless_ads_option($key);
        printf('<tr><th scope="row"><label for="amx-%1$s">%2$s</label></th><td>', esc_attr($key), esc_html($label));
        if ($secret) {
            printf('<input type="password" class="regular-text" id="amx-%1$s" name="amatchless_ads[%1$s]" value="" autocomplete="new-password" placeholder="%2$s">', esc_attr($key), $val !== '' ? 'Saved (hidden)' : 'Not set');
            if ($val !== '') printf(' <label><input type="checkbox" name="amatchless_ads[%s_clear]" value="1"> Clear</label>', esc_attr($key));
        } else {
            printf('<input type="text" class="regular-text" id="amx-%1$s" name="amatchless_ads[%1$s]" value="%2$s">', esc_attr($key), esc_attr($val));
        }
        if ($help) printf('<p class="description">%s</p>', esc_html($help));
        echo '</td></tr>';
    }
    echo '</tbody></table>';
    submit_button();
    echo '</form>';
    if (amatchless_ads_option('sheet_url')) {
        printf('<p><a class="button" href="%s">Send a test row to the Google Sheet</a></p>', esc_url(wp_nonce_url(add_query_arg('amx_test', 1), 'amx_sheet_test')));
    }
    echo '</div>';
}

/* ── Form handler ────────────────────────────────────────────── */
function amatchless_lp_fail($msg, $field = '') {
    wp_send_json_error(['message' => $msg, 'field' => $field]);
}

// Indian mobile: keep the last 10 digits after dropping +91 / 0; must start 6–9.
function amatchless_lp_phone($raw) {
    $d = preg_replace('/\D/', '', $raw);
    if (strlen($d) === 12 && str_starts_with($d, '91')) $d = substr($d, 2);
    if (strlen($d) === 11 && $d[0] === '0') $d = substr($d, 1);
    return preg_match('/^[6-9]\d{9}$/', $d) ? $d : '';
}

function amatchless_lp_submit() {
    $p = fn($k) => sanitize_text_field(wp_unslash($_POST[$k] ?? ''));

    // 1. Spam: honeypot, then Turnstile when it is set up.
    if ($p('amx_hp') !== '') {
        wp_send_json_success(['redirect' => home_url('/thank-you/')]); // look like success to the bot
    }
    $lp_slug = $p('lp');
    $pages   = amatchless_landing_pages();
    if (!isset($pages[$lp_slug])) amatchless_lp_fail('Please reload the page and try again.');
    $lp = $pages[$lp_slug];

    if (amatchless_ads_option('turnstile_secret') !== '') {
        $res = wp_remote_post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'timeout' => 8,
            'body'    => ['secret' => amatchless_ads_option('turnstile_secret'), 'response' => $p('cf-turnstile-response'), 'remoteip' => $_SERVER['REMOTE_ADDR'] ?? ''],
        ]);
        $ok = !is_wp_error($res) && !empty(json_decode(wp_remote_retrieve_body($res), true)['success']);
        if (!$ok) amatchless_lp_fail('We could not confirm you are not a robot. Please try again, or WhatsApp us.');
    }

    // Validate.
    $lead = [
        'name'    => $p('name'),
        'phone'   => amatchless_lp_phone($p('phone')),
        'email'   => sanitize_email(wp_unslash($_POST['email'] ?? '')),
        'company' => $p('company'),
        'website' => $p('website'),
        'role'    => $p('role'),
        'budget'  => $p('budget'),
        'city'    => $p('city'),
        'message' => sanitize_textarea_field(wp_unslash($_POST['message'] ?? '')),
        'service' => $lp['service'],
        'source'  => 'Website',
        'ip'      => sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? ''),
    ];
    if ($lead['name'] === '')                                   amatchless_lp_fail('Please enter your full name.', 'name');
    if ($lead['phone'] === '')                                  amatchless_lp_fail('Please enter a 10-digit mobile number.', 'phone');
    if (!is_email($lead['email']))                              amatchless_lp_fail('Please enter a valid email address.', 'email');
    if ($lead['company'] === '')                                amatchless_lp_fail('Please enter your brand or company.', 'company');
    if ($lp['website_required'] && $lead['website'] === '')     amatchless_lp_fail('Please enter your website or Instagram.', 'website');
    if (!isset(amatchless_lp_roles()[$lead['role']]))           amatchless_lp_fail('Please tell us who you are.', 'role');
    if (!in_array($lead['budget'], $lp['budgets'], true))       amatchless_lp_fail('Please choose a budget.', 'budget');
    if (!in_array($lead['city'], amatchless_lp_cities(), true)) amatchless_lp_fail('Please choose your city.', 'city');
    if (empty($_POST['consent']))                               amatchless_lp_fail('Please agree to the Privacy Policy.', 'consent');

    foreach (['page_url', 'utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term', 'fbclid', 'gclid', 'referrer'] as $k) {
        $lead[$k] = substr($p($k), 0, 500);
    }
    $lead['phone'] = '+91 ' . $lead['phone'];
    $lead['status'] = 'New';
    $is_creator = $lead['role'] === 'Creator';
    $event_id = 'lead-' . wp_generate_uuid4();
    $lead['event_id'] = $event_id;

    // 2. Save in WordPress first, so nothing is lost if the Sheet or the email fails.
    $lead_id = amatchless_save_lead($lead);

    // 3. Google Sheet.
    $sheet = amatchless_sheet_send(amatchless_sheet_row($lead + ['lead_id' => $lead_id]));
    if ($lead_id) {
        update_post_meta($lead_id, '_lead_sheet', $sheet === true ? 'Added' : 'Failed: ' . $sheet);
        if ($sheet !== true && !wp_next_scheduled('amatchless_sheet_retry')) wp_schedule_single_event(time() + 600, 'amatchless_sheet_retry');
    }

    // 4. Email alert with every field.
    $labels = ['name' => 'Name', 'phone' => 'Phone', 'email' => 'Email', 'company' => 'Brand / company', 'website' => 'Website or Instagram', 'role' => 'I am', 'service' => 'Service', 'budget' => 'Budget', 'city' => 'City', 'message' => 'Next 3 months', 'page_url' => 'Page', 'utm_source' => 'utm_source', 'utm_medium' => 'utm_medium', 'utm_campaign' => 'utm_campaign', 'utm_content' => 'utm_content', 'utm_term' => 'utm_term', 'fbclid' => 'fbclid', 'gclid' => 'gclid', 'referrer' => 'Referrer', 'ip' => 'IP'];
    $body = 'New ' . ($is_creator ? 'CREATOR enquiry (not a brand lead)' : 'ad lead') . " from amatchless.com\n\n";
    foreach ($labels as $k => $l) $body .= str_pad($l . ':', 22) . ($lead[$k] !== '' ? $lead[$k] : '—') . "\n";
    $body .= "\nGoogle Sheet: " . ($sheet === true ? 'added' : 'NOT added (' . $sheet . '), will retry') . "\n";
    $body .= 'Submitted: ' . current_time('mysql') . ($lead_id ? "\nView in admin: " . admin_url('post.php?post=' . $lead_id . '&action=edit') : '');
    $subject = ($is_creator ? '[Creator] ' : '[Ad lead] ') . $lead['service'] . ': ' . $lead['name'] . ' from ' . $lead['company'];
    $sent = wp_mail(AMATCHLESS_EMAIL, $subject, $body, [
        'Content-Type: text/plain; charset=UTF-8',
        'From: Amatchless Website <noreply@amatchless.com>',
        'Reply-To: ' . $lead['email'],
    ]);
    if ($lead_id) update_post_meta($lead_id, '_lead_emailed', $sent ? 'Yes' : 'No — sending failed');

    if (!$lead_id && $sheet !== true && !$sent) {
        amatchless_lp_fail('Sorry, something went wrong. Please WhatsApp us or email ' . AMATCHLESS_EMAIL . '.');
    }

    // 5. Conversions API (brand and agency leads only, so Meta doesn't learn to find creators).
    if (!$is_creator) {
        $capi = amatchless_capi_lead($lead, $event_id);
        if ($lead_id) update_post_meta($lead_id, '_lead_capi', $capi);
    }

    wp_send_json_success([
        'creator'  => $is_creator,
        'redirect' => $is_creator ? '' : home_url('/thank-you/'),
        'event_id' => $event_id,
        'service'  => $lead['service'],
        'budget'   => $lead['budget'],
    ]);
}
add_action('wp_ajax_nopriv_amatchless_lp', 'amatchless_lp_submit');
add_action('wp_ajax_amatchless_lp', 'amatchless_lp_submit');

/* ── Google Sheet ────────────────────────────────────────────── */
// One row, keyed by the sheet's own column names. The Apps Script matches them to the header row
// and adds any tracking column (utm_source, fbclid, …) that the sheet doesn't have yet.
function amatchless_sheet_row(array $l) {
    $g = fn($k) => (string) ($l[$k] ?? '');
    $now = !empty($l['date']) ? new DateTimeImmutable($l['date'], wp_timezone()) : current_datetime();
    return [
        'Date received'                    => $now->format('d M Y'),
        'Time received'                    => $now->format('H:i'),
        'Source (Meta form / WhatsApp / Website)' => 'Website',
        'Campaign'                         => $g('utm_campaign'),
        'Ad set'                           => $g('utm_term'),
        'Ad name'                          => $g('utm_content'),
        'Full name'                        => $g('name'),
        'Phone'                            => $g('phone'),
        'Work email'                       => $g('email'),
        'Brand / company'                  => $g('company'),
        'Website or Instagram'             => $g('website'),
        'I am (Brand / Agency / Creator)'  => $g('role'),
        'Service (Influencer / SEO / Other)' => $g('service') === 'Influencer marketing' ? 'Influencer' : ($g('service') === 'SEO' ? 'SEO' : ($g('service') ?: 'Other')),
        'Budget band'                      => $g('budget'),
        'City'                             => $g('city'),
        'Message'                          => $g('message'),
        'Status (New / Contacted / Qualified / Call booked / Proposal sent / Won / Lost / Junk)' => 'New',
        'Notes'                            => $g('role') === 'Creator' ? 'Creator, not a brand: reply by email about collaborations.' : '',
        'utm_source'                       => $g('utm_source'),
        'utm_medium'                       => $g('utm_medium'),
        'utm_campaign'                     => $g('utm_campaign'),
        'utm_content'                      => $g('utm_content'),
        'utm_term'                         => $g('utm_term'),
        'fbclid'                           => $g('fbclid'),
        'gclid'                            => $g('gclid'),
        'referrer'                         => $g('referrer'),
        'page_url'                         => $g('page_url'),
        'event_id'                         => $g('event_id'),
        'WordPress lead ID'                => $g('lead_id'),
    ];
}

// Returns true, or a short reason it failed.
function amatchless_sheet_send(array $row) {
    $url = amatchless_ads_option('sheet_url');
    if ($url === '') return 'Google Sheet not set up (Settings → Ad leads)';
    $res = wp_remote_post($url, [
        'timeout'     => 12,
        'redirection' => 5,
        'headers'     => ['Content-Type' => 'application/json'],
        'body'        => wp_json_encode(['secret' => amatchless_ads_option('sheet_secret'), 'row' => $row], JSON_UNESCAPED_UNICODE),
    ]);
    if (is_wp_error($res)) return $res->get_error_message();
    $json = json_decode(wp_remote_retrieve_body($res), true);
    if (!empty($json['ok'])) return true;
    return 'HTTP ' . wp_remote_retrieve_response_code($res) . (isset($json['error']) ? ' ' . $json['error'] : '');
}

// Retry leads whose Sheet row failed (runs 10 minutes after a failure, then again while any are left).
add_action('amatchless_sheet_retry', function () {
    $q = new WP_Query(['post_type' => 'amatchless_lead', 'post_status' => 'any', 'posts_per_page' => 20, 'fields' => 'ids',
        'meta_query' => [['key' => '_lead_sheet', 'value' => 'Failed', 'compare' => 'LIKE']]]);
    $left = false;
    foreach ($q->posts as $id) {
        $l = ['name' => get_the_title($id), 'message' => get_post_field('post_content', $id), 'lead_id' => $id, 'date' => get_post_field('post_date', $id)];
        foreach (array_keys(AMATCHLESS_LEAD_FIELDS) as $k) $l[$k] = get_post_meta($id, '_lead_' . $k, true);
        $r = amatchless_sheet_send(amatchless_sheet_row($l));
        update_post_meta($id, '_lead_sheet', $r === true ? 'Added (retry)' : 'Failed: ' . $r);
        if ($r !== true) $left = true;
    }
    if ($left) wp_schedule_single_event(time() + HOUR_IN_SECONDS, 'amatchless_sheet_retry');
});

/* ── Meta Conversions API ────────────────────────────────────── */
function amatchless_capi_lead(array $lead, $event_id) {
    $pixel = amatchless_ads_option('pixel_id');
    $token = amatchless_ads_option('capi_token');
    if ($pixel === '' || $token === '') return 'Not sent: Pixel ID or token not set';

    $h = fn($v) => $v === '' ? null : hash('sha256', $v);
    $name  = preg_split('/\s+/', strtolower(trim($lead['name'])));
    $fbc   = sanitize_text_field(wp_unslash($_COOKIE['_fbc'] ?? ''));
    if ($fbc === '' && $lead['fbclid'] !== '') $fbc = 'fb.1.' . round(microtime(true) * 1000) . '.' . $lead['fbclid'];
    $user = array_filter([
        'em'  => [$h(strtolower(trim($lead['email'])))],
        'ph'  => [$h('91' . substr(preg_replace('/\D/', '', $lead['phone']), -10))],
        'fn'  => [$h($name[0] ?? '')],
        'ln'  => count($name) > 1 ? [$h(end($name))] : null,
        'ct'  => $lead['city'] !== 'Other' ? [$h(preg_replace('/[^a-z]/', '', strtolower($lead['city'])))] : null,
        'country' => [$h('in')],
        'external_id' => [$h($event_id)],
        'client_ip_address' => $lead['ip'] ?: null,
        'client_user_agent' => sanitize_text_field(wp_unslash($_SERVER['HTTP_USER_AGENT'] ?? '')) ?: null,
        'fbp' => sanitize_text_field(wp_unslash($_COOKIE['_fbp'] ?? '')) ?: null,
        'fbc' => $fbc ?: null,
    ], fn($v) => $v !== null && $v !== [null]);

    $payload = ['data' => [[
        'event_name'       => 'Lead',
        'event_time'       => time(),
        'event_id'         => $event_id,
        'action_source'    => 'website',
        'event_source_url' => home_url('/thank-you/'),
        'user_data'        => $user,
        'custom_data'      => ['service' => $lead['service'], 'budget_band' => $lead['budget'], 'lead_type' => $lead['role'], 'content_name' => $lead['service']],
    ]]];
    if (amatchless_ads_option('capi_test_code') !== '') $payload['test_event_code'] = amatchless_ads_option('capi_test_code');

    $res = wp_remote_post('https://graph.facebook.com/' . AMATCHLESS_GRAPH_VERSION . '/' . rawurlencode($pixel) . '/events?access_token=' . rawurlencode($token), [
        'timeout' => 6,
        'headers' => ['Content-Type' => 'application/json'],
        'body'    => wp_json_encode($payload),
    ]);
    if (is_wp_error($res)) return 'Failed: ' . $res->get_error_message();
    $code = wp_remote_retrieve_response_code($res);
    if ($code === 200) return 'Sent (' . $event_id . ')';
    $err = json_decode(wp_remote_retrieve_body($res), true);
    return 'Failed: HTTP ' . $code . (isset($err['error']['message']) ? ' ' . $err['error']['message'] : '');
}
