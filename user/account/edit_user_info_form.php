<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/countries.inc");

function process_country() {
	$country = post_str("country");
	if ($country == "") {
		$country = "International";
	}
	if (!is_valid_country($country)) {
		add_form_error("country","Invalid country");
	}
	return $country;
}

function process_name() {
	$new_name = boinc_htmlentities(process_user_text(post_str("new_name")));
	if (empty($new_name)) {
		add_form_error("new_name","You must supply a name for your account");
	}
	if ($new_name != strip_tags($new_name)) {
		add_form_error("new_name","HTML tags not allowed in name");
	}
	return $new_name;
}

function process_postal_code() {
	$postal_code = strip_tags(process_user_text(post_str("postal_code", true)));
	return $postal_code;
}

function process_url() {
	$url = strip_tags(process_user_text(post_str("url", true)));
	return $url;
}

db_init();
$user = get_logged_in_user();
$submitted = post_str("submit", true);

if ($submitted) {
	$name = process_name();
	$country = process_country();
	$postal_code = process_postal_code();
	$url = process_url();
	if (any_form_errors()) {
		setMessage("error","There was an error in your submission. Please correct and resubmit.");
	}
	else {	
		$result = $user->update("name='$name', url='$url', country='$country', postal_code='$postal_code'");
		if ($result) {
			setMessage("notice","Account information has been changed.");
		} else {
			setMessage("error","There was an internal error. Account information not updated.<br>\n".BoincDb::error());
		}
		gotoLocation("/account/");
	}
}

display_page_top("Edit account information");
?>

<p>
	<? $form="change_info"; ?>
	<form name="<?= $form ?>" action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
    <input type="hidden" name="form" value="<?= $form ?>" />
	<table>
        <tr>
            <td>
                <?= tra("Name"); ?><br />
                <span class="description"><?= tra("Identifies you on our web site. Use your real name or a nickname."); ?></span>
            </td>
            <td>
                <input type="text" name="new_name" value="<?= $user->name ?>" size="30" />
                <? display_form_error("new_name"); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?= tra("Country"); ?><br />
                <span class="description"><?= tra("Select the country you want to represent, if any."); ?></span>
            </td>
            <td>
                <select name="country">
                    <? print_country_select(); ?>
                </select>
                <? display_form_error("country"); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?= tra("Postal or ZIP Code"); ?><br />
                <span class="description"><?= tra("Optional"); ?></span>
            </td>
            <td>
                <input type="text" name="postal_code" value="<?= $user->postal_code ?>" size="20" />
                <? display_form_error("postal_code"); ?>
            </td>
        </tr>
        <tr>
            <td>
                Website<br />
                <span class="description"><?= tra("Optional"); ?></span>
            </td>
            <td>
                <input type="text" name="url" value="<?= $user->url ?>" size="50" />
                <? display_form_error("url"); ?>
            </td>
        </tr>
        <tr>
            <td width="250">&nbsp;</td>
            <td>
                <input type="submit" name="submit" value="<?= tra("Change information"); ?>">
            </td>
        </tr>
        </table>
	</form>
</p>
<? 
display_page_bottom();
?>

