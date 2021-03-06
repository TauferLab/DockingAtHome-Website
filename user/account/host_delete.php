<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/host.inc");

$user = get_logged_in_user();

$hostid = get_int("hostid");
$host = BoincHost::lookup_id($hostid);
if (!$host || $host->userid != $user->id) {
    error_page("We have no record of that computer.");
}

$nresults = host_nresults($host);
if ($nresults == 0) {
    $host->delete();
} else {
    error_page(
        "You can not delete our record of this computer because our
        database still contains work for it.
        You must wait a few days until the work for this computer
        has been deleted from the project database."
    );
}
display_page_top("Delete record of computer");
echo "
    Record deleted.
    <p><a href=../hosts_user.php>Return to list of your computers</a>
";
display_page_bottom();

?>
