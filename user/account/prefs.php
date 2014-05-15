<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/prefs.inc");

db_init();

$user = get_logged_in_user();

$subset = get_str("subset");
$columns = get_int("cols", true);
$updated = get_int("updated", true);

display_page_top(subset_name($subset)." preferences");

if (isset($updated)) {
	setMessage("notice","Your preferences have been updated.
        Client-related preferences
        will take effect when your computer communicates
        with ".PROJECT." or
        you issue the \"Update\" command from the BOINC client.");
}
if ($subset == "global") {
    print_prefs_display_global($user, $columns);
} else {
    print_prefs_display_project($user, $columns);
}
display_page_bottom();

?>
