<div class="mainBox" id="users_profile">

<h1>This is the profile of <?=$user->first_name?></h1>

<h3>E-mail Address: <?=$user->email?></h3>

<p>
	</br>

	<p>Add a photo!</p>
	
	<form method="POST" action="/users/upload_image" enctype="multipart/form-data">
		<label for="file">Filename:</label>
		<input type="file" name="file" id="file"><br>
		<input type="submit" name="submit" value="Submit">
	</form>

	<br>

	<?php if(isset($user->image_location)): ?>
		<img src="../<?=$user->image_location?>" width="150" height="150" alt="profile_pic">
	<?php else: ?>
		<img src="/images/nophoto.jpg" width="150" height="150" alt="no_photo">
	<?php endif; ?>

	<br>

	<?php if(isset($error)): ?>
        <div class='error'>
        </br>
            File uploaded is not an image, or image is used by another user.
        </div>
        <br>
    <?php endif; ?>

	
</p>

</div>