<?php


require_once dirname(__DIR__, 4) . '/wp-load.php';

// Allow only HTMX requests
if (empty($_SERVER['HTTP_HX_REQUEST'])) {
    wp_die('Unauthorized access');
}

$htmx_template = $_POST["template"];

switch ($htmx_template) {
    case 'check_each_remarks':
        echo get_template_part('htmx/data/data-check_each_remarks');;
        break;   

    case 'check_total_remarks':
        echo get_template_part('htmx/data/data-check_total_remarks');;
        break;

    case 'update_blog_fields':
        echo get_template_part('htmx/data/data-update_blog_fields');;
        break;     
           
    case 'update_facebook_like':
        echo get_template_part('htmx/data/data-update_facebook_like');;
        break;


    default:
        echo 'This is something else.';
        break;
}
