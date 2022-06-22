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
            <input type="submit" name="post" id="post_button" value="Post" class="shadow_button">
        </form>


        <div class="posts_area"></div>
        <img id="loading" width="50vh" src="includes\images\icons\loading.gif">

    </div>

    <script>

        $(function(){
            var userLoggedIn = '<?php echo $userLoggedIn; ?>';
            var inProgress = false;
            loadPosts(); //Load first posts
            $(window).scroll(function() {
                var bottomElement = $(".status_post").last();
                var noMorePosts = $('.posts_area').find('.noMorePosts').val();
                // isElementInViewport uses getBoundingClientRect(), which requires the HTML DOM object, not the jQuery object. The jQuery equivalent is using [0] as shown below.
                // when there is no  more posts and the page is at the bottom
                if (noMorePosts == 'false' && isElementInView(bottomElement[0])) {
                    loadPosts();
                }
            });
            function loadPosts() {
                if(inProgress) { //If it is already in the process of loading some posts, just return
                    return;
                }
                inProgress = true;
                $('#loading').show();
                var page = $('.posts_area').find('.nextPage').val() || 1; //If .nextPage couldn't be found, it must not be on the page yet (it must be the first time loading posts), so use the value '1'
                $.ajax({
                    url: "includes/handlers/ajax_load_posts.php",
                    type: "POST",
                    data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
                    cache:false,
                    success: function(response) {
                        $('.posts_area').find('.nextPage').remove(); //Removes current .nextpage
                        $('.posts_area').find('.noMorePosts').remove(); //Removes current .nextpage
                        $('.posts_area').find('.noMorePostsText').remove(); //Removes current .nextpage
                        $('#loading').hide();
                        $(".posts_area").append(response);
                        inProgress = false;
                    }
                });
            }
            //Check if the element is in view
            function isElementInView (el) {
                var rect = el.getBoundingClientRect();
                return (
                    rect.top >= 0 &&
                    rect.left >= 0 &&
                    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && //* or $(window).height()
                    rect.right <= (window.innerWidth || document.documentElement.clientWidth) //* or $(window).width()
                );
            }
        });

    </script>

    </div>
</body>
</html>