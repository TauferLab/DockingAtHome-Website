<?php

// Users are taken here after creating an account via the Wizard.
// They've already entered an email address and password.
// Now get a name, country, and zip code

require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/countries.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/translation.inc");

$auth = process_user_text(get_str("auth"));
$user = lookup_user_auth($auth);
if (!$user) {
    setMessage("error","There was an issue with the BOINC wizard. Because of this, you've been forwarded to the full account creation form. Please fill this out to continue.");
	gotoLocation("/account/create_html.php");
}

display_page_top("Finish account setup");

echo "
    <form action=account_finish_action.php method=post>
";
start_table();
row2(
    tra("Name")."<br><span class=\"description\">".tra("Identifies you on our web site. Use your real name or a nickname.")."</span>",
    "<input name=\"name\" size=\"30\" value=\"$user->name\">"
);
row2_init(
    tra("Country")."<br><span class=\"description\">".tra("Select the country you want to represent, if any.")."</span>",
    "<select name=\"country\">"
);
print_country_select();
echo "</select></td></tr>\n";
row2(
    tra("Postal or ZIP Code")."<br><span class=\"description\">".tra("Optional")."</span>",
    "<input name=\"postal_code\" size=\"20\">"
);
row2("",
    "<input type=\"submit\" value=\"OK\">"
);
end_table();
echo "
    <input type=hidden name=auth value=$auth>
    </form>
";

display_page_bottom();

?>