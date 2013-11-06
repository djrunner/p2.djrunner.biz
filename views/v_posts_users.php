<div class="mainBox" id="posts_users">

	<?php foreach($users as $user): ?>

    	<div id="posts_users_inside">

		<!-- Show user's profile pic -->
		<?php if(isset($user['image_location'])): ?>
		   <img src="../<?=$user['image_location']?>" width="50" height="50" alt="profile_pic">
	    <?php else: ?>
		   <img src="/images/nophoto.jpg" width="50" height="50" alt="no_photo">
	    <?php endif; ?>

		<!-- Print this user's name -->
		<?=$user['first_name']?> <?=$user['last_name']?>

		<br>


		<!-- If there exists a connection with this user, show a unfollow link -->
		<?php if(isset($connections[$user['user_id']])): ?>
			<a href='/posts/unfollow/<?=$user['user_id']?>'>Unfollow</a>


		<!-- Otherwise, show the follow link -->
		<?php else: ?>
			<a href='/posts/follow/<?=$user['user_id']?>'>Follow</a>
		<?php endif; ?>

		<br><br>

		

		</div>

	<?php endforeach; ?>

</div>