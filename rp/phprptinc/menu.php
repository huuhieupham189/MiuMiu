<!-- Begin Main Menu -->
<div class="ewMenu">
<?php $RootMenu = new crMenu(EWR_MENUBAR_ID); ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(12, "mi_ThF4ng_Tin_TE0i_Kho1EA3n", $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("12", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "ThF4ng_Tin_TE0i_Kho1EA3nsmry.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(13, "mi_ThF4ng_Tin_S1EA3n_Ph1EA9m", $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("13", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "ThF4ng_Tin_S1EA3n_Ph1EA9msmry.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(15, "mi_Doanh_Thu", $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("15", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "Doanh_Thusmry.php", -1, "", IsLoggedIn(), FALSE);
if (IsLoggedIn()) {
	$RootMenu->AddMenuItem(-1, "mi_logout", $ReportLanguage->Phrase("Logout"), "rlogout.php", -1, "", TRUE);
} elseif (substr(ewr_ScriptName(), 0 - strlen("rlogin.php")) <> "rlogin.php") {
	$RootMenu->AddMenuItem(-1, "mi_login", $ReportLanguage->Phrase("Login"), "rlogin.php", -1, "", TRUE);
}
$RootMenu->Render();
?>
</div>
<!-- End Main Menu -->
