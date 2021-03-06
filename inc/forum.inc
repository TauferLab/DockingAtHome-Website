<?php

if(!defined("PROJECT_HTML_FOLDER")) require_once("../project/project.inc");
require_once(PROJECT_HTML_FOLDER."inc/forum_db.inc");
require_once(PROJECT_HTML_FOLDER."inc/pm.inc");
require_once(PROJECT_HTML_FOLDER."inc/team.inc");
require_once(PROJECT_HTML_FOLDER."inc/text_transform.inc");

define('THREADS_PER_PAGE', 50);

// sorting styles
define('MODIFIED_NEW', 1);
define('MODIFIED_OLD',2);
define('VIEWS_MOST',3);
define('REPLIES_MOST',4);
define('CREATE_TIME_NEW',5);
define('CREATE_TIME_OLD',6);
define('POST_SCORE',7);

// names for the above
$thread_sort_styles[CREATE_TIME_OLD] = "Oldest post first";
$thread_sort_styles[CREATE_TIME_NEW] = "Newest post first";
$thread_sort_styles[POST_SCORE] = "Highest rated posts first";

$forum_sort_styles[MODIFIED_NEW] = "Newest reply first";
//$forum_sort_styles[MODIFIED_OLD] = "Oldest reply first";
$forum_sort_styles[VIEWS_MOST] = "Most views first";
$forum_sort_styles[REPLIES_MOST] = "Most posts first";
$forum_sort_styles[CREATE_TIME_NEW] = "Newest first";
//$forum_sort_styles[CREATE_TIME_OLD] = "Oldest first";

// values for thread.status
define('THREAD_SOLVED', 1);

define('AVATAR_WIDTH', 100);
define('AVATAR_HEIGHT',100);

define('ST_NEW_TIME', 1209600); //3600*24*14 - 14 days
define('ST_NEW', 'New member');

define('MAXIMUM_EDIT_TIME',3600);
    // allow edits of forums posts up till one hour after posting.

define('MAX_FORUM_LOGGING_TIME', 2419200); //3600*24*28 - 28 days
define('NO_CONTROLS', 0);
define('FORUM_CONTROLS', 1);
define('HELPDESK_CONTROLS', 2);
define("EXCERPT_LENGTH", "120");

define('NEW_IMAGE', '/img/unread_post.png');
define('NEW_IMAGE_STICKY', '/img/unread_sticky.png');
define('NEW_IMAGE_LOCKED', '/img/unread_locked.png');
define('NEW_IMAGE_STICKY_LOCKED', '/img/unread_sticky_locked.png');
define('IMAGE_STICKY', '/img/sticky_post.png');
define('IMAGE_LOCKED', '/img/locked_post.png');
define('IMAGE_STICKY_LOCKED', '/img/sticky_locked_post.png');
define('NEW_IMAGE_HEIGHT','15');
define('EMPHASIZE_IMAGE', '/img/emphasized_post.png');
define('EMPHASIZE_IMAGE_HEIGHT','15');
define('FILTER_IMAGE', '/img/filtered_post.png');
define('FILTER_IMAGE_HEIGHT','15');
define('RATE_POSITIVE_IMAGE', '/img/rate_positive.png');
define('RATE_POSITIVE_IMAGE_HEIGHT','9');
define('RATE_NEGATIVE_IMAGE', '/img/rate_negative.png');
define('RATE_NEGATIVE_IMAGE_HEIGHT','9');
define('REPORT_POST_IMAGE', '/img/report_post.png');
define('REPORT_POST_IMAGE_HEIGHT','9');

define ('SOLUTION', 'This answered my question');
define ('SUFFERER', 'I also have this question');
define ('OFF_TOPIC', 'Off-topic');

define ('DEFAULT_LOW_RATING_THRESHOLD', -25);
define ('DEFAULT_HIGH_RATING_THRESHOLD', 5);

// A list of what kind of special users exist
define('S_MODERATOR', 0);
define('S_ADMIN', 1);
define('S_DEV', 2);
define('S_TESTER', 3);
define('S_VOLUNTEER', 4);
define('S_VOLUNTEER_TESTER', 5);
define('S_SCIENTIST', 6);

$special_user_bitfield[S_MODERATOR]="Forum moderator";
$special_user_bitfield[S_ADMIN]="Project administrator";
$special_user_bitfield[S_DEV]="Project developer";
$special_user_bitfield[S_TESTER]="Project tester";
$special_user_bitfield[S_VOLUNTEER]="Volunteer developer";
$special_user_bitfield[S_VOLUNTEER_TESTER]="Volunteer tester";
$special_user_bitfield[S_SCIENTIST]="Project scientist";

// show a banner with search form on left and PM info on right
//
function show_forum_header($user) {
    start_table_noborder();
    echo "<tr>\n";
    
    // Search
    echo "<td><form action=\"/community/forum/search_action.php\" method=\"POST\">
        <input type=\"hidden\" name=\"search_max_time\" value=\"30\">
        <input type=\"hidden\" name=\"search_forum\" value=\"-1\">
        <input type=\"hidden\" name=\"search_sort\" value=\"5\">
        <input type=\"text\" name=\"search_keywords\">
        <input class=\"btn\" title=\"".tra("Search for words in forum messages")."\" type=\"submit\" value=\"".tra("Search forums")."\"><br>
        <span class=\"smalltext\"><a href=\"/community/forum/search.php\">".tra("Advanced search")."</a></span>
        </form>
    ";
    echo "</td>\n";
    
    if ($user) {
        echo "<td align=\"right\">\n";
        echo "<p>".tra("Private messages").": ", pm_notification($user);
        echo "</td>\n";
    }
    echo "</tr>\n";
    end_table();
}

// Output the forum/thread title.
//
function show_forum_title($category, $forum, $thread, $link_thread=false) {
    if ($category) {
        $is_helpdesk = $category->is_helpdesk;
    } else {
        $is_helpdesk = false;
    }
    $where = $is_helpdesk?tra("Questions and Answers"):tra("Message boards");
    $top_url = $is_helpdesk?"/community/forum/help_desk.php":"/community/forum/";
    if (!$forum && !$thread) {
        echo "<span class=\"title\">$where</span>";

    } else if ($forum && !$thread) {
        echo "<p>";
        echo "<a href=\"$top_url\">$where</a> : ";
        echo $forum->title;
        echo "</p>";
    } else if ($forum && $thread) {
        echo "<p>
            <a href=\"$top_url\">$where</a> : 
            <a href=\"/community/forum/forum.php?id=".$forum->id."\">", $forum->title, "</a> : 
        ";
        if ($link_thread) {
            echo "<a href=/community/forum/thread.php?id=$thread->id>";
        }
        echo cleanup_title($thread->title);
        if ($link_thread) {
            echo "</a>";
        }
        echo "</p>";
    } else {
        echo "<p>Invalid input to show_forum_title<br>";
        echo "threadid $thread->id </p>";
        // TODO: handle this condition gracefully 
    }
}

function show_team_forum_title($forum, $thread=null, $link_thread=false) {
    $team = BoincTeam::lookup_id($forum->category);
    echo "<span class=title>
        <a href=\"/community/forum/\">".tra("Message boards")."</a> :
    ";
    if ($thread) {
        echo "
            <a href=/community/team/forum.php?teamid=$team->id>".tra("%1 message board", $team->name)."</a>
        ";
        if ($link_thread) {
            echo " : <a href=/community/forum/thread.php?id=$thread->id>$thread->title</a>";
        } else {
            echo " : $thread->title";
        }
    } else {
        echo tra("%1 message board", $team->name);
    }
    echo "</span>";
}

// Start the forum table, output the proper headings and such.
//
function start_forum_table($headings, $extra="width=\"100%\"") {
    $span = null;
    
    start_table($extra." cellspacing=\"0\"");
    echo "<tr>";

    for ($i=0; $i<count($headings); $i++) {
        if (is_array($headings[$i])){
            $title = $headings[$i][0];
            $class = $headings[$i][1]?$headings[$i][1]:"heading";
            if (isset($headings[$i][2])) {
                $span = " colspan=\"".$headings[$i][2]."\" ";
            }
        } else {
            $title = $headings[$i];
            $class = "heading";
            $span="";
        }
        echo "<th class=$class$span>$title</th>";
    }
    echo "</tr>\n";
}

// return a string containing a paged navigation bar 
// for the given forum.  The default start place is 0. 
//
function show_page_nav($forum, $start=0){
    // How many pages to potentially show before and after this one:
    $preshow = 5; $postshow = 10;
    $navbar = "";
    
    if ($forum->threads > THREADS_PER_PAGE) {
        $total = ceil($forum->threads / THREADS_PER_PAGE);
        $curpage = ceil($start / THREADS_PER_PAGE);
        // If this is not the first page, display "previous"
        if ($curpage > 0){
            $navbar = '<a href="/community/forum/forum.php?id='.get_int("id").'&start='.(($curpage-1)*THREADS_PER_PAGE);
            $sort = get_int("sort",true);
            if ($sort) $navbar.='&sort='.$sort;
            $navbar.= '"> &lt;-- Previous</a> ';
        }
        
        // Display a list of pages surrounding this one
        for ($i=$curpage-$preshow;$i<($curpage+$postshow);$i++){
            if ($i<1) continue;
            if ($i>$total) break;
            // If this is the current page, emphasize it.
            if ($i == $curpage+1){
                $navbar.="<em>";
            }
            $navbar.='<a href="/community/forum/forum.php?id='.get_int("id").'&start='.(($i-1)*THREADS_PER_PAGE);
            $sort = get_int("sort",true);
            if ($sort) $navbar.='&sort='.$sort;
            $navbar.='">'.$i.' |</a> ';
            if ($i == $curpage+1){$navbar.="</em>";}
        }

        // If there is a next page
        if ($curpage+1 < $total){
            $navbar.= '<a href="/community/forum/forum.php?id='.get_int("id").'&start='.(($curpage+1)*THREADS_PER_PAGE);
            $sort = get_int("sort",true);
            if ($sort) $navbar.='&sort='.$sort;
            $navbar.= '"> Next --&gt;</a>';
        }

    }
    return $navbar;
}

function thread_last_visit($user, $thread) {
    if (!$user) return false;
    $log = BoincForumLogging::lookup($user->id, $thread->id);
    return $log->timestamp;
}

function thread_is_unread($user, $thread) {
    if (!$user) return false;
    if ($thread->timestamp < $user->prefs->mark_as_read_timestamp) return false;
    $log = BoincForumLogging::lookup($user->id, $thread->id);
    if ($log && ($thread->timestamp < $log->timestamp)) return false;
    return true;
}

//  Process a user-supplied title to remove HTML stuff
//
function cleanup_title($title) {
    $x = trim(htmlspecialchars($title));
    $x = stripslashes($x);      // clean up funky old titles in DB
    if (strlen($x)==0) return "(no title)";
    else return $x;
}

function can_reply($thread, $forum, $user) {
    if ($thread->locked) {
        if (!is_moderator($user, $forum)) return false;
    }
    return true;
}

function should_show_post(
    $logged_in_user, $postcount, $postnumber, $post, $sort_style, $last_visit
){
    $no_wraparound = get_str("nowrap",true);

    // If no user logged in, display everything (useful for Google bots etc)
    //
    if (!$logged_in_user) return true;
	    
    // If the user hasn't enabled the feature to display only
    // a certain amount of posts, simply display all of them.
    //
    if (!$logged_in_user->prefs->minimum_wrap_postcount) return true;
		    
    // If the user has asked to display all the posts just display them
    //
    if ($no_wraparound) return true;
	    
    // If it is enabled and we havent yet hit the limit, simply display all
    if ($postcount < $logged_in_user->prefs->minimum_wrap_postcount) return true;
				    
    // display the post if it is the first post
    //
    if ($postnumber==1 || $postnumber==($postcount+1)) return true;
    				    
    // if this post is unread, show it
    //
    if ($post->timestamp > $last_visit) return true;
						    
    // The user can choose to display the last X posts in a thread only,
    // "last" here depends on sorting criteria:
    //
    if ($sort_style == CREATE_TIME_OLD){
        if ($postnumber > $postcount+1-$logged_in_user->prefs->display_wrap_postcount) return true;
    } else if ($sort_style == CREATE_TIME_NEW){
        if ($postnumber <= $logged_in_user->prefs->display_wrap_postcount) return true;
    } else {
        // For other sorting criteria we do not know how to define "last"
        // so simply display it all
        //
        return true;
    }
    
    // In all other cases we should not show this particular post
    return false;
}

// Show the posts in a thread for a user.
//
function show_posts(
    $thread, $forum, $sort_style, $filter, $logged_in_user, $show_controls=true
) {
    $n = 1;
    $first_unread_post = null;
    $last_visit = 0;
    
    if ($show_controls) {
        $controls = FORUM_CONTROLS;
    } else {
        $controls = NO_CONTROLS;
    }

    // If logged in user is moderator,
    // let him see all posts - including hidden ones
    //
    if (is_moderator($logged_in_user, $forum)) {
        $show_hidden = true;
    } else {
        $show_hidden = false;
    }
    $posts = get_thread_posts($thread->id, $sort_style, $show_hidden);
    $postcount = (sizeof($posts)-1);
    if ($logged_in_user) {
        $last_visit = thread_last_visit($logged_in_user, $thread);
    }

    $postnumber=0; $previous_post=0;
    $no_wraparound = get_str("nowrap",true);
    foreach ($posts as $post){
        $postnumber++;
        if (should_show_post(
            $logged_in_user, $postcount, $postnumber, $post,
            $sort_style, $last_visit)
        ) {

            if ($postnumber!=$previous_post+1){
                // A number of posts were hidden, display a way to unhide them:
                //
                echo "<tr class=\"postseperator\"><td></td><td colspan=\"2\">
                    Only the first post and the last ".($logged_in_user->prefs->display_wrap_postcount)." posts 
                    (of the ".($postcount+1)." posts in this thread) are displayed. <br />
                    <a href=\"?id=".$thread->id."&amp;nowrap=true\">Click here to also display the remaining posts</a>.</td></tr>
                ";
            }
            $previous_post=$postnumber;
            show_post($post, $thread, $forum, $logged_in_user, $last_visit, $n, $controls, $filter);
            $n = ($n+1)%2;
            
            if (($post->timestamp>$last_visit) && 
                ((!$first_unread_post) || ($post->timestamp<$first_unread_post->timestamp))
               ){
                $first_unread_post=$post;
            }
        }
    }

    if ($logged_in_user && $logged_in_user->prefs->jump_to_unread){
        if ($first_unread_post){
            echo "<script>function jumpToUnread(){location.href='#".$first_unread_post->id."';}</script>";
        } else {
            echo "<script>function jumpToUnread(){};</script>";
        }
    }

    if ($logged_in_user) {
        BoincForumLogging::replace($logged_in_user->id, $thread->id, time());
    }
}

function get_ignored_list($user) {
    return explode("|", $user->prefs->ignorelist);
}

function add_ignored_user($user, $other_user) {
    $list = explode("|", $user->prefs->ignorelist);
    foreach ($list as $key=>$userid) {
        if ($userid == $other_user->id) {
            return true;
        }
    }
    $list[] = $other_user->id;
    $x = implode("|", array_values($list));
    return $user->prefs->update("ignorelist='$x'");
}

function remove_ignored_user($user, $other_user) {
    $list = explode("|", $user->prefs->ignorelist);
    foreach ($list as $key=>$userid) {
        if ($userid == $other_user->id) {
            unset($list[$key]);
        }
    }
    $x = implode("|", array_values($list));
    return $user->prefs->update("ignorelist='$x'");
}

function is_ignoring($user, $other_user) {
    $list = explode("|", $user->prefs->ignorelist);
    return in_array($other_user->id, $list);
}

// Display an individual post
//
function show_post(
    $post, $thread, $forum, $logged_in_user, $last_visit, $n, $controls=FORUM_CONTROLS, $filter=true
) {
    $user = BoincUser::lookup_id($post->user);
    BoincForumPrefs::lookup($user);
    if (is_banished($user) && !is_moderator($logged_in_user, $forum)) {
        return;
    }

    $config = get_config();
    $no_forum_rating = parse_bool($config, "no_forum_rating");

    $tokens = "";
    $rated_below_threshold = false;
    $rated_above_threshold = false;
    $options = get_output_options($logged_in_user);

    //If the user that made this post is on the list of people to ignore,
    // change thresholds to be much more strict
    //
    if ($logged_in_user){
        $tokens = url_tokens($logged_in_user->authenticator);
        if (is_ignoring($logged_in_user, $user)){
            $user_is_on_ignorelist=true;
            $rated_below_threshold = ($logged_in_user->prefs->high_rating_threshold>$post->rating());
            $rated_above_threshold = ($logged_in_user->prefs->high_rating_threshold+abs($logged_in_user->prefs->low_rating_threshold)<($post->rating));
        } else {                //Use normal threshold values
            $rated_below_threshold = ($logged_in_user->prefs->low_rating_threshold>($post->rating()));
            $rated_above_threshold = ($logged_in_user->prefs->high_rating_threshold<($post->rating()));
        }
    }

    // The creator can edit the post, but only in a specified amount of time
    // (exception: a moderator can edit his/her posts at any time)
    //
    $can_edit = false;
    if ($logged_in_user) {
        if ($user->id == $logged_in_user->id) {
            if (is_moderator($logged_in_user, $forum)) {
                $can_edit = true;
            } else if (can_reply($thread, $forum, $logged_in_user)) {
                $time_limit = $post->timestamp+MAXIMUM_EDIT_TIME;
                $can_edit = time()<$time_limit;
            } else {
                $can_edit = false;
            }
        }
    }

    echo "
        <tr class=\"row".$n."\" valign=\"top\">
        <td rowspan=\"3\"><a name=\"".$post->id."\"></a><div class=\"authorcol\">
    ";

    echo user_links($user);
    echo "<br>";

    // Print the special user lines, if any
    global $special_user_bitfield; 
    $fstatus="";
    $keys = array_keys($special_user_bitfield);
    for ($i=0; $i<sizeof($special_user_bitfield);$i++) {
        if ($user->prefs->privilege($keys[$i])) {
            $fstatus.=$special_user_bitfield[$keys[$i]]."<br>";
        }
    }
    if ($user->create_time > time()-ST_NEW_TIME) $fstatus.=ST_NEW."<br>";
    if ($fstatus) echo "<font size=\"-2\">$fstatus</font>";

    echo "<span class=\"authorinfo\">";
    if (!$filter || !$rated_below_threshold){
        if ($user->prefs->avatar!=""  && (!$logged_in_user || ($logged_in_user->prefs->hide_avatars==false))) {
            echo "<img width=\"".AVATAR_WIDTH."\" height=\"".AVATAR_HEIGHT."\" src=\"/".$user->prefs->avatar."\" alt=\"Avatar\"><br>";
        }
    }
    
    $url = "/community/pm.php?action=new&userid=".$user->id;
    $name = $user->name;
    show_button($url, "Send message", "Send $name a private message");
    echo "<br>Joined: ", gmdate('M j y', $user->create_time), "<br>";

    if (!isset($user->nposts)) {
        $user->nposts = BoincPost::count("user=$user->id");
    }
    
    if(function_exists('project_forum_user_info')){
        project_forum_user_info($user);
    } else { // default
        // circumvent various forms of identity spoofing
        // by displaying the  user id of the poster.
        //
        echo "Posts: $user->nposts<br>";
        echo "ID: ".$user->id."<br>";
        echo "Credit: ".number_format($user->total_credit)."<br>";
        echo "RAC: ".number_format($user->expavg_credit)."<br>";
    }
    echo "</span></div></td>";

    if ($controls == FORUM_CONTROLS) {
        echo "<td colspan=\"2\" class=\"postheader\">";
        echo "<form action=\"/community/forum/rate.php?post=", $post->id, "\" method=\"post\">";
    } else {
        echo "<td class=\"postheader\">";
    }

    if ($logged_in_user && $post->timestamp>$last_visit){
        show_image(NEW_IMAGE, "You haven't read this message yet", "Unread", NEW_IMAGE_HEIGHT);
    }
    if ($rated_above_threshold){
        show_image(EMPHASIZE_IMAGE, "This message has a high average rating", "Highly rated", EMPHASIZE_IMAGE_HEIGHT);
    }

    echo " <a href=\"/community/forum/thread.php?id=".$thread->id."&nowrap=true#$post->id\">Message ".$post->id."</a> - ";
    if ($post->hidden) echo "<font color=red>[hidden] </font>";
    echo "
        Posted ", pretty_time_str($post->timestamp);
    ;

    if ($post->parent_post) {
        echo " - in response to <a href=\"/community/forum/thread.php?id=".$thread->id."&nowrap=true#".$post->parent_post."\">Message ID ".$post->parent_post."</a>.";
    }
    echo " ";
    if ($can_edit && $controls != NO_CONTROLS) {
        show_button("/community/forum/edit.php?id=".$post->id."$tokens", "Edit", "Edit this message");
    }
    if (is_moderator($logged_in_user, $forum)) {
        show_post_moderation_links($config, $logged_in_user, $post, $forum, $tokens);
    }
    if ($post->modified) {
        echo "<br>Last modified: ", pretty_time_Str($post->modified);
    }
    if ($rated_below_threshold && $filter){
        if ($user_is_on_ignorelist) {
            $andtext=" and the user is on your ignore list";
        }
        echo "<br>This post has been filtered (rating: ".($post->rating()).")$andtext, press <a href=\"?id=".$thread->id."&amp;filter=false#".$post->id."\">here</a> to view this thread without filtering";
    }
    echo "</td></tr></form>";
    echo "<tr class=\"row$n\"><td class=\"postbody\" colspan=\"2\">";

    if (!$filter || !$rated_below_threshold){
        $posttext = $post->content;

        // If the creator of this post has a signature and
        // wants it to be shown for this post AND the logged in
        // user has signatures enabled: show it
        //
        if ($post->signature && (!$logged_in_user || !$logged_in_user->prefs->hide_signatures)){
            $posttext.="\n____________\n".$user->prefs->signature;
        }

        $posttext = output_transform($posttext, $options);
        
        echo "<p>", $posttext, "</p>";
        echo "</td></tr><tr><td class=\"postfooter\">ID: <i>", $post->id;
        if ($no_forum_rating != NULL) { 
            echo " | <a href=\"/community/forum/report_post.php?post=".$post->id."\">";
            show_image(REPORT_POST_IMAGE, "Report this post as offensive", "Report as offensive", REPORT_POST_IMAGE_HEIGHT);
            echo "</td>";
        } else {
            $rating = $post->rating();
            echo " | Rating: ", $rating, "</i> | rate: 
                <a href=\"/community/forum/rate.php?post=".$post->id."&amp;choice=p$tokens\">
            ";
            show_image(RATE_POSITIVE_IMAGE, "Click if you like this message", "Rate +", RATE_POSITIVE_IMAGE_HEIGHT);
            echo "</a> / <a href=\"/community/forum/rate.php?post=".$post->id."&choice=n$tokens\">";
            show_image(RATE_NEGATIVE_IMAGE, "Click if you don't like this message", "Rate -", RATE_NEGATIVE_IMAGE_HEIGHT);
            echo "</a> <a href=\"/community/forum/report_post.php?post=".$post->id."\">";
            show_image(REPORT_POST_IMAGE, "Report this post as offensive", "Report as offensive", REPORT_POST_IMAGE_HEIGHT);
            echo "</a></td> ";
        }
        if (($controls == FORUM_CONTROLS) && (can_reply($thread, $forum, $logged_in_user))) {
            echo "<td align=right class=\"postfooter\">";
            $url = "/community/forum/reply.php?thread=" . $thread->id . "&post=" . $post->id . "#input";
            show_button($url, "Reply", "Post a reply to this message");
            echo "</td>";
        } else {
            echo "<td class=\"postfooter\"></td>";
        }
        echo "</tr>";
    } else {
        echo "</td></tr><tr><td class=\"postfooter\" colspan=\"2\">";
    }
    echo "<tr class=\"postseperator\"><td colspan=3></td></tr>";
}

// Show a post and its context (e.g. for search results, user posts)
//
function show_post_and_context($post, $thread, $forum, $options, $n) {
    $thread = BoincThread::lookup_id($post->thread);
    $forum = BoincForum::lookup_id($thread->forum);

    $content = output_transform($post->content, $options);
    $when = time_diff_str($post->timestamp, time());
    $user = lookup_user_id($post->user);
    $title = cleanup_title($thread->title);
    $m = $n%2;
    if ($post->hidden) {
        $deleted = "<br><font color=red>[Hidden by a moderator]</font>";
    } else {
        $deleted = "";
    }
    echo "
        <tr class=row$m>
        <td>
            $n)
    ";
    switch ($forum->parent_type) {
    case 0:
        $category = BoincCategory::lookup_id($forum->category);
        show_forum_title($category, $forum, $thread);
        break;
    case 1:
        show_team_forum_title($forum);
        break;
    }
    echo "
        (<a href=\"/community/forum/thread.php?id=".$thread->id."&amp;nowrap=true#".$post->id."\">Message ".$post->id."</a>)
        <br>
        Posted $when by ".user_links($user)." $deleted
        <hr>
        $content
        </td></tr>
    ";
}

function is_banished($user) {
    return ($user->prefs->banished_until > time());
}

function check_banished($user) {
    if (is_banished($user)) {
        error_page(
            "You may not post or rate messages until ".gmdate('M j, Y', $user->prefs->banished_until)
        );
    }
}

function post_rules() {
    if (function_exists("project_forum_post_rules")) {
      $project_rules=project_forum_post_rules();
    } else {
      $project_rules="";
    }
    return "
        <ul>
        <li> Posts must be 'kid friendly': they may not contain
            content that is obscene, hate-related,
            sexually explicit or suggestive.
        <li> No commercial advertisements.
        <li> No links to web sites involving sexual content,
            gambling, or intolerance of others.
        <li> No messages intended to annoy or antagonize other people,
            or to hijack a thread.
        <li> No messages that are deliberately hostile or insulting.
        <li> No abusive comments involving race, religion,
            nationality, gender, class or sexuality.
	".$project_rules."
        </ul>
    ";
}

function post_warning() {
    return "<br><br>
        <table><tr><td align=left>
        <font size=-2>
        Rules:
    ".post_rules()."
        <a href=/community/forum/moderation.php>More info</a>
        </font>
        </td></tr></table>
    ";
}

function notify_subscriber($thread, $user) {
    BoincForumPrefs::lookup($user);
    if ($user->prefs->pm_notification == 1) {
        send_reply_notification_email($thread, $user);
    }
    $now = time();
    $type = NOTIFY_SUBSCRIBED_POST;
    BoincNotify::replace("userid=$user->id, create_time=$now, type=$type, opaque=$thread->id");
}

// Various functions for adding/hiding/unhiding stuff.
// These take care of counts and timestamps.
// Don't do these things directly - use these functions
//
function create_post($content, $parent_id, $user, $forum, $thread, $signature) {
    $content = substr($content, 0, 64000);
    $content = mysql_real_escape_string($content);
    $now = time();
    $sig = $signature?1:0;
    $id = BoincPost::insert("(thread, user, timestamp, content, parent_post, signature) values ($thread->id, $user->id, $now, '$content', $parent_id, $sig)");
    if (!$id) return null;

    // notify subscribed users
    //
    $subs = BoincSubscription::enum("threadid=$thread->id");
    foreach ($subs as $sub) {
        if ($user->id == $sub->userid) continue;
        $user2 = BoincUser::lookup_id($sub->userid);
        notify_subscriber($thread, $user2);
    }
    $user->update("posts=posts+1");
    $thread->update("replies=replies+1, timestamp=$now");
    $forum->update("posts=posts+1, timestamp=$now");
}

function create_thread($title, $content, $user, $forum, $signature) {
    $title = trim($title);
    $title = strip_tags($title);
    $title = mysql_real_escape_string($title);
    $now = time();
    $id  = BoincThread::insert("(forum, owner, title, create_time, timestamp, replies) values ($forum->id, $user->id, '$title', $now, $now, -1)");
    if (!$id) return null;
    $thread = BoincThread::lookup_id($id);
    create_post($content, 0, $user, $forum, $thread, $signature);
    $forum->update("threads=threads+1");
    return $thread;
}

function hide_post($post, $thread, $forum) {
    $post->update("hidden=1");
    $thread->update("replies=replies-1");
    return $forum->update("posts=posts-1");
}

function unhide_post($post, $thread, $forum) {
    $now = time();
    $post->update("hidden=0");
    $thread->update("replies=replies+1, timestamp=$now");
    return $forum->update("posts=posts+1, timestamp=$now");
}

function delete_post($post, $thread, $forum) {
    $post->delete();
    $thread->update("replies=replies-1");
    $forum->update("posts=posts-1");
    $count = BoincPost::count("thread=$thread->id");
    if ($count == 0) {
        $forum->update("threads=threads-1");
        $thread->delete();
    }
}

function move_post($post, $old_thread, $old_forum, $new_thread, $new_forum) {
    $now = time();
    $post->update("thread=$new_thread->id");
    $old_thread->update("replies=replies-1");
    $new_thread->update("replies=replies+1, timestamp=$now");
    $old_forum->update("posts=posts-1");
    return $new_forum->update("posts=posts+1, timestamp=$now");
}

function hide_thread($thread, $forum) {
    $thread->update("hidden=1");
    $forum->update("threads=threads-1");
    return $forum->update("posts=posts-$thread->replies-1");
}

function unhide_thread($thread, $forum) {
    $now = time();
    $thread->update("hidden=0");
    return $forum->update("threads=threads+1, posts=posts+$thread->replies+1, timestamp=$now");
}

function move_thread($thread, $old_forum, $new_forum) {
    $now = time();
    $old_forum->update("threads=threads-1, posts=posts-$thread->replies-1");
    $new_forum->update("threads=threads+1, posts=posts+$thread->replies+1, timestamp=$now");
    return $thread->update("forum=$new_forum->id");
}

// $show_hidden: 1 if it is a moderator reading
// Error page if this function returns NULL.
// $forumID - int
// $min - int
// $nRec - int
// $sort_style - string (checked by switch statement)
// $show_hidden - bool (not directly passed to SQL)
// $sticky - bool (not directly passed to SQL)
//
function get_forum_threads(
    $forumID, $start=-1, $nRec=-1, $sort_style=MODIFIED_NEW,
    $show_hidden = 0, $sticky = 1
) {
    //if (! (is_numeric($forumID) && is_numeric($min) && is_numeric($nRec))) {
    //    return NULL;  // Something is wrong here.
    //}
        
    $sql = 'forum = ' . $forumID ;
    if ($sticky){
        $stickysql = "sticky DESC, ";
    }
    if (!$show_hidden) {
        $sql .= ' AND hidden = 0';
    }
    switch($sort_style) {
    case MODIFIED_NEW:
        $sql .= ' ORDER BY '.$stickysql.'timestamp DESC';
        break;
    case MODIFIED_OLD:
        $sql .= ' ORDER BY '.$stickysql.'timestamp ASC';
        break;
    case VIEWS_MOST:
        $sql .= ' ORDER BY '.$stickysql.'views DESC';
        break;
    case REPLIES_MOST:
        $sql .= ' ORDER BY '.$stickysql.'replies DESC';
        break;
    case CREATE_TIME_NEW:
        $sql .= ' ORDER by '.$stickysql.'create_time desc';
        break;
    case CREATE_TIME_OLD:
        $sql .= ' ORDER by '.$stickysql.'create_time asc';
        break;
    case 'sufferers':
        $sql .= ' ORDER by '.$stickysql.'sufferers desc';
        break;
    case 'activity':
        $sql .= ' ORDER by '.$stickysql.'activity desc';
        break;
    case 'score':
        $sql .= ' ORDER by '.$stickysql.'score desc';
        break;
    default:
        $sql .= ' ORDER BY '.$stickysql.'timestamp DESC';
        break;
    }
    if ($start > -1) {
        $sql .= ' LIMIT '.$start;
        if ($nRec > -1) {
            $sql .= ', '.$nRec;
        }
    } else if ($nRec > -1) {
        $sql .= ' LIMIT '.$nRec;
    }
    return BoincThread::enum($sql);
}

// $show_hidden = true when it is a moderator reading
// error_page if this function returns NULL.
// $sort_style - string (checked by switch statement)
// $show_hidden - bool (not directly passed to SQL)
//
function get_thread_posts($threadid, $sort_style, $show_hidden) {
    $sql = "thread=$threadid";
    if (!$show_hidden) {
        $sql .= ' AND hidden = 0';
    }
    switch($sort_style) {
    case CREATE_TIME_NEW:
        $sql .= ' ORDER BY timestamp desc';
        break;
    case CREATE_TIME_OLD:
        $sql .= ' ORDER BY timestamp asc';
        break;
    case POST_SCORE:
        $sql .= ' ORDER BY score DESC';
        break;
    default:
        $sql .= ' ORDER BY timestamp asc';
        break;        
    }
    return BoincPost::enum($sql);
}

// Show the links for possible moderation actions related to a single post 
//
function show_post_moderation_links(
    $config, $logged_in_user, $post, $forum, $tokens
){
    $moderators_allowed_to_ban = parse_bool($config, "moderators_allowed_to_ban"); 
    $moderators_vote_to_ban = parse_bool($config, "moderators_vote_to_ban");

    if ($post->hidden) {
        show_button("/community/forum/moderate_post_action.php?action=unhide&id=".$post->id."$tokens", "Unhide", "Unhide this post");
    } else {
        show_button("/community/forum/moderate_post.php?action=hide&id=".$post->id."$tokens", "Hide", "Hide this post");
    }

    show_button(
        "/community/forum/moderate_post.php?action=move&id=".$post->id."$tokens",
        "Move", "Move post to a different thread"
    );

    if ($forum->parent_type == 0) {
        if ($logged_in_user->prefs->privilege(S_ADMIN) || ($logged_in_user->prefs->privilege(S_MODERATOR) && $moderators_allowed_to_ban)) {
            show_button("/community/forum/moderate_post.php?action=banish_user&id=".$post->id."&userid=".$post->user."$tokens", "Banish author", "Banish author");
        }
        if ($logged_in_user->prefs->privilege(S_MODERATOR) && $moderators_vote_to_ban) {
            require_once(PROJECT_HTML_FOLDER."inc/forum_banishment_vote.inc");
            if (vote_is_in_progress($post->user)) {
                show_button("/community/forum/banishment_vote.php?action=yes&userid=".$post->user, "Vote to banish author", "Vote to banish author");
                show_button("/community/forum/banishment_vote.php?action=no&userid=".$post->user, "Vote not to banish author", "Vote not to banish author");
            } else {
                show_button("/community/forum/banishment_vote.php?action=start&userid=".$post->user, "Start vote to banish author", "Start vote to banish author");
            }
        }
    }
}

function check_create_thread_access($user, $forum) {
    if ($forum->is_dev_blog){
        if (
           (!$user->prefs->privilege(S_SCIENTIST)) &&
           (!$user->prefs->privilege(S_DEV)) &&
           (!$user->prefs->privilege(S_ADMIN))
        ) {
            error_page("This forum is marked as a development blog, only people directly working with the project may start a new thread here. <br/>However, you may post a reply to an existing thread.");
        }
    }
    check_post_access($user, $forum);
}

function check_post_access($user, $forum) {
    switch ($forum->parent_type) {
    case 0:
        if ($user->prefs->privilege(S_MODERATOR)) return;
        break;
    case 1:
        $team = BoincTeam::lookup_id($forum->category);
        if (is_team_admin($user, $team)) return;

        // non-team-members can't post
        //
        if ($user->teamid != $team->id) {
            error_page("Only team members can post to the team message board");
        }
        break;
    }

    // If user haven't got enough credit (according to forum regulations)
    // We do not tell the (ab)user how much this is -
    // no need to make it easy for them to break the system.
    //
    if ($user->total_credit<$forum->post_min_total_credit || $user->expavg_credit<$forum->post_min_expavg_credit) {
        error_page(tra("In order to create a new thread in %1 you must have a certain amount of credit. This is to prevent and protect against abuse of the system.", $forum->title));
    }

    // If the user is posting faster than forum regulations allow
    // Tell the user to wait a while before creating any more posts
    //
    if (time()-$user->prefs->last_post <$forum->post_min_interval) {
        error_page(tra("You cannot create any more threads right now. Please wait a while before trying again. This delay has been enforced to protect against abuse of the system."));
    }
}

function check_reply_access($user, $forum, $thread) {
    if ($thread->locked && !is_moderator($user, $forum)) {
        error_page(
            "This thread is locked. Only forum moderators and administrators are allowed to post there."
        );
    }
    if ($thread->hidden) {
        error_page(
           "Can't post to a hidden thread."
        );
    }

    check_post_access($user, $forum);
}

function is_moderator($user, $forum) {
    if (!$user) return false;
    switch ($forum->parent_type) {
    case 0:
        if ($user->prefs->privilege(S_MODERATOR)) return true;
        if ($user->prefs->privilege(S_ADMIN)) return true;
        if ($user->prefs->privilege(S_DEV)) return true;
        break;
    case 1:
        if ($user->prefs->privilege(S_ADMIN)) return true;
        $team = BoincTeam::lookup_id($forum->category);
        return is_team_admin($user, $team);
        break;
    }
    return false;
}

function show_thread_and_context_header() {
    start_forum_table(array(tra("Thread"), tra("Posts"), tra("Author"), tra("Views"), "<nobr>".tra("Last post")."</nobr>"));
}

// show a 1-line summary of thread and its forum.
// Used for search results and subscription list
//
function show_thread_and_context($thread, $user) {
    $thread_forum = BoincForum::lookup_id($thread->forum);
    if (!$thread_forum) return;
    if (!is_forum_visible_to_user($thread_forum, $user)) return;
    $owner = BoincUser::lookup_id($thread->owner);
    echo "<tr><td>\n";
    switch($thread_forum->parent_type) {
    case 0:
        $category = BoincCategory::lookup_id($thread_forum->category);
        show_forum_title($category, $thread_forum, $thread, true);
        break;
    case 1:
        show_team_forum_title($thread_forum, $thread);
        break;
    }
    echo '
        </td><td>'.($thread->replies+1).'</td>
        <td align="left"><div class="authorcol">'.user_links($owner).'</div></td>
        <td>'.$thread->views.'</td>
        <td style="text-align:right">'.time_diff_str($thread->timestamp, time()).'</td>
        </tr>
    ';
}

// see if thread is in subscription list
//
function is_subscribed($thread, $subs) {
    foreach ($subs as $sub) {
        if ($sub->threadid == $thread->id) return true;
    }
    return false;
}

function is_forum_visible_to_user($forum, $user) {
    if ($forum->parent_type == 1) {
        if (parse_config(get_config(), "<team_forums_members_only>")) {
            if (!$user) return false;
            if ($user->teamid != $forum->category) return false;
        }
    }
    return true;
}

function subscribed_post_email_line($notify) {
    $thread = BoincThread::lookup_id($notify->opaque);
    return "There are new posts in the thread '$thread->title'";
}

function subscribed_post_web_line($notify) {
    $thread = BoincThread::lookup_id($notify->opaque);
    return "New posts in the thread <a href=community/forum/thread.php?id=$thread->id>$thread->title</a>";
}

function subscribe_rss($notify, &$title, &$msg, &$url) {
    $thread = BoincThread::lookup_id($notify->opaque);
    $title = "New posts in subscribed thread";
    $msg = "There are new posts in the thread '$thread->title'";
    $url = URL_BASE."community/forum/thread.php?id=$thread->id";
}

function show_mark_as_read_button($user) {
    if ($user) {
        $return = urlencode(current_url());
        $tokens = url_tokens($user->authenticator);
        $url = "/community/forum/?read=1$tokens&return=$return";
        show_button($url, tra("Mark all threads as read"), tra("Mark all threads in all message boards as 'read'."));
    }
}

?>
