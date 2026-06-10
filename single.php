<?php get_header(); ?>

<!-- Main page -->
<div id="primary" class="content-area">
   <main id="main" class="site-main py-0" role="main">
      <?php if( have_posts()):the_post(); ?>

           <?php if(false): ?>
              <section>
                  <div class="container-fluid">
                      <div class="row">
                           <div class="col-12 col-xl-8 col-xxxl-6 mx-auto">
                               <div class="bg-light border p-4 bg-white">
                                   <div class="row row-cols">
                                      <div class="col text-center ">
                                         <h1 class="">000</h1>
                                         Remarks
                                      </div>
                                   </div>
                               </div>
                           </div>
                      </div>
                  </div>
              </section>
           <?php endif; ?>

           

           <section>
               <div class="container-fluid">
                   <div class="row">
                        <div class="col-12 col-xl-8 col-xxxl-6 mx-auto">
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
                            <?php $meta_desc = get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true);; ?>
                            <?php $slug = get_post_field( 'post_name', get_post() ); ?>
                            <?php $clinic_id = get_field('dental_clinic', $post->ID); ?>

                            

                            <p class="mb-0">Prepared by <a href="<?php echo $author_overview; ?>" title="<?php echo $author_email; ?>" style="background-image: url('<?php echo $avatar_url; ?>');" class="ratio overview-user ratio-1x1  general-image general-image-agent d-inline-block align-middle" ></a> <?php echo $author_nickname; ?></p>

                            <h1 class=""><?php the_title(); ?></h1>
                            <?php if($meta_desc): ?>
                               <div>
                                   <?php echo wpautop($meta_desc); ?>
                               </div>
                            <?php endif; ?>
                            <ul class="list-unstyled ml-0 pl-0">
                                <li><a href="javascript:void(0)"><i class="fa-solid fa-link fa-fw"></i> <?php echo $slug; ?></a></li>
                                <?php if($clinic_id): ?>
                                    <?php $each_user_parameter["clinic"] = $clinic_id; ?> 
                                    <?php $author_blog = add_query_arg($each_user_parameter, get_permalink(get_page_by_path('each-clinic-blogs/')) ); ?>

                                   <li><a href="<?php echo $author_blog; ?>" target="_blank"><i class="fa-regular fa-house-chimney-medical fa-fw"></i> <?php echo get_the_title($clinic_id); ?></a></li>
                                <?php endif; ?>
                            </ul>

                            
                       </div>
                   </div>
               </div>
           </section>

           <?php $acf_source_details = get_field('source_details', get_the_ID()); ?>
           <?php if($acf_source_details): ?>
                <section class="py-4">
                    <div class="container-fluid">
                        <div class="row">
                             <div class="col-12 col-xl-8 col-xxxl-6 mx-auto">
                                 <div class="row gy-3">
                                     <?php foreach($acf_source_details as $source_details_ctr => $each_item): ?>
                                     
                                         <?php $each_item_image = ""; ?>
                                         <?php if($each_item['image']): ?>
                                            <?php $image_full = wp_get_attachment_image_url($each_item['image'],"full", false); ?>
                                            <?php $image_thumbnail = wp_get_attachment_image_url($each_item['image'],"thumbnail", false); ?>
                                             <?php $each_item_image = (( $image_thumbnail ) ?  : 'false'); ?>
                                         <?php endif; ?>
                                         <?php $each_item_content = $each_item['content']; ?>
                                         <?php $each_item_link = $each_item['link']; ?>

                                         <div class="col-12 col-lg-2">
                                            <a href="javascript:void(0)" data-caption="<?php echo $each_item_content; ?>" data-src="<?php echo $image_full; ?>" data-thumb="<?php echo $image_thumbnail; ?>" data-fancybox class="ratio ratio-1x1 general-image d-block border shadow" style="background-image: url('<?php echo $each_item_image; ?>');"></a>
                                            <div class="text-center"><a href="<?php echo $each_item_link; ?>" target="_blank">link <i class="fa-regular fa-arrow-up-right-from-square"></i></a></div>
                                         </div>
                                     
                                     <?php endforeach; ?>
                                     <?php $countr = (6 - count($acf_source_details)); ?>
                                     <?php for ($ctr_item  = 1; $ctr_item  <= $countr; $ctr_item++): ?>
                                        <div class="col-12 col-lg-2">
                                           <div  class="ratio ratio-1x1 general-image d-block border "></div>
                                        </div>
                                     <?php endfor; ?>
                                 </div>
                             </div>
                        </div>
                    </div>
                </section>
               
           <?php endif; ?>  
           

           <section>
               <div class="container-fluid ">
                  <div class="row">
                      <div class="col-12 col-xl-8 col-xxxl-6 mx-auto ">
                         <?php the_content(); ?>
                      </div>
                  </div>
               </div>
           </section>

           <section>
               <div class="container-fluid ">
                  <div class="row">
                      <div class="col-12 col-xl-8 col-xxxl-6 mx-auto">
                          <div class="row">
                              <?php for ($ctr_item  = 1; $ctr_item  <= 4; $ctr_item++): ?>
                                 <div class="col-12 col-lg-3">
                                     <a href="javascript:void(0)" class="ratio ratio-3x4 rounded-3 general-image d-block"></a>
                                 </div>
                              <?php endfor; ?>
                          </div>
                      </div>
                  </div>
               </div>
           </section>

      <?php endif; ?>
   </main>
</div>
<!-- Main page -->

<?php get_footer(); ?>