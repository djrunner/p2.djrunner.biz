<div id="profile">

<h1>This is the profile of <?=$user->first_name?></h1>

<h3>E-mail Address: <?=$user->email?></h3>

<p>
	Picture!</br>
	
	<form method="POST" action="/users/upload_image" enctype="multipart/form-data">
		<label for="file">Filename:</label>
		<input type="file" name="file" id="file"><br>
		<input type="submit" name="submit" value="Submit">
	</form>

	<img src="../<?=$user->image_location?>" width="200" height="200" alt="profile_pic">
</p>

</div>