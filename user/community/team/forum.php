<?php

// create, manage, or read a team message board
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/team.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/forum_db.inc");

function create_confirm($user, $team) {
    display_page_top("Create Message Board");
    echo "
        You may create a Message Board for use by $team->name.
        <ul>
        <li> Only team members will be able to post.
        <li> At your option, only members will be able to read.
        <li> You and your Team Admins will have moderator privileges.
        </ul>
    ";
    $tokens = url_tokens($user->authenticator);
    show_button(
        "/community/team/forum.php?teamid=$team->id&cmd=create$tokens",
        "Create Message Board",
        "Create a Message Board for $team->name"
    );
    display_page_bottom();
}

function create_forum($user, $team) {
    $f = BoincForum::lookup("parent_type=1 and category=$team->id");
    if ($f) {
        error_page("Team already has a forum");
    }
    $id = BoincForum::insert("(category, parent_type) values ($team->id, 1)");
    $forum = BoincForum::lookup_id($id);
    if (!$forum) {
        error_page("couldn't create forum");
    }
    edit_form($user, $team, $forum, true);
}

function edit_form($user, $team, $forum, $first) {
    display_page_top("Team forum");
    echo "
        <form action=/community/team/forum.php method=post>
        <input type=hidden name=teamid value=$team->id>
        <input type=hidden name=cmd value=edit_action>
    ";
    echo form_tokens($user->authenticator);
    start_table();
    if (!strlen($forum->title)) $forum->title = $team->name;
    if (!strlen($forum->description)) $forum->description = "Discussion among members of $team->name";
    row2("Title", "<input name=title value=\"$forum->title\">");
    row2("Description", "<textarea name=description>$forum->description</textarea>");
    row2("Minimum time between posts (seconds)",
        "<input name=post_min_interval value=$forum->post_min_interval>"
    );
    row2("Minimum total credit to post",
        "<input name=post_min_total_credit value=$forum->post_min_total_credit>"
    );
    row2("Minimum average credit to post",
        "<input name=post_min_expavg_credit value=$forum->post_min_expavg_credit>"
    );
    row2("", "<input type=submit value=OK>");
    end_table();
    echo "
        </form>
    ";
    if (!$first) {
        echo "
            <p>
            <a href=/community/team/forum.php?teamid=$team->id&cmd=remove_confirm$tokens>
            Remove your team's message board.</a>
        ";
    }
    display_page_bottom();
}

function remove_confirm($user, $team) {
    $tokens = url_tokens($user->authenticator);
    display_page_top("Really remove message board?");
    echo "
        Are you sure you want to remove your team's message board?
        All threads and posts will be permanently removed.
        (You may, however, create a new message board later).
        <p>
        <a href=/community/team/forum.php?teamid=$team->id&cmd=remove>Yes - remove message board</a>
    ";
    display_page_bottom();
}

function remove($team) {
    $forum = BoincForum::lookup("parent_type=1 and category=$team->id");
    if (!$forum) error_page("not found");
    
    // delete threads and posts
    //
    $threads = BoincThread::enum("forum=$forum->id");
    foreach ($threads as $thread) {
        $posts = BoincPost::enum("thread=$thread->id");
        foreach ($posts as $post) {
            $post->delete();
        }
        $thread->delete();
    }
    $forum->delete();

    display_page_top("Message board removed");
    display_page_bottom();
}

function edit_action($forum) {
    $title = strip_tags(post_str('title'));
    $title = BoincDb::escape_string($title);
    $description = strip_tags(post_str('description'));
    $description = BoincDb::escape_string($description);
    $post_min_interval = post_int('post_min_interval');
    $post_min_total_credit = post_int('post_min_total_credit');
    $post_min_expavg_credit = post_int('post_min_expavg_credit');
    $ret = $forum->update("title='$title', description='$description', post_min_interval=$post_min_interval, post_min_total_credit=$post_min_total_credit, post_min_expavg_credit=$post_min_expavg_credit");
    if ($ret) {
        display_page_top("Team Message Board Updated");
        echo "Update successful";
        display_page_bottom();
    } else {
        error_page("update failed");
    }
}

function show_forum($team) {
    $forum = BoincForum::lookup("parent_type=1 and category=$team->id");
    if (!$forum) {
        error_page("team has no forum");
    }
    Header("Location: /community/forum/forum.php?id=$forum->id");
}

$teamid = get_int("teamid", true);
if (!$teamid) $teamid = post_int('teamid');

$team = BoincTeam::lookup_id($teamid);
if (!$team) {
    error_page("no such team");
}

$cmd = get_str('cmd', true);
if (!$cmd) $cmd = post_str('cmd', true);

if ($cmd == 'manage') {
    $user = get_logged_in_user();
    require_founder_login($user, $team);
    $forum = BoincForum::lookup("parent_type=1 and category=$teamid");
    if (!$forum) {
        create_confirm($user, $team);
    } else {
        edit_form($user, $team, $forum, false);
    }
} else if ($cmd == 'create') {
    $user = get_logged_in_user();
    check_tokens($user->authenticator);
    require_founder_login($user, $team);
    create_forum($user, $team);
} else if ($cmd == 'edit_action') {
    $user = get_logged_in_user();
    require_founder_login($user, $team);
    check_tokens($user->authenticator);
    $forum = BoincForum::lookup("parent_type=1 and category=$teamid");
    if (!$forum) error_page("no forum");
    edit_action($forum);
} else if ($cmd == "remove_confirm") {
    $user = get_logged_in_user();
    require_founder_login($user, $team);
    remove_confirm($user, $team);
} else if ($cmd == "remove") {
    $user = get_logged_in_user();
    require_founder_login($user, $team);
    remove($team);
} else if ($cmd != "") {
    error_page("unknown command $cmd");
} else {
    show_forum($team);
}

?>
