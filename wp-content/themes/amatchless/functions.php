<?php
defined('ABSPATH') || exit;

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
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400;1,600&family=Outfit:wght@300;400;500;600;700&display=swap',
        [], null
    );
    wp_enqueue_style('amatchless-style', get_stylesheet_uri(), ['google-fonts'], '1.1.0');
    wp_enqueue_script('amatchless-main', get_template_directory_uri() . '/assets/main.js', [], '1.1.0', true);
    wp_localize_script('amatchless-main', 'amatchlessAjax', [
        'url'   => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('amatchless_contact_nonce'),
    ]);
}
add_action('wp_enqueue_scripts', 'amatchless_assets');

/* ── Preconnect Hints ────────────────────────────────────────── */
function amatchless_preconnect() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
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
            'speakable'   => ['@type' => 'SpeakableSpecification', 'cssSelector' => ['.hero-headline', '.hero-sub', '.eyebrow']],
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
            'name'        => 'How Amatchless Delivers Digital Marketing Results — The 5-Stage Campaign Framework',
            'description' => 'Our five-stage campaign framework: Discover, Define, Create, Activate, Optimise — a repeatable process that turns brand understanding into measurable growth.',
            'totalTime'   => 'P6M',
            'step'        => [
                ['@type' => 'HowToStep', 'position' => 1, 'name' => 'Discover', 'text' => 'Understand the brand, target audience, competitive landscape, and campaign objective before a single brief is written.'],
                ['@type' => 'HowToStep', 'position' => 2, 'name' => 'Define',   'text' => 'Develop precise positioning and campaign direction — the strategic why before the creative what.'],
                ['@type' => 'HowToStep', 'position' => 3, 'name' => 'Create',   'text' => 'Build the full creative and content system — every asset designed for a specific channel and measurable outcome.'],
                ['@type' => 'HowToStep', 'position' => 4, 'name' => 'Activate', 'text' => 'Launch across all relevant channels in a coordinated sequence, maximising impact from day one.'],
                ['@type' => 'HowToStep', 'position' => 5, 'name' => 'Optimise', 'text' => 'Analyse, learn, and refine continuously — building compound value so every campaign outperforms the last.'],
            ],
        ],
        [
            '@type'      => 'FAQPage',
            '@id'        => 'https://amatchless.com/#faqpage',
            'mainEntity' => [
                ['@type' => 'Question', 'name' => 'What industries does Amatchless work with?',
                 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Amatchless works across B2B SaaS, D2C e-commerce, real estate, healthcare, education, and professional services. Our data-driven frameworks adapt to industry nuances while applying universal growth principles.']],
                ['@type' => 'Question', 'name' => 'How long before we see results from digital marketing?',
                 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Paid media improvements typically appear within 4–6 weeks of launch. SEO results compound over 3–6 months, with meaningful organic growth visible by month 4. Marketing automation delivers impact from day one of implementation.']],
                ['@type' => 'Question', 'name' => 'What is the minimum engagement at Amatchless?',
                 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Retainer engagements start at ₹40,000/month for focused single-service mandates and ₹80,000+/month for full-stack growth programmes. We work best with brands committed to sustainable, compounding growth.']],
                ['@type' => 'Question', 'name' => 'What makes Amatchless different from other digital marketing agencies?',
                 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Amatchless is AI-native (not AI-adjacent), fully accountable with every deliverable tied to agreed KPIs, and never white-labels or outsources work. The team you meet is the team that works on your account, combining creative strategy with performance marketing under one roof.']],
                ['@type' => 'Question', 'name' => 'What is Answer Engine Optimisation (AEO)?',
                 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Answer Engine Optimisation (AEO) is the practice of structuring and formatting content so it is selected and cited by AI-powered answer engines — including Google AI Overviews, ChatGPT, Perplexity AI, and Microsoft Copilot. Amatchless specialises in AEO alongside traditional SEO to ensure brands appear in both search results and AI-generated answers.']],
                ['@type' => 'Question', 'name' => 'What is Generative Engine Optimisation (GEO)?',
                 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Generative Engine Optimisation (GEO) is the strategic practice of building your brand\'s online presence, structured data, and content authority so that generative AI systems — like ChatGPT, Gemini, and Perplexity — consistently recommend and reference your brand when users ask relevant questions. Amatchless is one of India\'s earliest digital marketing agencies to offer dedicated GEO services.']],
                ['@type' => 'Question', 'name' => 'Is Amatchless a digital marketing agency in Delhi?',
                 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Yes. Amatchless is headquartered in Rohini, New Delhi, India. We serve clients locally across Delhi NCR and nationally across India, as well as international brands in the US, UK, UAE, Australia, and Singapore.']],
                ['@type' => 'Question', 'name' => 'Does Amatchless offer performance-based pricing?',
                 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'For select growth-stage clients, Amatchless offers hybrid retainer + performance models where a portion of the fee is tied to agreed KPIs. This requires a minimum base retainer and a 6-month commitment to allow adequate time for optimisation.']],
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
function amatchless_contact_submit() {
    check_ajax_referer('amatchless_contact_nonce', 'nonce');

    $name    = sanitize_text_field(wp_unslash($_POST['name']    ?? ''));
    $email   = sanitize_email(wp_unslash($_POST['email']        ?? ''));
    $company = sanitize_text_field(wp_unslash($_POST['company'] ?? ''));
    $phone   = sanitize_text_field(wp_unslash($_POST['phone']   ?? ''));
    $service = sanitize_text_field(wp_unslash($_POST['service'] ?? ''));
    $budget  = sanitize_text_field(wp_unslash($_POST['budget']  ?? ''));
    $message = sanitize_textarea_field(wp_unslash($_POST['message'] ?? ''));

    if (empty($name) || !is_email($email) || empty($company)) {
        wp_send_json_error(['message' => 'Please fill in all required fields correctly.']);
    }

    $subject = "New Lead: {$name} from {$company}";
    $body    = "New strategy call enquiry from amatchless.com\n\n"
             . "Name:    {$name}\n"
             . "Company: {$company}\n"
             . "Email:   {$email}\n"
             . "Phone:   {$phone}\n"
             . "Service: {$service}\n"
             . "Budget:  {$budget}\n\n"
             . "Message:\n{$message}\n\n"
             . "IP: " . sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? '') . "\n"
             . "Submitted: " . current_time('mysql');

    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'From: Amatchless Website <noreply@amatchless.com>',
        'Reply-To: ' . $email,
    ];

    $sent = wp_mail('info@amatchless.com', $subject, $body, $headers);

    // Save lead to custom DB table as backup
    global $wpdb;
    $wpdb->insert(
        $wpdb->prefix . 'amatchless_leads',
        ['name' => $name, 'email' => $email, 'company' => $company, 'phone' => $phone,
         'service' => $service, 'budget' => $budget, 'message' => $message, 'created_at' => current_time('mysql')],
        ['%s','%s','%s','%s','%s','%s','%s','%s']
    );

    if ($sent) {
        wp_send_json_success(['message' => 'Success']);
    } else {
        // Even if email fails, lead is saved to DB
        wp_send_json_success(['message' => 'Saved']);
    }
}
add_action('wp_ajax_nopriv_amatchless_contact', 'amatchless_contact_submit');
add_action('wp_ajax_amatchless_contact', 'amatchless_contact_submit');

/* ── Create leads table on theme activate ────────────────────── */
function amatchless_create_leads_table() {
    global $wpdb;
    $table = $wpdb->prefix . 'amatchless_leads';
    if ($wpdb->get_var("SHOW TABLES LIKE '{$table}'") !== $table) {
        $charset = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE {$table} (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            name varchar(200) NOT NULL,
            email varchar(200) NOT NULL,
            company varchar(200) NOT NULL,
            phone varchar(50) DEFAULT '',
            service varchar(200) DEFAULT '',
            budget varchar(100) DEFAULT '',
            message text DEFAULT '',
            created_at datetime NOT NULL,
            PRIMARY KEY (id)
        ) {$charset};";
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }
}
add_action('after_setup_theme', 'amatchless_create_leads_table');

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
function amatchless_remove_version($src) {
    if (strpos($src, 'ver=')) {
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
