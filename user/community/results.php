<?php

// show recent results for a host or user
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/result.inc");

$config = get_config();
if (!parse_bool($config, "show_results")) {
    error_page("This feature is turned off temporarily");
}

$results_per_page = 20;

$hostid = get_int("hostid", true);
$userid = get_int("userid", true);
$offset = get_int("offset", true);
if (!$offset) $offset=0;

if ($hostid) {
    $host = BoincHost::lookup_id($hostid);
    $type = "computer";
    $clause = "hostid=$hostid";
} else {
    $user = get_logged_in_user();
    if ($userid != $user->id) {
        setMessage("error","Sorry, you can only access your tasks.");
		gotoLocation("/account/");
    }
    $type = "user";
    $clause = "userid=$userid";
}
display_page_top("Tasks for $type");
result_table_start(true, false, true);
$i = 0;
$query = "$clause order by id desc limit $offset,".($results_per_page+1);
$results = BoincResult::enum($query);
$number_of_results = count($results);
echo show_result_navigation(
    $clause, $number_of_results, $offset, $results_per_page
);
foreach ($results as $result) {
    if ($i >= $results_per_page) break;
    show_result_row($result, true, false, true);
    $i++;
}
echo "</table>\n";

echo show_result_navigation(
    $clause, $number_of_results, $offset, $results_per_page
);
?>
<div id="explain_server_state" style="display:none;">
	<p>A tasks's <b>server state</b> indicates
        whether the task has been sent to a computer,
        and if so whether the computer has finished it.
        Possible values are:</p>
    <p><b>Inactive</b>: The task is not ready to send (for example, because its input files are unavailable)</p>
    <p><b>Unsent</b>: The task is ready to send, but hasn't been sent yet.</p>
    <p><b>In Progress</b>: The task has been sent; waiting for completion.</p>
    <p><b>Over</b>: The task has been sent to a computer and either it has timed out or the computer has reported its completion.</p>
</div>
<div id="explain_result_outcome" style="display:none;">
	<p>A tasks's <b>outcome</b> is defined if its server state is <b>over</b>.
        Possible values are:</p>
    <p><b>Unknown</b>: The task was sent to a computer, but the computer has not yet completed the work and reported the outcome.</p>
    <p><b>Success</b>: A computer completed and reported the task successfully.</p>
    <p><b>Couldn't send</b>: The server wasn't able to send the task to a computer (perhaps because its resource requirements were too large)</p>
    <p><b>Client error</b>: The task was sent to a computer and an error occurred.</p>
    <p><b>No reply</b>: The task was sent to a computer and no reply was received within the time limit.</p>
    <p><b>Didn't need</b>: The task wasn't sent to a computer because enough other tasks were completed for this workunit.</p>
    <p><b>Validate error</b>: The task was reported but could not be validated, typically because the output files were lost on the server.</p>
</div>
<div id="explain_result_client_state" style="display:none;">
	<p>A result's <b>client state</b>
        indicates the stage of processing at which an error occurred.</p>
    <p><b>New</b>: The computer has not yet completed the task.</p>
    <p><b>Done</b>: The computer completed the task successfully.</p>
    <p><b>Downloading</b>: The computer couldn't download the application or input files.</p>
    <p><b>Computing</b>: An error occurred during computation.</p>
    <p><b>Uploading</b>: The computer couldn't upload the output files.</p>
</div>
<div id="explain_result_time" style="display:none;">
	<p>A task's <b>Time reported or deadline</b> field depends
        on whether the task has been reported yet:</p>
    <p><b>Already reported</b>: The date/time it was reported</p>
    <p><b>Not reported yet</b>: Deadline in the future, shown in green.</p>
    <p><b>Not reported yet</b>: Deadline in the past, shown in red.</p>
</div>
<?
display_page_bottom();
?>
