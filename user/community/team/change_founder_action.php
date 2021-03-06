<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/team.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");

$user = get_logged_in_user();

$teamid = post_int("teamid");
$team = BoincTeam::lookup_id($teamid);
if (!$team) {
    error_page("No such team");
}
require_founder_login($user, $team);
check_tokens($user->authenticator);

$userid = post_int("userid");
$new_founder = BoincUser::lookup_id($userid);
if (!$new_founder || $new_founder->teamid != $team->id) {
    error_page( "User is not a member of $team->name");
}

display_page_top("Changing founder of $team->name");
$team->update("userid=$userid, ping_user=0");
echo "$new_founder->name is now founder of $team->name";
display_page_bottom();

?>
