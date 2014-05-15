<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/team.inc");

$user = get_logged_in_user();

$teamid = get_int("teamid");
$team = BoincTeam::lookup_id($teamid);
if (!$team) error_page("no such team");
require_admin($user, $team);

$team_name = ereg_replace("\"", "'", $team->name);
display_page_top("Edit ".$team_name);
team_edit_form($team, "Update team info", "/community/team/edit_action.php");
display_page_bottom();

?>
