<?php
/**
 * SEO: page titles and descriptions, share image, structured data.
 * Values here override Yoast's stored ones for the main pages so they live in git.
 */

function amatchless_seo_map() {
    return [
        'home' => [
            'title' => 'Custom Software, AI & Marketing Partner | Amatchless',
            'desc'  => 'We learn your business and its pain points, then build custom software, AI and automation, and grow it with SEO and marketing. Book a discovery call.',
        ],
        'services' => [
            'title' => 'Services: Software, AI, Automation & Marketing | Amatchless',
            'desc'  => 'From business discovery and custom software to AI, process automation, SEO, ads, influencer and content marketing. One team, one plan.',
        ],
        'work' => [
            'title' => 'Our Work: Brands, Creators & Businesses We Help | Amatchless',
            'desc'  => "Case studies from MD Biocoals, Isola, AleuCo, Bailey's Blossoms, Moment and Haliburton Forest: software, automation and marketing in practice.",
        ],
        'about' => [
            'title' => 'About Amatchless | One Partner for the Whole Business',
            'desc'  => 'Amatchless is one team for creative, media and code. We understand your business first, then build and market what helps it run leaner and grow faster.',
        ],
        'ai-automation' => [
            'title' => 'AI & Automation for Business | Amatchless',
            'desc'  => 'Practical AI and automation that cut manual work in sales, HR and onboarding, plus custom software built around how your business runs.',
        ],
        'blog' => [
            'title' => 'Blog: Ideas on Brand, Growth & Automation | Amatchless',
            'desc'  => 'Practical articles on branding, paid ads and marketing automation for businesses and creators.',
        ],
    ];
}

function amatchless_seo_key() {
    if (is_front_page()) return 'home';
    if (is_home()) return 'blog';
    if (is_page()) {
        $slug = get_post_field('post_name', get_queried_object_id());
        if (isset(amatchless_seo_map()[$slug])) return $slug;
    }
    return '';
}

function amatchless_seo_field($field, $fallback) {
    $key = amatchless_seo_key();
    $map = amatchless_seo_map();
    return ($key && isset($map[$key][$field])) ? $map[$key][$field] : $fallback;
}

function amatchless_seo_image() {
    return get_template_directory_uri() . '/assets/og-image.jpg';
}

// Yoast: override titles, descriptions and share image when Yoast is active.
add_filter('wpseo_title',               fn($v) => amatchless_seo_field('title', $v));
add_filter('wpseo_opengraph_title',     fn($v) => amatchless_seo_field('title', $v));
add_filter('wpseo_twitter_title',       fn($v) => amatchless_seo_field('title', $v));
add_filter('wpseo_metadesc',            fn($v) => amatchless_seo_field('desc', $v));
add_filter('wpseo_opengraph_desc',      fn($v) => amatchless_seo_field('desc', $v));
add_filter('wpseo_twitter_description', fn($v) => amatchless_seo_field('desc', $v));
add_filter('wpseo_opengraph_image',     function ($v) { return $v ?: amatchless_seo_image(); });
add_filter('wpseo_twitter_image',       function ($v) { return $v ?: amatchless_seo_image(); });
add_filter('wpseo_add_opengraph_images', function ($images) {
    if (is_front_page() || is_home() || is_page()) {
        $images->add_image(['url' => amatchless_seo_image(), 'width' => 1200, 'height' => 630, 'type' => 'image/jpeg']);
    }
    return $images;
});

// Without Yoast: plain title and description for the main pages.
add_filter('pre_get_document_title', function ($t) {
    if (function_exists('wpseo_init')) return $t;
    return amatchless_seo_key() ? amatchless_seo_field('title', $t) : $t;
});
add_action('wp_head', function () {
    if (function_exists('wpseo_init')) return;
    $d = amatchless_seo_key() ? amatchless_seo_field('desc', '') : '';
    if ($d) echo '<meta name="description" content="' . esc_attr($d) . '">' . "\n";
}, 4);

/* ── Structured data (home page): only facts the owner has confirmed ── */
function amatchless_schema() {
    if (!is_front_page()) return;

    $org = [
        '@type'       => 'Organization',
        '@id'         => 'https://amatchless.com/#organization',
        'name'        => 'Amatchless',
        'url'         => 'https://amatchless.com/',
        'logo'        => ['@type' => 'ImageObject', 'url' => get_template_directory_uri() . '/assets/icons/icon-512.png', 'width' => 512, 'height' => 512],
        'image'       => amatchless_seo_image(),
        'description' => 'Amatchless is a one-stop partner for custom software, AI and automation, and marketing. We learn your business and its pain points, then build what makes it efficient and market it to grow.',
        'email'       => AMATCHLESS_EMAIL,
        'telephone'   => '+91-90508-20042',
        'address'     => [
            '@type'           => 'PostalAddress',
            'addressLocality' => 'Rohini, New Delhi',
            'addressRegion'   => 'Delhi',
            'addressCountry'  => 'IN',
        ],
        'sameAs'      => ['https://www.instagram.com/amatchless_/'],
        'knowsAbout'  => ['Custom software', 'AI and automation', 'SEO', 'Digital marketing', 'Influencer marketing', 'Content marketing'],
    ];

    $services = ['Business discovery and strategy', 'Custom software and web', 'AI solutions', 'Process automation', 'SEO', 'Digital marketing and ads', 'Influencer marketing', 'Content, social and branding'];
    $graph = [$org, [
        '@type'      => 'WebSite',
        '@id'        => 'https://amatchless.com/#website',
        'name'       => 'Amatchless',
        'url'        => 'https://amatchless.com/',
        'inLanguage' => 'en-IN',
        'publisher'  => ['@id' => 'https://amatchless.com/#organization'],
    ], [
        '@type'       => 'WebPage',
        '@id'         => 'https://amatchless.com/#webpage',
        'url'         => 'https://amatchless.com/',
        'name'        => amatchless_seo_map()['home']['title'],
        'description' => amatchless_seo_map()['home']['desc'],
        'isPartOf'    => ['@id' => 'https://amatchless.com/#website'],
        'about'       => ['@id' => 'https://amatchless.com/#organization'],
        'inLanguage'  => 'en-IN',
    ], [
        '@type'       => 'ItemList',
        '@id'         => 'https://amatchless.com/#services',
        'name'        => 'Amatchless services',
        'itemListElement' => array_map(function ($n, $i) {
            return ['@type' => 'ListItem', 'position' => $i + 1, 'item' => ['@type' => 'Service', 'name' => $n, 'provider' => ['@id' => 'https://amatchless.com/#organization']]];
        }, $services, array_keys($services)),
    ]];

    echo '<script type="application/ld+json">' . wp_json_encode(['@context' => 'https://schema.org', '@graph' => $graph], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'amatchless_schema');
