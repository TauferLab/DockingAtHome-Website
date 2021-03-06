<?php

function result_claimed_credit_string($result, $string_to_show) {
    if ($result->server_state <> 5) return "---";
    switch($result->outcome) {
    case 1: return $string_to_show; //Success
    case 2: return "---"; //Couldn't send
    case 3: if ($result->exit_status <> -221) {
                return $string_to_show; //Client error
	    } else return "---"; // Aborted by server
    case 4: return "---"; //No reply
    case 5: return "---"; //Didn't need
    case 6: return "---"; // Validate error
    case 7: return "---"; // client detached
    default: return $string_to_show;
    }
}

function result_granted_credit_string($result, $string_to_show) {
    if ($result->server_state <> 5) return "---";
    switch($result->outcome) {
    case 1:              //Success
        switch ($result->validate_state) {
        case 0:
        case 4:
            return "pending";
        }
        return $string_to_show;
    case 2: return "---"; //Couldn't send
    case 3: return "---"; //Client error
    case 4: return "---"; //No reply
    case 5: return "---"; //Didn't need
    case 6: return "---"; //Validate error
    case 7: return "---"; // client detached
    default: return $string_to_show;
    }
} 

function result_server_state_string($result) {
    switch($result->server_state) {
    case 1: return "Inactive";
    case 2: return "Unsent";
    case 4: return "In Progress";
    case 5: return "Over";
    }
    return "Unknown";
}

function result_outcome_string($result) {
    switch($result->outcome) {
    case 1: return "Success";
    case 2: return "Couldn't send";
    case 3: if ($result->exit_status <> -221) {
               return "Client error";
	    } else return "Redundant result";
    case 4: return "No reply";
    case 5: return "Didn't need";
    case 6: return "Validate error";
    case 7: return "Client detached";
    }
    return "Unknown";
}

function result_client_state_string($result) {
    switch($result->client_state) {
    case 0: return "New";
    case 1: return "Downloading";
    case 2: return "Computing";
    case 3: return "Compute error";
    case 4: return "Uploading";
    case 5: return "Done";
    case 6: if ($result->exit_status <> -221) {
               return "Aborted by user";
	    } else return "Cancelled by server";
    }
}

function validate_state_str($result) {
    switch($result->validate_state) {
    case 0: return "Initial";
    case 1: return "Valid";
    case 2: if ($result->exit_status <> -221) {
               return "Invalid";
	    } else return "Not necessary";
    case 3: return "Workunit error - check skipped";
    case 4: return "Checked, but no consensus yet";
    case 5: return "Task was reported too late to validate";
    }
    return "Unknown";
}

function wu_error_mask_str($s) {
    $x = "";
    if ($s & 1) {
        $x = $x."Couldn't send result ";
        $s -= 1;
    }
    if ($s & 2) {
        $x = $x."Too many error results ";
        $s -= 2;
    }
    if ($s & 4) {
        $x = $x."Too many success results ";
        $s -= 4;
    }
    if ($s & 8) {
        $x = $x."Too many total results ";
        $s -= 8;
    }
    if ($s & 16) {
        $x = $x."Cancelled ";
        $s -= 16;
    }
    if ($s) {
        $x = $x."Unrecognized Error: $s ";
    }
    if (strlen($x)) {
    } else {
        $x="<br>";
    }
    return $x;
}

function result_table_start($show_wu_link, $show_host_link, $show_result_link) {
    start_table();
    echo "
        <tr>
    ";
    if ($show_result_link) {
        echo "<th>Task ID<br><span class=\"smalltext\">click for details</span></th>\n";
    }
    if ($show_wu_link) {
        echo "<th>Work unit ID<br><span class=\"smalltext\">click for details</span></th>\n";
    }
    if ($show_host_link) {
        echo "<th>Computer</th>\n";
    }
    echo "
        <th>Sent</th>
        <th>Time reported
            <br>or deadline
            <br><span class=\"smalltext\"><a href=\"#TB_inline?height=150&width=400&inlineId=explain_result_time\" class=\"thickbox\">explain</a></span>
        </th>
        <th>Server state
            <br><span class=\"smalltext\"><a href=\"#TB_inline?height=150&width=400&inlineId=explain_server_state\" class=\"thickbox\">explain</a></span>
        </th>
        <th>Outcome
            <br><span class=\"smalltext\"><a href=\"#TB_inline?height=150&width=400&inlineId=explain_result_outcome\" class=\"thickbox\">explain</a></span>
        </th>
        <th>Client state
            <br><span class=\"smalltext\"><a href=\"#TB_inline?height=150&width=400&inlineId=explain_result_client_state\" class=\"thickbox\">explain</a></span>
        </th>
        <th>CPU time (sec)</th>
        <th>claimed credit</th>
        <th>granted credit</th>
        </tr>
    ";
}

// was result invalid or timed out?
//
function bad_result($result) {
    if ($result->validate_state == 2) return true;
    if (!$result->received_time && ($result->report_deadline < time())) return true;
    return false;
}

function show_result_row(
    $result, $show_wu_link, $show_host_link, $show_result_link
) {
    $s = time_str($result->sent_time);
    // if result has been received, show the received time,
    // else show the reporting deadline in green if in the future
    // and in red if in the past.
    //
    if ($result->received_time) {
        $r = time_str($result->received_time);
    } else if ($result->report_deadline) {
        if ($result->report_deadline>time()) {
            $r = "<font color='#33cc33'>" . time_str($result->report_deadline) . "</font>";
        } else {
            $r = "<font color='#ff3333'>" . time_str($result->report_deadline) . "</font>";
        }
    } else {
        $r = "---";
    }
    $ss = result_server_state_string($result);
    $out = result_outcome_string($result);
    $cl = result_client_state_string($result);
    $result_claimed_credit = format_credit($result->claimed_credit);
    $result_granted_credit = format_credit($result->granted_credit);
    $result_claimed_credit = result_claimed_credit_string($result, $result_claimed_credit);
    $result_granted_credit = result_granted_credit_string($result, $result_granted_credit); 
    if (bad_result($result)) {
        echo "<tr class=invalid_result>";
    } else {
        echo "<tr>";
    }
    if ($show_result_link) {
        echo "<td><a href=\"result.php?resultid=$result->id\" title=\"Name: ".$result->name."\">$result->id</a></td>\n";
    }
    if ($show_wu_link) {
        echo "<td><a href=\"workunit.php?wuid=$result->workunitid\">$result->workunitid</a></td>\n";
    }
    if ($show_host_link) {
        echo "<td>", host_link($result->hostid), "</td>\n";
    }
    if ($result->server_state <> 5) {
        $cpu_time = "---";
    } else {
        $cpu_time = number_format($result->cpu_time, 2);
    }
    echo "
        <td>$s</td>
        <td>$r</td>
        <td>$ss</td>
        <td>$out</td>
        <td>$cl</td>
        <td>$cpu_time</td>
        <td>$result_claimed_credit</td>
        <td>$result_granted_credit</td>
        </tr>
    ";
}

function version_string($version_num) {
    if (!$version_num) {
        return '---';
    } else {
        return sprintf("%.2f", $version_num/100);
    }
}
function exit_status_string($result) {
    $x = $result->exit_status;
    if ($x == 0) {
        $y = parse_element($result->stderr_out, "<exit_status>");
        if ($y) {
            $x = (int)$y;
        }
    }
    return sprintf("%d (0x%x)", $x, $x);
}

function show_result($result) {
    start_table();
    row2("Task ID", $result->id);
    row2("Name", $result->name);
    row2("Workunit", "<a href=\"workunit.php?wuid=$result->workunitid\">$result->workunitid</a>");
    row2("Created", time_str($result->create_time));
    row2("Sent", time_str($result->sent_time));
    row2("Received", time_str($result->received_time));
    row2("Server state", result_server_state_string($result));
    row2("Outcome", result_outcome_string($result));
    row2("Client state", result_client_state_string($result));
    row2("Exit status", exit_status_string($result));
    row2("Computer ID", host_link($result->hostid));
    row2("Report deadline", time_str($result->report_deadline));
    row2("CPU time", $result->cpu_time);
    row2("stderr out", "<pre>".htmlspecialchars($result->stderr_out)."</pre>");
    row2("Validate state", validate_state_str($result));
    row2("Claimed credit", $result->claimed_credit);
    row2("Granted credit", $result->granted_credit);
    row2("application version", version_string($result->app_version_num));
    end_table();
}

function show_result_navigation(
    $clause, $number_of_results, $offset, $results_per_page
) {
    echo "<br><center>";
    if ($offset >= $results_per_page) {
        $offset_p = $offset-$results_per_page;
        echo "<a href=results.php?$clause&offset=$offset_p>Previous $results_per_page</a>";
    }
    if (($offset >= $results_per_page) && ($number_of_results > $results_per_page)) {
        echo "&nbsp;|&nbsp;";
    }
    if ($number_of_results > $results_per_page) {
        $offset_n = $offset+$results_per_page;
        echo "<a href=results.php?$clause&offset=$offset_n>Next $results_per_page</a></center><br>";
    } else {
        echo "</center><br><br>";
    }
}

$cvs_version_tracker[]="\$Id: result.inc 14200 2007-11-14 16:03:47Z davea $";  //Generated automatically - do not edit

?>
