<?php
// This page shows basic account details about a given user
// The page can be output as either XML or HTML.
// If output as xml the user may optionally
// also get a list of hosts in case the user provides his/her authenticator.
// Object-caching and full-file caching is used to speed up queries
// for data from this page.

require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/cache.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/xml.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/user.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/forum.inc");

$id = get_int("userid", true);
$format = get_str("format", true);
$auth = get_str("auth", true);

if ($format=="xml"){
    // XML doesn't need translating, so use the full-file cache for this
    //
    $cache_args="userid=".$id."&auth=".$auth;
    start_cache(USER_PAGE_TTL, $cache_args);
    xml_header();
    $retval = db_init_xml();
    if ($retval) xml_error($retval);
    if ($auth){
        $user = lookup_user_auth($auth);        
        $show_hosts = true;
    } else {
        $user = lookup_user_id($id);
        if ($user) {
            $user = get_other_projects($user);
        }
        $show_hosts = false;
    }
    if (!$user) xml_error(-136);

    show_user_xml($user, $show_hosts);
    end_cache(USER_PAGE_TTL, $cache_args);
} else {
    db_init();  // need to do this in any case,
        // since show_user_summary_public() etc. accesses DB

    // The page may be presented in many different languages,
    // so here we cache the data instead
    //
    $cache_args="userid=".$id;
    $cached_data = get_cached_data(TOP_PAGES_TTL, $cache_args);
    if ($cached_data){
        // We found some old but non-stale data, let's use it
        $user = unserialize($cached_data);
    } else {
        // No data was found, generate new data for the cache and store it
        $user = lookup_user_id($id);
        BoincForumPrefs::lookup($user);
        $user = get_other_projects($user);
        set_cache_data(serialize($user), $cache_args);
    }
    if (!$user->id) {
        error_page("No such user found - please check the ID and try again.");
    }

    get_logged_in_user(false);

    display_page_top("Account data for $user->name");
    start_table();
    echo "<tr><td valign=top>";
    start_table();
    show_user_summary_public($user);
    end_table();
    project_user_summary($user);
    show_other_projects($user, false);
    echo "</td><td valign=top>";
    start_table();
    show_profile_link($user);
    community_links($user);
    end_table();
    echo "</td></tr></table>";
    display_page_bottom();
}

?>
