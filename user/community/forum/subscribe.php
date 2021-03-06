<?php

// This file allows people to subscribe to threads.
// Whenever someone posts to the thread
// the subscribers will receive a notification email
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT'].'/../inc/forum.inc');

$action = get_str('action');
$threadid = get_int('thread');
$thread = BoincThread::lookup_id($threadid);
$forum = BoincForum::lookup_id($thread->forum);

function show_title($forum, $thread) {
    switch ($forum->parent_type) {
    case 0:
        $category = BoincCategory::lookup_id($forum->category);
        show_forum_title($category, $forum, $thread);
        break;
    case 1:
        show_team_forum_title($forum, $thread);
        break;
    }
}

function subscribe($forum, $thread, $user) {
    if (BoincSubscription::replace($user->id, $thread->id)) {
        display_page_top("Subscription successful");
        show_forum_header($user);
        show_title($forum, $thread);
        echo "<p>You are now subscribed to <b>", cleanup_title($thread->title), "</b>.
        You will be notified whenever there is a new post.";
    } else {
        display_page_top("Subscription failed");
        echo "<p>We are currently unable to subscribe you to this thread (<b>", cleanup_title($thread->title), "</b>).
        Please try again later..";
    }
    echo "</p><p><br /><a href=\"/community/forum/thread.php?id=".$thread->id."\">Return to thread</a></p>";
    display_page_bottom();
}

function unsubscribe($forum, $thread, $user) {
    BoincSubscription::delete($user->id, $thread->id);
    if (!BoincSubscription::lookup($user->id, $thread->id)) {
        display_page_top("Unsubscription successful");
        show_forum_header($user);
        show_title($forum, $thread);
        echo "<p>You are no longer subscribed to <b>", cleanup_title($thread->title), "</b>.
        You will no longer receive notifications for this thread.";
    } else {
        display_page_top("Unsubscription failed");
        echo "<p>We are currently unable to unsubscribe you to this thread (<b>", cleanup_title($thread->title), "</b>).
        Please try again later..";
    }
    echo "</p><p><br /><a href=\"/community/forum/thread.php?id=".$thread->id."\">Return to thread</a></p>";
    display_page_bottom();
}

if (!$thread || !$action) {
    error_page("Unknown subscription action");
}

$user = get_logged_in_user();
check_tokens($user->authenticator);

if ($action == "subscribe") {
    subscribe($forum, $thread, $user);
    exit();
} else if ($action == "unsubscribe") {
    unsubscribe($forum, $thread, $user);
    exit();
}

?>

