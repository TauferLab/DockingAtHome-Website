<?php

// This file allows you to create a new thread in a forum
// At first it displays an input box and when you submit
// it will apply the changes by calling methods on the forum
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT'].'/../inc/forum_email.inc');
require_once($_SERVER['DOCUMENT_ROOT'].'/../inc/forum.inc');
require_once($_SERVER['DOCUMENT_ROOT'].'/../inc/akismet.inc');

$logged_in_user = get_logged_in_user();
BoincForumPrefs::lookup($logged_in_user);

check_banished($logged_in_user);

$forumid = get_int("id");
$forum = BoincForum::lookup_id($forumid);

check_create_thread_access($logged_in_user, $forum);

$title = post_str("title", true);
$content = post_str("content", true);
$preview = post_str("preview", true);

if ($content && $title && (!$preview)){
    if (post_str('add_signature',true)=="add_it"){
        $add_signature=true;    // set a flag and concatenate later
    }  else {
        $add_signature=false;
    }
    check_tokens($logged_in_user->authenticator);
    akismet_check($logged_in_user, $content);
    $thread = create_thread(
        $title, $content, $logged_in_user, $forum, $add_signature
    );
    header('Location: /community/forum/thread.php?id=' . $thread->id);
}

display_page_top('Create new thread');
show_forum_header($logged_in_user);

switch ($forum->parent_type) {
case 0:
    $category = BoincCategory::lookup_id($forum->category);
    show_forum_title($category, $forum, null);
    break;
case 1:
    show_team_forum_title($forum);
    break;
}

if ($preview == tra("Preview")) {
    $options = null;
    echo "<div id=\"preview\">\n";
    echo "<div class=\"header\">".tra("Preview")."</div>\n";
    echo output_transform($content, $options);
    echo "</div>\n";
}

echo "<form action=\"/community/forum/post.php?id=".$forum->id."\" method=\"POST\">\n";
echo form_tokens($logged_in_user->authenticator);

start_table();

row1(tra("Create a new thread")); //New thread
$submit_help = "";
$body_help = "";

//Title
if ($content && !$title) $submit_help = "<br /><font color=\"red\">Remember to add a title</font>";
row2(tra("Title").$submit_help, "<input type=\"text\" name=\"title\" size=\"62\" value=\"".stripslashes(htmlspecialchars($title))."\">");
//Message
row2(tra("Message").html_info().post_warning().$body_help, "<textarea name=\"content\" rows=\"12\" cols=\"54\">".stripslashes(htmlspecialchars($content))."</textarea>");

if (!$logged_in_user->prefs->no_signature_by_default) {
    $enable_signature="checked=\"true\"";
} else {
    $enable_signature="";
}

row2("", "<input name=\"add_signature\" value=\"add_it\" ".$enable_signature." type=\"checkbox\">".tra("Add my signature to this post"));
row2("", "<input type=\"submit\" name=\"preview\" value=\"".tra("Preview")."\"> <input type=\"submit\" value=\"OK\">");


end_table();

echo "</form>\n";

display_page_bottom();

$cvs_version_tracker[]="\$Id: forum_post.php 14233 2007-11-16 21:48:28Z davea $";
?>
