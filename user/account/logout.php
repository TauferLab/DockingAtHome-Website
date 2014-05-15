<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");

$next_url = $_GET["next_url"];
if (empty($next_url)) $next_url = "/";

$user = get_logged_in_user(false);

if ($user) {
    check_tokens($user->authenticator);
    clear_cookie('auth');
    $notice = "Successfully logged out.";
	setMessage("notice",$notice);
	gotoLocation($next_url);
} else {
    $error = "No user was logged in.";
	setMessage("error",$error);
	gotoLocation($next_url);
}

?>
