<?php

// action = 'transfer':
//    handle a user's request to initiate a foundership transfer 
// action = 'decline':
//    handle the current founder's declining of the request
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/team.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/email.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/pm.inc");

$user = get_logged_in_user();
global $logged_in_user;
$logged_in_user=$user;
if (!$user->teamid) {
    error_page("You must be a member of a team to access this page.");
}

function send_founder_transfer_email($team, $user) {
    $body = "Team member ".$user->name." has asked that you
transfer foundership of $team->name in ".PROJECT.".
Please visit
".URL_BASE."community/team/change_founder_form.php?teamid=".$team->id."
to transfer foundership or decline the request.
    
If you do not respond to this request within two months, ".$user->name." will
be given the option to become the team founder.
    
Please do not respond to this email.
The mailbox is not monitored and the email
was sent using an automated system.";
    
    $subject = PROJECT." team founder transfer";
    $founder = lookup_user_id($team->userid);

    // send founder a private message for good measure

    pm_send($founder, $subject, $body);
    return send_email($founder, $subject, $body);
}

function send_founder_transfer_decline_email($team, $user) {
    $body = "The founder of ".$team->name." has declined your request
to become the founder in ".PROJECT.".
You can repeat the request at least 90 days after the initial request.
    
Please do not respond to this email.
The mailbox is not monitored and the email
was sent using an automated system.";
    
    return send_email($user, PROJECT." team founder transfer declined", $body);
}

$action = post_str("action");

if ($action == "transfer") {
    $team = BoincTeam::lookup_id($user->teamid);
    display_page_top("Request foundership of ".$team->name);
    $now = time();

    if (new_transfer_request_ok($team, $now)) {
        $success = send_founder_transfer_email($team, $user);

        // Go ahead with the transfer even if the email send fails.
        // Otherwise it would be impossible to rescue a team
        // whose founder email is invalid
        //
        $team->update("ping_user=$user->id, ping_time=$now");
        echo "<p>
            The current founder has been notified of your request by email
            and private message.
            <p>
            If the founder does not respond within 60 days you will be
            allowed to become the founder.
            <p>
        ";
    } else {
        if ($team->ping_user) {
            if ($user->id == $team->ping_user) {
                if (transfer_ok($team, $now)) {
                    $team->update("userid=$user->id, ping_user=0, ping_time=0");
                    echo "<p>Congratulations, you are now the new founder of team ".$team->name."
                    Go to <a href=\"".URL_BASE."/account/\">Your Account page</a>
                    to find the Team Admin options.";
                } else {
                    echo "<p>
                        You have already requested the foundership
                        of $team->name.
                        <p>
                        Team founder has been notified about your request.
                        If he/she does not respond by ".time_str(transfer_ok_time($team))."
                        you will be given the option to assume team foundership.
                    ";
                }
            } else {
                $ping_user = lookup_user_id($team->ping_user);
                echo "<p>Foundership was requested by ".user_links($ping_user)." on ".time_str($team->ping_time);
            }
        } else {
            echo "<p>A foundership change has been requested in the last three
                months and new requests are currently disabled.
            ";
        }
    }
} else if ($action == "decline") {
    $teamid = post_int("teamid");
    $team = lookup_team($teamid);
    require_founder_login($user, $team);
    display_page_top("Decline founder change request");
    
    if ($team->ping_user) {
        $ping_user = BoincUser::lookup_id($team->ping_user);
        
        $team->update("ping_user=0");
        send_founder_transfer_decline_email($team, $ping_user);
        echo "<p>The foundership request from ".user_links($ping_user)
            ." has been declined.
        ";
    } else {
        echo "<p>There were no foundership requests.";
    }
} else {
    error_page("no action");
}

echo "<a href='/community/team/display.php?teamid=$team->id'>Return to team page</a>";

display_page_bottom();

$cvs_version_tracker[]="\$Id: team_founder_transfer_action.php 15296 2008-05-27 21:26:49Z boincadm $";  //Generated automatically - do not edit

?>
