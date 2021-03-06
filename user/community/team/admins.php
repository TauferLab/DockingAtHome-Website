<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/team.inc");

function show_admin($user, $admin) {
    $admin_user = BoincUser::lookup_id($admin->userid);
    $tokens = url_tokens($user->authenticator);
    $date = date_str($admin->create_time);
    echo "<tr>
        <td>".user_links($admin_user)."</td>
        <td>$date</td>
        <td>
    ";
    show_button("/community/team/admins.php?teamid=$admin->teamid&action=remove&userid=$admin_user->id".$tokens, "Remove", "Remove Team Admin status from this member");
    echo "</td></tr>
    ";
}

function show_admins($user, $teamid) {
    display_page_top("Add or remove Team Admins");
    echo "
        You can select team members as 'Team Admins'.
        Team Admins can:
        <ul>
        <li> Edit team information (name, URL, description, country).
        <li> View the team's join/quit history.
        <li> Moderate the team forum, if any (admins get emails notification
            of moderation events and red X reports).
        </ul>
        Team Admins cannot:
        <ul>
        <li> Change the team founder.
        <li> Remove members.
        <li> Add or remove Team Admins.
        </ul>
        If a Team Admin quits the team, they cease to be a Team Admin.
        <p>
        We recommend that you select only people
        you know and trust very well as Team Admins.
    ";
    $admins = BoincTeamAdmin::enum("teamid=$teamid");
    start_table();
    if (count($admins)==0) {
        row1("There are currently no Team Admins");
    } else {
        row1("Current Team Admins", 3);
        table_header("Name", "Became Team Admin on", "");
        foreach ($admins as $admin) {
            show_admin($user, $admin);
        }
    }
    end_table();

    echo "
        <p>
        <form action=/community/team/admins.php>
        <input type=hidden name=action value=add>
        <input type=hidden name=teamid value=$teamid>
    ";
    echo form_tokens($user->authenticator);
    start_table();
    row1("Add Team Admin");
    row2("Email address of team member:", "<input name=email_addr>");
    row2("", "<input type=submit action value=\"Add\">");
    end_table();
    echo "</form>";

    display_page_bottom();
}

function remove_admin($team) {
    $userid = get_int('userid');
    $ret = BoincTeamAdmin::delete("teamid=$team->id and userid=$userid");
    if (!$ret) {
        error_page("failed to remove admin");
    }
}

function add_admin($team) {
    $email_addr = get_str('email_addr');
    $user = BoincUser::lookup("email_addr='$email_addr'");
    if (!$user) error_page("no such user");
    if ($user->teamid != $team->id) error_page("User is not member of team");
    if (is_team_admin($user, $team)) {
        error_page("$email_addr is already an admin of $team->name");
    }
    $now = time();
    $ret = BoincTeamAdmin::insert("(teamid, userid, create_time) values ($team->id, $user->id, $now)");
    if (!$ret) error_page("Couldn't add admin");
}

$user = get_logged_in_user();
$teamid = get_int('teamid');
$team = BoincTeam::lookup_id($teamid);
if (!$team) error_page("No such team");
require_founder_login($user, $team);

$action = get_str('action', true);
switch($action) {
case 'remove':
    check_tokens($user->authenticator);
    remove_admin($team);
    Header("Location: /community/team/admins.php?teamid=$teamid");
    exit();
case 'add':
    check_tokens($user->authenticator);
    add_admin($team);
    Header("Location: /community/team/admins.php?teamid=$teamid");
    exit();
}
show_admins($user, $teamid);

?>
