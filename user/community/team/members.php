<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/team.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/cache.inc");

if (isset($_GET["sort_by"])) {
    $sort_by = $_GET["sort_by"];
} else {
    $sort_by = "expavg_credit";
}

$offset = get_int("offset", true);
if (!$offset) $offset=0;

if ($offset > 1000) {
    error_page("Limit exceeded:  Can only display the first 1000 members.");
}

$teamid = get_int("teamid");

$cache_args = "teamid=$teamid&offset=$offset&sort_by=$sort_by";
start_cache(TEAM_PAGE_TTL, $cache_args);

$team = BoincTeam::lookup_id($teamid);

display_page_top("Members of <a href=/community/team/display.php?teamid=$teamid>$team->name</a>");
display_team_members($team, $offset, $sort_by);
display_page_bottom();

end_cache(TEAM_PAGE_TTL, $cache_args);

?>
