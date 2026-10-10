<?php
defined('ABSPATH') || exit;

define('AMATCHLESS_VERSION', '2.4.0');
define('AMATCHLESS_EMAIL', 'info@amatchless.com');
define('AMATCHLESS_PHONE', '+91 90508 20042');
define('AMATCHLESS_PHONE_E164', '+919050820042');
define('AMATCHLESS_WHATSAPP', 'https://wa.me/919050820042?text=Hi%20Amatchless%20Team%2C%20I%20want%20to%20discuss%20my%20digital%20marketing%20needs.');

/* ── Template helpers ────────────────────────────────────────── */
// Link to a section of the homepage: a bare #anchor on the homepage, a full URL elsewhere.
function amatchless_anchor($id) {
    return (is_front_page() || amatchless_is_section_page()) ? '#' . $id : home_url('/#' . $id);
}

// Menu items that have their own page: slug => [title, anchor on the home page].
function amatchless_section_pages() {
    return [
        'services'      => ['Services',      'services'],
        'work'          => ['Work',          'work'],
        'about'         => ['About',         'about'],
        'ai-automation' => ['AI Automation', 'automation'],
    ];
}

// True on the individual section pages (they all end with the contact form).
function amatchless_is_section_page() {
    return is_page(array_keys(amatchless_section_pages()));
}

// URL of a section's own page, falling back to its home-page anchor if the page is missing.
function amatchless_page_url($slug) {
    $pages = amatchless_section_pages();
    static $urls = [];
    if (!isset($urls[$slug])) {
        $page = get_page_by_path($slug);
        $urls[$slug] = ($page && $page->post_status === 'publish') ? get_permalink($page) : '';
    }
    if ($urls[$slug]) return $urls[$slug];
    return home_url('/#' . ($pages[$slug][1] ?? $slug));
}

// Create the section pages once (only the ones that don't exist yet).
function amatchless_create_section_pages() {
    if (get_option('amatchless_pages_created') === '1') return;
    $excerpts = [
        'services'      => 'Branding, content, social, SEO, Google and Meta ads, web development, automations and custom software from one accountable team.',
        'work'          => 'Selected projects and case studies for Isola, AleuCo, Bailey\'s Blossoms, Moment, Haliburton Forest and MD Biocoals.',
        'about'         => 'Amatchless is one team for creative, media and code, built to close the gap between good marketing and real growth.',
        'ai-automation' => 'AI and automation wired into the work itself: leads on autopilot, content and reporting pipelines, and custom AI assistants.',
    ];
    foreach (amatchless_section_pages() as $slug => $info) {
        if (get_page_by_path($slug)) continue;
        wp_insert_post([
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_name'    => $slug,
            'post_title'   => $info[0],
            'post_excerpt' => $excerpts[$slug],
        ]);
    }
    update_option('amatchless_pages_created', '1');
}
add_action('init', 'amatchless_create_section_pages', 20);

// The blog index URL, or '' when no "Posts page" is set in Settings → Reading.
function amatchless_blog_url() {
    $id = (int) get_option('page_for_posts');
    return $id ? get_permalink($id) : '';
}

function amatchless_img($file) {
    return get_template_directory_uri() . '/assets/img/' . $file;
}

/* ── Theme Setup ─────────────────────────────────────────────── */
function amatchless_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption','style','script']);
    add_theme_support('custom-logo');
    add_theme_support('automatic-feed-links');
    register_nav_menus(['primary' => __('Primary Menu', 'amatchless')]);
}
add_action('after_setup_theme', 'amatchless_setup');

/* ── Enqueue Styles & Scripts ────────────────────────────────── */
function amatchless_assets() {
    wp_enqueue_style('google-fonts',
        'https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300..600;1,9..144,300..500&family=Hanken+Grotesk:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap',
        [], null
    );
    wp_enqueue_style('amatchless-site', get_template_directory_uri() . '/assets/css/site.css', ['google-fonts'], AMATCHLESS_VERSION);
    wp_enqueue_script('amatchless-site', get_template_directory_uri() . '/assets/js/site.js', [], AMATCHLESS_VERSION, true);
    wp_localize_script('amatchless-site', 'amatchlessAjax', [
        'url'   => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('amatchless_contact_nonce'),
        'email' => AMATCHLESS_EMAIL,
    ]);
}
add_action('wp_enqueue_scripts', 'amatchless_assets');

/* ── Preconnect Hints ────────────────────────────────────────── */
function amatchless_preconnect() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    // Flag JS early so entrance animations never hide content when scripts fail.
    echo '<script>document.documentElement.classList.add(\'js\');</script>' . "\n";
}
add_action('wp_head', 'amatchless_preconnect', 1);

/* ── Canonical URL ───────────────────────────────────────────── */
function amatchless_canonical() {
    // Only output when Yoast hasn't already (Yoast outputs canonical at priority 10+)
    if (function_exists('wpseo_init')) return;
    if (is_front_page()) {
        echo '<link rel="canonical" href="' . esc_url(home_url('/')) . '">' . "\n";
    } elseif (is_singular()) {
        echo '<link rel="canonical" href="' . esc_url(get_permalink()) . '">' . "\n";
    }
}
add_action('wp_head', 'amatchless_canonical', 5);

/* ── Open Graph / Twitter Meta ───────────────────────────────── */
function amatchless_og_meta() {
    // Only add when Yoast hasn't covered it
    if (function_exists('wpseo_init')) return;
    if (is_front_page()) {
        $title       = 'Digital Marketing Agency in New Delhi | SEO, AEO, GEO & Performance Ads | Amatchless';
        $description = 'Amatchless is New Delhi\'s premier creative & digital growth agency. We deliver SEO, Answer Engine Optimisation (AEO), GEO, performance advertising, content marketing, and AI-powered automation for ambitious brands.';
        $url         = home_url('/');
    } elseif (is_singular()) {
        $title       = get_the_title() . ' | Amatchless';
        $description = has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 30, '...');
        $url         = get_permalink();
    } else {
        return;
    }
    echo '<meta property="og:locale" content="en_IN">' . "\n";
    echo '<meta property="og:type" content="website">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";
    echo '<meta property="og:site_name" content="Amatchless">' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($description) . '">' . "\n";
}
add_action('wp_head', 'amatchless_og_meta', 5);

/* ── Schema JSON-LD ──────────────────────────────────────────── */
function amatchless_schema() {
    if (!is_front_page()) return;

    $graph = [
        [
            '@type'         => 'Organization',
            '@id'           => 'https://amatchless.com/#organization',
            'name'          => 'Amatchless',
            'alternateName' => 'AMATCHLESS',
            'url'           => 'https://amatchless.com',
            'logo'          => [
                '@type' => 'ImageObject',
                'url'   => 'https://amatchless.com/wp-content/themes/amatchless/assets/og-image.jpg',
                'width' => 1200, 'height' => 630,
            ],
            'description'   => 'Amatchless is a creative and digital growth agency based in Rohini, New Delhi, India. We specialise in SEO, Answer Engine Optimisation (AEO), Generative Engine Optimisation (GEO), performance advertising, content marketing, social media marketing, and AI-powered marketing automation.',
            'email'         => 'info@amatchless.com',
            'telephone'     => '+91-90508-20042',
            'address'       => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => 'Rohini',
                'addressLocality' => 'New Delhi',
                'addressRegion'   => 'Delhi',
                'postalCode'      => '110085',
                'addressCountry'  => 'IN',
            ],
            'sameAs'        => [
                'https://www.linkedin.com/company/amatchless',
                'https://www.instagram.com/amatchless',
                'https://twitter.com/amatchless',
                'https://www.youtube.com/@amatchless',
            ],
            'foundingDate'  => '2020',
            'numberOfEmployees' => ['@type' => 'QuantitativeValue', 'minValue' => 5, 'maxValue' => 25],
            'areaServed'    => ['IN', 'US', 'GB', 'AU', 'AE', 'SG'],
            'knowsAbout'    => ['SEO', 'AEO', 'GEO', 'Performance Marketing', 'Content Marketing', 'Marketing Automation', 'Digital Marketing', 'AI Marketing'],
        ],
        [
            '@type'         => ['LocalBusiness', 'ProfessionalService'],
            '@id'           => 'https://amatchless.com/#localbusiness',
            'name'          => 'Amatchless',
            'description'   => 'Digital marketing agency in New Delhi offering SEO, AEO, GEO, performance advertising, content marketing, and marketing automation for brands across India and worldwide.',
            'email'         => 'info@amatchless.com',
            'telephone'     => '+91-90508-20042',
            'url'           => 'https://amatchless.com',
            'address'       => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => 'Rohini',
                'addressLocality' => 'New Delhi',
                'addressRegion'   => 'Delhi',
                'postalCode'      => '110085',
                'addressCountry'  => 'IN',
            ],
            'geo'           => ['@type' => 'GeoCoordinates', 'latitude' => '28.7041', 'longitude' => '77.1025'],
            'openingHoursSpecification' => [[
                '@type'     => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday','Tuesday','Wednesday','Thursday','Friday'],
                'opens'     => '09:00',
                'closes'    => '19:00',
            ]],
            'priceRange'    => '₹₹₹',
            'currenciesAccepted' => 'INR, USD',
            'areaServed'    => 'Worldwide',
            'hasOfferCatalog' => ['@id' => 'https://amatchless.com/#offers'],
        ],
        [
            '@type'     => 'WebSite',
            '@id'       => 'https://amatchless.com/#website',
            'name'      => 'Amatchless',
            'url'       => 'https://amatchless.com',
            'inLanguage' => 'en-IN',
            'publisher'  => ['@id' => 'https://amatchless.com/#organization'],
            'potentialAction' => [
                '@type'       => 'SearchAction',
                'target'      => ['@type' => 'EntryPoint', 'urlTemplate' => 'https://amatchless.com/?s={search_term_string}'],
                'query-input' => 'required name=search_term_string',
            ],
        ],
        [
            '@type'       => 'WebPage',
            '@id'         => 'https://amatchless.com/#webpage',
            'url'         => 'https://amatchless.com/',
            'name'        => 'Amatchless — Digital Marketing Agency in New Delhi | SEO, AEO, GEO & Performance Ads',
            'description' => 'Amatchless is New Delhi\'s premier digital marketing agency delivering SEO, AEO, GEO, performance advertising, content marketing, and AI-powered marketing automation.',
            'isPartOf'    => ['@id' => 'https://amatchless.com/#website'],
            'about'       => ['@id' => 'https://amatchless.com/#organization'],
            'inLanguage'  => 'en-IN',
            'speakable'   => ['@type' => 'SpeakableSpecification', 'cssSelector' => ['.hero h1', '.hero .lede']],
        ],
        [
            '@type'       => 'OfferCatalog',
            '@id'         => 'https://amatchless.com/#offers',
            'name'        => 'Digital Marketing Services by Amatchless',
            'itemListElement' => [
                ['@type' => 'Offer', 'itemOffered' => ['@id' => 'https://amatchless.com/#service-seo']],
                ['@type' => 'Offer', 'itemOffered' => ['@id' => 'https://amatchless.com/#service-ads']],
                ['@type' => 'Offer', 'itemOffered' => ['@id' => 'https://amatchless.com/#service-social']],
                ['@type' => 'Offer', 'itemOffered' => ['@id' => 'https://amatchless.com/#service-content']],
                ['@type' => 'Offer', 'itemOffered' => ['@id' => 'https://amatchless.com/#service-automation']],
                ['@type' => 'Offer', 'itemOffered' => ['@id' => 'https://amatchless.com/#service-cro']],
            ],
        ],
        [
            '@type'       => 'Service',
            '@id'         => 'https://amatchless.com/#service-seo',
            'name'        => 'SEO, AEO & GEO Services',
            'description' => 'Comprehensive SEO, Answer Engine Optimisation (AEO), and Generative Engine Optimisation (GEO) services. We help brands rank on Google and get cited by AI platforms like ChatGPT, Perplexity, and Google AI Overviews.',
            'serviceType' => 'Search Engine Optimisation',
            'provider'    => ['@id' => 'https://amatchless.com/#organization'],
            'areaServed'  => 'Worldwide',
            'url'         => 'https://amatchless.com/#services',
            'offers'      => ['@type' => 'Offer', 'priceSpecification' => ['@type' => 'PriceSpecification', 'priceCurrency' => 'INR', 'minPrice' => 40000]],
        ],
        [
            '@type'       => 'Service',
            '@id'         => 'https://amatchless.com/#service-ads',
            'name'        => 'Performance Advertising',
            'description' => 'Data-driven performance advertising on Google Ads, Meta Ads, and YouTube. We design precision-targeted funnels that convert clicks into revenue.',
            'serviceType' => 'Digital Advertising',
            'provider'    => ['@id' => 'https://amatchless.com/#organization'],
            'areaServed'  => 'Worldwide',
            'url'         => 'https://amatchless.com/#services',
        ],
        [
            '@type'       => 'Service',
            '@id'         => 'https://amatchless.com/#service-social',
            'name'        => 'Social Media Marketing',
            'description' => 'Strategic social media marketing including content creation, Reels, Shorts, and community management across Instagram, LinkedIn, YouTube, and Facebook.',
            'serviceType' => 'Social Media Marketing',
            'provider'    => ['@id' => 'https://amatchless.com/#organization'],
            'areaServed'  => 'Worldwide',
        ],
        [
            '@type'       => 'Service',
            '@id'         => 'https://amatchless.com/#service-content',
            'name'        => 'Content Marketing',
            'description' => 'Authority content marketing including long-form SEO articles, thought leadership, copywriting, and AI-ready content that ranks on Google and gets cited by AI assistants.',
            'serviceType' => 'Content Marketing',
            'provider'    => ['@id' => 'https://amatchless.com/#organization'],
            'areaServed'  => 'Worldwide',
        ],
        [
            '@type'       => 'Service',
            '@id'         => 'https://amatchless.com/#service-automation',
            'name'        => 'Marketing Automation',
            'description' => 'AI-powered marketing automation including CRM integrations, lead nurturing workflows, email sequences, and intelligent sales automation.',
            'serviceType' => 'Marketing Automation',
            'provider'    => ['@id' => 'https://amatchless.com/#organization'],
            'areaServed'  => 'Worldwide',
        ],
        [
            '@type'       => 'Service',
            '@id'         => 'https://amatchless.com/#service-cro',
            'name'        => 'Analytics & Conversion Rate Optimisation (CRO)',
            'description' => 'Data-led conversion rate optimisation using GA4, GTM, A/B testing, and funnel analysis. We find hidden leaks in your funnel and systematically seal them for compounding revenue gains.',
            'serviceType' => 'Conversion Rate Optimisation',
            'provider'    => ['@id' => 'https://amatchless.com/#organization'],
            'areaServed'  => 'Worldwide',
        ],
        [
            '@type'       => 'HowTo',
            '@id'         => 'https://amatchless.com/#howto',
            'name'        => 'How Amatchless works — from idea to compounding growth',
            'description' => 'Our four-stage process: Discover, Strategy, Build, Scale — a clear path from idea to compounding growth.',
            'step'        => [
                ['@type' => 'HowToStep', 'position' => 1, 'name' => 'Understand', 'text' => 'We learn your market, your goals and your real numbers before touching a single design.'],
                ['@type' => 'HowToStep', 'position' => 2, 'name' => 'Plan',       'text' => 'A focused plan tied to revenue and outcomes — not vanity metrics or busywork.'],
                ['@type' => 'HowToStep', 'position' => 3, 'name' => 'Launch',     'text' => 'Creative, campaigns and systems go live, built to the standard your brand deserves.'],
                ['@type' => 'HowToStep', 'position' => 4, 'name' => 'Compound',   'text' => 'We measure, optimise and automate what works, so results build on themselves.'],
            ],
        ],
    ];

    echo '<script type="application/ld+json">' . wp_json_encode(
        ['@context' => 'https://schema.org', '@graph' => $graph],
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
    ) . '</script>' . "\n";
}
add_action('wp_head', 'amatchless_schema');

/* ── Contact Form AJAX ───────────────────────────────────────── */
require_once get_template_directory() . '/inc/leads.php';

function amatchless_contact_submit() {
    check_ajax_referer('amatchless_contact_nonce', 'nonce');

    $name    = sanitize_text_field(wp_unslash($_POST['name']    ?? ''));
    $email   = sanitize_email(wp_unslash($_POST['email']        ?? ''));
    $company = sanitize_text_field(wp_unslash($_POST['company'] ?? ''));
    $phone   = sanitize_text_field(wp_unslash($_POST['phone']   ?? ''));
    $service = sanitize_text_field(wp_unslash($_POST['service'] ?? ''));
    $budget  = sanitize_text_field(wp_unslash($_POST['budget']  ?? ''));
    $message = sanitize_textarea_field(wp_unslash($_POST['message'] ?? ''));
    $ip      = sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? '');

    if (empty($name) || !is_email($email) || empty($company)) {
        wp_send_json_error(['message' => 'Please fill in all required fields correctly.']);
    }

    // Save first, so the lead is in wp-admin → Leads even if the email fails.
    $lead_id = amatchless_save_lead(compact('name', 'email', 'company', 'phone', 'service', 'budget', 'message', 'ip'));

    $subject = "New Lead: {$name} from {$company}";
    $body    = "New strategy call enquiry from amatchless.com\n\n"
             . "Name:    {$name}\n"
             . "Company: {$company}\n"
             . "Email:   {$email}\n"
             . "Phone:   {$phone}\n"
             . "Service: {$service}\n"
             . "Budget:  {$budget}\n\n"
             . "Message:\n{$message}\n\n"
             . "IP: {$ip}\n"
             . "Submitted: " . current_time('mysql')
             . ($lead_id ? "\n\nView in admin: " . admin_url('post.php?post=' . $lead_id . '&action=edit') : '');

    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'From: Amatchless Website <noreply@amatchless.com>',
        'Reply-To: ' . $email,
    ];

    $sent = wp_mail(AMATCHLESS_EMAIL, $subject, $body, $headers);
    if ($lead_id) {
        update_post_meta($lead_id, '_lead_emailed', $sent ? 'Yes' : 'No — sending failed');
    }

    if (!$lead_id && !$sent) {
        wp_send_json_error(['message' => 'Sorry, something went wrong. Please email us at ' . AMATCHLESS_EMAIL . '.']);
    }
    wp_send_json_success(['message' => 'Success']);
}
add_action('wp_ajax_nopriv_amatchless_contact', 'amatchless_contact_submit');
add_action('wp_ajax_amatchless_contact', 'amatchless_contact_submit');

// Send site mail with an amatchless.com return path, so SPF checks the domain the email claims to be from.
function amatchless_mail_sender($phpmailer) {
    if (!$phpmailer->Sender && str_ends_with(strtolower($phpmailer->From), '@amatchless.com')) {
        $phpmailer->Sender = $phpmailer->From;
    }
}
add_action('phpmailer_init', 'amatchless_mail_sender');

/* ── Excerpt ──────────────────────────────────────────────────── */
function amatchless_excerpt_length() { return 22; }
add_filter('excerpt_length', 'amatchless_excerpt_length');
function amatchless_excerpt_more() { return '&hellip;'; }
add_filter('excerpt_more', 'amatchless_excerpt_more');

/* ── Performance ──────────────────────────────────────────────── */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');

/* ── Security: Disable XML-RPC ───────────────────────────────── */
add_filter('xmlrpc_enabled', '__return_false');
add_filter('wp_xmlrpc_server_class', '__return_false');
remove_action('wp_head', 'wp_generator');

/* ── Security: Hide WP version from scripts/styles ──────────── */
// Strip only the WordPress core version; theme assets keep their own ?ver= so caches refresh on update.
function amatchless_remove_version($src) {
    if (strpos($src, 'ver=' . get_bloginfo('version')) !== false) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src',  'amatchless_remove_version', 9999);
add_filter('script_loader_src', 'amatchless_remove_version', 9999);

/* ── Security: Obfuscate login error messages ───────────────── */
function amatchless_login_error() {
    return 'Invalid credentials. Please try again.';
}
add_filter('login_errors', 'amatchless_login_error');

/* ── Security: Disable user enumeration via REST API ────────── */
function amatchless_disable_rest_user_enum($endpoints) {
    // Staff who can list users (admins) keep the endpoints: the block editor's author picker needs them.
    if (current_user_can('list_users')) {
        return $endpoints;
    }
    if (isset($endpoints['/wp/v2/users'])) {
        unset($endpoints['/wp/v2/users']);
    }
    if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
        unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
    }
    return $endpoints;
}
add_filter('rest_endpoints', 'amatchless_disable_rest_user_enum');

/* ── Security: Restrict REST API to authenticated users ─────── */
function amatchless_rest_auth($result) {
    if (!empty($result)) return $result;
    // Allow public access to specific namespaces only
    $allowed = ['contact-form-7', 'yoast', 'wp/v2/posts', 'wp/v2/pages', 'wp/v2/categories'];
    $route = $GLOBALS['wp']->query_vars['rest_route'] ?? '';
    foreach ($allowed as $ns) {
        if (strpos($route, $ns) !== false) return $result;
    }
    // For everything else, require authentication
    if (!is_user_logged_in() && strpos($route, 'users') !== false) {
        return new WP_Error('rest_not_logged_in', 'You must be logged in to access this resource.', ['status' => 401]);
    }
    return $result;
}
add_filter('rest_authentication_errors', 'amatchless_rest_auth');

/* ── Security: HTTP Security Headers via PHP (backup) ───────── */
function amatchless_security_headers() {
    if (!is_admin() && !headers_sent()) {
        header('X-Frame-Options: SAMEORIGIN');
        header('X-Content-Type-Options: nosniff');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
        header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.googletagmanager.com https://www.google-analytics.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com data:; img-src 'self' data: https: https://www.googletagmanager.com https://www.google-analytics.com; connect-src 'self' https://www.googletagmanager.com https://www.google-analytics.com https://analytics.google.com https://region1.googleanalytics.com https://stats.g.doubleclick.net; frame-src 'self' https://www.googletagmanager.com; frame-ancestors 'self'; base-uri 'self'; form-action 'self' https://amatchless.com");
    }
}
add_action('send_headers', 'amatchless_security_headers');

/* ── Security: Disable author archive URL redirect ──────────── */
function amatchless_block_author_enum() {
    if (!is_admin() && isset($_GET['author'])) {
        wp_redirect(home_url('/'), 301);
        exit;
    }
}
add_action('init', 'amatchless_block_author_enum');

/* ── Security: Add nonce to admin AJAX URL ───────────────────── */
function amatchless_heartbeat_settings($settings) {
    $settings['interval'] = 60; // reduce heartbeat from 15s to 60s
    return $settings;
}
add_filter('heartbeat_settings', 'amatchless_heartbeat_settings');
