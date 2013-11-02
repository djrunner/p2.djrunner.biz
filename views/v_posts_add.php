<div class="mainBox" id="posts_add">

<form method='POST' action='/posts/p_add'>

	<label for='content'>New Post:</label><br>
	<textarea name='content' id='content' rows="9" cols="60"></textarea>

	<br><br>
	<input type='submit' value='New post'>

	<?php if(isset($error)): ?>
        <div class='error'>
        </br>
            The Text field is empty, please enter text.
        </div>
        <br>
    <?php endif; ?>

</form>

</div>