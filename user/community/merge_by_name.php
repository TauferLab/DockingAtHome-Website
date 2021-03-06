<?php

require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/host.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");

db_init();

function merge_name($list) {
    // find the newest one
    //
    $newest_host = $list[0];
    echo "<br><br>Processing $newest_host->domain_name\n";
    foreach ($list as $host) {
        if ($host->create_time > $newest_host->create_time) {
            $newest_host = $host;
        }
    }
    foreach ($list as $host) {
        if ($host->id == $newest_host->id) {
            continue;
        }
        $error = merge_hosts($host, $newest_host);
        if (!$error) {
            echo "<br>Merged $host->id into $newest_host->id\n";
        } else {
            echo "<br>$error\n";
        }
    }
}

function merge_by_name($userid) {
    $hosts = array();
    $host_list = BoincHost::enum("userid=$userid");
    foreach($host_list as $host) {
        $hosts[$host->domain_name][] = $host;
    }
    foreach($hosts as $hlist) {
        merge_name($hlist);
    }
}

$user = get_logged_in_user();

display_page_top("Merge computers by name");

if ($_GET['confirmed']) {
    check_tokens($user->authenticator);
    merge_by_name($user->id);
    echo "
        <p><a href=hosts_user.php>
        Return to the list of your computers</a>.
    ";
} else {
    $tokens = url_tokens($user->authenticator);
    echo "
        This operation merges computers based on their domain name.
        <p>
        For each domain name, it will merge all older computers
        having that name with the newest computer having that name.
        Incompatible computers will not be merged.
        <p>
        <a href=merge_by_name.php?confirmed=1&$tokens>Go ahead and do this</a>.
        <p><a href=hosts_user.php>Return to the list of computers</a>.
    ";
}
display_page_bottom();
?>
