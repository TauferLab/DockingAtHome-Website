<?php

require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/translation.inc");

$platforms = BoincPlatform::enum("deprecated=0");

$xml = $_GET['xml'];
if ($xml) {
    require_once($_SERVER['DOCUMENT_ROOT']."/../inc/xml.inc");
    xml_header();
    echo "<app_versions>\n";
} else {
    display_page_top(tra("Applications"));
	
    echo "<p>".tra("%1 currently has the following applications. When you participate in %1, work for one or more of these applications will be assigned to your computer. The current version of the application will be downloaded to your computer. This happens automatically; you don't have to do anything.", PROJECT)."</p>";
    start_table();
}

$apps = BoincApp::enum("deprecated=0");

foreach ($apps as $app) {
    if ($xml) {
        echo "<application>\n";
        echo "\t<name>$app->user_friendly_name</name>\n";
    } else {
        echo "
            <tr><th colspan=3>$app->user_friendly_name</th></tr>
            <tr><th>".tra("Platform")."</th><th>".tra("Current version")."</th><th>".tra("Installation time")."</th></tr>\n
        ";
    }
    for ($i=0; $i<sizeof($platforms); $i++) {
        $platform = $platforms[$i];
        $newest = null;
        $avs = BoincAppVersion::enum("appid=$app->id and platformid = $platform->id and deprecated=0");
        foreach($avs as $av) {
            if (!$newest || $av->version_num>$newest->version_num) {
                $newest = $av;
            }
        }
        if ($newest) {
            $y = pretty_time_str($newest->create_time);
            if ($xml) {
                echo "\t<version>\n";
                echo "\t\t<platform_short>$platform->name</platform_short>\n";
                echo "\t\t<platform_long>$platform->user_friendly_name</platform_long>\n";
                echo "\t\t<version_num>$newest->version_num</version_num>\n";
                echo "\t\t<date>$y</date>\n";
                echo "\t\t<date_unix>$newest->create_time</date_unix>\n";
                echo "\t</version>\n";
            } else {
                $x = sprintf("%0.2f", $newest->version_num/100);
                echo "<tr>
                    <td>$platform->user_friendly_name</td>
                    <td>$x</td>
                    <td>$y</td>
                    </tr>
                ";
            }
        }
    }
    if ($xml) {
        echo "\t</application>\n";
    }
}

if ($xml) {
    echo "</app_versions>\n";
} else {
    end_table();
    display_page_bottom();
}
?>
