<?php

if(!defined("PROJECT_HTML_FOLDER")) require_once("../project/project.inc");
require_once(PROJECT_HTML_FOLDER."inc/util.inc");
require_once(PROJECT_HTML_FOLDER."inc/email.inc");


define('MASTER_URL', $master_url);

// send an email to admins:
// - project forums: everyone in POST_REPORT_EMAILS
// - team message board: team founder and admins
//
function mail_report_list($forum, $subject, $body, $must_send=false) {
    $success = true;
    switch ($forum->parent_type) {
    case 0:
        if ($must_send && !defined("POST_REPORT_EMAILS")) {
            echo "This project has not yet defined an administrator to
                handle this kind of forum report.
                Please contact the project and tell them to add this information
                in their html/project/project.inc file
            ";
        }
        $emails = explode("|", POST_REPORT_EMAILS);
        foreach ($emails as $email) {
            $admin->email_addr = $email;
            if (!send_email($admin, $subject, $body)) {
                $success = false;
            }
        }
        break;
    case 1:
        $team = BoincTeam::lookup_id($forum->category);
        $founder = BoincUser::lookup_id($team->userid);
        $success = send_email($founder, $subject, $body);
        $admins = BoincTeamAdmin::enum("teamid=$team->id");
        foreach ($admins as $admin) {
            $u = BoincUser::lookup_id($admin->userid);
            $success &= send_email($u, $subject, $body);
        }
        break;
    }
    return $success;
}

//////////////////// post hidden/unhidden ///////////
//
function send_moderation_email($forum, $post, $thread, $explanation, $action) {
    $moderator=get_logged_in_user();
    $body = "";
    $user = BoincUser::lookup_id($post->user);

    $subject = PROJECT." moderation notice";

    $body = "Your post [ID $post->id] in thread \"$thread->title\"
".URL_BASE."community/forum/thread.php?id=$thread->id#$post->id
has been $action by moderator $moderator->name (ID $moderator->id).
$explanation

The content of your post:
".$post->content."

For further information and assistance with ".PROJECT." go to ".MASTER_URL;

    $success = send_email($user, $subject, $body);

    $body = "Because of moderation by $moderator->name (ID $moderator->id),
The following email was sent to $user->name (ID $user->id)
".URL_BASE."community/forum/user_posts.php?userid=$user->id
------------------------------
Subject: $subject

$body
";
    $subject = PROJECT.": post $action in \"$thread->title\"";
    $success &= mail_report_list($forum, $subject, $body);
    return $success;
}

//////////////////// thread hidden/unhidden ///////////
//
function send_thread_moderation_email($forum, $thread, $message, $action) {
    $moderator=get_logged_in_user();
    $user = BoincUser::lookup_id($thread->owner);
    $body = "";

    $subject = PROJECT." forum moderation notice";
    $body = PROJECT." notification:

This email is sent to inform you that one of your threads in the forum has been affected by moderation in ".PROJECT.":
    Thread:         ".$thread->title."
    Link:           ".MASTER_URL."community/forum/thread.php?id=".$thread->id."
    Moderator:      ".$moderator->name." (".$moderator->id.")
    Action:         ".$action."

The moderator gave this explanation to why your thread was moderated:
".$message;
$body .= "

For further information and assistance with ".PROJECT." go to ".MASTER_URL;

    $success = mail_report_list($forum, "THREAD ".$action." REPORT: ".$thread->title, $body);
    $success &= send_email($user, $subject, $body);
    return $success;
}

// If a user is subscribed to a thread that is replied to,
// send them an email notifying them of the reply.
//
function send_reply_notification_email($thread, $user){
    $title = PROJECT . ": A user has posted to '". stripslashes($thread->title) ."'";
    $link = URL_BASE . "community/forum/thread.php?id=" . $thread->id;
    $body = "Another " . PROJECT . " user has posted to the thread
\"" . stripslashes($thread->title) . "\".\n"
           ."To view the updated thread, visit:\n$link

--------------------------
To change email preferences, visit:
".URL_BASE."account/edit_forum_preferences_form.php
Do not reply to this message.
";
    return send_email($user, $title, $body);
}

//////////////////// a user clicks the red "x" to report a post ///////////
//
function send_report_post_email($user, $forum, $thread,  $post, $message) {
    $body = "";
    $owner = BoincUser::lookup_id($post->user);

    $subject = PROJECT." post in '".$thread->title."' reported as offensive";
    $body = PROJECT." notification:

This email is sent to inform you that one of the posts in the forum was reported as offensive in ".PROJECT.":
    Thread:         ".$thread->title."
    Post:           ".$post->id." by ".$owner->id." (".$owner->name.")
    Reporting User: ".$user->id." (".$user->name.")
    Link:           ".URL_BASE."community/forum/thread.php?id=".$thread->id."#".$post->id."
    
The reporting user gave this explanation to why the post was reported:
".$message."

This was the contents of the post:
".$post->content."

For further information and assistance with ".PROJECT." go to ".MASTER_URL;

    $success = mail_report_list($forum, $subject, $body, true);

    // if it's a forum board, send to project admins too
    //
    if ($forum->parent_type != 0) {
        $forum = new BoincForum;
        $forum->parent_type = 0;
        $success &= mail_report_list($forum, $subject, $body, true);
    }
    return $success;
}

//////////////////// a user has been banished ///////////
//
function send_banish_email($forum, $user, $duration, $reason) {
    $subject = PROJECT." posting privileges suspended";
    $body = "
This email is to inform you that you will not be able to
post to the ".PROJECT." message boards until ".date('M j, Y G:i', $duration).",
because your postings have not followed our guidelines.
    ";
    if ($reason) {
        $body .= "\n\nThe moderator gave the following explanation about your suspension:\n";
        $body .= $reason;
    }
    $success = mail_report_list($forum, $user->name." has been banished.", $body);
    $success &= send_email($user, $subject, $body);
    return $success;
}

//////////////////// a banishment vote has been started  ///////////
//
function send_banish_vote_email($user, $duration, $reason, $end_time) {
    $now=time();
    $subject = PROJECT." banishment vote underway";
    $vote_url=parse_config(get_config(), "<master_url>")."community/forum/banishment_vote.php";
    $body = "
This email if to inform you that a vote has been started
regarding your banishment from the ".PROJECT." message boards until ".date('M j,
Y G:i', $duration+$now).",
because your postings have not followed our guidelines.

This vote will be underway until ".date('M j, Y G:i',$end_time)." or until a majority
decision has been reached.  If the vote does not result in banishment, you will be
able to resume posting at that time.
    ";
    if ($reason) {
        $body .= "\n\nThe moderator gave the following reason for your pending suspension:\n";
        $body .= $reason;
    }
    $success = send_email($user, $subject, $body);

    $body .= "\n\n<a href=".$vote_url."?action=yes&userid="
             .$user->id
           .">[vote to banish author]</a>\n\n"
           ."<a href=".$vote_url."?action=no&userid="
             .$user->id
           .">[vote not to banish author]</a>";

    $forum = new BoincForum;
    $forum->parent_type = 0;
    $success &= mail_report_list($forum, "A banishment vote for ".$user->name." has been started.", $body);
    return $success;
}

?>
