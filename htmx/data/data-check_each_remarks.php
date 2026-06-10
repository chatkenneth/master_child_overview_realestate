<div class="general-remarks">
    <?php $current_id = $_POST["current_id"]; ?>
    <?php $get_post_status = $_POST["current_status"]; ?>
    <?php $all_notes = get_field('all_notes', $current_id); ?>
    <?php $post_permalink_inputs = get_permalink($current_id) . "?inputs"; ?>

    <?php $total_invalid = validate_clinic_data($current_id, 'count');; ?>
    <?php $total_fixed = validate_clinic_data($current_id, 'fixed');; ?>
    <?php $total_remaining_invalid = validate_clinic_data($current_id, 'remaining_invalid');; ?>
    <?php $total_remaining_error_details = validate_clinic_data($current_id, 'remaining_error_details');; ?>

    <?php if($get_post_status == "publish"): ?>
       <?php if($total_invalid): ?>
          <?php $grand_total_remarks = $total_invalid + $grand_total_remarks ?>
          <?php $grand_total_fixed = $total_fixed + $grand_total_fixed ?>
          <?php $grand_total_remaining_invalid = $total_remaining_invalid + $grand_total_remaining_invalid ?>
          <?php if($total_fixed == $total_invalid): ?>
              
              
                 <?php if($all_notes): ?>
                 <div class="general-remarks-content general-remarks-left">
                     <p>
                         <?php foreach($all_notes as $all_notes_ctr => $each_note): ?>
                            <span class="fw-bold">[<?php echo $each_note["category"]; ?>]</span> - <?php echo $each_note["value"]; ?><br>
                         <?php endforeach; ?>
                     </p>
                 </div>
                 <?php endif; ?>

                  <span href="<?php echo $post_permalink_inputs; ?>"  target="_blank" class="text-primary fw-bold remarks-link">
                       <?php echo "$total_invalid Notes"; ?>
                   </span> 
              


          <?php else: ?>

              <?php if($total_remaining_error_details): ?>
              <div class="general-remarks-content general-remarks-left general-remarks-warning">
                  <p>
                      <?php foreach($total_remaining_error_details as $all_remaining_error_details => $each_remaining_error_details): ?>
                            <?php if($each_remaining_error_details): ?>
                               <?php foreach($each_remaining_error_details as $all_eacg_each_remaining): ?>
                            
                                  - <span class="fw-bold">[<?php echo $all_remaining_error_details; ?>]</span> <?php echo str_replace('_', ' ', $all_eacg_each_remaining); ?><br>
                                  
                               <?php endforeach; ?>
                            <?php endif; ?>
                      <?php endforeach; ?>

                  </p>
              </div>
              <?php endif; ?>

              <span href="<?php echo $post_permalink_inputs; ?>"  target="_blank" class="text-danger fw-bold remarks-link" style="cursor: context-menu">
                   <?php echo "$total_remaining_invalid Pending"; ?> 
               </span> 

          <?php endif; ?>
       <?php else: ?>
           <span href="<?php echo $post_permalink_inputs; ?>"  target="_blank" class="" style="cursor: context-menu">
               [All Good]
           </span> 
       <?php endif; ?>
    <?php else: ?>
       <span href="<?php echo $post_permalink_inputs; ?>"  target="_blank" class="" style="cursor: context-menu">
           —
       </span> 
    <?php endif; ?>
</div>
