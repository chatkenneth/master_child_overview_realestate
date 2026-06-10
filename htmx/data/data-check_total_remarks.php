<?php

$city =  $_POST["city_municipality"];
$barangay = $_POST["barangay"];
$user = $_POST["user"];

/**
 * Build Query Args
 */
$the_remarks_args = array(
    'post_type'      => array('all_entries'),
    'posts_per_page' => -1,
    'order'          => 'DESC',
    'orderby'        => 'date',
    'post_status'    => 'publish',
);

// Filter by author
if ($user) {
    $user_id = intval($user);
    if (get_user_by('id', $user_id)) {
        $the_remarks_args['author'] = $user_id;
    }
}

// Initialize meta_query
$meta_query = array('relation' => 'AND');


// City filter
if (!empty($city)) {
    $meta_query[] = array(
        'key'     => 'location_city_municipality',
        'value'   => sanitize_text_field($city),
        'compare' => '=',
        'type'    => 'CHAR',
    );
}

// Barangay filter
if (!empty($barangay)) {
    $meta_query[] = array(
        'key'     => 'location_barangay',
        'value'   => sanitize_text_field($barangay),
        'compare' => '=',
        'type'    => 'CHAR',
    );
}

// Apply meta_query only if may laman
if (count($meta_query) > 1) {
    $the_remarks_args['meta_query'] = $meta_query;
}

// Run Query
$the_remarks_query = new WP_Query($the_remarks_args);

// Initialize total
$grand_total_remaining_invalid = 0;

/**
 * Loop
 */
if ($the_remarks_query->have_posts()) :

    while ($the_remarks_query->have_posts()) : $the_remarks_query->the_post();

        $post_id = get_the_ID();

        // Get invalid count
        $total_invalid = validate_clinic_data($post_id, 'count');

        // Only process if may invalid
        if (!empty($total_invalid)) {

            $remaining_invalid = validate_clinic_data($post_id, 'remaining_invalid');

            $grand_total_remaining_invalid += intval($remaining_invalid);
        }

    endwhile;

endif;

// Reset post data
wp_reset_postdata();

// Output result
echo $grand_total_remaining_invalid;