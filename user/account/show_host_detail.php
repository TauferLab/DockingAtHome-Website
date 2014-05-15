<?php

require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/user.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/host.inc");

$hostid = get_int("hostid");
$ipprivate = get_str("ipprivate", true);
$host = BoincHost::lookup_id($hostid);
if (!$host) {
    echo "Couldn't find computer";
    exit();
}

$user = get_logged_in_user(false);
if ($user->id != $host->userid) {
    $user = null;
}

display_page_top("Computer summary");
show_host($host, $user, $ipprivate);
display_page_bottom();

?>
