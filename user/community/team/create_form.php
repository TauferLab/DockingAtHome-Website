<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/team.inc");

$user = get_logged_in_user();

display_page_top("Create a team");
if ($user->teamid) {
    $team = BoincTeam::lookup_id($user->teamid);
    echo "You belong to 
        <a href=/community/team/display.php?teamid=$team->id>$team->name</a>.
        You must <a href=/community/team/quit_form.php>quit this team</a> before creating a new one.
    ";
} else {
    team_edit_form(null, "Create team", "/community/team/create_action.php");
}
display_page_bottom();
?>
