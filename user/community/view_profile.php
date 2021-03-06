<?php

require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once(PROJECT_HTML_FOLDER."inc/profile.inc");

$userid = get_int('userid');
$user = BoincUser::lookup_id($userid);
if (!$user) {
    error_page("No such user");
}
 
$logged_in_user = get_logged_in_user(false);
$caching = false;
if (!$logged_in_user) {
    $caching = true;
    $cache_args = "userid=$userid";
    start_cache(USER_PROFILE_TTL, $cache_args);
}
display_page_top("Profile: $user->name");

start_table();
echo "<tr><td valign=top>";
start_table();
show_profile($user, $logged_in_user);
end_table();
echo "</td><td valign=top>";
start_table();
row2("Account data", "<a href=show_user.php?userid=$userid>View</a>");
community_links($user);
end_table();
echo "</td></tr></table>";

display_page_bottom();

if ($caching) {
    end_cache(USER_PROFILE_TTL, $cache_args);
}

?>
