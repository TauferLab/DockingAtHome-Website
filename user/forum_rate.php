<?php

// This file allows people to rate posts in a thread
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT'].'/../inc/forum.inc');
require_once($_SERVER['DOCUMENT_ROOT'].'/../inc/util.inc');

$config = get_config();
if (parse_bool($config, "no_forum_rating")) {
    display_page_top("Rating offline");
    echo "This function is turned off by the project";
    display_page_bottom();
    exit(0);
}

if (!empty($_GET['post'])) {
    $postId = get_int('post');
    $choice = post_str('submit', true);
    $rating = post_int('rating', true);
    if (!$choice) $choice = get_str('choice', true);
    
    if ($choice == SOLUTION or $choice=="p") {
        $rating = 1;
    } else {
        $rating = -1;
    }

    $user = get_logged_in_user();

    if ($choice == null && ($rating == null || $rating > 2 || $rating < -2)) {
        show_result_page(false, NULL, NULL, $choice);
    }

    $post = BoincPost::lookup_id($postId);
    $thread = BoincThread::lookup_id($post->thread);
    $forum = BoincForum::lookup_id($thread->forum);

    // Make sure the user has the forum's minimum amount of RAC and total credit
    // before allowing them to rate a post.
    //
    if ($user->total_credit<$forum->rate_min_total_credit || $user->expavg_credit<$forum->rate_min_expavg_credit) {
        error_page("You need more average or total credit to rate a post.");
    }
    
    if (BoincPostRating::lookup($user->id, $post->id)) {
        error_page("You have already rated this post once.<br /><br /><a href=\"/community/forum/thread.php?nowrap=true&id=".$thread->id."#".$post->id."\">Return to thread</a>");
    } else {
        $success = BoincPostRating::replace($user->id, $post->id, $rating);
        show_result_page($success, $post, $thread, $choice);
    }
}

function show_result_page($success, $post, $thread, $choice) {
    if ($success) {
        if ($choice) {
            display_page_top('Input Recorded');
                echo "<p>Your input has been successfully recorded.  Thank you for your help.</p>";
        } else {
            display_page_top('Vote Registered');
        echo "<span class=\"title\">Vote Registered</span>";
        echo "<p>Your rating has been successfully recorded.  Thank you for your input.</p>";
        }
        echo "<a href=\"/community/forum/thread.php?nowrap=true&id=", $thread->id, "#", $post->id, "\">Return to thread</a>";
    } else {
        display_page_top('Vote Submission Problem');    
        echo "<span class=\"title\">Vote submission failed</span>";
        if ($post) {
            echo "<p>There was a problem recording your vote in our database.  Please try again later.</p>";
            echo "<a href=\"/community/forum/thread.php?id=", $thread->id, "#", $post->id, "\">Return to thread</a>";
        } else {
            echo "<p>There post you specified does not exist, or your rating was invalid.</p>";
        }
    }
    display_page_bottom();
    exit;
}

$cvs_version_tracker[]="\$Id: forum_rate.php 14160 2007-11-12 20:57:15Z davea $";  //Generated automatically - do not edit
?>
