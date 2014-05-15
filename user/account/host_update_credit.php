<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/host.inc");

function fail($msg) {
    echo "Error: $msg";
    display_page_bottom();
    exit();
}

function get_host($hostid, $user) {
    $host = lookup_host($hostid);
    if (!$host || $host->userid != $user->id) {
        fail("We have no record of that computer");
    }
    return $host;
}

db_init();
$user = get_logged_in_user();

display_page_top("Updating computer credit");

$hostid = get_int("hostid");
host_update_credit($hostid);
echo "<br>Host credit updated";
display_page_bottom();

?>
