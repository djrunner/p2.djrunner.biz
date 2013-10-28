<?php foreach($posts as $post): ?>

<article>

    <h1><?=$post['first_name']?> <?=$post['last_name']?> posted:</h1>

    <img src="../<?=$post['image_location']?>" width="100" height="100" alt="profile_pic">

    <p><?=$post['content']?></p>

    <time datetime="<?=Time::display($post['created'],'Y-m-d G:i')?>">
        <?=Time::display($post['created'])?>
    </time>

    <?php if(isset($users_posts['awkward'])): ?>
		<p>worked!</p>


	<!-- Otherwise, show the follow link -->
	<?php else: ?>
		<a href='/posts/awkward/<?=$post['post_id']?>'>Mark as Awkward</a>
	<?php endif; ?>

</article>

<?php endforeach; ?>