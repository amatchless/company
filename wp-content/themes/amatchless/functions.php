<?php
defined('ABSPATH') || exit;

define('AMATCHLESS_VERSION', '3.10.0');
define('AMATCHLESS_EMAIL', 'info@amatchless.com');
define('AMATCHLESS_WHATSAPP', 'https://wa.me/919050820042?text=' . rawurlencode("Hi Amatchless, I'd like to discuss a project with you."));

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
        'contact'       => ['Contact',       'contact'],
    ];
}

// True on the individual section pages and the blog (they all end with the contact form).
function amatchless_is_section_page() {
    return is_page(array_keys(amatchless_section_pages())) || is_home() || is_archive() || is_search() || is_singular('post') || amatchless_current_case();
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

// Create the section pages once per set (only the ones that don't exist yet). Bump the number when a page is added.
function amatchless_create_section_pages() {
    if (get_option('amatchless_pages_created') === '2') return;
    $excerpts = [
        'services'      => 'Business discovery, custom software, AI, automation and marketing — SEO, digital, influencer and content — from one accountable team.',
        'work'          => 'Selected projects and case studies for Isola, AleuCo, Bailey\'s Blossoms, Moment, and Haliburton Forest.',
        'about'         => 'Amatchless is one partner for the whole business: we understand it first, then build what makes it efficient and market it to grow.',
        'ai-automation' => 'Custom software, AI and automation built around your business so processes run on their own.',
        'contact'       => 'Book a discovery call, email or WhatsApp the Amatchless team. We reply within 24 hours.',
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
    update_option('amatchless_pages_created', '2');
}
add_action('init', 'amatchless_create_section_pages', 20);

// The blog index URL, or '' when no "Posts page" is set in Settings → Reading.
function amatchless_blog_url() {
    $id = (int) get_option('page_for_posts');
    return $id ? get_permalink($id) : '';
}

// The FAQ questions and answers: shown by template-parts/section-faq.php and marked up as FAQPage schema in inc/seo.php.
function amatchless_faqs() {
    return [
        ['What does it cost?', 'We scope every engagement after the discovery call, so you see the plan and the price before you commit to anything.'],
        ['Do you build software, or only do marketing?', 'Both. We build custom software, AI tools and automations around how your business works, and we run SEO, digital, influencer and content marketing to bring in customers. One team plans and delivers all of it.'],
        ['Can you work with the tools we already use?', 'Where it makes sense, yes. We start from how you work today and connect, replace or build only what will save time or win business.'],
        ['How soon will we see results?', "It depends on the work. On the discovery call we'll tell you what to expect for your plan and how we'll measure it."],
        ['Who owns the software and the data?', 'We agree ownership, access and data handling in writing before any work starts.'],
        ['What happens after I send the form?', 'We reply within 24 hours, set up a 30-minute discovery call, and then send you a clear plan: what to build, automate and market, in order of impact.'],
    ];
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
    wp_enqueue_style('amatchless-site', get_template_directory_uri() . '/assets/css/site.css', [], AMATCHLESS_VERSION);
    wp_enqueue_script('amatchless-site', get_template_directory_uri() . '/assets/js/site.js', [], AMATCHLESS_VERSION, true);
    wp_localize_script('amatchless-site', 'amatchlessAjax', [
        'url'   => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('amatchless_contact_nonce'),
        'email' => AMATCHLESS_EMAIL,
    ]);
}
add_action('wp_enqueue_scripts', 'amatchless_assets');

/* ── Fonts: self-hosted and inlined (no Google Fonts request chain) ── */
function amatchless_fonts() {
    $dir = get_template_directory();
    $uri = get_template_directory_uri();
    foreach (['BricolageGrotesque-latin', 'DMSans-latin'] as $f) {
        echo '<link rel="preload" href="' . esc_url($uri . '/assets/fonts/' . $f . '.woff2') . '" as="font" type="font/woff2" crossorigin>' . "\n";
    }
    $css = @file_get_contents($dir . '/assets/css/fonts.css');
    if ($css) {
        echo '<style id="amatchless-fonts">' . str_replace('../fonts/', $uri . '/assets/fonts/', $css) . '</style>' . "\n";
    }
}
add_action('wp_head', 'amatchless_fonts', 2);

/* ── Preconnect Hints ────────────────────────────────────────── */
function amatchless_preconnect() {
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
        $title       = 'Software, AI & Digital Marketing Partner in New Delhi | Amatchless';
        $description = 'Amatchless is a one-stop partner for business growth. We understand your business and its pain points, then build custom software, AI and automation to make it more efficient, and grow it with SEO, digital, influencer and content marketing.';
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

/* ── Blog page, categories and the post editor live in inc/blog.php ── */
require_once get_template_directory() . '/inc/blog.php';

/* ── Case study story pages (/work/{project}/) live in inc/cases.php ── */
require_once get_template_directory() . '/inc/cases.php';

/* ── Client testimonials (drafts until each client signs off) live in inc/testimonials.php ── */
require_once get_template_directory() . '/inc/testimonials.php';

/* ── SEO titles, descriptions, share image and schema live in inc/seo.php ── */
require_once get_template_directory() . '/inc/seo.php';

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

    if (empty($name) || !is_email($email) || empty($message)) {
        wp_send_json_error(['message' => 'Please fill in all required fields correctly.']);
    }

    // Save first, so the lead is in wp-admin → Leads even if the email fails.
    $lead_id = amatchless_save_lead(compact('name', 'email', 'company', 'phone', 'service', 'budget', 'message', 'ip'));

    $subject = $company !== '' ? "New Lead: {$name} from {$company}" : "New Lead: {$name}";
    $body    = "New discovery call enquiry from amatchless.com\n\n"
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
    // Signed-in writers keep the endpoints: the block editor loads the current user and the author picker from them.
    if (current_user_can('edit_posts')) {
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
        header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.googletagmanager.com https://www.google-analytics.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com data:; img-src 'self' data: https: https://www.googletagmanager.com https://www.google-analytics.com; connect-src 'self' https://www.googletagmanager.com https://www.google-analytics.com https://analytics.google.com https://region1.google-analytics.com https://*.google-analytics.com https://*.analytics.google.com https://stats.g.doubleclick.net; frame-src 'self' https://www.googletagmanager.com https://www.youtube.com https://www.youtube-nocookie.com https://player.vimeo.com; frame-ancestors 'self'; base-uri 'self'; form-action 'self' https://amatchless.com");
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

/* ── Favicon (the Amatchless logo) ───────────────────────────── */
// Replaces any Site Icon set under Appearance → Customize, so the logo is always used.
remove_action('wp_head', 'wp_site_icon', 99);
function amatchless_favicon_tags() {
    $dir = get_template_directory_uri() . '/assets/icons/';
    echo '<link rel="icon" href="' . esc_url($dir . 'favicon.ico') . '" sizes="48x48">' . "\n";
    echo '<link rel="icon" type="image/png" href="' . esc_url($dir . 'favicon-32.png') . '" sizes="32x32">' . "\n";
    echo '<link rel="icon" type="image/png" href="' . esc_url($dir . 'icon-192.png') . '" sizes="192x192">' . "\n";
    echo '<link rel="apple-touch-icon" href="' . esc_url($dir . 'apple-touch-icon.png') . '">' . "\n";
}
add_action('wp_head', 'amatchless_favicon_tags', 99);
add_action('login_head', 'amatchless_favicon_tags');
add_action('admin_head', 'amatchless_favicon_tags');

// Browsers still ask for /favicon.ico directly; answer with the logo icon.
add_action('do_faviconico', function () {
    $file = get_template_directory() . '/assets/icons/favicon.ico';
    if (!is_readable($file)) return;
    header('Content-Type: image/x-icon');
    header('Cache-Control: public, max-age=604800');
    readfile($file);
    exit;
});

// Author name for article pages: a login-style display name (such as the default admin account) reads as "Amatchless".
function amatchless_author_name() {
    $name  = get_the_author();
    $login = get_the_author_meta('user_login');
    return (!$name || $name === $login) ? 'Amatchless' : $name;
}
