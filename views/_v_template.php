<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($title)) echo $title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
					
	<!-- Controller Specific JS/CSS -->
	<?php if(isset($client_files_head)) echo $client_files_head; ?>
	
</head> 

<body>	

	<div id='v_template_menu'>

		<a href='/'>Home</a><br>

		<!-- Menu for users who ar logged in -->
		<?php if($user): ?>

			<a href='/users/logout'>Logout</a><br>
			<a href='/users/Profile'>Profile</a><br>
			<a href='/posts/index'>See Posts</a><br>
			<a href='/posts/add'>Add Posts</a><br>
			<a href='/posts/users'>See Users</a><br>

		<!-- Menu options for users who are not logged in -->
		<?php else: ?>

            <a href='/users/signup'>Sign up</a><br>
            <a href='/users/login'>Log in</a><br>

        <?php endif; ?>

    </div>

    <br>

	<?php if(isset($content)) echo $content; ?>

	<?php if(isset($client_files_body)) echo $client_files_body; ?>
</body>
</html>