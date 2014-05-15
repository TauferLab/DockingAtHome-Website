<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/user.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");

$code = get_str("code");
$userid = get_int('userid');
$user = lookup_user_id($userid);
if (!$user) {
    error_page("no user");
}

if (salted_key($user->authenticator) != $code) {
    error_page("bad code");
}

$result = $user->update("send_email=0");

if ($result) {
    display_page_top("$email removed from mailing list");
    echo "
        No further emails will be sent to $user->email_addr.
        To resume getting emails,
        go <a href=".URL_BASE."account/prefs_edit.php?subset=project>here</a>
    ";
    display_page_bottom();
}
error_page("database error");

?>
