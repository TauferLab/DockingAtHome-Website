<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT'].'/../inc/forum.inc');
require_once($_SERVER['DOCUMENT_ROOT'].'/../inc/util.inc');
require_once($_SERVER['DOCUMENT_ROOT'].'/../inc/time.inc');

$user = get_logged_in_user(false);

display_page_top("Questions and answers");

echo "<p>
    Talk live via Skype with a volunteer, in any of several languages.
    Go to
    <a href=\"http://boinc.berkeley.edu/help.php\">BOINC Online Help</a>.</p>
";

show_forum_header($user);

$categories = BoincCategory::enum("is_helpdesk=1 order by orderID");
$first = true;
foreach ($categories as $category) {
    if ($first) {
        $first = false;
        show_forum_title($category, null, null);
        show_mark_as_read_button($user);
        echo "<p>";
        start_forum_table(array("Topic", "# Questions", "Last post"));
    }
    if (strlen($category->name)) {
        echo "
            <tr class=\"subtitle\">
            <td class=\"category\" colspan=\"4\">", $category->name, "</td>
            </tr>
        ";
    }

    $forums = BoincForum::enum("parent_type=0 and category=$category->id order by orderID");
    foreach ($forums as $forum) {
        echo "
        <tr class=\"row1\">
        <td>
            <b><a href=\"/community/forum/forum.php?id=$forum->id\">$forum->title</a></b>
            <br>", $forum->description, "
        </td>
        <td>", $forum->threads, "</td>
        <td>", time_diff_str($forum->timestamp, time()), "</td>
    </tr>
        ";
    }
}

echo "
    </table>
</p>
";

display_page_bottom();

$cvs_version_tracker[]="\$Id: forum_help_desk.php 14487 2008-01-08 00:34:55Z boincadm $";  //Generated automatically - do not edit
?>
