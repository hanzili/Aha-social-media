<?php
include("includes/header.php");
include("includes/classes/User.php");
include("includes/classes/Post.php");

// the page will refresh when you lick the post button
if (isset($_POST['post'])) {
    $post = new Post($con,$userLoggedIn);
    $post->submitPost($_POST['post_text'], 'none');
    header("Location: index.php");
}
//session_destroy(); // reset all session variables
?>
    <div class="user_details column">
        <a href="<?php echo $userLoggedIn; ?>"><img src="<?php echo $user['profile_pic']; ?>"></a>
        <div class="user_figure">
            <span><a href="<?php echo $userLoggedIn; ?>"><?php echo $user['first_name'] . " " . $user['last_name'];?></a></span>
            <span><?php echo "Posts: " . $user['num_posts'];?></span>
            <span><?php echo "Likes: " .  $user['num_likes'];?></span>
        </div>
    </div>

    <div class="main_column column" id="main_column">
        <form class="post_form" action="index.php" method="POST">
            <textarea name="post_text" id="post_text" placeholder="Hey, <?php echo $user['first_name']?>! What stood-out about today?"></textarea>
            <input type="submit" name="post" id="post_button" value="Post" class="btn btn-warning">
        </form>

        <?php
        $post = new Post($con, $userLoggedIn);
        $post->loadPostsFriends();
        ?>

    </div>

    </div>
</body>
</html>