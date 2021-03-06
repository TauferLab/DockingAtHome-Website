<?php

// Forum index
// shows the categories and the forums in each category
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT'].'/../inc/forum.inc');
require_once($_SERVER['DOCUMENT_ROOT'].'/../inc/pm.inc');
require_once($_SERVER['DOCUMENT_ROOT'].'/../inc/time.inc');


$user = get_logged_in_user(false);

// Process request to mark all posts as read
//
if ((get_int("read", true) == 1)) {
    if ($user) {
        check_tokens($user->authenticator);
        BoincForumPrefs::lookup($user);
        $now = time();
        $user->prefs->update("mark_as_read_timestamp=$now");
        Header("Location: ".get_str("return", true));
    }
}

function show_forum_summary($forum) {
    switch ($forum->parent_type) {
    case 0:
        $t = $forum->title;
        $d = $forum->description;
        break;
    case 1:
        $team = BoincTeam::lookup_id($forum->category);
        $t = $forum->title;
        if (!strlen($t)) $t = $team->name;
        $d = $forum->description;
        if (!strlen($d)) $d = "Discussion among members of $team->name";
        break;
    }
    echo "
        <tr class=\"row1\">
        <td>
            <em>
            <a href=\"/community/forum/forum.php?id=$forum->id\">$t
            </a></em>
            <br><span class=\"note\">$d</span>
        </td>
        <td>$forum->threads</td>
        <td>$forum->posts</td>
        <td>".time_diff_str($forum->timestamp, time())."</td>
    </tr>";
}

display_page_top(tra("%1 Message boards", PROJECT));

echo "
    <p>
    If you have a question or problem, please use the
    <a href=/community/forum/help_desk.php>Questions & answers</a>
    area instead of the Message boards.
    </p>
";

show_forum_header($user);

$categories = BoincCategory::enum("is_helpdesk=0 order by orderID");
$first = true;
foreach ($categories as $category) {
    if ($first) {
        $first = false;
        show_forum_title($category, NULL, NULL);
        show_mark_as_read_button($user);
        echo "<p>";
        start_forum_table(
            array(tra("Topic"), tra("Threads"), tra("Posts"), tra("Last post"))
        );
    }
    if (strlen($category->name)) {
        echo '
            <tr class="subtitle">
            <td class="category" colspan="4">'.$category->name.'</td>
            </tr>
        ';
    }
    $forums = BoincForum::enum("parent_type=0 and category=$category->id order by orderID");
    foreach ($forums as $forum) {
        show_forum_summary($forum);
    }
}

if ($user && $user->teamid) {
    $forum = BoincForum::lookup("parent_type=1 and category=$user->teamid");
    if ($forum) {
        show_forum_summary($forum);
    }
}
end_table();

if ($user) {
    $subs = BoincSubscription::enum("userid=$user->id");
    if (count($subs)) {
        echo "<h3>Subscribed threads</h2>";
        show_thread_and_context_header();
        foreach ($subs as $sub) {
            $thread = BoincThread::lookup_id($sub->threadid);
            if (!$thread) {
                BoincSubscription::delete($user->id, $sub->threadid);
                continue;
            }
            if ($thread->hidden) continue;
            show_thread_and_context($thread, $user);
        }
        end_table();
    }
}

display_page_bottom();
flush();
BoincForumLogging::cleanup();

$cvs_version_tracker[]="\$Id: forum_index.php 15070 2008-04-21 14:04:01Z boincadm $";  //Generated automatically - do not edit
?>
