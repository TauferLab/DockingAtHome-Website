<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/prefs.inc");

db_init();

$user = get_logged_in_user();
check_tokens($user->authenticator);

$action = get_str("action", true);
$subset = get_str("subset");
$venue = get_str("venue");
$columns = get_int("cols", true);
$c = $columns?"&cols=$columns":"";
check_venue($venue);
check_subset($subset);

if ($action) {
    if ($subset == "global") {
        $prefs = prefs_parse_global($user->global_prefs);
        $prefs->$venue = $prefs;
        $error = prefs_global_parse_form($new_prefs);
        if ($error != false) {
            $title = "Edit ".subset_name($subset)." preferences";
            if ($venue) $title = "$title for $venue";
            display_page_top($title);
			
            $x = $venue?"&venue=$venue":"";

            echo PREFS_FORM_DESC1;
            echo PREFS_FORM_ERROR_DESC;

            print_prefs_form(
                "add", $subset, $venue, $user, $new_prefs, $columns, $error
            );
        } else {
            $prefs->$venue = $new_prefs;
            global_prefs_update($user, $prefs);
            gotoLocation("prefs.php?subset=$subset$c");
        }
    } else {
        $prefs = prefs_parse_project($user->project_prefs);
        $prefs->$venue = $prefs;

        $project_error = prefs_project_parse_form($new_prefs);
        $error = prefs_resource_parse_form($new_prefs);
        if ($project_has_beta) prefs_beta_parse_form($new_prefs);

        if ($error != false || $project_error != false) {
            $title = "Edit ".subset_name($subset)." preferences";
            if ($venue) $title = "$title for $venue";
            display_page_top($title);
			
            $x = $venue?"&venue=$venue":"";

            echo PREFS_FORM_ERROR_DESC;

            print_prefs_form(
                "add", $subset, $venue, $user, $new_prefs, $columns,
                $error, $project_error
            );
        } else {
            $prefs->$venue = $new_prefs;
            project_prefs_update($user, $prefs);
            gotoLocation("prefs.php?subset=$subset&c");
        }
    }
} else {
    $title = "Add ".subset_name($subset)." preferences for $venue";
    display_page_top($title);
	
    if ($subset == "global") {
        $prefs = default_prefs_global();
    } else {
        $prefs = default_prefs_project();
    }
    print_prefs_form("add", $subset, $venue, $user, $prefs, $columns);
}
display_page_bottom();
$cvs_version_tracker[]="\$Id: add_venue.php 11995 2007-01-29 18:15:16Z boincadm $";  //Generated automatically - do not edit
?>
