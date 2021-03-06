<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/email.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/team.inc");

$xml = get_int('xml', true);
if ($xml) {
    require_once($_SERVER['DOCUMENT_ROOT']."/../inc/xml.inc");
    xml_header();
    $retval = db_init_xml();
    if ($retval) xml_error($retval);
    $teamid = get_int("teamid");
    $team = BoincTeam::lookup_id($teamid);
    if (!$team) {
        xml_error(-136);
    }
    $account_key = get_str('account_key', true);
    $user = lookup_user_auth($account_key);
    $show_email = ($user && is_team_founder($user, $team));
    echo "<users>\n";
    $users = BoincUser::enum_fields("id, email_addr, send_email, name, total_credit, expavg_credit, has_profile, donated, country, cross_project_id, create_time, url", "teamid=$team->id");
    //$users = BoincUser::enum("teamid=$team->id");
    foreach($users as $user) {
        show_team_member($user, $show_email);
    } 
    echo "</users>\n";
    exit();
}

$user = get_logged_in_user();
$teamid = get_int("teamid");
$plain = get_int("plain", true);
$team = BoincTeam::lookup_id($teamid);
if (!$team) error_page("no such team");
require_founder_login($user, $team);

if ($plain) {
    header("Content-type: text/plain");
} else {
    display_page_top("$team->name Email List");
    start_table();
    table_header(array("Member list of ".$team->name, "colspan=\"6\""));
    table_header("Name", "Email address", "Total credit", "Recent average credit", "Country");
}
$users = BoincUser::enum_fields("id, email_addr, send_email, name, total_credit, expavg_credit, has_profile, donated, country, cross_project_id, create_time, url", "teamid=$team->id");
foreach($users as $user) {
    if ($plain) {
        $e = $user->send_email?"<$user->email_addr>":"";
        echo "$user->name $e\n";
    } else {
        $e = $user->send_email?"$user->email_addr":"";
        table_row(user_links($user), $e, format_credit($user->total_credit), format_credit($user->expavg_credit), $user->country);
    }
} 
if (!$plain) {
    end_table();
    echo "<p><a href=\"/community/team/email_list.php?teamid=".$teamid."&amp;plain=1\">Show as plain text</a></p>";
    display_page_bottom();
}

?>
