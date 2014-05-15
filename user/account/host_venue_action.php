<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");

$user = get_logged_in_user();

$venue = get_venue("venue");
$hostid = get_int("hostid");

$host = BoincHost::lookup_id($hostid);
if (!$host) {
    error_page("No such host");
}
if ($host->userid != $user->id) {
    error_page("Not your host");
}

$retval = $host->update("venue='$venue'");
if ($retval) {
    display_page_top("Host venue updated");
    if ($venue == '') {
        $venue = '(none)';
    }
    echo "
        The venue of this host has been set to <b>$venue</b>.
        <p>
        This change will take effect the next time the
        host communicates with this project.
        <p>
        <a href=/community/show_host_detail.php?hostid=$hostid>Return to host page</a>.
    ";
    display_page_bottom();
} else {
    db_error_page();
}

?>
