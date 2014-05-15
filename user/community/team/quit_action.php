<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/team.inc");

db_init();
$user = get_logged_in_user(true);
check_tokens($user->authenticator);
$teamid = post_int("id");
$team = lookup_team($teamid);
if ($user->teamid == $team->id) {
    user_quit_team($user);
    Header("Location: /account/");
} else {
    display_page_top("Unable to quit team");
    echo "Team doesn't exist, or you don't belong to it.\n";
}

display_page_bottom();

?>
