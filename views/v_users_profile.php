<div class="mainBox" id="profile">

<h1>This is the profile of <?=$user->first_name?></h1>

<h3>E-mail Address: <?=$user->email?></h3>

<p>
	</br>
	
	<form method="POST" action="/users/upload_image" enctype="multipart/form-data">
		<label for="file">Filename:</label>
		<input type="file" name="file" id="file"><br>
		<input type="submit" name="submit" value="Submit">
	</form>

	<br>

	<?php if(isset($user->image_location)): ?>
		<img src="../<?=$user->image_location?>" width="150" height="150" alt="profile_pic">
	<?php else: ?>
		<p>Add a photo!</p>
	<?php endif; ?>

	
</p>

</div>