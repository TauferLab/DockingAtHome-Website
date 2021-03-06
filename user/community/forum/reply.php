<?php

// Use this file you can post a reply to a thread.
// Both input (form) and action take place here.
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT'].'/../inc/forum_email.inc');
require_once($_SERVER['DOCUMENT_ROOT'].'/../inc/forum.inc');
require_once($_SERVER['DOCUMENT_ROOT'].'/../inc/akismet.inc');

$logged_in_user = get_logged_in_user(true);
BoincForumPrefs::lookup($logged_in_user);
check_banished($logged_in_user);

$thread = BoincThread::lookup_id(get_int('thread'));
$forum = BoincForum::lookup_id($thread->forum);

$sort_style = get_str('sort', true);
$filter = get_str('filter', true);
$content = post_str('content', true);
$preview = post_str("preview", true);
$parent_post_id = get_int('post', true);
$parent_post = null;
if ($parent_post_id) {
    $parent_post = BoincPost::lookup_id($parent_post_id);
    if ($parent_post->thread != $thread->id) {
        error_page("wrong thread");
    }
} else {
    $parent_post_id = 0;
}

if ($filter != "false"){
    $filter = true;
} else {
    $filter = false;
}

check_reply_access($logged_in_user, $forum, $thread);

if (!$sort_style) {
    $sort_style = $logged_in_user->prefs->thread_sorting;
} else {
    $logged_in_user->prefs->update("thread_sorting=$sort_style");
}

if ($content && (!$preview)){
    if (post_str('add_signature',true)=="add_it"){
        $add_signature=true;    // set a flag and concatenate later
    }  else {
        $add_signature=false;
    }
    check_tokens($logged_in_user->authenticator);
    akismet_check($logged_in_user, $content);
    create_post($content, $parent_post_id, $logged_in_user, $forum, $thread, $add_signature);
    header('Location: /community/forum/thread.php?id='.$thread->id);
}

display_page_top(tra("Post to thread"));

show_forum_header($logged_in_user);

switch ($forum->parent_type) {
case 0:
    $category = BoincCategory::lookup_id($forum->category);
    show_forum_title($category, $forum, $thread);
    break;
case 1:
    show_team_forum_title($forum, $thread);
    break;
}
echo "<p>";

if ($preview == tra("Preview")) {
    $options = new output_options;
    echo "<div id=\"preview\">\n";
    echo "<div class=\"header\">".tra("Preview")."</div>\n";
    echo output_transform($content, $options);
    echo "</div>\n";
}

start_forum_table(array(tra("Author"), tra("Message")));

show_message_row($thread, $parent_post);
show_posts($thread, $forum, $sort_style, $filter, $logged_in_user, true);
end_table();

display_page_bottom();

function show_message_row($thread, $parent_post) {
    global $logged_in_user;
    global $content;
    global $preview;

    $x1 = "Message:".html_info().post_warning();
    $x2 = "";
    if ($parent_post) {
        $x2 .=" reply to <a href=#".$parent_post->id.">Message ID ".$parent_post->id."</a>:";
    }
    $x2 .= "<form action=/community/forum/reply.php?thread=".$thread->id;

    if ($parent_post) {
        $x2 .= "&post=".$parent_post->id;
    }

    $x2 .= " method=\"post\">\n";
    $x2 .= form_tokens($logged_in_user->authenticator);
    $x2 .= "<textarea name=\"content\" rows=\"18\" cols=\"80\">";
    if ($preview) {
        $x2 .= stripslashes(htmlspecialchars($content));
    } else {
        if ($parent_post) $x2 .= quote_text(stripslashes(htmlspecialchars($parent_post->content)), 80)."\n";
    }
    if (!$logged_in_user->prefs->no_signature_by_default){
        $enable_signature="checked=\"true\"";
    } else {
        $enable_signature="";
    }
    $x2 .= "</textarea><p>
        <input type=\"submit\" name=\"preview\" value=\"".tra("Preview")."\">
        <input type=\"submit\" value=\"Post reply\">
        &nbsp;&nbsp;&nbsp;
        <input name=\"add_signature\" id=\"add_signature\" value=\"add_it\" ".$enable_signature." type=\"checkbox\">
        <label for=\"add_signature\">Add my signature to this reply</label>

        </form>
    ";
    row2($x1, $x2);
}

function quote_text($text, $cols = 0) {
	/* $cols is depricated. */
    $text = "[quote]" . $text . "[/quote]";
    return $text;
}
$cvs_version_tracker[]="\$Id: forum_reply.php 14303 2007-11-26 04:12:15Z davea $";
?>
