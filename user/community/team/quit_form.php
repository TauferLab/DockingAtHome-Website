<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/team.inc");

db_init();
$user = get_logged_in_user(true);

$team = lookup_team($user->teamid);
if (!$team) {
    error_page("No such team");
}

display_page_top("Quit $team->name");
echo "
    <b>Please note before quitting a team:</b>
    <ul>
    <li>If you quit a team, you may rejoin later,
    or join any other team you desire
    <li>Quitting a team does not affect your personal credit
    statistics in any way.
    </ul>
    </p>
    <form method=\"post\" action=\"/community/team/quit_action.php\">";
echo form_tokens($user->authenticator);
echo "<input type=\"hidden\" name=\"id\" value=\"$team->id\">
    <input type=\"submit\" value=\"Quit Team\">
    </form>
";
display_page_bottom();

?>
