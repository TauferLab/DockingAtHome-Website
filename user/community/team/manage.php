<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/team.inc");

function show_admin_page($user, $team) {
    display_page_top("Team administration for $team->name");
    echo "
        <ul>
        <li><a href=/community/team/edit_form.php?teamid=$team->id>Edit team info</a>
            <br><span class=note>Change team name, URL, description, type, or country</span>
        <li>
            Member list:
        <a href=/community/team/email_list.php?teamid=$team->id>HTML</a>
        | <a href=/community/team/email_list.php?teamid=$team->id&plain=1>text</a>
            <br><span class=note> View member names and email addresses </span>
        <li>View change history:
            <a href=/community/team/delta.php?teamid=$team->id>HTML</a>
            | <a href=/community/team/delta.php?teamid=$team->id&xml=1>XML</a>
            <br><span class=note>See when members joined or quit this team</span>
    ";

    // founder-only stuff follows
    //
    if ($team->userid == $user->id) {
        $tokens = url_tokens($user->authenticator);
        if ($team->ping_user > 0) {
            $user2 = BoincUser::lookup_id($team->ping_user);
            $deadline = date_str(transfer_ok_time($team));
            echo "<li>
                <a href=/community/team/change_founder_form.php?teamid=$team->id><font color=red><b>Respond to foundership request</b></font></a>.  If you don't respond by $deadline, $user2->name may assume foundership of this team.
            ";
        }
        echo "
            <li><a href=/community/team/remove_inactive_form.php?teamid=$team->id>Remove members</a>
                <br><span class=note>Remove inactive or unwanted members from this team</span>
            <li><a href=/community/team/change_founder_form.php?teamid=$team->id>Change founder</a>
                <br><span class=note>Transfer foundership to another member</span>
            <li><a href=/community/team/admins.php?teamid=$team->id>Add/remove Team Admins</a>
                <br><span class=note>Give selected team members Team Admin privileges</span>

            <li><a href=/community/team/manage.php?teamid=$team->id&action=delete&$tokens>Remove team</a>
                <br><span class=note>Allowed only if team has no members</a>
            <li><a href=/community/team/forum.php?teamid=$team->id&cmd=manage>Message board</a>
                <br><span class=note>Create or manage team message board</span>
        ";
    }
    echo "

        <p>
        <li>
            To have this team created on all BOINC projects
            (current and future) you can make it into a
            <a href=http://boinc.berkeley.edu/teams/>BOINC-wide team</a>.
        <li>
            Team admins are encouraged to join and participate in the Google
            <a href=http://groups.google.com/group/boinc-team-founders>boinc-team-founders</a> group.
        <li>
            Other resources for BOINC team admins
            are available from a third-party site,
            <a href=http://www.boincteams.com>www.boincteams.com</a>.
    </ul>
    ";

    display_page_bottom();
}

$user = get_logged_in_user(true);
$teamid = get_int('teamid');
$team = BoincTeam::lookup_id($teamid);
if (!$team) error_page("no such team");

$action = get_str('action', true);
if ($action == 'delete') {
    require_founder_login($user, $team);
    if (team_count_members($team->id) > 0) {
        error_page("Can't delete non-empty team");
    }
    check_tokens($user->authenticator);
    $team->delete();
    display_page_top("Team $team->name deleted");
    display_page_bottom();
} else {
    require_admin($user, $team);
    show_admin_page($user, $team);
}
?>
