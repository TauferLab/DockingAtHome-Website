<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/team.inc");

$user = get_logged_in_user();

$name = post_str("name"); 
if (strlen($name) == 0) {
    error_page("You must choose a non-blank team name");
}

$new_team = lookup_team_name($name);
if ($new_team) {
    error_page("A team named '$name' already exists - try another name");
}

$url = post_str("url", true);
$type = post_str("type", true);
$name_html = post_str("name_html", true);
$description = post_str("description", true);
$country = post_str("country", true);
if ($country == "") {
    $country = "International";
}

$new_team = make_team(
    $user->id, $name, $url, $type, $name_html, $description, $country
);

if ($new_team) {
    user_join_team($new_team, $user);
    Header("Location: /community/team/display.php?teamid=$new_team->id");
} else {
    error_page("Could not create team - please try later.");
}

?>
