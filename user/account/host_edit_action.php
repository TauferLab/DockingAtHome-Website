<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/host.inc");

function fail($msg) {
    echo "Error: $msg";
    display_page_bottom();
    exit();
}

function get_host($hostid, $user) {
    $host = BoincHost::lookup_id($hostid);
    if (!$host || $host->userid != $user->id) {
        fail("We have no record of that computer");
    }
    return $host;
}

$user = get_logged_in_user();

display_page_top("Merge computer records");

$nhosts = get_int("nhosts");
$hostid = get_int("id_0");
$latest_host = get_host($hostid, $user);
for ($i=1; $i<$nhosts; $i++) {
	$var = "id_$i";
	$hostid = get_int($var, true);
    if (!$hostid) continue;
	$host = get_host($hostid, $user);
	if ($host->create_time > $latest_host->create_time) {
		$error = merge_hosts($latest_host, $host);
        if ($error) {
            fail($error);
        }
		$latest_host = $host;
	} else {
		merge_hosts($host, $latest_host);
	}
	// reread latest_host from database since we just
	// updated its credits
	//
	$latest_host = BoincHost::lookup_id($latest_host->id);
}
echo "
	<p><a href=/account/hosts_user.php>Return to list of your computers</a>
";
display_page_bottom();

//Header("Location: show_host_detail.php?hostid=$latest_host->id");

?>
