<?php

// display the threads in a forum.
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT'].'/../inc/util.inc');
require_once($_SERVER['DOCUMENT_ROOT'].'/../inc/time.inc');
require_once($_SERVER['DOCUMENT_ROOT'].'/../inc/forum.inc');
require_once($_SERVER['DOCUMENT_ROOT'].'/../inc/pm.inc');

$id = get_int("id");
$sort_style = get_int("sort", true);
$start = get_int("start", true);
if (!$start) $start = 0;

$forum = BoincForum::lookup_id($id);
$user = get_logged_in_user(false);

if (!is_forum_visible_to_user($forum, $user)) {
    error_page("Not visible");
}

BoincForumPrefs::lookup($user);

if (!$sort_style) {
    // get the sort style either from the logged in user or a cookie
    if ($user){
        $sort_style = $user->prefs->forum_sorting;
    } else {
        if (isset($_COOKIE['sorting'])) {
            list($sort_style,$thread_style)=explode("|",$_COOKIE['sorting']);
        }
    }
} else {
    // set the sort style
    if ($user){
        $user->prefs->forum_sorting = $sort_style;
        $user->prefs->update("forum_sorting=$sort_style");
    } else {
        list($old_style,$thread_style)=explode("|",$_COOKIE['sorting']);
        send_cookie('sorting', implode("|",array($sort_style,$thread_style)), true);
    }
}


switch ($forum->parent_type) {
case 0:
    $category = BoincCategory::lookup_id($forum->category); 
    if ($category->is_helpdesk){
        display_page_top(tra("Questions and Answers").' : '.$forum->title);
        echo '<link href="/community/forum/help_desk.php" rel="up" title="Forum Index">';
    } else {
        display_page_top(tra("Message boards").' : '.$forum->title);
        echo '<link href="/community/forum/" rel="up" title="Forum Index">';
    }
    show_forum_header($user);
    show_forum_title($category, $forum, NULL);
    break;
case 1:
    $team = BoincTeam::lookup_id($forum->category); 
    display_page_top("Team message board for <a href=/community/team/display.php?teamid=$team->id>$team->name</a>");
    show_forum_header($user);
    show_team_forum_title($forum);
    break;
}

echo '
    <p>
    <table width="100%" cellspacing="0" cellpadding="0">
    <tr valign="top">
    <td colspan=2>
';

show_button("/community/forum/post.php?id=$id", "New thread", "Add a new thread to this forum");

echo " <br><br></td>";
echo '<td valign=top align="right">';
echo '    <form action="/community/forum/forum.php" method="get">
    <input type="hidden" name="id" value="'.$forum->id.'">';
echo select_from_array("sort", $forum_sort_styles, $sort_style);
echo '<input type="submit" value="Sort"></form></td>';
echo "</tr></table>";

show_forum($forum, $start, $sort_style, $user);

display_page_bottom();

// This function shows the threads for the given forum
// Starting from $start,
// using the given $sort_style (as defined in forum.php)
// and using the features for the logged in user in $user.
//
function show_forum($forum, $start, $sort_style, $user) {
    $gotoStr = "";
    $nav = show_page_nav($forum, $start);
    if ($nav) {
        $gotoStr = "<div align=\"right\">$nav</div><br>";
    }
    echo $gotoStr; // Display the navbar
    start_forum_table(array("", tra("Threads"), tra("Posts"), tra("Author"), tra("Views"), "<nobr>".tra("Last post")."</nobr>"));
    
    $sticky_first = !$user || !$user->prefs->ignore_sticky_posts;

    // Show hidden threads if logged in user is a moderator
    //
    $show_hidden = is_moderator($user, $forum);
    $threads = get_forum_threads(
        $forum->id, $start, THREADS_PER_PAGE,
        $sort_style, $show_hidden, $sticky_first
    );

    if ($user) {
        $subs = BoincSubscription::enum("userid=$user->id");
    }
    
    // Run through the list of threads, displaying each of them
    $n = 0; $i=0;
    foreach ($threads as $thread) {
        $owner = BoincUser::lookup_id($thread->owner);
        $unread = thread_is_unread($user, $thread);
        
        //if ($thread->status==1){
            // This is an answered helpdesk thread
        if ($user && is_subscribed($thread, $subs)) {
            echo '<tr class="row_hd'.$n.'">';
        } else {
            // Just a standard thread.
            echo '<tr class="row'.$n.'">';    
        }
        
        echo "<td width=\"1%\" align=\"right\"><nobr>";
        if ($user && ($thread->rating()>$user->prefs->high_rating_threshold)) {
            show_image(EMPHASIZE_IMAGE, "This message has a high average rating", "Highly rated");
        }
        if ($user && ($thread->rating()<$user->prefs->low_rating_threshold)) {
            show_image(FILTER_IMAGE, "This message has a low average rating", "Low rated");
        }
        if ($thread->hidden) {
            echo "[hidden]";
        }
        if ($unread) {
            if ($thread->sticky) {
                if ($thread->locked) {
                    show_image(NEW_IMAGE_STICKY_LOCKED, "This thread is sticky and locked, and you haven't read it yet", "sticky/locked/unread");
                } else {
                    show_image(NEW_IMAGE_STICKY, "This thread is sticky and you haven't read it yet", "sticky/unread");
                }
            } else {
                if ($thread->locked) {
                    show_image(NEW_IMAGE_LOCKED, "You haven't read this thread yet, and it's locked", "unread/locked");
                } else {
                    show_image(NEW_IMAGE, "You haven't read this thread yet", "unread");
                }
            }
        } else {
            if ($thread->sticky) {
                if ($thread->locked) {
                    show_image(IMAGE_STICKY_LOCKED, "This thread is sticky and locked", "sticky/locked");
                } else {
                    show_image(IMAGE_STICKY, "This thread is sticky", "sticky");
                }
            } else {
                if ($thread->locked) {
                    show_image(IMAGE_LOCKED, "This thread is locked", "locked");
                }
            }
        }
        echo "</nobr></td>";

        $titlelength = 48;
        $title = $thread->title;
        if (strlen($title) > $titlelength) {
            $title = substr($title,0,$titlelength)."...";
        }
        $title = cleanup_title($title);
        echo '<td class="threadline"><a href="/community/forum/thread.php?id='.$thread->id.'"><b>'.$title.'</b></a><br></td>';
        $n = ($n+1)%2;

        echo '
            <td>'.($thread->replies+1).'</td>
            <td class=\"threadauthor\"><div class="authorcol">'.user_links($owner).'</div></td>
            <td>'.$thread->views.'</td>
            <td class=\"lastpost\">'.time_diff_str($thread->timestamp, time()).'</td>
            </tr>
        ';
        flush();
    }
    end_table();
    echo "<br>$gotoStr";    // show page links
}

?>
