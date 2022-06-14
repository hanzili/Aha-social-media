<?php
class Post{
    private $user_obj;
    private $con;

    public function __construct($con, $user) {
        $this->con = $con;
        // create the User obj when creating its Post obj
        $this->user_obj = new User($con, $user);
    }

    // content： body  the person who send this post: user_to
    public function submitPost($body, $user_to) {
        // filter the content
        $body = strip_tags($body); //remove html tags
        $body = mysqli_real_escape_string($this->con, $body);
        $body = str_replace('\r\n','\n', $body);
        $body = nl2br($body); // replace newline with line break
        $check_empty = preg_replace('/\s+/', '',$body); // delete any space
 
        if($check_empty != "") {
            $date_added = date("Y-m-d H:i:s"); // current date and time
            $added_by = $this->user_obj->getUsername();
            // if the user sending the message is hiself or herself
            if ($user_to == $added_by) {
                $user_to = "none";
            }
            //insert the post
            $query = mysqli_query($this->con, "INSERT INTO posts VALUES('','$body','$added_by', '$user_to', '$date_added', 'no','no', '0')");
            $returned_id = mysqli_insert_id($this->con);
            // insert notification
            //update post counts for user_to
            $num_posts = $this->user_obj->getNumPosts();
            $num_posts++;
            $update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");
        }
    }
}

    
?>