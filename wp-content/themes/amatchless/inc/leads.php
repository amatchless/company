<?php
/* ── Leads: contact form enquiries, listed in wp-admin → Leads ──
   Stored as a private post type so they get WordPress's own list screen,
   search, sorting and trash. Only Editors and Administrators can see them. */
defined('ABSPATH') || exit;

const AMATCHLESS_LEAD_FIELDS = [
    'email'   => 'Email',
    'company' => 'Company',
    'phone'   => 'Phone',
    'service' => 'Service',
    'budget'  => 'Budget',
    'ip'      => 'IP address',
    'emailed' => 'Email sent',
];

function amatchless_register_leads() {
    // Every capability maps to one Editors and Admins have; nobody can create leads by hand.
    $cap = 'edit_others_posts';
    register_post_type('amatchless_lead', [
        'labels' => [
            'name'               => 'Leads',
            'singular_name'      => 'Lead',
            'menu_name'          => 'Leads',
            'all_items'          => 'All Leads',
            'edit_item'          => 'Lead',
            'search_items'       => 'Search Leads',
            'not_found'          => 'No leads yet.',
            'not_found_in_trash' => 'No leads in the trash.',
        ],
        'public'          => false,
        'show_ui'         => true,
        'show_in_menu'    => true,
        'show_in_rest'    => false,
        'menu_position'   => 25,
        'menu_icon'       => 'dashicons-email-alt',
        'supports'        => false,
        'map_meta_cap'    => false,
        'capabilities'    => [
            'create_posts'           => 'do_not_allow',
            'publish_posts'          => 'do_not_allow',
            'edit_post'              => $cap,
            'read_post'              => $cap,
            'delete_post'            => $cap,
            'edit_posts'             => $cap,
            'edit_others_posts'      => $cap,
            'edit_published_posts'   => $cap,
            'edit_private_posts'     => $cap,
            'read_private_posts'     => $cap,
            'delete_posts'           => $cap,
            'delete_others_posts'    => $cap,
            'delete_published_posts' => $cap,
            'delete_private_posts'   => $cap,
        ],
    ]);
}
add_action('init', 'amatchless_register_leads');

// Save one enquiry; returns the new lead's ID (0 on failure).
function amatchless_save_lead(array $lead) {
    $id = wp_insert_post([
        'post_type'    => 'amatchless_lead',
        'post_status'  => 'publish',
        'post_title'   => $lead['name'],
        'post_content' => $lead['message'],
        'post_date'    => $lead['date'] ?? current_time('mysql'),
    ], true);
    if (is_wp_error($id)) {
        return 0;
    }
    foreach (array_keys(AMATCHLESS_LEAD_FIELDS) as $key) {
        if (isset($lead[$key]) && $lead[$key] !== '') {
            update_post_meta($id, '_lead_' . $key, $lead[$key]);
        }
    }
    return $id;
}

/* ── List screen columns ─────────────────────────────────────── */
function amatchless_lead_columns($cols) {
    return [
        'cb'      => $cols['cb'],
        'title'   => 'Name',
        'company' => 'Company',
        'email'   => 'Email',
        'phone'   => 'Phone',
        'service' => 'Service',
        'budget'  => 'Budget',
        'date'    => 'Received',
    ];
}
add_filter('manage_amatchless_lead_posts_columns', 'amatchless_lead_columns');

function amatchless_lead_column($col, $id) {
    $val = get_post_meta($id, '_lead_' . $col, true);
    if ($val === '') {
        echo '—';
    } elseif ($col === 'email') {
        printf('<a href="mailto:%1$s">%1$s</a>', esc_attr($val));
    } elseif ($col === 'phone') {
        printf('<a href="tel:%s">%s</a>', esc_attr(preg_replace('/[^\d+]/', '', $val)), esc_html($val));
    } else {
        echo esc_html($val);
    }
}
add_action('manage_amatchless_lead_posts_custom_column', 'amatchless_lead_column', 10, 2);

// Search by email, company or phone as well as name and message.
function amatchless_lead_search($search, $query) {
    global $wpdb;
    if (!is_admin() || !$query->is_main_query() || $query->get('post_type') !== 'amatchless_lead' || !$query->get('s')) {
        return $search;
    }
    $like = '%' . $wpdb->esc_like($query->get('s')) . '%';
    $meta = $wpdb->prepare(
        " OR {$wpdb->posts}.ID IN (SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key IN ('_lead_email','_lead_company','_lead_phone') AND meta_value LIKE %s)",
        $like
    );
    return preg_replace('/\)\)\s*$/', ')' . $meta . ')', $search, 1);
}
add_filter('posts_search', 'amatchless_lead_search', 10, 2);

// Leads have no public page, so drop the "View" / "Quick Edit" row actions.
function amatchless_lead_row_actions($actions, $post) {
    if ($post->post_type === 'amatchless_lead') {
        unset($actions['inline hide-if-no-js'], $actions['view']);
        if (isset($actions['edit'])) {
            $actions['edit'] = sprintf('<a href="%s">Open</a>', esc_url(get_edit_post_link($post->ID)));
        }
    }
    return $actions;
}
add_filter('post_row_actions', 'amatchless_lead_row_actions', 10, 2);

/* ── Single lead screen ──────────────────────────────────────── */
function amatchless_lead_meta_box() {
    add_meta_box('amatchless_lead_details', 'Enquiry', 'amatchless_render_lead', 'amatchless_lead', 'normal', 'high');
}
add_action('add_meta_boxes_amatchless_lead', 'amatchless_lead_meta_box');

function amatchless_render_lead($post) {
    echo '<table class="form-table" role="presentation"><tbody>';
    printf('<tr><th>Name</th><td>%s</td></tr>', esc_html($post->post_title));
    printf('<tr><th>Received</th><td>%s</td></tr>', esc_html(get_the_date('j M Y, g:i a', $post)));
    foreach (AMATCHLESS_LEAD_FIELDS as $key => $label) {
        $val = get_post_meta($post->ID, '_lead_' . $key, true);
        if ($key === 'email' && $val) {
            $val = sprintf('<a href="mailto:%1$s">%1$s</a>', esc_attr($val));
        } else {
            $val = $val === '' ? '—' : esc_html($val);
        }
        printf('<tr><th>%s</th><td>%s</td></tr>', esc_html($label), $val);
    }
    printf('<tr><th>Message</th><td>%s</td></tr>', $post->post_content === '' ? '—' : nl2br(esc_html($post->post_content)));
    echo '</tbody></table>';
}

/* ── One-time import of leads saved by theme 1.x/2.x into wp_amatchless_leads ── */
function amatchless_import_legacy_leads() {
    global $wpdb;
    if (get_option('amatchless_leads_imported') || !current_user_can('edit_others_posts')) {
        return;
    }
    $table = $wpdb->prefix . 'amatchless_leads';
    if ($wpdb->get_var($wpdb->prepare('SHOW TABLES LIKE %s', $table)) === $table) {
        foreach ($wpdb->get_results("SELECT * FROM {$table} ORDER BY id", ARRAY_A) as $row) {
            amatchless_save_lead([
                'name'    => $row['name'],
                'message' => (string) $row['message'],
                'date'    => $row['created_at'],
                'email'   => $row['email'],
                'company' => $row['company'],
                'phone'   => (string) $row['phone'],
                'service' => (string) $row['service'],
                'budget'  => (string) $row['budget'],
            ]);
        }
    }
    update_option('amatchless_leads_imported', 1, false);
}
add_action('admin_init', 'amatchless_import_legacy_leads');
