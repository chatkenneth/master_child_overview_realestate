


<?php
if (isset($_GET['paged'])) {
    $paged = intval($_GET['paged']); // Get the 'paged' parameter and ensure it's an integer
} else {
    $paged = 1; // Default to page 1 if not set
}

if (isset($_GET['posts_per_page'])) {
    $posts_per_page = intval($_GET['posts_per_page']); // Get the 'posts_per_page' parameter and ensure it's an integer
} else {
    $posts_per_page = 1; // Default to page 1 if not set
}




# Parameter
$output_date_args = array (
    'post_type' => array( 'post', ),
    'posts_per_page'  => $posts_per_page,  # -1 for all
    'order'   => 'DESC',  # Newest
    'orderby' => 'date',  # 'rand' 'post__in'
    'paged'  => $paged,  # For Pagination
);

if (isset($_GET['post_search'])) {
    $post_search =  $_GET['post_search'];
    if ($post_search != "") {
        $output_date_args['s'] = $post_search;
    }
}

if (isset($_GET['post_exlude'])) {
    $post_exlude =  $_GET['post_exlude'];
    if ($post_exlude != "") {
        $output_date_args['post__not_in'] = array($post_exlude);
    }
}

if (isset($_GET['post_category'])) {
    // Convert the comma-separated string back into an array
    $post_category =  $_GET['post_category'];

    if ($post_category != "") {
        $category_ids = explode(',', $_GET['post_category']);
        $category_ids = array_map('intval', $category_ids);

        $output_date_args['category__in'] = $category_ids;
    }
}


# Connect Loop to Parameter
$output_date_query = new WP_Query( $output_date_args );

# For Pagination Issue (Optional)
$temp_query = $wp_query;
$wp_query   = NULL;
$wp_query   = $output_date_query;
?>

<?php
# Loop
if ( $output_date_query->have_posts() ) : ?>

    <?php $total_posts = $output_date_query->found_posts; ?>
    <?php $displayed_posts = $posts_per_page * $paged; ?>

  <?php if(isset($_GET["test"])): ?>
     <div class="container py-5 ">
         <div class="row g-4">
  <?php endif; ?>
          <?php while ( $output_date_query->have_posts() ) : $output_date_query->the_post(); ?>
              <div class="col-12 col-lg-4">
                 <?php # Template Part | Footer CTA
                 get_template_part('template-parts/content-each-blog'); ?>
              </div>
          <?php endwhile; ?>

          <?php  echo rs_loadmore(
              $displayed_posts = $displayed_posts, 
              $total_posts = $total_posts,
              $posts_per_page = $posts_per_page, 
              $paged = $paged, 
              $post_exlude = $post_exlude,
              $post_search = $post_search,
              $post_category = $category_ids
          ) ?>


     <?php if(isset($_GET["test"])): ?>
           </div>
       </div>
    <?php endif; ?>



<?php endif; ?>

<?php wp_reset_query(); ?>  

 

