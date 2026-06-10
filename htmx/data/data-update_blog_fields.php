<?php

$current_id =  $_POST["current_id"];
?>

<?php $acf_dental_clinic = get_field('dental_clinic', $current_id); ?>
<?php $acf_source_details_link = get_field('source_details', $current_id); ?>


<?php if($acf_dental_clinic): ?>
   <?php $find_title = get_the_title($acf_dental_clinic); // change 'post' to your post type ?> 
   <?php $post = get_page_by_title($find_title, OBJECT, 'all_entries'); // change 'post' to your post type ?> 

   <?php if($post): ?>
       <?php $new_id = $post->ID; ?>
       <?php update_field('select_blog_entry', $new_id, $current_id); ?>
       <?php update_field('blog_post_link', $acf_source_details_link[0]["link"], $current_id); ?>
        <?php echo get_the_title($new_id); ?>
   <?php else: ?>
       <?php echo "FALSE"; ?>
   <?php endif; ?>
<?php endif; ?>

