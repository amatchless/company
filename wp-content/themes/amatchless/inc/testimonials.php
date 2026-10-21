<?php
/**
 * Client testimonials for template-parts/section-testimonials.php.
 *
 * The quotes below are DRAFTS written from what we did for each client. They are not the
 * clients' words yet. Send each one to the client, use their edits, fill in the real name and
 * role, and only then set 'approved' => true.
 *
 * Visitors only ever see approved quotes; if none are approved the section is left out.
 * Logged-in admins see the drafts too, marked DRAFT, so the layout can be checked on the live site.
 */
defined('ABSPATH') || exit;

function amatchless_testimonials() {
    return [
        [
            'slug'     => 'baileys-blossoms',
            'company'  => "Bailey's Blossoms",
            'name'     => '',                       // the client's real name, once they sign off
            'role'     => 'Founder',
            'services' => 'Meta ads',
            'rating'   => 5,
            'bg'       => '#FFE14D',
            'quote'    => "Shark Tank got people to know our name. Amatchless made our ads pay for themselves. They test creative properly, track every dollar, and our Meta campaigns now return four times what we put in, so we scale spend with confidence instead of crossing our fingers.",
            'mark'     => 'return four times what we put in',
            'featured' => true,
            'approved' => false,
        ],
        [
            'slug'     => 'isola',
            'company'  => 'Isola',
            'name'     => 'Saanya Khatter',
            'role'     => 'Creator and founder',
            'services' => 'Website · Social media',
            'rating'   => 5,
            'bg'       => '#FF7A1A',
            'quote'    => "For years my DMs were full of “where can I buy this?” and all I could say was “coming soon”. Amatchless built Isola around how my followers actually shop, on their phones and straight from Instagram, and they run our social every day. The feed and the store finally feel like one brand.",
            'mark'     => 'feel like one brand',
            'approved' => false,
        ],
        [
            'slug'     => 'moment',
            'company'  => 'Moment',
            'name'     => '',
            'role'     => 'Founder',
            'services' => 'Branding · SEO · Ads',
            'rating'   => 5,
            'bg'       => '#5B2EFF',
            'quote'    => "A drink built around calm can't win by shouting, and Amatchless got that on the first call. They sharpened our branding, grew our organic search and run our paid ads as one plan, so the people looking for a better kind of drink actually find us.",
            'mark'     => 'one plan',
            'approved' => false,
        ],
        [
            'slug'     => 'aleuco',
            'company'  => 'AleuCo',
            'name'     => '',
            'role'     => 'Founder',
            'services' => 'SEO · AEO/GEO · Branding',
            'rating'   => 5,
            'bg'       => '#FFC2DD',
            'quote'    => "We don't have a salon window anyone walks past. Every booking starts with a search. Amatchless showed us exactly where competitors appeared and we didn't, on Google, on Maps and in AI answers, and they've been closing those gaps month by month. Our brand finally looks as polished as our artists' work.",
            'mark'     => 'as polished as our artists\' work',
            'approved' => false,
        ],
        [
            'slug'     => 'haliburton-forest',
            'company'  => 'Haliburton Forest',
            'name'     => '',
            'role'     => 'Marketing lead',
            'services' => 'Website · Booking system',
            'rating'   => 5,
            'bg'       => '#3DEBB0',
            'quote'    => "We're 100,000 acres and 100 lakes, open all year, and our old website didn't do any of it justice. Amatchless designed a site that feels like the forest and built a booking system our visitors use to reserve stays and activities in every season.",
            'mark'     => 'in every season',
            'approved' => false,
        ],
    ];
}

// The testimonials this visitor may see: approved ones, plus drafts for logged-in admins.
function amatchless_visible_testimonials() {
    $preview = current_user_can('edit_theme_options');
    return array_values(array_filter(amatchless_testimonials(), function ($t) use ($preview) {
        return !empty($t['approved']) || $preview;
    }));
}

// The quote, escaped, with its 'mark' phrase highlighted.
function amatchless_testimonial_quote($t) {
    $quote = esc_html($t['quote']);
    if (empty($t['mark'])) return $quote;
    $mark = esc_html($t['mark']);
    $pos  = strpos($quote, $mark);
    if ($pos === false) return $quote;
    $cls = empty($t['featured']) ? 'mark-yellow' : 'mark-mint';
    return substr_replace($quote, '<span class="' . $cls . '">' . $mark . '</span>', $pos, strlen($mark));
}
