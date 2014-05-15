<?
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
display_page_top("Translations of the ".PROJECT." web site");
?>

<p>
If you are fluent in English and another language,
you can help <?= PROJECT ?> by translating parts of our web site
into your non-English language.
If you are interested in doing this:
<ul>
<li> Learn how BOINC's
<a href="http://boinc.berkeley.edu/translation.php">web site translation mechanism</a> works.
<li>
Contact project staff to obtain project-specific translation files,
and to get instructions for submitting translations into your language.
</ul>

There is an email list
<a href="http://www.ssl.berkeley.edu/mailman/listinfo/boinc_loc">boinc_loc at ssl.berkeley.edu</a> for people doing translations of the BOINC client software
and web interfaces.

<?
display_page_bottom();
?>
