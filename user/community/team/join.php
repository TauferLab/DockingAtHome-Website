<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/team.inc");

$user = get_logged_in_user(true);
check_tokens($user->authenticator);

$teamid = get_int("teamid");
$team = BoincTeam::lookup_id($teamid);
require_team($team);
if ($user->teamid == $team->id) {
    display_page_top("Already a member");
    echo "You are already a member of $team->name.";
} else {
    $success = user_join_team($team, $user);
    if ($success) {
        Header("Location: /account/");
    } else {
        error_page("Couldn't join team - please try later.");
    }
}

display_page_bottom();

?>
