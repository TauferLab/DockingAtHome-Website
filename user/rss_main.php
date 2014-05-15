<?php
// include project constants and news file
require_once("../inc/news.inc");
//require_once("../project/project.inc");
//require_once("../project/project_news.inc");
$last_mod_time=filemtime("../project/project_news.inc");
$create_date  = gmdate('D, d M Y H:i:s', $last_mod_time) . ' GMT';
$description = "BOINC project ".PROJECT.": Main page News";
$channel_image = URL_BASE . "images/icons/dh_icon_32.png";
$language = "en-us";
$writexml= "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>
    <rss version=\"2.0\">
    <channel>
    <title>".PROJECT."</title>
    <link>".URL_BASE."</link>
    <description>".$description."</description>
    <copyright>".COPYRIGHT_HOLDER."</copyright>
    <lastBuildDate>".$create_date."</lastBuildDate>
    <language>".$language."</language>
    <image>
        <url>".$channel_image."</url>
        <title>".PROJECT."</title>
        <link>".URL_BASE."</link>
    </image>
";
echo $writexml;

// rss_main.php:
// RSS 2.0 feed for BOINC default server installation.
// Channel Main show the current news on project mainpage 
// - for more informations about RSS see RSS 2.0 Specification:
//   http://blogs.law.harvard.edu/tech/rss

// Check your page with http://feedvalidator.org/                                                                                                                                     

// Create and send out http header
//

// Get unix time that last modification was made to the news source
//
//$last_mod_time=filemtime("../project/project_news.inc");
//$create_date  = gmdate('D, d M Y H:i:s', $last_mod_time) . ' GMT'; 

// Now construct header
//
header ("Expires: " . gmdate('D, d M Y H:i:s', time()) . " GMT");
header ("Last-Modified: " . $create_date);
header ("Content-Type: application/xml");

// Get or set display options
// - from 1 to 9 News could be set by option news, default is up to 9
//
$items = "9";
if (isset($_GET["items"])) $items=$_GET["items"];

if($items < "1" or $items > "9") {
    $items = "9";
}

// include project constants and news file
//
//require_once("../inc/news.inc");
require_once("../project/project.inc");
require_once("../project/project_news.inc");

// Create channel header and open XML content
//
$description = "BOINC project ".PROJECT.": Main page News";
$channel_image = URL_BASE . "images/icons/dh_icon_32.png";
$language = "en-us";
$writexml= "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>
    <rss version=\"2.0\">
    <channel>
    <title>".PROJECT."</title>
    <link>".URL_BASE."</link>
    <description>".$description."</description>
    <copyright>".COPYRIGHT_HOLDER."</copyright>
    <lastBuildDate>".$create_date."</lastBuildDate>
    <language>".$language."</language>
    <image>
        <url>".$channel_image."</url>
        <title>".PROJECT."</title>
        <link>".URL_BASE."</link>
    </image>
";
//echo $writexml;

// write news items
//
$total_items = count($project_news);
$items = min($total_items, $items);
display_news_rss($project_news,$items);

// Close XML content
//
echo "
    </channel>
    </rss>
";

?>
