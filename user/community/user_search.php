<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/user.inc");

// We have indices on id, name, total credit, and RAC.
// So we provide the following searches:
// - new users in last N days (1, 7)
// - users with names starting with X
// - users ordered by decreasing total credit
// - users ordered by decreasing RAC
//
// In addition you can filter by:
// - a given country
// - with/without profile
// - with/without team
//
// We don't do the filtering in the SQL, because that would
// lead to table scans in the worst case.
// Instead we use the following policies:
// - a given search can scan no more than MAX_ROWS rows
// - a given search can return no more than MAX_RESULTS results
//
// here's how we do this:
// result_list = empty
// while n<MAX_ROWS
//   enumerate rows w/o filtering, limit n, 1000
//      (read only the fields we need for display)
//   scan through batch, doing filtering, appending to result_list


function filter_user($user, $filter) {
    if ($filter->do_country && $user->country!=$filter->country) return false;
    if ($filter->do_profile) {
        if (!($user->has_profile!=0 xor $filter->has_profile)) return false;
    }
    if ($filter->do_team) {
        if ($filter->team xor $user->teamid!=0) return false;
    }
    return true;
}

function show_user($user) {
    echo "
        <tr class=row1>
        <td>", user_links($user), "</td>
    ";
    if ($user->teamid) {
        $team = BoincTeam::lookup_id($user->teamid);
        echo "
            <td> <a href=/community/team/display.php?teamid=$team->id>$team->name</a> </td>
        ";
    } else {
        echo "<td><br></td>";
    }
    echo "
        <td align=right>", format_credit($user->expavg_credit), "</td>
        <td align=right>", format_credit_large($user->total_credit), "</td>
        <td>", $user->country, "</td>
        <td>", time_str($user->create_time),"</td>
        </tr>
    ";
}

function do_search($order, $filter) {
    $filtered_list = array();
    $nrows_scanned = 0;
    $fields = "id, create_time, name, country, total_credit, expavg_credit, teamid, url, has_profile, donated";
    while (1) {
        if (count($filtered_list) > 500) break;
        $limit_clause = " limit $nrows_scanned, 1000";
        $users = BoincUser::enum_fields($fields, null, $order.$limit_clause);
        $n = count($users);
        $nrows_scanned += $n;
        if ($nrows_scanned > 10000) break;
        if ($n==0) break;
        foreach($users as $user) {
            if (filter_user($user, $filter)) {
                $filtered_list[] = $user;
            }
        }
    }
    start_table();
    table_header("Name", "Team", "Average credit", "Total credit", "Country", "Joined");
    foreach ($filtered_list as $user) {
        show_user($user);
    }
    end_table();
}

function search_form() {
    display_page_top("User search");
    echo "<form name=f method=get action=/community/user_search.php>";
    start_table();
    row1("Search type", 2, "heading");
    row2("User name starts with <input name=search_string>", "<input type=radio name=search_type value=\"name_prefix\" checked >");
    row2("Decreasing sign-up time", "<input type=radio name=search_type value=\"date\">");
    row2("Decreasing average credit", "<input type=radio name=search_type value=\"rac\">");
    row2("Decreasing total credit", "<input type=radio name=search_type value=\"total\">");
    row1("Filters", 2, "heading");
    row2_init("Country", "<select name=country><option value=\"any\" selected>Any</option>");
    print_country_select("asdf");
    echo "</select></td></tr>";
    row2("With profile?",
        "<input type=radio name=profile value=either checked=1> Either
        <input type=radio name=profile value=no> No
        <input type=radio name=profile value=yes> Yes
    ");
    row2("On a team?",
        "<input type=radio name=team value=either checked=1> Either
        <input type=radio name=team value=no> No
        <input type=radio name=team value=yes> Yes
    ");
    row2("", "<input type=submit name=action value=Search>");
    end_table();
    echo "
        <script>document.f.search_string.focus()</script>
    ";
            
    display_page_bottom();
}

function name_search($filter) {
    $count = 100;
    $search_string = get_str('search_string');

    if (strlen($search_string)<3) {
        error_page("search string must be at least 3 characters");
    }
    $urls = urlencode($search_string);
    $s = escape_pattern($search_string);
    $fields = "id, create_time, name, country, total_credit, expavg_credit, teamid, url, has_profile";
    $users = BoincUser::enum_fields($fields, "name like '$s%'", "limit $count");
    $n=0;
    foreach ($users as $user) {
        if (!filter_user($user, $filter)) continue;
        if ($n==0) {
            echo "<h3>User names starting with '".htmlspecialchars($search_string)."' $nice_name</h3>\n";
            start_table();
            table_header("Name", "Team", "Average credit", "Total credit", "Country", "Joined");

        }
        show_user($user);
        $n++;
    }
    end_table();
    if (!$n) {
        echo "No users matching your search criteria.";
    }
}

function main() {
    $search_type = get_str('search_type', true);
    if ($search_type) {
        switch ($search_type) {
        case 'date':
            $order = 'order by id desc';
            break;
        case 'rac':
            $order = 'order by expavg_credit desc';
            break;
        case 'total':
            $order = 'order by total_credit desc';
            break;
        case 'name_prefix':
            break;
        default:
            error_page("missing search type");
        }

        $filter = null;
        $filter->do_country = false;
        $filter->do_profile = false;
        $filter->do_team = false;
        $country = get_str('country');
        if ($country != 'any') {
            $filter->do_country = true;
            $filter->country = $country;
        }
        switch (get_str('profile')) {
        case 'yes':
            $filter->do_profile = true;
            $filter->profile = true;
            break;
        case 'no':
            $filter->do_profile = true;
            $filter->profile = false;
            break;
        case 'either':
            $filter->do_profile = false;
            break;
        }
        switch (get_str('team')) {
        case 'yes':
            $filter->do_team = true;
            $filter->team = true;
            break;
        case 'no':
            $filter->do_team = true;
            $filter->team = false;
            break;
        case 'either':
            $filter->do_team = false;
            break;
        }
        display_page_top("User search results");
        if ($search_type == 'name_prefix') {
            name_search($filter);
        } else {
            do_search($order, $filter);
        }
        display_page_bottom();
    } else {
        search_form();
    }
}

main();

$cvs_version_tracker[]="\$Id: user_search.php 13586 2007-09-13 09:46:36Z Rytis $";  //Generated automatically - do not edit
?>
