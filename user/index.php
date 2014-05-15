<?
	//require($_SERVER['DOCUMENT_ROOT']."/includes/php/global.php");
	ini_set('display_errors','1');
	ini_set('display_startup_errors','1');
	error_reporting(E_ALL);
	require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
	require_once($_SERVER['DOCUMENT_ROOT']."/../project/project_news.inc");
	require_once($_SERVER['DOCUMENT_ROOT']."/../inc/db.inc");
	require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
	require_once($_SERVER['DOCUMENT_ROOT']."/../inc/news.inc");
	require_once($_SERVER['DOCUMENT_ROOT']."/../inc/cache.inc");
	require_once($_SERVER['DOCUMENT_ROOT']."/../inc/uotd.inc");
	require_once($_SERVER['DOCUMENT_ROOT']."/../inc/sanitize_html.inc");
	require_once($_SERVER['DOCUMENT_ROOT']."/../inc/translation.inc");
	require_once($_SERVER['DOCUMENT_ROOT']."/../inc/text_transform.inc");
	
	
	$config = get_config();
    $master_url = parse_config($config, "<master_url>");
	
	$caching = false;

	if ($caching) {
		start_cache(INDEX_PAGE_TTL);
	}
	
	$stopped = web_stopped();
	if (!$stopped) db_init();
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="keywords" content="Docking@Home, Docking, Protein, Ligand, @Home, Pharmaceutical, Research, Computing, Distributed Computing, University of Delaware, CIS, GCL" />
    <meta name="description" content="The official Docking@Home website." />
	<title>Welcome to Docking@Home!</title>
	<? require($_SERVER['DOCUMENT_ROOT']."/includes/head.php"); ?>
    <? require($_SERVER['DOCUMENT_ROOT']."/schedulers.txt"); ?>
    <script type="text/javascript">
		<!--
		// Page specific cached images for onmouseover/click. 
		// Forces browser to download image before effect is called.
		var cachedGettingStarted_over = new Image();
		cachedGettingStarted_over.src = '/images/gettingstarted_button_over.png';
		
		//-->
	</script>
</head>

<body>
	<? if ($stopped) { ?>
    	<div id="content">
            <b><?= PROJECT ?> is temporarily shut down for maintenance.
            Please try again later.</b>
        </div>
	<? } else { ?>
		<? require($_SERVER['DOCUMENT_ROOT']."/includes/header.php"); ?>
        <div id="content">
            <table><tr><td id="homepage_left">
                <?
                    $splashImage[0]["src"] = "/images/splashimages/bloodcellsweb.jpg";
                    $splashImage[0]["alt"] = "Finding cures for diseases";
                    $splashImage[1]["src"] = "/images/splashimages/chipweb.jpg";
                    $splashImage[1]["alt"] = "Using technology to cure human diseases";
                    $splashImage[2]["src"] = "/images/splashimages/pillsweb.jpg";
                    $splashImage[2]["alt"] = "Helping create the medicines of the future";
                    $splashImage[3]["src"] = "/images/splashimages/testtubesweb.jpg";
                    $splashImage[3]["alt"] = "Helping create the medicines of the future";
                    
                    $selection = mt_rand(0,sizeof($splashImage)-1);
                    
                    print '<div id="homepage_splashimage">';
                    print '<img src="'.$splashImage[$selection]["src"].'" alt="'.$splashImage[$selection]["alt"].'" />';
                    //print $splashImage[$selection]["alt"];
                    print '</div>';
                    
                ?>
                <h1 id="homepage_title">Welcome to Docking@Home</h1><br>

<div id="retireMsg" style="
    text-align: center;
    background: #28368F;
    color: white;
    padding-top: 10px;
    padding-bottom: 10px;
"><h1 style="
    font-size: 24px;
    color: white;
">Docking@Home is Retiring</h1><p style="
    font-size: 14px;
">Our Docking@Home adventure is coming to an end on May 23, 2014. Join us on our next challenge at <a href="https://exscitech.org" style="
    color: white;
    text-decoration: underline;
">ExSciTecH</a>.</p></div>

<br>
<p>
                    Docking@Home is a project which uses Internet-connected computers to perform scientific calculations that aid in the creation of new and improved medicines. The project aims to help cure diseases such as Human Immunodeficiency Virus (HIV).  Docking@Home is a collaboration between the University of Delaware, The Scripps Research Institute, and the University of California - Berkeley. It is part of the <a href="http://gcl.cis.udel.edu/projects/daplds/" target="_blank">Dynamically Adaptive Protein-Ligand Docking System project</a> and is supported by the National Science Foundation. 
                </p>
                <h3>How Does It Work?</h3>
                <p>
                    Before new drugs can be produced for laboratory testing, researchers must create molecular models and simulate their interactions to reveal possible candidates for effective drugs. This simulation is called docking. The combinations of molecules and their binding orientations are infinite in number. Simulating as many combinations as possible requires a tremendous amount of computing power. In order to reduce costs, researchers have decided that an effective means of generating this computing power is to distribute the tasks across a large number of computers.
                </p>
                <h3>How Can I Help?</h3>
                <p>
                    By downloading a free program developed at University of California - Berkeley called BOINC, you can contribute your computer's idle processing cycles to the Docking@Home project. It's safe, easy to setup, and runs only when you want it to so it won't affect your ability to use your computer. If you are interested in finding out more information, you can read more about <a href="/about/project/">the project</a> and <a href="/about/science/">the science</a> behind it, or if you are ready to help, you can get started below.
                </p><br />
                <div align="center">
                    <a href="/join/gettingstarted.php">
                        <img src="/images/gettingstarted_button.png"
                            alt="Getting Started"
                            name="gettingstarted_button"
                            onmouseover="this.src='/images/gettingstarted_button_over.png'"
                            onmouseout="this.src='/images/gettingstarted_button.png'" />
                    </a>
                </div>
                <hr />
                <h2 class="title">Sponsors</h2>
                <div id="homepage_sponsors">
                    <a href="http://www.udel.edu/" target="_blank">
                        <img src="/images/sponsors/ud.png" alt="University of Delaware Logo" title="University of Delaware" />
                    </a>
                    <a href="http://www.nsf.gov/" target="_blank">
                        <img src="/images/sponsors/nsf.png" alt="National Science Foundation Logo" title="National Science Foundation" />
                    </a>
                    <a href="http://www.innodb.com/" target="_blank">
                        <img src="/images/sponsors/innobase.gif" alt="Innobase Logo" title="Innobase" />
                    </a>
                </div><hr />
               <h2 class="title">Recommended by:</h2>
                <div id="homepage_recomendations" align="center">
                    <a href="http://www.rechenkraft.net/wiki/index.php?title=Docking%40home/Seal_of_Approval" target="_blank">
                        <img src="/images/seal.png" alt="Rechenkraft.net seal of approval" title="Rechenkraft.net" />
                    </a>
                    <p align="left"> <a htref="http://www.rechenkraft.net/">Rechenkraft.net</a> is Germany's first and so far biggest non-for-profit distributed and grid computing organization. Their goal is to support education, research and science through the use of distributed & grid computing technology</p>
                </div>
            </td>
            <td id="homepage_right">
                <div class="homepage_section_header">
                    <h2>News</h2>
                </div>
                <div class="homepage_section">
                    <? display_homepage_news($project_news); ?>
                    <p style="font-weight: bold;">
                    	<a href="/about/project/news.php">View all news stories</a>
                    </p>
                    <p style="font-size: 10px; font-weight: bold; padding-top: 5px; padding-bottom: 5px;">
                        <img src="/images/icons/rssfeed.png" alt="RSS Feed Icon" />
                        News is available as an <a href="/rss_main.php">RSS Feed</a>.
                    </p>
                </div>
                <div class="homepage_section_header">
                    <h2>User of the Day</h2>
                </div>
                <div class="homepage_section">
                    <? display_uotd(); ?>
                </div>
                <div class="homepage_section_header">
                    <h2>Concept of the Day</h2>
                </div>
                <div class="homepage_section">
                	<? display_cotd(); ?>
                </div>
            </td></tr></table>
    	</div>
    	<? require($_SERVER['DOCUMENT_ROOT']."/includes/footer.php"); ?>
	<? } ?>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-8656018-2");
pageTracker._trackPageview();
} catch(err) {}
</script>

</body>
</html>
