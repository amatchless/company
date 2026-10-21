<?php
/**
 * Case studies told as stories: one page per project at /work/{slug}/.
 * The stories live here (in git); WordPress only holds an empty child page of "Work" for each,
 * which case-study.php renders.
 */
defined('ABSPATH') || exit;

// The Amatchless crew, as drawn in assets/img/team/.
function amatchless_crew() {
    return [
        'bravo'   => ['name' => 'Bravo',   'role' => 'Sales Director',         'bg' => '#FFE14D'],
        'blossom' => ['name' => 'Blossom', 'role' => 'Creative Head',          'bg' => '#FF4F9A'],
        'dexter'  => ['name' => 'Dexter',  'role' => 'Director of Technology', 'bg' => '#5B2EFF'],
        'kim'     => ['name' => 'Kim',     'role' => 'Client Head',            'bg' => '#3DEBB0'],
    ];
}

/*
 * One entry per project, in Work-grid order. Chapters run: situation → the talk with Bravo → the work → the result.
 * Each chapter's 'say' is the comic panel: [speaker, line], at most two different speakers ('client' or a crew key).
 */
function amatchless_cases() {
    return [
        'isola' => [
            'name'    => 'Isola',
            'anchor'  => 'isola',
            'site'    => 'https://isolabysk.com',
            'bg'      => '#FF7A1A',
            'fg'      => '#0E0B1F',
            'word'    => '<i>Isola</i>',
            'badge'   => '575K CREATOR',
            'label'   => 'Creator brand · E-commerce',
            'title'   => 'From 575K followers to her very first store.',
            'lede'    => 'Saanya Khatter had the audience, the eye and a swimwear line she loved. What she didn\'t have was any idea how to sell it online. This is how that changed.',
            'client'  => ['name' => 'Saanya', 'role' => 'Creator and founder, Isola'],
            'crew'    => ['bravo', 'dexter', 'blossom', 'kim'],
            'services' => ['Web development', 'E-commerce', 'Social media'],
            'seo_title' => 'Isola Case Study: A Creator\'s First Online Store | Amatchless',
            'seo_desc'  => 'How we helped creator Saanya Khatter launch Isola, her resort-wear and swimwear label: an e-commerce store designed and built, plus social media run day to day.',
            'chapters' => [
                [
                    'title'   => 'A creator with a dream (and no store)',
                    'caption' => 'Once upon a feed…',
                    'sfx'     => 'DING!',
                    'text'    => 'Saanya had spent years building an audience of 575K on Instagram. Her followers kept asking where to buy the resort-wear she was designing: pieces cut for the water and worn to dinner. But Isola was her first online business, and every DM got the same answer: "Coming soon!"',
                    'say'     => [
                        ['client', 'I\'ve got the designs and the followers. I just don\'t know where to start with selling online.'],
                    ],
                ],
                [
                    'title'   => 'Enter Bravo, with a plan',
                    'caption' => 'One discovery call later…',
                    'sfx'     => 'DEAL!',
                    'text'    => 'Saanya booked a call and got Bravo. Before he said a word about websites, he asked about her customers, her prices, how she\'d ship and what "luxury" meant to her. Then he put the plan on one page: a store that feels as premium as the clothes, a feed that sends people to it, and a team to handle the tech.',
                    'say'     => [
                        ['client', 'Do I need an app? A marketplace? A website? I\'m lost.'],
                        ['bravo',  'Relax. You need one great store and a feed that sends people to it. Leave the hard part to us.'],
                        ['client', 'That\'s it?'],
                        ['bravo',  'That\'s step one. Let me introduce you to Dexter.'],
                    ],
                ],
                [
                    'title'   => 'Meanwhile, in Dexter\'s lab…',
                    'caption' => 'Experiment no. 14',
                    'sfx'     => 'ZAP!',
                    'text'    => 'Saanya told Dexter how she pictured Isola: calm, sunlit and expensive-looking, with nothing between a shopper and checkout. Dexter disappeared into his lab. Many prototypes and checkout trials later, he came out with a store built for people arriving from Instagram on their phones. Next door, Blossom shaped the look so the brand felt the same on the feed as on the site.',
                    'say'     => [
                        ['dexter',  'A product page that loads before you can blink. Experiment fourteen: success!'],
                        ['blossom', 'And I\'m making the feed look like a holiday you can buy.'],
                    ],
                    'built'   => ['E-commerce store, designed and built', 'Mobile-first product pages and checkout', 'One brand look for site and social', 'Social media content plan'],
                ],
                [
                    'title'   => 'Isola opens its doors',
                    'caption' => 'Launch day',
                    'sfx'     => 'TA-DA!',
                    'text'    => 'Isola launched as a premium direct-to-consumer label, available across India, and Saanya\'s audience could finally buy what they\'d been asking about. We still run the brand\'s social media day to day, so the store and the feed keep pulling in the same direction.',
                    'say'     => [
                        ['client', 'My DMs say "just ordered!" now, instead of "when?"'],
                        ['kim',    'And we\'re right here for the next collection.'],
                    ],
                ],
            ],
            'metrics' => [['Web', 'E-commerce store, designed &amp; built'], ['Social', 'Ongoing social media management'], ['DTC', 'Full brand launch, India-wide']],
        ],

        'aleuco' => [
            'name'    => 'AleuCo',
            'anchor'  => 'aleuco',
            'site'    => 'https://aleuco.com',
            'bg'      => '#FFC2DD',
            'fg'      => '#B0125B',
            'word'    => 'AleuCo',
            'badge'   => 'BEAUTY ON DEMAND',
            'label'   => 'Beauty · US market',
            'title'   => 'The beauty studio people couldn\'t find.',
            'lede'    => 'AleuCo brings luxury hair and makeup to clients\' doors across the US. The work was gorgeous. The hard part was getting found by the people searching for it.',
            'client'  => ['name' => 'AleuCo', 'role' => 'Luxury mobile hair & makeup'],
            'crew'    => ['bravo', 'blossom', 'dexter', 'kim'],
            'services' => ['SEO', 'AEO & GEO', 'Branding'],
            'seo_title' => 'AleuCo Case Study: Getting a Beauty Brand Found | Amatchless',
            'seo_desc'  => 'How we\'re helping AleuCo, a luxury mobile hair and makeup studio in the US, get found in search, maps and AI answers with SEO, AEO, GEO and branding.',
            'chapters' => [
                [
                    'title'   => 'Gorgeous work, invisible online',
                    'caption' => 'Somewhere in the US…',
                    'sfx'     => 'HMM?',
                    'text'    => 'AleuCo\'s artists travel to brides, events and photo shoots, so there\'s no salon on a high street for anyone to walk past. Every new booking starts with a search. And when people typed "mobile makeup artist near me", or asked an AI assistant for a recommendation, AleuCo rarely came up.',
                    'say'     => [
                        ['client', 'Our clients love us. New clients just can\'t find us.'],
                    ],
                ],
                [
                    'title'   => 'Bravo searches like a bride-to-be',
                    'caption' => 'On the discovery call…',
                    'sfx'     => 'AHA!',
                    'text'    => 'Bravo started by searching the way AleuCo\'s customers do: on Google, on Maps, and in the AI assistants people now ask for recommendations. He showed AleuCo where competitors appeared and they didn\'t, then laid out a three-part plan: sharpen the brand, win classic search, and get into the AI and map answers too.',
                    'say'     => [
                        ['client', 'Isn\'t SEO just keywords?'],
                        ['bravo',  'Not any more. People ask ChatGPT and Maps now. You need to show up in all three places.'],
                        ['client', 'Okay. I\'m listening.'],
                    ],
                ],
                [
                    'title'   => 'Blossom polishes, Dexter optimises',
                    'caption' => 'Studio on the left, lab on the right',
                    'sfx'     => 'SPARKLE!',
                    'text'    => 'Blossom sharpened how AleuCo looks and talks, so the brand reads as luxury at a glance. Dexter took the technical side into his lab: how the pages are built, the local listings, and the structured information search engines and AI tools read when they decide who to recommend.',
                    'say'     => [
                        ['blossom', 'Same artists, same magic. Now the brand finally looks the part.'],
                        ['dexter',  'And I\'m teaching the robots who the best mobile makeup studio is.'],
                    ],
                    'built'   => ['Brand positioning and identity', 'SEO for services and locations', 'Local and map listings', 'AEO & GEO: content AI answers can quote'],
                ],
                [
                    'title'   => 'Showing up where it counts',
                    'caption' => 'Month by month',
                    'sfx'     => 'FOUND!',
                    'text'    => 'AleuCo now has a brand that matches the quality of its work, and a search presence built for classic results and for the AI answers buyers rely on. The work is ongoing: Kim keeps it moving every month, so the right clients find AleuCo first.',
                    'say'     => [
                        ['kim',    'Every month we check where you show up, then push a little further.'],
                        ['client', 'Finally, the internet knows who we are.'],
                    ],
                ],
            ],
            'metrics' => [['SEO', 'Search visibility &amp; local reach'], ['AEO/GEO', 'Found in AI &amp; map answers'], ['Brand', 'Positioning &amp; identity']],
        ],

        'baileys-blossoms' => [
            'name'    => 'Bailey\'s Blossoms',
            'anchor'  => 'baileys',
            'site'    => 'https://www.baileysblossoms.com',
            'bg'      => '#FFE14D',
            'fg'      => '#0E0B1F',
            'word'    => 'Bailey\'s<br>Blossoms',
            'badge'   => '★ SHARK TANK',
            'label'   => 'E-commerce · Kids & family',
            'title'   => 'Turning ad spend into four times the sales.',
            'lede'    => 'Bailey\'s Blossoms dresses girls and their moms in matching outfits, has been on Shark Tank and is trusted by over a million moms. They wanted Meta ads that paid for themselves, every time.',
            'client'  => ['name' => 'Bailey\'s Blossoms', 'role' => 'Girls\' and Mommy & Me clothing'],
            'crew'    => ['bravo', 'blossom', 'dexter', 'kim'],
            'services' => ['Meta ads', 'Ad creative', 'Tracking'],
            'seo_title' => 'Bailey\'s Blossoms Case Study: 4× Return on Meta Ads | Amatchless',
            'seo_desc'  => 'How we run Meta ads for Bailey\'s Blossoms, the Shark Tank girls\' and Mommy & Me clothing brand: tested creative and tracked campaigns returning 4× ad spend.',
            'chapters' => [
                [
                    'title'   => 'A loved brand with a leaky ad budget',
                    'caption' => 'After Shark Tank…',
                    'sfx'     => 'UH-OH',
                    'text'    => 'Bailey\'s Blossoms didn\'t have a fame problem. Shark Tank and a million happy moms had taken care of that. The challenge was Facebook and Instagram advertising: some campaigns flew, others quietly burned money, and it was hard to tell in advance which would be which.',
                    'say'     => [
                        ['client', 'Some months the ads are magic. Other months, I have no idea where the money went.'],
                    ],
                ],
                [
                    'title'   => 'Bravo talks numbers',
                    'caption' => 'The first call',
                    'sfx'     => 'DEAL!',
                    'text'    => 'Bravo asked the question that matters most for an online shop: for every dollar spent on Meta, how many come back? Then he proposed a simple way of working. Test creative quickly, keep the winners, cut the losers, and only scale what is profitable.',
                    'say'     => [
                        ['bravo',  'Let\'s agree on one number: return on ad spend. Everything we do should move it.'],
                        ['client', 'Just one number?'],
                        ['bravo',  'One number, tested every week. Blossom is going to love this.'],
                    ],
                ],
                [
                    'title'   => 'Blossom\'s creative kitchen',
                    'caption' => 'Test, learn, repeat',
                    'sfx'     => 'TWIRL!',
                    'text'    => 'Blossom built ads around the way moms actually shop: real mother-and-daughter moments, matching outfits and occasions to dress up for. Dexter made sure every sale was tracked back to the ad that drove it, so decisions came from real numbers rather than gut feel.',
                    'say'     => [
                        ['blossom', 'Twirling dresses, matching smiles. Thumb-stopping, guaranteed.'],
                        ['dexter',  'And I\'ll know exactly which ad sold which dress.'],
                    ],
                    'built'   => ['Ad creative for Facebook and Instagram', 'Campaign structure and audiences', 'Weekly creative testing', 'Sales tracked back to each ad'],
                ],
                [
                    'title'   => '4× and counting',
                    'caption' => 'The scoreboard',
                    'sfx'     => '4×!',
                    'text'    => 'The campaigns now bring back four times what goes in. And because the process is repeatable, Bailey\'s Blossoms can scale its spend with confidence instead of crossing its fingers.',
                    'say'     => [
                        ['client', 'Four back for every one in? I\'ll take that.'],
                        ['kim',    'Same time next week. We\'ve got new creative to test.'],
                    ],
                ],
            ],
            'metrics' => [['4×', 'Return on ad spend'], ['Meta', 'Facebook &amp; Instagram ads'], ['Scaled', 'Profitable, repeatable spend']],
        ],

        'moment' => [
            'name'    => 'Moment',
            'anchor'  => 'moment',
            'site'    => 'https://drinkmoment.com',
            'bg'      => '#5B2EFF',
            'fg'      => '#FFFFFF',
            'word'    => 'moment',
            'badge'   => '★ SHARK TANK',
            'label'   => 'Wellness · Functional beverages',
            'title'   => 'Helping a calm drink make some noise.',
            'lede'    => 'Moment makes functional, meditation-inspired drinks and has been on Shark Tank. A brilliant product in a crowded aisle, and a need to reach the people looking for exactly this.',
            'client'  => ['name' => 'Moment', 'role' => 'Functional, meditation-inspired drinks'],
            'crew'    => ['bravo', 'blossom', 'dexter', 'kim'],
            'services' => ['Branding', 'SEO', 'Paid ads'],
            'seo_title' => 'Moment Case Study: Brand, SEO and Ads for a Wellness Drink | Amatchless',
            'seo_desc'  => 'How we support Moment, the Shark Tank functional drinks brand, across branding, SEO and paid ads so a standout product reaches the people looking for it.',
            'chapters' => [
                [
                    'title'   => 'A calm product in a noisy market',
                    'caption' => 'Fresh from the Shark Tank',
                    'sfx'     => 'SHHH…',
                    'text'    => 'Moment had already won over the Sharks. But the drinks aisle and the internet are loud, and a product built around calm doesn\'t win by shouting. Moment needed the people searching for a better kind of drink to find it, and to get the brand in a second.',
                    'say'     => [
                        ['client', 'We made a drink that helps people slow down. How do we stand out without yelling?'],
                    ],
                ],
                [
                    'title'   => 'Bravo\'s three-part plan',
                    'caption' => 'Over a can of Moment…',
                    'sfx'     => 'DEAL!',
                    'text'    => 'Bravo suggested working on three fronts at once, because each makes the others stronger: a sharper brand, organic growth through SEO, and paid ads to reach new customers. One team on all three, so they actually talk to each other.',
                    'say'     => [
                        ['bravo',  'Brand, search and ads. One makes you memorable, one makes you findable, one gets you seen.'],
                        ['client', 'All three at once?'],
                        ['bravo',  'All three, one team. That\'s the trick.'],
                    ],
                ],
                [
                    'title'   => 'Studio and lab, side by side',
                    'caption' => 'Deep breath. Begin.',
                    'sfx'     => 'OMMM',
                    'text'    => 'Blossom sharpened Moment\'s positioning and identity so the brand feels as calm and premium as the drink tastes. Dexter worked on the search foundations and content, so Moment shows up for people looking for functional and wellness drinks. The ads then carried the same story to new audiences.',
                    'say'     => [
                        ['blossom', 'Less noise, more feeling. That\'s the Moment look.'],
                        ['dexter',  'Search engines now know exactly what\'s in the can.'],
                    ],
                    'built'   => ['Brand positioning and identity', 'SEO and search content', 'Paid ad campaigns', 'One story across all three'],
                ],
                [
                    'title'   => 'A brand that reaches its people',
                    'caption' => 'And breathe out',
                    'sfx'     => 'AHHH',
                    'text'    => 'Moment\'s branding, organic search and paid ads now pull the same way, so a standout product reaches the people looking for it. Kim keeps all three in step as the brand grows.',
                    'say'     => [
                        ['client', 'It finally feels like one brand, everywhere.'],
                        ['kim',    'And we\'ll keep it that way.'],
                    ],
                ],
            ],
            'metrics' => [['SEO', 'Organic search growth'], ['Brand', 'Positioning &amp; identity'], ['Ads', 'Paid acquisition']],
        ],

        'haliburton-forest' => [
            'name'    => 'Haliburton Forest',
            'anchor'  => 'haliburton',
            'site'    => 'https://www.haliburtonforest.com',
            'bg'      => '#3DEBB0',
            'fg'      => '#0E0B1F',
            'word'    => 'Haliburton<br>Forest',
            'badge'   => 'BOOKING SYSTEM',
            'label'   => 'Tourism · Web & booking',
            'title'   => 'Putting 100,000 acres of wilderness online.',
            'lede'    => 'Haliburton Forest & Wild Life Reserve is one of Ontario\'s largest outdoor adventure destinations. Visitors wanted to plan and book their trip in one place, at any time of year.',
            'client'  => ['name' => 'Haliburton Forest', 'role' => 'Wilderness reserve, Ontario'],
            'crew'    => ['bravo', 'dexter', 'kim'],
            'services' => ['Web development', 'Booking system'],
            'seo_title' => 'Haliburton Forest Case Study: Website and Booking System | Amatchless',
            'seo_desc'  => 'How we designed and built the website and booking system for Haliburton Forest, a 100,000-acre Ontario reserve, so visitors can book stays and activities all year.',
            'chapters' => [
                [
                    'title'   => 'A huge forest with a lot to explain',
                    'caption' => 'Deep in Ontario…',
                    'sfx'     => 'HOOT!',
                    'text'    => 'With 100,000 acres, 100 lakes and something to do in every season, Haliburton Forest has plenty to offer. That was also what made it hard to show online. Visitors had to piece together where to stay and what to do, then get in touch to book it.',
                    'say'     => [
                        ['client', 'Cabins, campsites, trails, lakes. Getting all of it online and bookable? That\'s the tricky part.'],
                    ],
                ],
                [
                    'title'   => 'Bravo plans the trip',
                    'caption' => 'Map spread on the table…',
                    'sfx'     => 'DEAL!',
                    'text'    => 'Bravo looked at the forest the way a first-time visitor would. What is this place? Where do I stay? What can I do? How do I book? His plan: a new website that answers those questions in that order, and a booking system built around how the reserve actually runs.',
                    'say'     => [
                        ['bravo',  'Your visitors ask four questions. The website should answer them in order, and end at "Book now".'],
                        ['client', 'And the bookings themselves?'],
                        ['bravo',  'That\'s a job for Dexter\'s lab.'],
                    ],
                ],
                [
                    'title'   => 'Dexter\'s biggest experiment yet',
                    'caption' => 'Four seasons of testing',
                    'sfx'     => 'ZAP!',
                    'text'    => 'Dexter designed and built the website, and a custom reservation system for stays and activities that copes with four seasons\' worth of options. After plenty of experiments in the lab, visitors could see what\'s available and reserve it directly online.',
                    'say'     => [
                        ['dexter', 'Cabins, campsites and activities, every season, all bookable. My lab has never been this outdoorsy.'],
                        ['client', 'So I can book a canoe from my phone?'],
                    ],
                    'built'   => ['Website, designed and built', 'Custom reservation system', 'Stays and activities in one place', 'Bookable all year round'],
                ],
                [
                    'title'   => 'Open for bookings, all year round',
                    'caption' => 'Spring, summer, autumn, winter',
                    'sfx'     => 'TA-DA!',
                    'text'    => 'Haliburton Forest now has a website as big as the adventure, and visitors can reserve stays and activities right through the year. Kim stayed close through launch, so the reserve\'s team always had someone to call.',
                    'say'     => [
                        ['client', 'The forest is officially open online!'],
                        ['kim',    'And I\'m one call away whenever you need me.'],
                    ],
                ],
            ],
            'metrics' => [['Web', 'Full website, designed &amp; built'], ['Booking', 'Custom reservation system'], ['4-season', 'Stays &amp; activities online']],
        ],
    ];
}

// The case shown on the current page, or null. A case page is a child of "Work" whose slug is a key above.
function amatchless_current_case() {
    if (!is_page()) return null;
    $post = get_queried_object();
    if (!$post || empty($post->post_parent) || get_post_field('post_name', $post->post_parent) !== 'work') return null;
    $cases = amatchless_cases();
    return isset($cases[$post->post_name]) ? $cases[$post->post_name] + ['slug' => $post->post_name] : null;
}

// URL of a case's story page, falling back to its card on the Work page if the page is missing.
function amatchless_case_url($slug) {
    static $urls = [];
    if (!isset($urls[$slug])) {
        $page = get_page_by_path('work/' . $slug);
        $urls[$slug] = ($page && $page->post_status === 'publish') ? get_permalink($page) : '';
    }
    if ($urls[$slug]) return $urls[$slug];
    $anchor = amatchless_cases()[$slug]['anchor'] ?? $slug;
    return amatchless_page_url('work') . '#case-' . $anchor;
}

// Create the story pages under "Work" once (only the ones that don't exist yet).
function amatchless_create_case_pages() {
    if (get_option('amatchless_case_pages_created') === '1') return;
    $work = get_page_by_path('work');
    if (!$work) return; // try again once the Work page exists
    foreach (amatchless_cases() as $slug => $c) {
        if (get_page_by_path('work/' . $slug)) continue;
        wp_insert_post([
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_parent'  => $work->ID,
            'post_name'    => $slug,
            'post_title'   => $c['name'] . ': ' . rtrim($c['title'], '.'),
            'post_excerpt' => $c['seo_desc'],
        ]);
    }
    update_option('amatchless_case_pages_created', '1');
}
add_action('init', 'amatchless_create_case_pages', 21);

add_filter('template_include', function ($template) {
    if (amatchless_current_case()) {
        $t = locate_template('case-study.php');
        if ($t) return $t;
    }
    return $template;
});

add_filter('body_class', function ($classes) {
    if (amatchless_current_case()) $classes[] = 'case-study';
    return $classes;
});

// Who appears in a case: 'client' plus the crew, each with name, role, image and colour.
function amatchless_case_cast($case) {
    $base = get_template_directory_uri() . '/assets/img/';
    $cast = ['client' => $case['client'] + ['img' => $base . 'clients/' . $case['slug'] . '.svg?ver=' . AMATCHLESS_VERSION, 'bg' => $case['bg']]];
    $crew = amatchless_crew();
    foreach ($case['crew'] as $k) {
        $cast[$k] = $crew[$k] + ['img' => $base . 'team/' . $k . '.svg?ver=' . AMATCHLESS_VERSION];
    }
    return $cast;
}
