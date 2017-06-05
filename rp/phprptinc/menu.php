<!-- Begin Main Menu -->
<div class="ewMenu">
<?php $RootMenu = new crMenu(EWR_MENUBAR_ID); ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(1, "mi_cthd", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("1", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "cthdrpt.php?cmd=resetdrilldown", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(3, "mi_hoa_don", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("3", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "hoa_donrpt.php?cmd=resetdrilldown", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(4, "mi_hoadon", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("4", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "hoadonrpt.php?cmd=resetdrilldown", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(23, "mi_doanhthu", $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("23", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "doanhthusmry.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(24, "mi_QL_Doanh_Thu", $ReportLanguage->Phrase("CrosstabReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("24", "MenuText") . $ReportLanguage->Phrase("CrosstabReportMenuItemSuffix"), "QL_Doanh_Thuctb.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(25, "mi_chi_tiet_hoa_don", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("25", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "chi_tiet_hoa_donrpt.php?cmd=resetdrilldown", -1, "", TRUE, FALSE);
$RootMenu->Render();
?>
</div>
<!-- End Main Menu -->
