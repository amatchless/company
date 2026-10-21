<?php
/**
 * Blog: the /blog/ page, categories, and a tidy admin for the team's weekly posts.
 */
defined('ABSPATH') || exit;

// Starter categories for the team (created once; editable under Posts → Categories).
function amatchless_blog_categories() {
    return [
        'Automation'        => 'Workflows, tools and time-savers that run on their own.',
        'AI'                => 'Practical AI for small teams and growing businesses.',
        'Branding'          => 'Making a business recognisable and memorable.',
        'Paid Ads'          => 'Meta, Google and creator ads that pay for themselves.',
        'SEO'               => 'Getting found on Google and in AI answers.',
        'Content Marketing' => 'Content, social and influencer marketing that builds demand.',
        'Company News'      => 'What we are building and who we are working with.',
    ];
}

// One-time setup: a published "Blog" page set as the Posts page, the homepage as a static front page,
// starter categories, and comments off for new posts (articles have no comment section).
function amatchless_blog_setup() {
    if (get_option('amatchless_blog_setup') === '1') return;

    if (!get_option('page_for_posts')) {
        $blog = get_page_by_path('blog');
        if ($blog) {
            if ($blog->post_status !== 'publish') wp_update_post(['ID' => $blog->ID, 'post_status' => 'publish']);
            $blog_id = $blog->ID;
        } else {
            $blog_id = wp_insert_post(['post_type' => 'page', 'post_status' => 'publish', 'post_name' => 'blog', 'post_title' => 'Blog']);
        }
        if ($blog_id && !is_wp_error($blog_id)) update_option('page_for_posts', (int) $blog_id);
    }

    // A Posts page only works when the homepage is a static page.
    if (get_option('show_on_front') !== 'page' || !get_option('page_on_front')) {
        $home = get_page_by_path('home');
        if (!$home) {
            $found = get_posts(['post_type' => 'page', 'title' => 'Home', 'post_status' => 'publish', 'numberposts' => 1]);
            $home  = $found ? $found[0] : null;
        }
        $home_id = $home ? $home->ID : wp_insert_post(['post_type' => 'page', 'post_status' => 'publish', 'post_name' => 'home', 'post_title' => 'Home']);
        if ($home_id && !is_wp_error($home_id)) {
            update_option('page_on_front', (int) $home_id);
            update_option('show_on_front', 'page');
        }
    }

    foreach (amatchless_blog_categories() as $name => $desc) {
        if (!term_exists($name, 'category')) wp_insert_term($name, 'category', ['description' => $desc]);
    }
    // "Uncategorized" reads badly on a card: rename the default category.
    $default = get_term((int) get_option('default_category'), 'category');
    if ($default && !is_wp_error($default) && $default->slug === 'uncategorized') {
        wp_update_term($default->term_id, 'category', ['name' => 'Insights', 'slug' => 'insights']);
    }

    // The default "Hello world!" post goes back to draft (still in Posts → Drafts if anyone wants it).
    $hello = get_page_by_path('hello-world', OBJECT, 'post');
    if ($hello && $hello->post_status === 'publish') wp_update_post(['ID' => $hello->ID, 'post_status' => 'draft']);

    update_option('default_comment_status', 'closed');
    update_option('default_ping_status', 'closed');
    update_option('amatchless_blog_setup', '1');
}
add_action('init', 'amatchless_blog_setup', 21);

// Posts kept off the site's lists: the default "Hello world!" post.
function amatchless_hidden_post_ids() {
    $hello = get_page_by_path('hello-world', OBJECT, 'post');
    return $hello ? [$hello->ID] : [];
}

// Blog and archive lists: 10 per page (a wide lead card plus a 3 × 3 grid).
function amatchless_blog_query($q) {
    if (is_admin() || !$q->is_main_query()) return;
    if ($q->is_home() || $q->is_category() || $q->is_tag() || $q->is_author() || $q->is_date()) {
        $q->set('posts_per_page', 10);
        $q->set('post__not_in', amatchless_hidden_post_ids());
    }
}
add_action('pre_get_posts', 'amatchless_blog_query');

// Reading time for the current post.
function amatchless_read_time() {
    $words = str_word_count(wp_strip_all_tags(get_the_content()));
    return max(1, (int) ceil($words / 220)) . ' min read';
}

// Category chips for the blog list: All plus every category with posts.
function amatchless_category_chips() {
    $cats = get_categories(['hide_empty' => true]);
    if (count($cats) < 2) return;
    $current = is_category() ? get_queried_object_id() : 0;
    $all     = amatchless_blog_url() ?: home_url('/');
    echo '<nav class="chips" aria-label="Categories">';
    echo '<a class="chip' . ($current ? '' : ' is-on') . '" href="' . esc_url($all) . '"' . ($current ? '' : ' aria-current="page"') . '>All</a>';
    foreach ($cats as $c) {
        $on = $c->term_id === $current;
        echo '<a class="chip' . ($on ? ' is-on' : '') . '" href="' . esc_url(get_category_link($c)) . '"' . ($on ? ' aria-current="page"' : '') . '>' . esc_html($c->name) . '</a>';
    }
    echo '</nav>';
}

/* ── Editor: brand fonts and colours inside the post editor ─── */
function amatchless_editor_setup() {
    add_theme_support('editor-styles');
    add_editor_style(['assets/css/fonts.css', 'assets/css/editor.css']);
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('disable-custom-colors');
    add_theme_support('editor-color-palette', [
        ['name' => 'Ink',    'slug' => 'ink',    'color' => '#0E0B1F'],
        ['name' => 'Purple', 'slug' => 'purple', 'color' => '#5B2EFF'],
        ['name' => 'Pink',   'slug' => 'pink',   'color' => '#FF4F9A'],
        ['name' => 'Yellow', 'slug' => 'yellow', 'color' => '#FFE14D'],
        ['name' => 'Mint',   'slug' => 'mint',   'color' => '#3DEBB0'],
        ['name' => 'White',  'slug' => 'white',  'color' => '#FFFFFF'],
    ]);
}
add_action('after_setup_theme', 'amatchless_editor_setup');

/* ── Admin: featured image column on Posts ───────────────────── */
add_filter('manage_post_posts_columns', function ($cols) {
    return array_slice($cols, 0, 1, true) + ['amx_thumb' => 'Image'] + array_slice($cols, 1, null, true);
});
add_action('manage_post_posts_custom_column', function ($col, $id) {
    if ($col !== 'amx_thumb') return;
    echo has_post_thumbnail($id)
        ? get_the_post_thumbnail($id, [64, 40], ['style' => 'width:64px;height:40px;object-fit:cover;border-radius:6px'])
        : '<span style="color:#b32d2e" title="No featured image">None</span>';
}, 10, 2);
add_action('admin_head-edit.php', function () {
    echo '<style>.column-amx_thumb{width:76px}</style>';
});

// Point writers to the featured image box.
add_filter('admin_post_thumbnail_html', function ($html, $post_id) {
    if (get_post_type($post_id) !== 'post') return $html;
    return '<p class="description">Shown on the blog card and at the top of the article. Best size: 1600 × 1000 px, JPG or WebP, under 500 KB.</p>' . $html;
}, 10, 2);

/* ── Admin: a "Blog" dashboard panel for the weekly rhythm ─── */
function amatchless_blog_dashboard() {
    $last = get_posts(['numberposts' => 1, 'post_status' => 'publish', 'exclude' => amatchless_hidden_post_ids()]);
    $next = get_posts(['numberposts' => 3, 'post_status' => 'future', 'order' => 'ASC']);
    $drafts = wp_count_posts('post');
    $blog = amatchless_blog_url();

    if ($last) {
        $days = (int) floor((time() - get_post_time('U', true, $last[0])) / DAY_IN_SECONDS);
        $tone = $days >= 7 ? '#b32d2e' : '#007017';
        echo '<p style="font-size:14px">Last post: <a href="' . esc_url(get_edit_post_link($last[0])) . '"><strong>' . esc_html(get_the_title($last[0])) . '</strong></a>, <span style="color:' . $tone . '">' . esc_html($days === 0 ? 'today' : sprintf(_n('%d day ago', '%d days ago', $days), $days)) . '</span>.' . ($days >= 7 ? ' This week’s post is due.' : '') . '</p>';
    } else {
        echo '<p style="font-size:14px">No posts published yet. The first one goes here.</p>';
    }
    if ($next) {
        echo '<p><strong>Scheduled:</strong></p><ul style="margin-top:0">';
        foreach ($next as $p) echo '<li>' . esc_html(get_the_title($p)) . ' — ' . esc_html(get_the_date('', $p)) . '</li>';
        echo '</ul>';
    }
    echo '<p>Drafts waiting: <strong>' . (int) $drafts->draft . '</strong>' . ((int) $drafts->pending ? ' · In review: <strong>' . (int) $drafts->pending . '</strong>' : '') . '</p>';
    echo '<p><a class="button button-primary" href="' . esc_url(admin_url('post-new.php')) . '">Write a new post</a> ';
    if ($blog) echo '<a class="button" href="' . esc_url($blog) . '" target="_blank" rel="noopener">View the blog</a>';
    echo '</p>';
    echo '<details><summary style="cursor:pointer;font-weight:600">Before you press Publish</summary><ol style="margin-top:8px">'
       . '<li>Title under 65 characters, written the way a customer would search for it.</li>'
       . '<li>One category (Posts → Categories), plus 2 to 4 tags.</li>'
       . '<li>A featured image, 1600 × 1000 px, with alt text.</li>'
       . '<li>An excerpt of one or two sentences: it appears on the blog card.</li>'
       . '<li>Use Heading 2 for sections and Heading 3 inside them. Keep paragraphs short.</li>'
       . '<li>To post on a set day, use Publish → Schedule instead of publishing now.</li>'
       . '</ol></details>';
}
add_action('wp_dashboard_setup', function () {
    if (current_user_can('edit_posts')) {
        wp_add_dashboard_widget('amatchless_blog', 'Amatchless blog', 'amatchless_blog_dashboard', null, null, 'normal', 'high');
    }
});
