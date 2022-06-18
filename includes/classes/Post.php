<?php
class Post{
    private $user_obj; // the user that the post is sent to
    private $con; // database of posts

    public function __construct($con, $user) {
        $this->con = $con;
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

    public function loadPostsFriends() {
        $str = "";
        $data = mysqli_query($this->con, "SELECT * FROM posts WHERE deleted='no' ORDER BY id DESC"); // fetch the post in decending order
        while ($row = mysqli_fetch_array($data)) { // get the row line by line
            $id = $row['id'];
            $body = $row['body'];
            $added_by = $row['added_by'];
            $date_time = $row['date_added'];

            if ($row['user_to'] == "none") {
                $user_to = "";
            } else { 
                // when the add_by and user_to are two different users 
                $user_to_obj = new User($con, $row['user_to']); // create the user obj itself
                $user_to_name = $user_to_obj->getFirstAndLastName();
                $user_to = " to <a href='" . $row['user_to'] . "'>" . $user_to_name . "</a>"; // create a link
            }

            $added_by_obj = new User($this->con, $added_by); // get the user that add this post
            // NOTE: it is fine to create more than one user object, becasue we are just creating a link to the database to get the user information
            // check if user who posted , has their account closed
            if ($added_by_obj->isClosed()) {
                continue; // skip this post if the user is closed
            }

            $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
            $user_row = mysqli_fetch_array($user_details_query);
            $first_name = $user_row['first_name'];
            $last_name = $user_row['last_name'];
            $profile_pic = $user_row['profile_pic'];

            //Timeframe
            $time_message="";
            $date_time_now = date("Y-m-d H:i:s");
            $start_date = new DateTime($date_time);
            $end_date = new DateTime($date_time_now);
            $Interval = $start_date->diff($end_date);
            if ($Interval->y >= 1) { // the post is at least a year old
                if($Interval == 1){
                    $time_message = $Interval-> y . " year ago";
                }
                else {
                    $time_message = $Interval->y . " years ago";
                }   
            } 
            else if ($Interval-> m >= 1) { // the post is at least a month old
                if ($Interval->d == 0) {
                    $days = " ago";
                    }    
                else if ($Interval->d == 1) {
                        $days = $Interval->d . " day ago";
                    } else {
                        $day = $Interval->d . " days ago";
                    }

                if ($Interval->m == 1) {
                    $time_message = $Interval->m . " month" . $days;
                }  
                else {
                    $time_message = $Interval->m . " months" . $days;       
                }        
            } 
            else if ($Interval->d >= 1) {
                if ($Interval->d == 1) {
                    $time_message = "Yesterday";
                }
                else {
                    $time_message = $Interval->d . " days ago";
                }
            }
            else if ($Interval-> h >= 1) {
                if ($Interval->h == 1) {
                    $time_message = $Interval->h . " hour ago";
                }
                else {
                    $time_message = $Interval->h . " hours ago";
                }
            }
            else if ($Interval-> i >= 1) {
                if ($Interval-> i == 1) {
                    $time_message = $Interval->i . " minute ago";
                }
                else {
                    $time_message = $Interval->i . " minutes ago";
                }
            }
            else if ($Interval-> s >= 1) {
                if ($Interval-> s < 30) {
                    $time_message = "Just now";
                }
                else {
                    $time_message = $Interval->s . " seconds ago";
                }
            }

            $str .= 
            "<div class='status_post'>
                        <div class='post_profile_pic'>
                            <img src='$profile_pic' width='50'>
                        </div>

                        <div class='posted_by' style='color:#ACACAC;'>
                            <a href='$added_by'> $first_name $last_name </a> $user_to &nbsp;&nbsp;&nbsp;&nbsp;
                                $time_message
                        </div>
                        <div id='post_body'>
                            $body
                            <br>
                        </div>                 
            </div>
            ";
            
        }
        echo $str;

    }
}

    
?>