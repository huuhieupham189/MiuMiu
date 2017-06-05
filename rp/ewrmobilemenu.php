<!-- Begin Main Menu -->
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(1, "mmi_cthd", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("1", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "cthdrpt.php?cmd=resetdrilldown", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(3, "mmi_hoa_don", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("3", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "hoa_donrpt.php?cmd=resetdrilldown", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(4, "mmi_hoadon", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("4", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "hoadonrpt.php?cmd=resetdrilldown", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(23, "mmi_doanhthu", $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("23", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "doanhthusmry.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(24, "mmi_QL_Doanh_Thu", $ReportLanguage->Phrase("CrosstabReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("24", "MenuText") . $ReportLanguage->Phrase("CrosstabReportMenuItemSuffix"), "QL_Doanh_Thuctb.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(25, "mmi_chi_tiet_hoa_don", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("25", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "chi_tiet_hoa_donrpt.php?cmd=resetdrilldown", -1, "", TRUE, FALSE);
$RootMenu->Render();
?>
<!-- End Main Menu -->
