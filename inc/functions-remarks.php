<?php

function normalize_title($title) {
    $title = strtolower(trim($title));
    $title = preg_replace('/\s+/', ' ', $title); // collapse multiple spaces
    return $title;
}


function ordinal($number) {
    $suffix = 'th';

    if (!in_array($number % 100, [11, 12, 13])) {
        switch ($number % 10) {
            case 1: $suffix = 'st'; break;
            case 2: $suffix = 'nd'; break;
            case 3: $suffix = 'rd'; break;
        }
    }

    return $number . $suffix;
}

function is_duplicate_title_strict($item_id) {
    $title = normalize_title(get_the_title($item_id));

    if ($title === '') return 0;

    $query = new WP_Query([
        'post_type'      => 'all_entries',
        'posts_per_page' => -1,
        'post_status'    => 'any',
        'post__not_in'   => [$item_id],
        'fields'         => 'ids',
        'no_found_rows'  => true,
    ]);

    $duplicate_count = 0;

    foreach ($query->posts as $id) {
        $existing_title = normalize_title(get_the_title($id));

        if ($existing_title === $title) {
            $duplicate_count++;
        }
    }

    return $duplicate_count;
}



function get_category_list($post_id, $category, $mode = 'html') {
    $all_notes = get_field('all_notes', $post_id);

    if (empty($all_notes) || !is_array($all_notes)) {
        return ($mode === 'count') ? 0 : '';
    }

    $items = [];

    foreach ($all_notes as $item) {
        if (isset($item['category'], $item['value']) && $item['category'] === $category) {
            $items[] = esc_html($item['value']);
        }
    }

    if ($mode === 'count') {
        return count($items);
    }

    if (empty($items)) {
        return '';
    }

    $html_items = array_map(function($value) {
        return '<li>' . $value . '</li>';
    }, $items);

    return '<ul class="remarks-list mb-0 ps-3">' . implode('', $html_items) . '</ul>';
}

function render_error_list($errors = []) {
    if (empty($errors) || !is_array($errors)) {
        return '<span class="text-success">—</span>';
    }

    $html = '<ul class="remarks-list mb-0 ps-3">';
    foreach ($errors as $error) {
        $html .= '<li>' . esc_html($error) . '</li>';
    }
    $html .= '</ul>';

    return $html;
}


function validate_clinic_data($post_id = null, $return = 'html') {

    

    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $row_counter = 1;
    $invalid = 0;
    $error_details = [];
    $rows = '';

    // Location fields
    $province = get_field('location_province', $post_id);
    $city     = get_field('location_city_municipality', $post_id);
    $barangay = get_field('location_barangay', $post_id);




    // =========================
    // About
    // =========================

    $error_details = array_merge_recursive($error_details, get_remarks_details_about($post_id, 0, 'errors') );
    $rows .= get_remarks_details_about($post_id, $row_counter++);

    // =========================
    // Tagline
    // =========================

    $error_details = array_merge_recursive($error_details, get_remarks_details_tagline($post_id, 0, 'errors') );
    $rows .= get_remarks_details_tagline($post_id, $row_counter++);

    // =========================
    // Featured Video
    // =========================

    $error_details = array_merge_recursive($error_details, get_remarks_details_featured_video($post_id, 0, 'errors') );
    $rows .= get_remarks_details_featured_video($post_id, $row_counter++);

    // =========================
    // Hours
    // =========================

    $error_details = array_merge_recursive($error_details, get_remarks_all_hours($post_id, 0, 'errors') );
    $rows .= get_remarks_all_hours($post_id, $row_counter);

    $error_details = array_merge_recursive($error_details, get_remarks_all_hours_notes($post_id, 0, 'errors') );
    $rows .= get_remarks_all_hours_notes($post_id, $row_counter);

    // =========================
    // All Services
    // =========================

    $error_details = array_merge_recursive($error_details, get_remarks_all_services($post_id, 0, 'errors') );
    $rows .= get_remarks_all_services($post_id, $row_counter++); 

    // =========================
    // Why Choose Us
    // =========================

    $error_details = array_merge_recursive($error_details, get_remarks_why_choose_us($post_id, 0, 'errors') );
    $rows .= get_remarks_why_choose_us($post_id, $row_counter++); 

    // =========================
    // MOBILE NUMBERS
    // =========================
    $error_details = array_merge_recursive($error_details, get_remarks_contacts_mobile_numbers($post_id, 0, 'errors') );
    $rows .= get_remarks_contacts_mobile_numbers($post_id, $row_counter++);

    // =========================
    // PHONE NUMBERS
    // =========================
    $error_details = array_merge_recursive($error_details, get_remarks_contacts_phone_number($post_id, 0, 'errors') );
    $rows .= get_remarks_contacts_phone_number($post_id, $row_counter++);

    // =========================
    // Email Address
    // =========================

    $error_details = array_merge_recursive($error_details, get_remarks_contacts_email_address($post_id, 0, 'errors') );
    $rows .= get_remarks_contacts_email_address($post_id, $row_counter++);  

      
    // =========================
    // WEBSITE URL
    // =========================
    $error_details = array_merge_recursive($error_details, get_remarks_socials_website_url($post_id, 0, 'errors') );
    $rows .= get_remarks_socials_website_url($post_id, $row_counter++);  

    // =========================
    // Facebook URL
    // =========================
     
    $error_details = array_merge_recursive($error_details, get_remarks_socials_facebook_url($post_id, 0, 'errors') );
    $rows .= get_remarks_socials_facebook_url($post_id, $row_counter++);

    // =========================
    // Facebook Date Created
    // =========================
     
    $error_details = array_merge_recursive($error_details, get_remarks_socials_facebook_date_created($post_id, 0, 'errors') );
    $rows .= get_remarks_socials_facebook_date_created($post_id, $row_counter++);


    // =========================
    // Facebook Last Active
    // =========================
    $error_details = array_merge_recursive($error_details, get_remarks_socials_facebook_last_active($post_id, 0, 'errors') );
    $rows .= get_remarks_socials_facebook_last_active($post_id, $row_counter++);

    // =========================
    // Anniversary Post
    // =========================
    $error_details = array_merge_recursive($error_details, get_remarks_socials_anniversary_post($post_id, 0, 'errors') );
    $rows .= get_remarks_socials_anniversary_post($post_id, $row_counter++);


    // =========================
    // Other Socials
    // =========================
  
    $error_details = array_merge_recursive($error_details, get_remarks_socials_other_socials($post_id, 0, 'errors') );
    $rows .= get_remarks_socials_other_socials($post_id, $row_counter++);

    // =========================
    // Address
    // =========================

    $error_details = array_merge_recursive($error_details, get_remarks_location_province($post_id, 0, 'errors'));
    $error_details = array_merge_recursive($error_details, get_remarks_location_city_municipality($post_id, 0, 'errors'));
    $error_details = array_merge_recursive($error_details, get_remarks_location_barangay($post_id, 0, 'errors'));
    $error_details = array_merge_recursive($error_details, get_remarks_location_full_address($post_id, 0, 'errors'));

    $rows .= get_remarks_location_province($post_id, $row_counter++);
    $rows .= get_remarks_location_city_municipality($post_id, $row_counter++);
    $rows .= get_remarks_location_barangay($post_id, $row_counter++);
    $rows .= get_remarks_location_full_address($post_id, $row_counter++);

    // =========================
    // Location Directions
      // =========================

    $error_details = array_merge_recursive($error_details, get_remarks_location_directions($post_id, 0, 'errors') );
    $rows .= get_remarks_location_directions($post_id, $row_counter++);


    // =========================
    // Landmark
    // =========================
    $error_details = array_merge_recursive($error_details, get_remarks_location_landmarks($post_id, 0, 'errors') );
    $rows .= get_remarks_location_landmarks($post_id, $row_counter++);
    

    // =========================
    // Testimonial
    // =========================

    $error_details = array_merge_recursive($error_details, get_remarks_testimonials($post_id, 0, 'errors') );
    $rows .= get_remarks_testimonials($post_id, $row_counter++);
   
    // =========================
    // Office Images
    // =========================

    $error_details = array_merge_recursive($error_details, get_remarks_images_office_images($post_id, 0, 'errors') );
    $rows .= get_remarks_images_office_images($post_id, $row_counter++);
   
    // =========================
    // Team Images
    // =========================

    $error_details = array_merge_recursive($error_details, get_remarks_images_team_images($post_id, 0, 'errors') );
    $rows .= get_remarks_images_team_images($post_id, $row_counter++);
   
    // =========================
    // Our Team
    // =========================

    $error_details = array_merge_recursive($error_details, get_remarks_our_team($post_id, 0, 'errors') );
    $rows .= get_remarks_our_team($post_id, $row_counter++);   

    // =========================
    // All Policies
    // =========================

    $error_details = array_merge_recursive($error_details, get_remarks_all_policies($post_id, 0, 'errors') );
    $rows .= get_remarks_all_policies($post_id, $row_counter++);

    
     // =========================
     // RETURN MODES
     // =========================

    $all_notes = get_field('all_notes', $post_id);
    $all_notes = is_array($all_notes) ? $all_notes : [];

    $error_details = is_array($error_details) ? $error_details : [];

    // Ensure each value is countable
    $variable_one = array_map(function ($item) {
        return is_array($item) ? count($item) : 0;
    }, $error_details);

    // Extract categories safely
    $categories = array_map(function ($item) {
        return is_array($item) && isset($item['category']) ? $item['category'] : null;
    }, $all_notes);

    // Remove null values
    $categories = array_filter($categories, function ($val) {
        return !is_null($val);
    });

    // Count occurrences
    $counts_two = array_count_values($categories);

    $total_fix = 0;
    $remaining_errors = [];

    foreach ($variable_one as $key => $expected_count) {
        $expected_count = (int) $expected_count;
        $actual_count   = isset($counts_two[$key]) ? (int) $counts_two[$key] : 0;

        // matched (fixed)
        $matched = min($actual_count, $expected_count);

        // remaining (not fixed)
        $remaining = $expected_count - $matched;

        // accumulate total fixed
        $total_fix += $matched;

        // collect remaining errors
        if ($remaining > 0 && isset($error_details[$key])) {
            $remaining_errors[$key] = array_slice($error_details[$key], 0, $remaining);
        }
    }

    // $total_invalid = (( $error_details ) ? count(array_filter($error_details)) : 0);
    $total_invalid = !empty($error_details) ? array_sum(array_map('count', $error_details)) : 0;

    $total_remaining_invalid = max(0, (int)$total_invalid - $total_fix);


    // =========================
    // RETURNS
    // =========================

    if ($return === 'count') {
        return $total_invalid;
    }

    if ($return === 'remaining_invalid') {
        return $total_remaining_invalid;
    }

    if ($return === 'fixed') {
        return $total_fix;
    }

    if ($return === 'error_details') {
        return $error_details;
    }

    if ($return === 'remaining_error_details') {
        return $remaining_errors;
    }

    if ($return === 'data') {
        return [
            'invalid' => $total_invalid,
            'errors'  => $error_details
        ];
    }

     // Default: HTML
     ob_start();
     ?>
     <section class="">
         <div class="container">
             <div class="row align-items-center gy-4">
                 <div class="col-12 col-lg-12 order-2">
                     <div class="table-responsive">
                         <table class="table table-f w-100 table-striped border mb-0" style="table-layout: fixed;">
                             <colgroup>
                               <col style="width: 45px">
                               <col style="width: 230px;">
                               <col style="width: 500px">
                               <col style="width: 400px">
                               <col style="width: 300px">
                             </colgroup>
                             <tr>
                                 <th>#</th>
                                 <th>Input</th>
                                 <th>Value</th>
                                 <th>Remarks</th>
                                 <th >Notes</th>
                             </tr>
                             <?php echo $rows; ?>
                         </table>
                     </div>
                 </div>
                 <div class="col-12 col-lg-12 order-1 ">

                     <?php $entry_remarks_your_notes = get_field('entry_remarks_your_notes', $post_id); ?>

                     <?php $post_permalink = get_permalink() . "?preview"; ?>
                     <?php  $is_current_administrator = current_user_can('administrator'); ?>
                     <?php if($is_current_administrator): ?>
                         <h2 class="h3 mb-0"><a href="<?php echo  $post_permalink; ?>"  target="_blank"><?php  the_title(); ?></a></h2>
                     <?php else: ?>
                         <h2 class="h3 mb-0"><?php  the_title(); ?></h2>
                     <?php endif; ?>

                     <?php $author_fullname = get_the_author_meta('display_name'); ?>
                     <?php $author_first_name = get_the_author_meta('first_name'); ?>
                     <?php $author_last_name = get_the_author_meta('last_name'); ?>
                     <?php $author_nickname = get_the_author_meta('nickname'); ?>
                     <?php $author_ID = get_the_author_meta('ID'); ?>
                     <?php $avatar_url = get_avatar_url($author_ID); ?>
                     <?php $author_email = get_the_author_meta('user_email'); ?>
                     <?php $author_website = get_the_author_meta('user_url'); ?>
                     <?php $author_permalink = get_author_posts_url($author_ID); ?>
                     <?php $author_overview = $page_link . "?user=" . $author_ID; ?>

                     <p>Prepared by <a href="<?php echo $author_overview; ?>" title="<?php echo $author_email; ?>" style="background-image: url('<?php echo $avatar_url; ?>');" class="ratio overview-user ratio-1x1  general-image general-image-agent d-inline-block align-middle" ></a> <?php echo $author_nickname; ?></p>

                     <div class="bg-light border p-4 text-center">
                         <div class="row align-items-center  gy-3">
                             <div class="col-12 ">
                                
                                 <div class="row row-cols">
                                     <div class="col text-center fw-bold text-danger">
                                        <h1 class="fw-bold  mb-0 text-danger">
                                            <?php echo $total_invalid; ?>
                                        </h1>
                                        <span class=" ">Pending Remarks</span>
                                     </div>
                                    <div class="col text-center fw-bold  text-primary">
                                       <h1 class="fw-bold text-primary">
                                           <?php echo $total_fix; ?>
                                       </h1>
                                       Total Remarks
                                    </div> 
                                 </div>
                             </div>
            
                         </div>  
                     </div>

                     <?php $acf_images = get_field('images_logo', get_the_ID()); ?>

                  
                     <?php if($acf_images): ?>
                         <?php $image_full = wp_get_attachment_image_url($acf_images,"thumbnail", false); ?>
                    
                         <?php $acf_styling_options_primary_color = get_field('styling_options_primary_color', get_the_ID()); ?>
                         <?php $acf_styling_options_secondary_color = get_field('styling_options_secondary_color', get_the_ID()); ?>
                         <?php $acf_styling_options_background_color = get_field('styling_options_background_color', get_the_ID()); ?>
                        <div class="dentist-logo mt-2">
                            <div class="website-banner-avatar" style="background-image: url('<?php echo $image_full; ?>');border-color: <?php echo $acf_styling_options_background_color; ?>"></div>
                            
                            <div class="dentist-color dentist-color-first" style="background-color: <?php echo $acf_styling_options_primary_color; ?>;">
                                <span class="dentist-color-text">
                                    <?php echo $acf_styling_options_primary_color; ?>
                                </span>
                            </div>
                            <div class="dentist-color dentist-color-second" style="background-color: <?php echo $acf_styling_options_secondary_color; ?>;">
                                <span class="dentist-color-text">
                                    <?php echo $acf_styling_options_secondary_color; ?>
                                </span>
                            </div>
                            <div class="dentist-color dentist-color-third" style="background-color: <?php echo $acf_styling_options_background_color; ?>;">
                                <span class="dentist-color-text">
                                    <?php echo $acf_styling_options_background_color; ?>
                                </span>
                            </div>
                        </div>
                     <?php endif; ?>

                 </div>
             </div>
             

             
         </div>
     </section>
     <?php
     return ob_get_clean();


    
}