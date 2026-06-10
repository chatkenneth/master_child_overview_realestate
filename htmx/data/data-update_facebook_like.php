<?php

$current_id =  $_POST["current_id"];
?>

<?php $acf_admin_facebook_like = get_field('admin_facebook_like', $current_id); ?>
<?php $like_value = (( $acf_admin_facebook_like ) ? false : true) ?>


<?php update_field('admin_facebook_like', $like_value, $current_id); ?>

<?php if($like_value): ?>
	<i class="fa-solid fa-thumbs-up fa-fw "></i>
<?php else: ?>
	<i class="fa-regular fa-thumbs-up fa-fw "></i>
<?php endif; ?>