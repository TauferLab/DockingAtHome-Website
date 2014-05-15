<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/team.inc");

db_init();
$user = get_logged_in_user();
$teamid = get_int("id");

$team = lookup_team($teamid);
$team_name = $team->name;
display_page_top("Join $team_name");
echo " <p><b>Please note:</b>
    <ul>
    <li> Joining a team gives its founder access to your email address.
    <li> Joining a team does not affect your account's credit.
    </ul>
    <hr>
    <form method=\"post\" action=\"/community/team/join_action.php\">";
echo form_tokens($user->authenticator);
echo "
    <input type=\"hidden\" name=\"teamid\" value=\"$teamid\">
    <input type=\"submit\" value=\"Join team\">
    </form>
";
display_page_bottom();

?>
