<div class="mainBox" id="posts">

<?php foreach($posts as $post): ?>

<article>

    <h1><?=$post['first_name']?> <?=$post['last_name']?> posted:</h1>

    <img src="../<?=$post['image_location']?>" width="100" height="100" alt="profile_pic">

    <p><?=$post['content']?></p>

    <time datetime="<?=Time::display($post['created'],'Y-m-d G:i')?>">
        <?=Time::display($post['created'])?>
    </time>

    <?php if($post['post_user_id'] == $post['follower_id']): ?>
    	<a href='/posts/p_delete/<?=$post['post_id']?>'>Delete this post</a>
	<!-- Otherwise, show the follow link -->
	<?php else: ?>
	<?php endif; ?>

    <br><br>

</article>

<?php endforeach; ?>

</div>