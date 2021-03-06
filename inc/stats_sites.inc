<?php
$cvs_version_tracker[]="\$Id: stats_sites.inc 15020 2008-04-06 03:15:36Z davea $";  //Generated automatically - do not edit

// the following sites generate stats for a given CPID
//
$cpid_stats_sites = array(
    array("BOINC all Project Stats",
        "http://www.allprojectstats.com/showuser.php?id=%s"
    ),
    array("BOINCstats",
        "http://www.boincstats.com/stats/boinc_user_graph.php?pr=bo&amp;id=%s"
    ),
    array("BOINC Statistics for the WORLD!",
        "http://www.boincsynergy.com/stats/boinc-individual.php?cpid=%s"
    ),
    array("BOINC Combined Statistics",
        "http://boinc.netsoft-online.com/e107_plugins/boinc/get_user.php?cpid=%s&amp;html=1"
    ),
    array("The Knights Who Say 'Ni!'",
        "http://stats.kwsn.net/user.php?proj=all&amp;cpid=%s"
    ),
    array("Team Starfire World BOINC Stats 'N Stones",
        "http://statsnstones.tswb.org/userdetail.aspx?cpid=%s"
    ),
);

$stats_sites = array(
    array(
        "http://www.myboinc.com/FormulaBoinc/",
        "Formula BOINC",
        "(Team ranking based on position within projects,
        as in Formula 1 racing, rather than total points)"
    ),
    array(
        "http://statsnstones.tswb.org/",
        "Team Starfire World BOINC Stats 'N Stones",
        ""
    ),
    array(
        "http://www.allprojectstats.com/",
        "BOINC All Project Stats",
        ""
    ),
    array(
        "http://stats.free-dc.org",
        "Free-DC",
        "Includes non-BOINC projects and completed projects."
    ),
    array(
        "http://www.boincuk.com/globalprojectstats.php",
        "BOINC UK",
        ""
    ),
    array("http://www.boincsynergy.com/stats/index.php",
        "BOINC Statistics for the WORLD!",
        "developed by Zain Upton (email: zain.upton at boincsynergy.com)"
    ),
    array("http://boinc.netsoft-online.com/",
        "BOINC Combined Statistics",
        "developed by James Drews"
    ),
    array("http://home.btconnect.com/Gabys_Bazar/hwupgrade.html",
        "Every Earthly Hour",
        "developed by Hydnum Repandum."
    ),
    array("http://www.boincstats.com/",
        "BOINCstats",
        "by Willy de Zutter"
    ),
    array("http://www.dc-vault.com",
        "DC-Vault",
        "Include non-BOINC projects"
    ),
    array("http://www.seti.nl/boinc_team.php",
        "SETI@Netherlands stats page",
        ""
    ),
    array("http://stats.kwsn.net/",
        "The Knights Who Say 'Ni' stats",
        ""
    ),
    array("http://www.teamocuk.com/",
        "Team OcUK stats",
        ""
    ),
);

$team_stats_sites = array(
    array("http://www.spacepage.be/component/option,com_boinc/", "Spacepage"),
    array("http://boinc.radax.net/de_boinc.htm", "BOINC@Austria"),
    array("http://www.myboinc.com/scores/", "L'Alliance Francophone"),
    array("http://boincdenmark.dk/", "BOINC@Denmark", "(Danish)"),
    array("http://boincdenmark.dk/default_en.html", "BOINC@Denmark", "(English)"),
    array("http://www.bigbee.be/comp/boinc/index.php",
        "Boinc.be team stats",
        ""
    ),
    array("http://www.seti-teamartbell.com/",
        "Team Art Bell", ""
    ),
);

$sig_sites = array(
//    array(
//        "http://brainsmashr.com/BOINC/",
//        "BrainSmashR.com boincwapstats",
//        "Boincwapstats retrieves real-time BOINC statistics data
//        and creates signature pictures out of it.
//        You can select the background, style, data, etc.
//        It's PHP and open source, so you can run it on your own server."
//    ),
    array(
        "http://www.boincuk.com/show3.php",
        "BOINC UK",
        "Highly configurable!"
    ),
    array("http://boinc.mundayweb.com/",
        "http://boinc.mundayweb.com",
        "User-configurable stats counters. Cool!"
    ),
    array("http://www.bigbee.be/comp/boinc/",
        "boinc.be",
        ""
    ),
    array("http://www.boincstats.com/page/faq.php#3",
        "BOINCstats",
        "by Willy de Zutter"
    ),
    array(
        "http://www.allprojectstats.com/signature.php",
        "BOINC All Project Stats",
        "Signature files for both users and teams"
    ),
);

function site_list($sites) {
    echo "<ul>\n";
    for ($i=0; $i<count($sites); $i++) {
        $s = $sites[$i];
        $url = $s[0];
        $name = $s[1];
        $comment = $s[2];
        echo "<li><a href=\"$url\">$name</a> $comment\n";
    }
    echo "</ul>\n";
}

?>
