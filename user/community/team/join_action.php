<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/team.inc");

$user = get_logged_in_user(true);
check_tokens($user->authenticator);

$teamid = post_int("teamid");
$team = BoincTeam::lookup_id($teamid);
require_team($team);
if ($user->teamid == $team->id) {
    display_page_top("Unable to add $user->name");
    echo "You are already a member of $team->name.";
} else {
    $success = user_join_team($team, $user);
    if ($success) {
        display_page_top("Joined $team->name");
        echo "You have joined
            <a href=/community/team/display.php?teamid=$team->id>$team->name</a>.
        ";
    } else {
        error_page("Couldn't join team - please try later.");
    }
}

display_page_bottom();

?>
