<div class="mainBox" id="posts_index">

<?php foreach($posts as $post): ?>

<article>

    <div id="posts_index_inside">

    <h1><?=$post['first_name']?> <?=$post['last_name']?> posted:</h1>

    <?php if(isset($post['image_location'])): ?>
        <img src="../<?=$post['image_location']?>" width="100" height="100" alt="profile_pic">
    <?php else: ?>
        <img src="/images/nophoto.jpg" width="100" height="100" alt="no_photo">
    <?php endif; ?>

    <p><?=$post['content']?></p>

    <time datetime="<?=Time::display($post['created'],'Y-m-d G:i')?>">
        <?=Time::display($post['created'])?>
    </time>

    <br>

    <?php if($post['post_user_id'] == $post['follower_id']): ?>
    	<a href='/posts/p_delete/<?=$post['post_id']?>'>Delete this post</a>
	<!-- Otherwise, show the follow link -->
	<?php else: ?>
	<?php endif; ?>

    <br><br>

    </div>

</article>

<?php endforeach; ?>

</div>