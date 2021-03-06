<?php
// Allows users to search for a post or thread.
// Sends to forum_search_action.php for action and display.
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT'].'/../inc/forum.inc');

display_page_top(tra("Forum search"));

start_table();
echo "<form action=\"/community/forum/search_action.php\" method=\"post\">";
row1("Search query");
row2("Search for keywords:<br />
    <font size=-1>Posts that contain all the specified words will be displayed</font>",
    '<input type="text" style="width: 290px" name="search_keywords" size="30" /><br />
    <font size=-1>For example: "screensaver freeze"</font>');
row2("Search for author ID:<br />
    <font size=-1>Only posts by this author will be displayed</font>",
    '<input type="text" style="width: 150px" name="search_author" size="10" /><br />
    <font size=-1>For example: "43214"</font>');

row1("Search options");
row2("Search limits<br />
    <font size=-1>Search at most this many days back in time</font>",
    '<select name="search_max_time">
    <option value="1">1 day</option>
    <option value="3">3 days</option>
    <option value="7">7 days</option>
    <option value="15">15 days</option>
    <option value="30" selected>30 days</option>
    <option value="90">3 months</option>
    <option value="180">6 months</option>
    <option value="360">1 year</option>
    </select>');

$forumid = null;
if (get_str("forumid",true)){
    $forumid = get_str("forumid");
}
$forumlist="<option value=\"-1\">All</option>";
$categories = BoincCategory::enum();
foreach ($categories as $category) {
    $forums = BoincForum::enum("parent_type=0 and category=$category->id");
    foreach ($forums as $forum) {
        if ($forum->id==$forumid){
            $forumlist.="<option selected value=\"".$forum->id."\">".$forum->title."</option>";
        } else {
            $forumlist.="<option value=\"".$forum->id."\">".$forum->title."</option>";
        }
    }
}
row2("Forum<br />
    <font size=-1>Only display posts from this forum</font>",
    '<select name="search_forum">'.$forumlist.'</select');

$sortlist = null;
foreach ($thread_sort_styles as $id => $style){
    if ($id == CREATE_TIME_NEW){
        $sortlist.="<option selected value=\"".$id."\">".$style."</option>";
    } else {
        $sortlist.="<option value=\"".$id."\">".$style."</option>";
    }
}
row2("Sort by", 
    '<select name="search_sort">'.$sortlist.'</select');

row1("&nbsp;");
row2("","<input type=\"submit\" value=\"Start the search\">");
echo "</form>";
end_table();

display_page_bottom();
exit;

$cvs_version_tracker[]="\$Id: forum_search.php 14297 2007-11-25 04:47:54Z davea $";  //Generated automatically - do not edit
?>
