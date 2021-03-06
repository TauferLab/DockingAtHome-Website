<?php

if(!defined("PROJECT_HTML_FOLDER")) require_once("../project/project.inc");
require_once(PROJECT_HTML_FOLDER."inc/credit.inc");
require_once(PROJECT_HTML_FOLDER."inc/email.inc");
require_once(PROJECT_HTML_FOLDER."inc/util.inc");
require_once(PROJECT_HTML_FOLDER."inc/team.inc");
require_once(PROJECT_HTML_FOLDER."inc/friend.inc");
require_once(PROJECT_HTML_FOLDER."inc/forum_db.inc");
require_once(PROJECT_HTML_FOLDER."inc/notify.inc");

function parse_project($f) {
    $p->total_credit = 0.0;
    $p->expavg_credit = 0.0;
    while (!feof($f)) {
        $buf = fgets($f);
        if (strstr($buf, "</project>")) break;
        if ($x = parse_element($buf, "<name>")) {
            $p->name = $x;
        }
        if ($x = parse_element($buf, "<name>")) {
            $p->name = $x;
        }
        if ($x = parse_element($buf, "<url>")) {
            $p->url = $x;
        }
        if ($x = parse_element($buf, "<total_credit>")) {
            $p->total_credit = $x;
        }
        if ($x = parse_element($buf, "<expavg_credit>")) {
            $p->expavg_credit = $x;
        }
        if ($x = parse_element($buf, "<id>")) {
            $p->id = $x;
        }
        if ($x = parse_element($buf, "<country>")) {
            $p->country = $x;
        }
        if ($x = parse_element($buf, "<team_id>")) {
            $p->team_id = $x;
        }
        if ($x = parse_element($buf, "<team_name>")) {
            $p->team_name = $x;
        }
        if ($x = parse_element($buf, "<create_time>")) {
            $p->create_time = $x;
        }
    }
    return $p;
}

function parse_user($f, $user) {
    $user->projects = array();
    while (!feof($f)) {
        $buf = fgets($f);
        if (strstr($buf, "</user>")) break;
        if (strstr($buf, "<project>")) {
            $user->projects[] = parse_project($f);
        }
    }
    return $user;
}

function get_other_projects($user) {
    $cpid = md5($user->cross_project_id . $user->email_addr);
    $url = "http://boinc.netsoft-online.com/get_user.php?cpid=$cpid";
    $f = fopen($url, "r");
    if (!$f) {
        return $user;
    }
    $u = parse_user($f, $user);
    fclose($f);
    return $u;
}

function show_project($project) {
    if ($project->url == "http://www.worldcommunitygrid.org/") {
        $x = $project->name;
    } else {
        $x = "<a href=\"$project->url"."show_user.php?userid=$project->id\">$project->name</a>";
    }
    echo "<tr>
        <td>$x</td>
        <td align=\"right\">".number_format($project->total_credit, 0)."</td>
        <td align=\"right\">".number_format($project->expavg_credit, 0)."</td>
        <td align=\"right\">".date_str($project->create_time)."</td>
        </tr>
    ";
}

function cmp($a, $b) {
    if ($a->expavg_credit == $b->expavg_credit) return 0;
    return ($a->expavg_credit < $b->expavg_credit)? 1 : -1;
}

function show_other_projects($user, $personal) {
    if (count($user->projects) > 1) {
        usort($user->projects, "cmp");
        if ($personal) {
            echo "<h3>".tra("Projects in which you are participating")."</h3>";
        } else {
            echo "<h3>".tra("Projects in which %1 is participating", $user->name)."</h3>";
        }
        start_table();
        row_heading_array(array(
            tra("Project")."<br/><span class=\"note\">".tra("Click for user page")."</span>", tra("Total credit"), tra("Average credit"), tra("Since")
        ));
        foreach($user->projects as $project) {
            show_project($project);
        }
        end_table();
    }
}

function total_posts($user) {
    return BoincPost::count("user=$user->id");
}

function show_credit($user) {
    row2(tra("Total credit"), format_credit_large($user->total_credit));
    row2(tra("Recent average credit"), format_credit($user->expavg_credit));
    project_user_credit($user);
}

require_once(PROJECT_HTML_FOLDER."inc/stats_sites.inc");
// show dynamic user info (private)
//
function show_user_stats_private($user) {
    global $cpid_stats_sites;
    row1(tra("Computing and credit"));
    show_credit($user);
    $config = get_config();
    if (parse_bool($config, "show_results")) {
        row2(tra("Pending credit"), "<a href=\"/account/pending.php\">".tra("View")."</a>");
    }
    row2(tra("Computers on this account"), "<a href=\"/community/hosts_user.php\">".tra("View")."</a>");
    row2(tra("Tasks"), "<a href=\"/community/results.php?userid=$user->id\">".tra("View")."</a>");
    $cpid = md5($user->cross_project_id . $user->email_addr);
    $x = "";
    shuffle($cpid_stats_sites);
    foreach ($cpid_stats_sites as $site) {
        $name = $site[0];
        $y = sprintf($site[1], $cpid);
        $x .= "<a href=\"$y\">$name</a><br/>";
    }
    $x .= "<br/><span class=\"smalltext\">".tra("Cross-project ID").": $cpid</span>\n";
    row2(tra("Cross-project statistics"), $x);
    row2(tra("Stats on your cell phone"), URL_BASE."userw.php?id=$user->id");
}

function notify_description($notify) {
    switch ($notify->type) {
    case NOTIFY_FRIEND_REQ:
        return friend_notify_req_web_line($notify);
    case NOTIFY_FRIEND_ACCEPT:
        return friend_notify_accept_web_line($notify);
    case NOTIFY_PM:
        return pm_web_line($notify);
    case NOTIFY_SUBSCRIBED_POST:
        return subscribed_post_web_line($notify);
    }
    return "Unknown notification type: $notify->type";
}

function weak_auth($user) {
    $x = md5($user->authenticator.$user->passwd_hash);
    return "{$user->id}_$x";
}

// show static user info (private)
//
function show_user_info_private($user) {
    if (is_valid_email_addr($user->email_addr)) {
        $email_text = $user->email_addr;
    } else {
        $email_text = "Verification pending";
    }

    row1(tra("Account information"));
    row2(tra("Name"), $user->name);
    row2(tra("Email address"), $email_text);
    if (strlen($user->url)) {
        $x = "http://$user->url";
    } else {
        $x = "none";
    }
    row2(tra("URL"), $x);
    row2(tra("Country"), $user->country);
    row2(tra("Postal code"), $user->postal_code);
    row2(tra("%1 member since", PROJECT), date_str($user->create_time));
    row2(tra("Change"), "<a href=\"/account/edit_email_form.php\">".tra("email address")."</a> | <a href=\"/account/edit_passwd_form.php\">".tra("password")."</a> | <a href=\"/account/edit_user_info_form.php\">".tra("other account info")."</a>");
    row2("", "<a href=\"/account/logout.php?".url_tokens($user->authenticator)."\">".tra("Log out")."</a>");
    row2(tra("User ID")."<br/><span class=\"note\">".tra("Used in community functions")."</span>", $user->id);
    if (!no_computing()) {
        row2(tra("Account key")."<br/><span class=\"note\">".tra("Provides full access to your account")."</span>", $user->authenticator);
        row2(tra("Weak account key")."<br/><span class=\"note\">".tra("Provides")." <a href=\"/account/weak_auth.php\">".tra("limited access")."</a> ".tra("to your account")."</span>", weak_auth($user));
    }

    row1("<a name=\"prefs\"></a>".tra("Preferences"));
    if (!no_computing()) {
        row2(
            tra("When and how BOINC uses your computer"),
            "<a href=\"/account/prefs.php?subset=global\">".tra("Computing preferences")."</a>"
        );
    }
    row2(tra("Message boards and private messages"),
        "<a href=\"/account/edit_forum_preferences_form.php\">".tra("Community preferences")."</a>"
    );
    if (!no_computing()) {
        row2(tra("Resource share and graphics"),
            "<a href=\"/account/prefs.php?subset=project\">".tra("%1 preferences", PROJECT)."</a>"
        );
    }
}

function show_community_private($user) {
    row1(tra("Community"));

    if ($user->has_profile) {
        $x = "<a href=\"/community/view_profile.php?userid=$user->id\">".tra("View")."</a> | <a href=\"/account/delete_profile.php\">".tra("Delete")."</a>";
    } else {
        $x = "<a href=\"/account/create_profile.php\">".tra("Create")."</a>";
    }
    row2(tra("Profile"), $x);
    $tot = total_posts($user);
    if ($tot) {
        row2(tra("Message boards"), "<a href=\"/community/forum/user_posts.php?userid=$user->id\">".tra("%1 posts", $tot)."</a>");
    }
    
    row2(tra("Private messages"), pm_notification($user).pm_email_remind($user));

    $notifies = BoincNotify::enum("userid=$user->id");
    if (count($notifies)) {
        $x = "";
        foreach ($notifies as $notify) {
            $x .= "&bull; ".notify_description($notify)."<br>";
        }
        $x .= "<a href=\"".notify_rss_url($user)."\"><img vspace=\"4\" border=\"0\" src=\"img/rss_icon.gif\" alt=\"RSS\" /></a>";
        row2(tra("Notifications"), $x);
    }

    if ($user->teamid) {
        $team = lookup_team($user->teamid);
        $x = "<a href=\"/community/team/display.php?teamid=$team->id\">$team->name</a>
            | <a href=\"/community/team/quit_form.php\">".tra("Quit team")."</a>";
        if (is_team_admin($user, $team)) {
            $x .= " | <a href=\"/community/team/manage.php?teamid=$user->teamid\">".tra("Administer")."</a>";
        }

        // if there's a foundership request, notify the founder
        //
        if ($user->id==$team->userid && $team->ping_user >0) {
            $x .= "<span style=\"color:red;\">".tra("(foundership change request pending)")."</span>";
        }
        row2(tra("Member of team"), $x);
    } else {
        row2(tra("Team"), tra("None")." | <a href=\"/community/team/search.php\">".tra("find a team")."</a>");
    }
    
    $teams_founded = BoincTeam::enum("userid=$user->id");
    foreach ($teams_founded as $team) {
        if ($team->id != $user->teamid) {
            $x = "<a href=\"/community/team/display.php?teamid=$team->id\">$team->name</a>";
            $x .= "| <a href=\"/community/team/manage.php?teamid=".$team->id."\">".tra("Administer")."</a>";
            if ($team->ping_user > 0) {
                $x .= "<span style=\"color:red;\">".tra("(foundership change request pending)")."</span>";
            }
            row2(tra("Founder but not member of"), $x);
        }
    }

    $friends = BoincFriend::enum("user_src=$user->id and reciprocated=1");
    $x = "<a href=\"/community/user_search.php\">".tra("Find friends")."</a><br\>\n";
    $n = count($friends);
    if ($n) {
        foreach($friends as $friend) {
            $fuser = BoincUser::lookup_id($friend->user_dest);
            $x .= friend_links($fuser);
        }
        row2(tra("Friends")." ($n)", $x);
    } else {
        row2(tra("Friends"), $x);
    }
}

// show summary of dynamic and static info (public)
//
function show_user_summary_public($user) {
    global $g_logged_in_user;
    row2(tra("%1 member since", PROJECT), date_str($user->create_time));
    row2(tra("Country"), $user->country);
    if (strlen($user->url)) {
        row2(tra("URL"), "<a href=\"http://$user->url\">http://$user->url</a>");
    }
    if (!no_computing()) {
        show_credit($user);

        if ($user->show_hosts) {
            row2(tra("Computers"), "<a href=\"/community/hosts_user.php?userid=$user->id\">".tra("View")."</a>");
        } else {
            row2(tra("Computers"), tra("hidden"));
        }
    }
    if ($user->donated == 1) { 
        if (file_exists("../project/donations.inc")) {
            require_once(PROJECT_HTML_FOLDER."project/donations.inc");
            $x .= DONATION_LINK;
            row2(tra("Donor"), $x);
        }
    }
}

function community_links($user) {
    global $g_logged_in_user;
    if ($user->teamid && ($team = lookup_team($user->teamid))) {
        row2(tra("Team"), "<a href=\"".URL_BASE."community/team/display.php?teamid=$team->id\">$team->name</a>");
    } else {
        row2(tra("Team"), tra("None"));
    }
    $tot = total_posts($user);
    if ($tot) {
        row2(tra("Message boards"), "<a href=\"".URL_BASE."community/forum/user_posts.php?userid=$user->id\">".tra("%1 posts", $tot)."</a>");
    }
    if ($g_logged_in_user && $g_logged_in_user->id != $user->id) {
        row2(tra("Contact"), "<a href=\"/community/pm.php?action=new&userid=".$user->id."\">".tra("Send private message")."</a>");
        $friend = BoincFriend::lookup($g_logged_in_user->id, $user->id);
        if ($friend && $friend->reciprocated) {
            row2(tra("This person is a friend"), 
                "<a href=\"/community/friend.php?action=cancel_confirm&userid=$user->id\">".tra("Cancel friendship")."</a>"
            );
        } else if ($friend) {
            row2(tra("Friends"),  "<a href=\"/community/friend.php?action=add&userid=$user->id\">".tra("Request pending")."</a>");
        } else {
            row2(tra("Friends"),  "<a href=\"/community/friend.php?action=add&userid=$user->id\">".tra("Add as friend")."</a>");
        }
    }
    $friends = BoincFriend::enum("user_src=$user->id and reciprocated=1");
    $n = count($friends);
    if ($n) {
        $x = null;
        foreach($friends as $friend) {
            $fuser = BoincUser::lookup_id($friend->user_dest);
            $x .= friend_links($fuser);
        }
        row2(tra("Friends")." ($n)", $x);
    }
}

function show_profile_link($user) {
    if ($user->has_profile) {
        row2(tra("Profile"), "<a href=\"/community/view_profile.php?userid=$user->id\">".tra("View")."</a>");
    }
}

function make_user(
    $email_addr, $name, $passwd_hash,
    $country=null, $postal_code=null, $project_prefs=null, $teamid=0
) {
    if (!is_valid_email_addr($email_addr)) return null;
    $authenticator = random_string();
    $cross_project_id = random_string();
    $now = time();
    if (!is_valid_country($country)) return null;
    $country = BoincDb::escape_string($country);
    $postal_code = strip_tags(process_user_text($postal_code));

    $ret = BoincUser::insert("(create_time, email_addr, name, authenticator, country, postal_code, total_credit, expavg_credit, expavg_time, project_prefs, teamid,  send_email, show_hosts, cross_project_id, passwd_hash) values($now, '$email_addr', '$name', '$authenticator', '$country', '$postal_code', 0, 0, unix_timestamp(), '$project_prefs', $teamid, 1, 1, '$cross_project_id', '$passwd_hash')");

    if ($ret) {
        $db = BoincDb::get();
        $id = $db->insert_id();
        return BoincUser::lookup_id($id);
    } else {
        return null;
    }
}

$cvs_version_tracker[]="\$Id: user.inc 15268 2008-05-21 16:37:11Z boincadm $";  //Generated automatically - do not edit

?>
