<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start();
?>
<?php include_once "phprptinc/ewrcfg10.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "phprptinc/ewmysql.php") ?>
<?php include_once "phprptinc/ewrfn10.php" ?>
<?php include_once "phprptinc/ewrusrfn10.php" ?>
<?php include_once "tai_khoanrptinfo.php" ?>
<?php

//
// Page class
//

$tai_khoan_rpt = NULL; // Initialize page object first

class crtai_khoan_rpt extends crtai_khoan {

	// Page ID
	var $PageID = 'rpt';

	// Project ID
	var $ProjectID = "{B19463A3-C58E-485F-ADEC-F8029FE765A1}";

	// Page object name
	var $PageObjName = 'tai_khoan_rpt';

	// Page name
	function PageName() {
		return ewr_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewr_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Export URLs
	var $ExportPrintUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportPdfUrl;
	var $ReportTableClass;
	var $ReportTableStyle = "";

	// Custom export
	var $ExportPrintCustom = FALSE;
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Message
	function getMessage() {
		return @$_SESSION[EWR_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EWR_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EWR_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EWR_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_WARNING_MESSAGE], $v);
	}

		// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EWR_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EWR_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EWR_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EWR_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog ewDisplayTable\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") // Header exists, display
			echo $sHeader;
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") // Fotoer exists, display
			echo $sFooter;
	}

	// Validate page request
	function IsPageRequest() {
		if ($this->UseTokenInUrl) {
			if (ewr_IsHttpPost())
				return ($this->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $CheckToken = EWR_CHECK_TOKEN;
	var $CheckTokenFn = "ewr_CheckToken";
	var $CreateTokenFn = "ewr_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ewr_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EWR_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EWR_TOKEN_NAME]);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $ReportLanguage;

		// Language object
		$ReportLanguage = new crLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (tai_khoan)
		if (!isset($GLOBALS["tai_khoan"])) {
			$GLOBALS["tai_khoan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tai_khoan"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";

		// Page ID
		if (!defined("EWR_PAGE_ID"))
			define("EWR_PAGE_ID", 'rpt', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EWR_TABLE_NAME"))
			define("EWR_TABLE_NAME", 'tai_khoan', TRUE);

		// Start timer
		$GLOBALS["gsTimer"] = new crTimer();

		// Open connection
		if (!isset($conn)) $conn = ewr_Connect($this->DBID);

		// Export options
		$this->ExportOptions = new crListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Search options
		$this->SearchOptions = new crListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Filter options
		$this->FilterOptions = new crListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption ftai_khoanrpt";

		// Generate report options
		$this->GenerateOptions = new crListOptions();
		$this->GenerateOptions->Tag = "div";
		$this->GenerateOptions->TagClassName = "ewGenerateOption";
	}

	//
	// Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $gsEmailContentType, $ReportLanguage, $Security;
		global $gsCustomExport;

		// Security
		$Security = new crAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin(); // Auto login
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate(ewr_GetUrl("rlogin.php"));
		}

		// Get export parameters
		if (@$_GET["export"] <> "")
			$this->Export = strtolower($_GET["export"]);
		elseif (@$_POST["export"] <> "")
			$this->Export = strtolower($_POST["export"]);
		$gsExport = $this->Export; // Get export parameter, used in header
		$gsExportFile = $this->TableVar; // Get export file, used in header
		$gsEmailContentType = @$_POST["contenttype"]; // Get email content type

		// Setup placeholder
		// Setup export options

		$this->SetupExportOptions();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $ReportLanguage->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Security, $ReportLanguage, $ReportOptions;
		$exportid = session_id();
		$ReportTypes = array();

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("PrinterFriendly", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("PrinterFriendly", TRUE)) . "\" href=\"" . $this->ExportPrintUrl . "\">" . $ReportLanguage->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = FALSE;
		$ReportTypes["print"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormPrint") : "";

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToExcel", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToExcel", TRUE)) . "\" href=\"" . $this->ExportExcelUrl . "\">" . $ReportLanguage->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;
		$ReportTypes["excel"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormExcel") : "";

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToWord", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToWord", TRUE)) . "\" href=\"" . $this->ExportWordUrl . "\">" . $ReportLanguage->Phrase("ExportToWord") . "</a>";

		//$item->Visible = TRUE;
		$item->Visible = TRUE;
		$ReportTypes["word"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormWord") : "";

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDF", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDF", TRUE)) . "\" href=\"" . $this->ExportPdfUrl . "\">" . $ReportLanguage->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Uncomment codes below to show export to Pdf link
//		$item->Visible = TRUE;

		$ReportTypes["pdf"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormPdf") : "";

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = $this->PageUrl() . "export=email";
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" id=\"emf_tai_khoan\" href=\"javascript:void(0);\" onclick=\"ewr_EmailDialogShow({lnk:'emf_tai_khoan',hdr:ewLanguage.Phrase('ExportToEmail'),url:'$url',exportid:'$exportid',el:this});\">" . $ReportLanguage->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;
		$ReportTypes["email"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormEmail") : "";
		$ReportOptions["ReportTypes"] = $ReportTypes;

		// Drop down button for export
		$this->ExportOptions->UseDropDownButton = FALSE;
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = $this->ExportOptions->UseDropDownButton;
		$this->ExportOptions->DropDownButtonPhrase = $ReportLanguage->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ftai_khoanrpt\" href=\"#\">" . $ReportLanguage->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ftai_khoanrpt\" href=\"#\">" . $ReportLanguage->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton; // v8
		$this->FilterOptions->DropDownButtonPhrase = $ReportLanguage->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Set up options (extended)
		$this->SetupExportOptionsExt();

		// Hide options for export
		if ($this->Export <> "") {
			$this->ExportOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}

		// Set up table class
		if ($this->Export == "word" || $this->Export == "excel" || $this->Export == "pdf")
			$this->ReportTableClass = "ewTable";
		else
			$this->ReportTableClass = "table ewTable";
	}

	// Set up search options
	function SetupSearchOptions() {
		global $ReportLanguage;

		// Filter panel button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = $this->FilterApplied ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-caption=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-toggle=\"button\" data-form=\"ftai_khoanrpt\">" . $ReportLanguage->Phrase("SearchBtn") . "</button>";
		$item->Visible = FALSE;

		// Reset filter
		$item = &$this->SearchOptions->Add("resetfilter");
		$item->Body = "<button type=\"button\" class=\"btn btn-default\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ResetAllFilter", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ResetAllFilter", TRUE)) . "\" onclick=\"location='" . ewr_CurrentPage() . "?cmd=reset'\">" . $ReportLanguage->Phrase("ResetAllFilter") . "</button>";
		$item->Visible = FALSE && $this->FilterApplied;

		// Button group for reset filter
		$this->SearchOptions->UseButtonGroup = TRUE;

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide options for export
		if ($this->Export <> "")
			$this->SearchOptions->HideAllOptions();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $ReportLanguage, $EWR_EXPORT, $gsExportFile;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		if ($this->Export <> "" && array_key_exists($this->Export, $EWR_EXPORT)) {
			$sContent = ob_get_contents();
			if (ob_get_length())
				ob_end_clean();

			// Remove all <div data-tagid="..." id="orig..." class="hide">...</div> (for customviewtag export, except "googlemaps")
			if (preg_match_all('/<div\s+data-tagid=[\'"]([\s\S]*?)[\'"]\s+id=[\'"]orig([\s\S]*?)[\'"]\s+class\s*=\s*[\'"]hide[\'"]>([\s\S]*?)<\/div\s*>/i', $sContent, $divmatches, PREG_SET_ORDER)) {
				foreach ($divmatches as $divmatch) {
					if ($divmatch[1] <> "googlemaps")
						$sContent = str_replace($divmatch[0], '', $sContent);
				}
			}
			$fn = $EWR_EXPORT[$this->Export];
			if ($this->Export == "email") { // Email
				if (@$this->GenOptions["reporttype"] == "email") {
					$saveResponse = $this->$fn($sContent, $this->GenOptions);
					$this->WriteGenResponse($saveResponse);
				} else {
					echo $this->$fn($sContent, array());
				}
				$url = ""; // Avoid redirect
			} else {
				$saveToFile = $this->$fn($sContent, $this->GenOptions);
				if (@$this->GenOptions["reporttype"] <> "") {
					$saveUrl = ($saveToFile <> "") ? ewr_ConvertFullUrl($saveToFile) : $ReportLanguage->Phrase("GenerateSuccess");
					$this->WriteGenResponse($saveUrl);
					$url = ""; // Avoid redirect
				}
			}
		}

		 // Close connection
		ewr_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EWR_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}

	// Initialize common variables
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $FilterOptions; // Filter options

	// Paging variables
	var $RecIndex = 0; // Record index
	var $RecCount = 0; // Record count
	var $StartGrp = 0; // Start group
	var $StopGrp = 0; // Stop group
	var $TotalGrps = 0; // Total groups
	var $GrpCount = 0; // Group count
	var $GrpCounter = array(); // Group counter
	var $DisplayGrps = 10; // Groups per page
	var $GrpRange = 10;
	var $Sort = "";
	var $Filter = "";
	var $PageFirstGroupFilter = "";
	var $UserIDFilter = "";
	var $DrillDown = FALSE;
	var $DrillDownInPanel = FALSE;
	var $DrillDownList = "";

	// Clear field for ext filter
	var $ClearExtFilter = "";
	var $PopupName = "";
	var $PopupValue = "";
	var $FilterApplied;
	var $SearchCommand = FALSE;
	var $ShowHeader;
	var $GrpColumnCount = 0;
	var $SubGrpColumnCount = 0;
	var $DtlColumnCount = 0;
	var $Cnt, $Col, $Val, $Smry, $Mn, $Mx, $GrandCnt, $GrandSmry, $GrandMn, $GrandMx;
	var $TotCount;
	var $GrandSummarySetup = FALSE;
	var $GrpIdx;
	var $DetailRows = array();

	//
	// Page main
	//
	function Page_Main() {
		global $rs;
		global $rsgrp;
		global $Security;
		global $gsFormError;
		global $gbDrillDownInPanel;
		global $ReportBreadcrumb;
		global $ReportLanguage;

		// Set field visibility for detail fields
		$this->MaTK->SetVisibility();
		$this->TenDangNhap->SetVisibility();
		$this->MatKhau->SetVisibility();
		$this->LoaiTK->SetVisibility();
		$this->_Email->SetVisibility();
		$this->HoTen->SetVisibility();
		$this->DiaChi->SetVisibility();
		$this->NgaySinh->SetVisibility();
		$this->SDT->SetVisibility();
		$this->CMND->SetVisibility();
		$this->DiemThuong->SetVisibility();
		$this->TenLoaiTK->SetVisibility();
		$this->ChietKhau->SetVisibility();
		$this->DiemChuan->SetVisibility();

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 15;
		$nGrps = 1;
		$this->Val = &ewr_InitArray($nDtls, 0);
		$this->Cnt = &ewr_Init2DArray($nGrps, $nDtls, 0);
		$this->Smry = &ewr_Init2DArray($nGrps, $nDtls, 0);
		$this->Mn = &ewr_Init2DArray($nGrps, $nDtls, NULL);
		$this->Mx = &ewr_Init2DArray($nGrps, $nDtls, NULL);
		$this->GrandCnt = &ewr_InitArray($nDtls, 0);
		$this->GrandSmry = &ewr_InitArray($nDtls, 0);
		$this->GrandMn = &ewr_InitArray($nDtls, NULL);
		$this->GrandMx = &ewr_InitArray($nDtls, NULL);

		// Set up array if accumulation required: array(Accum, SkipNullOrZero)
		$this->Col = array(array(FALSE, FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE));

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Load custom filters
		$this->Page_FilterLoad();

		// Set up popup filter
		$this->SetupPopup();

		// Load group db values if necessary
		$this->LoadGroupDbValues();

		// Handle Ajax popup
		$this->ProcessAjaxPopup();

		// Extended filter
		$sExtendedFilter = "";

		// Build popup filter
		$sPopupFilter = $this->GetPopupFilter();

		//ewr_SetDebugMsg("popup filter: " . $sPopupFilter);
		ewr_AddFilter($this->Filter, $sPopupFilter);

		// No filter
		$this->FilterApplied = FALSE;
		$this->FilterOptions->GetItem("savecurrentfilter")->Visible = FALSE;
		$this->FilterOptions->GetItem("deletefilter")->Visible = FALSE;

		// Call Page Selecting event
		$this->Page_Selecting($this->Filter);

		// Search options
		$this->SetupSearchOptions();

		// Get sort
		$this->Sort = $this->GetSort($this->GenOptions);

		// Get total count
		$sSql = ewr_BuildReportSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(), $this->Filter, $this->Sort);
		$this->TotalGrps = $this->GetCnt($sSql);
		if ($this->DisplayGrps <= 0 || $this->DrillDown) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowHeader = ($this->TotalGrps > 0);

		// Set up start position if not export all
		if ($this->ExportAll && $this->Export <> "")
			$this->DisplayGrps = $this->TotalGrps;
		else
			$this->SetUpStartGroup($this->GenOptions);

		// Set no record found message
		if ($this->TotalGrps == 0) {
				if ($this->Filter == "0=101") {
					$this->setWarningMessage($ReportLanguage->Phrase("EnterSearchCriteria"));
				} else {
					$this->setWarningMessage($ReportLanguage->Phrase("NoRecord"));
				}
		}

		// Hide export options if export
		if ($this->Export <> "")
			$this->ExportOptions->HideAllOptions();

		// Hide search/filter options if export/drilldown
		if ($this->Export <> "" || $this->DrillDown) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
			$this->GenerateOptions->HideAllOptions();
		}

		// Get current page records
		$rs = $this->GetRs($sSql, $this->StartGrp, $this->DisplayGrps);
		$this->SetupFieldCount();
	}

	// Accummulate summary
	function AccumulateSummary() {
		$cntx = count($this->Smry);
		for ($ix = 0; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 1; $iy < $cnty; $iy++) {
				if ($this->Col[$iy][0]) { // Accumulate required
					$valwrk = $this->Val[$iy];
					if (is_null($valwrk)) {
						if (!$this->Col[$iy][1])
							$this->Cnt[$ix][$iy]++;
					} else {
						$accum = (!$this->Col[$iy][1] || !is_numeric($valwrk) || $valwrk <> 0);
						if ($accum) {
							$this->Cnt[$ix][$iy]++;
							if (is_numeric($valwrk)) {
								$this->Smry[$ix][$iy] += $valwrk;
								if (is_null($this->Mn[$ix][$iy])) {
									$this->Mn[$ix][$iy] = $valwrk;
									$this->Mx[$ix][$iy] = $valwrk;
								} else {
									if ($this->Mn[$ix][$iy] > $valwrk) $this->Mn[$ix][$iy] = $valwrk;
									if ($this->Mx[$ix][$iy] < $valwrk) $this->Mx[$ix][$iy] = $valwrk;
								}
							}
						}
					}
				}
			}
		}
		$cntx = count($this->Smry);
		for ($ix = 0; $ix < $cntx; $ix++) {
			$this->Cnt[$ix][0]++;
		}
	}

	// Reset level summary
	function ResetLevelSummary($lvl) {

		// Clear summary values
		$cntx = count($this->Smry);
		for ($ix = $lvl; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 1; $iy < $cnty; $iy++) {
				$this->Cnt[$ix][$iy] = 0;
				if ($this->Col[$iy][0]) {
					$this->Smry[$ix][$iy] = 0;
					$this->Mn[$ix][$iy] = NULL;
					$this->Mx[$ix][$iy] = NULL;
				}
			}
		}
		$cntx = count($this->Smry);
		for ($ix = $lvl; $ix < $cntx; $ix++) {
			$this->Cnt[$ix][0] = 0;
		}

		// Reset record count
		$this->RecCount = 0;
	}

	// Accummulate grand summary
	function AccumulateGrandSummary() {
		$this->TotCount++;
		$cntgs = count($this->GrandSmry);
		for ($iy = 1; $iy < $cntgs; $iy++) {
			if ($this->Col[$iy][0]) {
				$valwrk = $this->Val[$iy];
				if (is_null($valwrk) || !is_numeric($valwrk)) {
					if (!$this->Col[$iy][1])
						$this->GrandCnt[$iy]++;
				} else {
					if (!$this->Col[$iy][1] || $valwrk <> 0) {
						$this->GrandCnt[$iy]++;
						$this->GrandSmry[$iy] += $valwrk;
						if (is_null($this->GrandMn[$iy])) {
							$this->GrandMn[$iy] = $valwrk;
							$this->GrandMx[$iy] = $valwrk;
						} else {
							if ($this->GrandMn[$iy] > $valwrk) $this->GrandMn[$iy] = $valwrk;
							if ($this->GrandMx[$iy] < $valwrk) $this->GrandMx[$iy] = $valwrk;
						}
					}
				}
			}
		}
	}

	// Get count
	function GetCnt($sql) {
		$conn = &$this->Connection();
		$rscnt = $conn->Execute($sql);
		$cnt = ($rscnt) ? $rscnt->RecordCount() : 0;
		if ($rscnt) $rscnt->Close();
		return $cnt;
	}

	// Get recordset
	function GetRs($wrksql, $start, $grps) {
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EWR_ERROR_FN"];
		$rswrk = $conn->SelectLimit($wrksql, $grps, $start - 1);
		$conn->raiseErrorFn = '';
		return $rswrk;
	}

	// Get row values
	function GetRow($opt) {
		global $rs;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row
			$rs->MoveFirst(); // Move first
				$this->FirstRowData = array();
				$this->FirstRowData['MaTK'] = ewr_Conv($rs->fields('MaTK'), 3);
				$this->FirstRowData['TenDangNhap'] = ewr_Conv($rs->fields('TenDangNhap'), 200);
				$this->FirstRowData['MatKhau'] = ewr_Conv($rs->fields('MatKhau'), 200);
				$this->FirstRowData['LoaiTK'] = ewr_Conv($rs->fields('LoaiTK'), 3);
				$this->FirstRowData['_Email'] = ewr_Conv($rs->fields('Email'), 200);
				$this->FirstRowData['HoTen'] = ewr_Conv($rs->fields('HoTen'), 200);
				$this->FirstRowData['DiaChi'] = ewr_Conv($rs->fields('DiaChi'), 200);
				$this->FirstRowData['NgaySinh'] = ewr_Conv($rs->fields('NgaySinh'), 133);
				$this->FirstRowData['SDT'] = ewr_Conv($rs->fields('SDT'), 200);
				$this->FirstRowData['CMND'] = ewr_Conv($rs->fields('CMND'), 200);
				$this->FirstRowData['DiemThuong'] = ewr_Conv($rs->fields('DiemThuong'), 3);
				$this->FirstRowData['TenLoaiTK'] = ewr_Conv($rs->fields('TenLoaiTK'), 200);
				$this->FirstRowData['ChietKhau'] = ewr_Conv($rs->fields('ChietKhau'), 4);
				$this->FirstRowData['DiemChuan'] = ewr_Conv($rs->fields('DiemChuan'), 3);
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$this->MaTK->setDbValue($rs->fields('MaTK'));
			$this->TenDangNhap->setDbValue($rs->fields('TenDangNhap'));
			$this->MatKhau->setDbValue($rs->fields('MatKhau'));
			$this->LoaiTK->setDbValue($rs->fields('LoaiTK'));
			$this->_Email->setDbValue($rs->fields('Email'));
			$this->HoTen->setDbValue($rs->fields('HoTen'));
			$this->DiaChi->setDbValue($rs->fields('DiaChi'));
			$this->NgaySinh->setDbValue($rs->fields('NgaySinh'));
			$this->SDT->setDbValue($rs->fields('SDT'));
			$this->CMND->setDbValue($rs->fields('CMND'));
			$this->DiemThuong->setDbValue($rs->fields('DiemThuong'));
			$this->TenLoaiTK->setDbValue($rs->fields('TenLoaiTK'));
			$this->ChietKhau->setDbValue($rs->fields('ChietKhau'));
			$this->DiemChuan->setDbValue($rs->fields('DiemChuan'));
			$this->GhiChu->setDbValue($rs->fields('GhiChu'));
			$this->Val[1] = $this->MaTK->CurrentValue;
			$this->Val[2] = $this->TenDangNhap->CurrentValue;
			$this->Val[3] = $this->MatKhau->CurrentValue;
			$this->Val[4] = $this->LoaiTK->CurrentValue;
			$this->Val[5] = $this->_Email->CurrentValue;
			$this->Val[6] = $this->HoTen->CurrentValue;
			$this->Val[7] = $this->DiaChi->CurrentValue;
			$this->Val[8] = $this->NgaySinh->CurrentValue;
			$this->Val[9] = $this->SDT->CurrentValue;
			$this->Val[10] = $this->CMND->CurrentValue;
			$this->Val[11] = $this->DiemThuong->CurrentValue;
			$this->Val[12] = $this->TenLoaiTK->CurrentValue;
			$this->Val[13] = $this->ChietKhau->CurrentValue;
			$this->Val[14] = $this->DiemChuan->CurrentValue;
		} else {
			$this->MaTK->setDbValue("");
			$this->TenDangNhap->setDbValue("");
			$this->MatKhau->setDbValue("");
			$this->LoaiTK->setDbValue("");
			$this->_Email->setDbValue("");
			$this->HoTen->setDbValue("");
			$this->DiaChi->setDbValue("");
			$this->NgaySinh->setDbValue("");
			$this->SDT->setDbValue("");
			$this->CMND->setDbValue("");
			$this->DiemThuong->setDbValue("");
			$this->TenLoaiTK->setDbValue("");
			$this->ChietKhau->setDbValue("");
			$this->DiemChuan->setDbValue("");
			$this->GhiChu->setDbValue("");
		}
	}

	// Set up starting group
	function SetUpStartGroup($options = array()) {

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;
		$startGrp = (@$options["start"] <> "") ? $options["start"] : @$_GET[EWR_TABLE_START_GROUP];
		$pageNo = (@$options["pageno"] <> "") ? $options["pageno"] : @$_GET["pageno"];

		// Check for a 'start' parameter
		if ($startGrp != "") {
			$this->StartGrp = $startGrp;
			$this->setStartGroup($this->StartGrp);
		} elseif ($pageNo != "") {
			$nPageNo = $pageNo;
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$this->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $this->getStartGroup();
			}
		} else {
			$this->StartGrp = $this->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$this->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$this->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$this->setStartGroup($this->StartGrp);
		}
	}

	// Load group db values if necessary
	function LoadGroupDbValues() {
		$conn = &$this->Connection();
	}

	// Process Ajax popup
	function ProcessAjaxPopup() {
		global $ReportLanguage;
		$conn = &$this->Connection();
		$fld = NULL;
		if (@$_GET["popup"] <> "") {
			$popupname = $_GET["popup"];

			// Check popup name
			// Output data as Json

			if (!is_null($fld)) {
				$jsdb = ewr_GetJsDb($fld, $fld->FldType);
				if (ob_get_length())
					ob_end_clean();
				echo $jsdb;
				exit();
			}
		}
	}

	// Set up popup
	function SetupPopup() {
		global $ReportLanguage;
		$conn = &$this->Connection();
		if ($this->DrillDown)
			return;

		// Process post back form
		if (ewr_IsHttpPost()) {
			$sName = @$_POST["popup"]; // Get popup form name
			if ($sName <> "") {
				$cntValues = (is_array(@$_POST["sel_$sName"])) ? count($_POST["sel_$sName"]) : 0;
				if ($cntValues > 0) {
					$arValues = ewr_StripSlashes($_POST["sel_$sName"]);
					if (trim($arValues[0]) == "") // Select all
						$arValues = EWR_INIT_VALUE;
					$_SESSION["sel_$sName"] = $arValues;
					$_SESSION["rf_$sName"] = ewr_StripSlashes(@$_POST["rf_$sName"]);
					$_SESSION["rt_$sName"] = ewr_StripSlashes(@$_POST["rt_$sName"]);
					$this->ResetPager();
				}
			}

		// Get 'reset' command
		} elseif (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];
			if (strtolower($sCmd) == "reset") {
				$this->ResetPager();
			}
		}

		// Load selection criteria to array
	}

	// Reset pager
	function ResetPager() {

		// Reset start position (reset command)
		$this->StartGrp = 1;
		$this->setStartGroup($this->StartGrp);
	}

	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {
		$sWrk = @$_GET[EWR_TABLE_GROUP_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayGrps = intval($sWrk);
			} else {
				if (strtoupper($sWrk) == "ALL") { // Display all groups
					$this->DisplayGrps = -1;
				} else {
					$this->DisplayGrps = 10; // Non-numeric, load default
				}
			}
			$this->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$this->setStartGroup($this->StartGrp);
		} else {
			if ($this->getGroupPerPage() <> "") {
				$this->DisplayGrps = $this->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = 10; // Load default
			}
		}
	}

	// Render row
	function RenderRow() {
		global $rs, $Security, $ReportLanguage;
		$conn = &$this->Connection();
		if (!$this->GrandSummarySetup) { // Get Grand total
			$bGotCount = FALSE;
			$bGotSummary = FALSE;

			// Get total count from sql directly
			$sSql = ewr_BuildReportSql($this->getSqlSelectCount(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
			$rstot = $conn->Execute($sSql);
			if ($rstot) {
				$this->TotCount = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
				$rstot->Close();
				$bGotCount = TRUE;
			} else {
				$this->TotCount = 0;
			}
		$bGotSummary = TRUE;

			// Accumulate grand summary from detail records
			if (!$bGotCount || !$bGotSummary) {
				$sSql = ewr_BuildReportSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
				$rs = $conn->Execute($sSql);
				if ($rs) {
					$this->GetRow(1);
					while (!$rs->EOF) {
						$this->AccumulateGrandSummary();
						$this->GetRow(2);
					}
					$rs->Close();
				}
			}
			$this->GrandSummarySetup = TRUE; // No need to set up again
		}

		// Call Row_Rendering event
		$this->Row_Rendering();

		//
		// Render view codes
		//

		if ($this->RowType == EWR_ROWTYPE_TOTAL && !($this->RowTotalType == EWR_ROWTOTAL_GROUP && $this->RowTotalSubType == EWR_ROWTOTAL_HEADER)) { // Summary row
			ewr_PrependClass($this->RowAttrs["class"], ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel); // Set up row class

			// MaTK
			$this->MaTK->HrefValue = "";

			// TenDangNhap
			$this->TenDangNhap->HrefValue = "";

			// MatKhau
			$this->MatKhau->HrefValue = "";

			// LoaiTK
			$this->LoaiTK->HrefValue = "";

			// Email
			$this->_Email->HrefValue = "";

			// HoTen
			$this->HoTen->HrefValue = "";

			// DiaChi
			$this->DiaChi->HrefValue = "";

			// NgaySinh
			$this->NgaySinh->HrefValue = "";

			// SDT
			$this->SDT->HrefValue = "";

			// CMND
			$this->CMND->HrefValue = "";

			// DiemThuong
			$this->DiemThuong->HrefValue = "";

			// TenLoaiTK
			$this->TenLoaiTK->HrefValue = "";

			// ChietKhau
			$this->ChietKhau->HrefValue = "";

			// DiemChuan
			$this->DiemChuan->HrefValue = "";
		} else {
			if ($this->RowTotalType == EWR_ROWTOTAL_GROUP && $this->RowTotalSubType == EWR_ROWTOTAL_HEADER) {
			} else {
			}

			// MaTK
			$this->MaTK->ViewValue = $this->MaTK->CurrentValue;
			$this->MaTK->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// TenDangNhap
			$this->TenDangNhap->ViewValue = $this->TenDangNhap->CurrentValue;
			$this->TenDangNhap->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// MatKhau
			$this->MatKhau->ViewValue = $this->MatKhau->CurrentValue;
			$this->MatKhau->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// LoaiTK
			$this->LoaiTK->ViewValue = $this->LoaiTK->CurrentValue;
			$this->LoaiTK->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Email
			$this->_Email->ViewValue = $this->_Email->CurrentValue;
			$this->_Email->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// HoTen
			$this->HoTen->ViewValue = $this->HoTen->CurrentValue;
			$this->HoTen->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// DiaChi
			$this->DiaChi->ViewValue = $this->DiaChi->CurrentValue;
			$this->DiaChi->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// NgaySinh
			$this->NgaySinh->ViewValue = $this->NgaySinh->CurrentValue;
			$this->NgaySinh->ViewValue = ewr_FormatDateTime($this->NgaySinh->ViewValue, 0);
			$this->NgaySinh->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// SDT
			$this->SDT->ViewValue = $this->SDT->CurrentValue;
			$this->SDT->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// CMND
			$this->CMND->ViewValue = $this->CMND->CurrentValue;
			$this->CMND->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// DiemThuong
			$this->DiemThuong->ViewValue = $this->DiemThuong->CurrentValue;
			$this->DiemThuong->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// TenLoaiTK
			$this->TenLoaiTK->ViewValue = $this->TenLoaiTK->CurrentValue;
			$this->TenLoaiTK->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// ChietKhau
			$this->ChietKhau->ViewValue = $this->ChietKhau->CurrentValue;
			$this->ChietKhau->ViewValue = ewr_FormatNumber($this->ChietKhau->ViewValue, $this->ChietKhau->DefaultDecimalPrecision, -1, 0, 0);
			$this->ChietKhau->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// DiemChuan
			$this->DiemChuan->ViewValue = $this->DiemChuan->CurrentValue;
			$this->DiemChuan->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// MaTK
			$this->MaTK->HrefValue = "";

			// TenDangNhap
			$this->TenDangNhap->HrefValue = "";

			// MatKhau
			$this->MatKhau->HrefValue = "";

			// LoaiTK
			$this->LoaiTK->HrefValue = "";

			// Email
			$this->_Email->HrefValue = "";

			// HoTen
			$this->HoTen->HrefValue = "";

			// DiaChi
			$this->DiaChi->HrefValue = "";

			// NgaySinh
			$this->NgaySinh->HrefValue = "";

			// SDT
			$this->SDT->HrefValue = "";

			// CMND
			$this->CMND->HrefValue = "";

			// DiemThuong
			$this->DiemThuong->HrefValue = "";

			// TenLoaiTK
			$this->TenLoaiTK->HrefValue = "";

			// ChietKhau
			$this->ChietKhau->HrefValue = "";

			// DiemChuan
			$this->DiemChuan->HrefValue = "";
		}

		// Call Cell_Rendered event
		if ($this->RowType == EWR_ROWTYPE_TOTAL) { // Summary row
		} else {

			// MaTK
			$CurrentValue = $this->MaTK->CurrentValue;
			$ViewValue = &$this->MaTK->ViewValue;
			$ViewAttrs = &$this->MaTK->ViewAttrs;
			$CellAttrs = &$this->MaTK->CellAttrs;
			$HrefValue = &$this->MaTK->HrefValue;
			$LinkAttrs = &$this->MaTK->LinkAttrs;
			$this->Cell_Rendered($this->MaTK, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// TenDangNhap
			$CurrentValue = $this->TenDangNhap->CurrentValue;
			$ViewValue = &$this->TenDangNhap->ViewValue;
			$ViewAttrs = &$this->TenDangNhap->ViewAttrs;
			$CellAttrs = &$this->TenDangNhap->CellAttrs;
			$HrefValue = &$this->TenDangNhap->HrefValue;
			$LinkAttrs = &$this->TenDangNhap->LinkAttrs;
			$this->Cell_Rendered($this->TenDangNhap, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// MatKhau
			$CurrentValue = $this->MatKhau->CurrentValue;
			$ViewValue = &$this->MatKhau->ViewValue;
			$ViewAttrs = &$this->MatKhau->ViewAttrs;
			$CellAttrs = &$this->MatKhau->CellAttrs;
			$HrefValue = &$this->MatKhau->HrefValue;
			$LinkAttrs = &$this->MatKhau->LinkAttrs;
			$this->Cell_Rendered($this->MatKhau, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// LoaiTK
			$CurrentValue = $this->LoaiTK->CurrentValue;
			$ViewValue = &$this->LoaiTK->ViewValue;
			$ViewAttrs = &$this->LoaiTK->ViewAttrs;
			$CellAttrs = &$this->LoaiTK->CellAttrs;
			$HrefValue = &$this->LoaiTK->HrefValue;
			$LinkAttrs = &$this->LoaiTK->LinkAttrs;
			$this->Cell_Rendered($this->LoaiTK, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Email
			$CurrentValue = $this->_Email->CurrentValue;
			$ViewValue = &$this->_Email->ViewValue;
			$ViewAttrs = &$this->_Email->ViewAttrs;
			$CellAttrs = &$this->_Email->CellAttrs;
			$HrefValue = &$this->_Email->HrefValue;
			$LinkAttrs = &$this->_Email->LinkAttrs;
			$this->Cell_Rendered($this->_Email, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// HoTen
			$CurrentValue = $this->HoTen->CurrentValue;
			$ViewValue = &$this->HoTen->ViewValue;
			$ViewAttrs = &$this->HoTen->ViewAttrs;
			$CellAttrs = &$this->HoTen->CellAttrs;
			$HrefValue = &$this->HoTen->HrefValue;
			$LinkAttrs = &$this->HoTen->LinkAttrs;
			$this->Cell_Rendered($this->HoTen, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// DiaChi
			$CurrentValue = $this->DiaChi->CurrentValue;
			$ViewValue = &$this->DiaChi->ViewValue;
			$ViewAttrs = &$this->DiaChi->ViewAttrs;
			$CellAttrs = &$this->DiaChi->CellAttrs;
			$HrefValue = &$this->DiaChi->HrefValue;
			$LinkAttrs = &$this->DiaChi->LinkAttrs;
			$this->Cell_Rendered($this->DiaChi, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// NgaySinh
			$CurrentValue = $this->NgaySinh->CurrentValue;
			$ViewValue = &$this->NgaySinh->ViewValue;
			$ViewAttrs = &$this->NgaySinh->ViewAttrs;
			$CellAttrs = &$this->NgaySinh->CellAttrs;
			$HrefValue = &$this->NgaySinh->HrefValue;
			$LinkAttrs = &$this->NgaySinh->LinkAttrs;
			$this->Cell_Rendered($this->NgaySinh, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// SDT
			$CurrentValue = $this->SDT->CurrentValue;
			$ViewValue = &$this->SDT->ViewValue;
			$ViewAttrs = &$this->SDT->ViewAttrs;
			$CellAttrs = &$this->SDT->CellAttrs;
			$HrefValue = &$this->SDT->HrefValue;
			$LinkAttrs = &$this->SDT->LinkAttrs;
			$this->Cell_Rendered($this->SDT, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// CMND
			$CurrentValue = $this->CMND->CurrentValue;
			$ViewValue = &$this->CMND->ViewValue;
			$ViewAttrs = &$this->CMND->ViewAttrs;
			$CellAttrs = &$this->CMND->CellAttrs;
			$HrefValue = &$this->CMND->HrefValue;
			$LinkAttrs = &$this->CMND->LinkAttrs;
			$this->Cell_Rendered($this->CMND, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// DiemThuong
			$CurrentValue = $this->DiemThuong->CurrentValue;
			$ViewValue = &$this->DiemThuong->ViewValue;
			$ViewAttrs = &$this->DiemThuong->ViewAttrs;
			$CellAttrs = &$this->DiemThuong->CellAttrs;
			$HrefValue = &$this->DiemThuong->HrefValue;
			$LinkAttrs = &$this->DiemThuong->LinkAttrs;
			$this->Cell_Rendered($this->DiemThuong, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// TenLoaiTK
			$CurrentValue = $this->TenLoaiTK->CurrentValue;
			$ViewValue = &$this->TenLoaiTK->ViewValue;
			$ViewAttrs = &$this->TenLoaiTK->ViewAttrs;
			$CellAttrs = &$this->TenLoaiTK->CellAttrs;
			$HrefValue = &$this->TenLoaiTK->HrefValue;
			$LinkAttrs = &$this->TenLoaiTK->LinkAttrs;
			$this->Cell_Rendered($this->TenLoaiTK, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// ChietKhau
			$CurrentValue = $this->ChietKhau->CurrentValue;
			$ViewValue = &$this->ChietKhau->ViewValue;
			$ViewAttrs = &$this->ChietKhau->ViewAttrs;
			$CellAttrs = &$this->ChietKhau->CellAttrs;
			$HrefValue = &$this->ChietKhau->HrefValue;
			$LinkAttrs = &$this->ChietKhau->LinkAttrs;
			$this->Cell_Rendered($this->ChietKhau, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// DiemChuan
			$CurrentValue = $this->DiemChuan->CurrentValue;
			$ViewValue = &$this->DiemChuan->ViewValue;
			$ViewAttrs = &$this->DiemChuan->ViewAttrs;
			$CellAttrs = &$this->DiemChuan->CellAttrs;
			$HrefValue = &$this->DiemChuan->HrefValue;
			$LinkAttrs = &$this->DiemChuan->LinkAttrs;
			$this->Cell_Rendered($this->DiemChuan, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
		}

		// Call Row_Rendered event
		$this->Row_Rendered();
		$this->SetupFieldCount();
	}

	// Setup field count
	function SetupFieldCount() {
		$this->GrpColumnCount = 0;
		$this->SubGrpColumnCount = 0;
		$this->DtlColumnCount = 0;
		if ($this->MaTK->Visible) $this->DtlColumnCount += 1;
		if ($this->TenDangNhap->Visible) $this->DtlColumnCount += 1;
		if ($this->MatKhau->Visible) $this->DtlColumnCount += 1;
		if ($this->LoaiTK->Visible) $this->DtlColumnCount += 1;
		if ($this->_Email->Visible) $this->DtlColumnCount += 1;
		if ($this->HoTen->Visible) $this->DtlColumnCount += 1;
		if ($this->DiaChi->Visible) $this->DtlColumnCount += 1;
		if ($this->NgaySinh->Visible) $this->DtlColumnCount += 1;
		if ($this->SDT->Visible) $this->DtlColumnCount += 1;
		if ($this->CMND->Visible) $this->DtlColumnCount += 1;
		if ($this->DiemThuong->Visible) $this->DtlColumnCount += 1;
		if ($this->TenLoaiTK->Visible) $this->DtlColumnCount += 1;
		if ($this->ChietKhau->Visible) $this->DtlColumnCount += 1;
		if ($this->DiemChuan->Visible) $this->DtlColumnCount += 1;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $ReportBreadcrumb;
		$ReportBreadcrumb = new crBreadcrumb();
		$url = substr(ewr_CurrentUrl(), strrpos(ewr_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$ReportBreadcrumb->Add("rpt", $this->TableVar, $url, "", $this->TableVar, TRUE);
	}

	function SetupExportOptionsExt() {
		global $ReportLanguage, $ReportOptions;
		$ReportTypes = $ReportOptions["ReportTypes"];
		$ReportOptions["ReportTypes"] = $ReportTypes;
	}

	// Return popup filter
	function GetPopupFilter() {
		$sWrk = "";
		if ($this->DrillDown)
			return "";
		return $sWrk;
	}

	//-------------------------------------------------------------------------------
	// Function GetSort
	// - Return Sort parameters based on Sort Links clicked
	// - Variables setup: Session[EWR_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
	function GetSort($options = array()) {
		if ($this->DrillDown)
			return "";
		$bResetSort = @$options["resetsort"] == "1" || @$_GET["cmd"] == "resetsort";
		$orderBy = (@$options["order"] <> "") ? @$options["order"] : ewr_StripSlashes(@$_GET["order"]);
		$orderType = (@$options["ordertype"] <> "") ? @$options["ordertype"] : ewr_StripSlashes(@$_GET["ordertype"]);

		// Check for a resetsort command
		if ($bResetSort) {
			$this->setOrderBy("");
			$this->setStartGroup(1);
			$this->MaTK->setSort("");
			$this->TenDangNhap->setSort("");
			$this->MatKhau->setSort("");
			$this->LoaiTK->setSort("");
			$this->_Email->setSort("");
			$this->HoTen->setSort("");
			$this->DiaChi->setSort("");
			$this->NgaySinh->setSort("");
			$this->SDT->setSort("");
			$this->CMND->setSort("");
			$this->DiemThuong->setSort("");
			$this->TenLoaiTK->setSort("");
			$this->ChietKhau->setSort("");
			$this->DiemChuan->setSort("");

		// Check for an Order parameter
		} elseif ($orderBy <> "") {
			$this->CurrentOrder = $orderBy;
			$this->CurrentOrderType = $orderType;
			$sSortSql = $this->SortSql();
			$this->setOrderBy($sSortSql);
			$this->setStartGroup(1);
		}
		return $this->getOrderBy();
	}

	// Export to WORD
	function ExportWord($html, $options = array()) {
		global $gsExportFile;
		$folder = @$options["folder"];
		$fileName = @$options["filename"];
		$responseType = @$options["responsetype"];
		$saveToFile = "";
		if ($folder <> "" && $fileName <> "" && ($responseType == "json" || $responseType == "file" && EWR_REPORT_SAVE_OUTPUT_ON_SERVER)) {
		 	ewr_SaveFile(ewr_PathCombine(ewr_AppRoot(), $folder, TRUE), $fileName, $html);
			$saveToFile = ewr_UploadPathEx(FALSE, $folder) . $fileName;
		}
		if ($saveToFile == "" || $responseType == "file") {
			header('Content-Type: application/vnd.ms-word' . (EWR_CHARSET <> '' ? ';charset=' . EWR_CHARSET : ''));
			header('Content-Disposition: attachment; filename=' . $gsExportFile . '.doc');
			echo $html;
		}
		return $saveToFile;
	}

	// Export to EXCEL
	function ExportExcel($html, $options = array()) {
		global $gsExportFile;
		$folder = @$options["folder"];
		$fileName = @$options["filename"];
		$responseType = @$options["responsetype"];
		$saveToFile = "";
		if ($folder <> "" && $fileName <> "" && ($responseType == "json" || $responseType == "file" && EWR_REPORT_SAVE_OUTPUT_ON_SERVER)) {
		 	ewr_SaveFile(ewr_PathCombine(ewr_AppRoot(), $folder, TRUE), $fileName, $html);
			$saveToFile = ewr_UploadPathEx(FALSE, $folder) . $fileName;
		}
		if ($saveToFile == "" || $responseType == "file") {
			header('Content-Type: application/vnd.ms-excel' . (EWR_CHARSET <> '' ? ';charset=' . EWR_CHARSET : ''));
			header('Content-Disposition: attachment; filename=' . $gsExportFile . '.xls');
			echo $html;
		}
		return $saveToFile;
	}

	// Export to PDF
	function ExportPdf($html, $options = array()) {
		$folder = @$options["folder"];
		$fileName = @$options["filename"];
		$responseType = @$options["responsetype"];
		$saveToFile = "";
		if ($folder <> "" && $fileName <> "" && ($responseType == "json" || $responseType == "file" && EWR_REPORT_SAVE_OUTPUT_ON_SERVER)) {
			$fileName = str_replace(".pdf", ".html", $fileName); // Handle as html
		 	ewr_SaveFile(ewr_PathCombine(ewr_AppRoot(), $folder, TRUE), $fileName, $html);
			$saveToFile = ewr_UploadPathEx(FALSE, $folder) . $fileName;
		}
		if ($saveToFile == "" || $responseType == "file")
			echo $html;
		ewr_DeleteTmpImages($html);
		return $saveToFile;
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ewr_Header(FALSE) ?>
<?php

// Create page object
if (!isset($tai_khoan_rpt)) $tai_khoan_rpt = new crtai_khoan_rpt();
if (isset($Page)) $OldPage = $Page;
$Page = &$tai_khoan_rpt;

// Page init
$Page->Page_Init();

// Page main
$Page->Page_Main();

// Global Page Rendering event (in ewrusrfn*.php)
Page_Rendering();

// Page Rendering event
$Page->Page_Render();
?>
<?php include_once "phprptinc/header.php" ?>
<?php if ($Page->Export == "") { ?>
<script type="text/javascript">

// Create page object
var tai_khoan_rpt = new ewr_Page("tai_khoan_rpt");

// Page properties
tai_khoan_rpt.PageID = "rpt"; // Page ID
var EWR_PAGE_ID = tai_khoan_rpt.PageID;

// Extend page with Chart_Rendering function
tai_khoan_rpt.Chart_Rendering = 
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }

// Extend page with Chart_Rendered function
tai_khoan_rpt.Chart_Rendered = 
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }
</script>
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($Page->Export == "") { ?>
<!-- container (begin) -->
<div id="ewContainer" class="ewContainer">
<!-- top container (begin) -->
<div id="ewTop" class="ewTop">
<a id="top"></a>
<?php } ?>
<?php if (@$Page->GenOptions["showfilter"] == "1") { ?>
<?php $Page->ShowFilterList(TRUE) ?>
<?php } ?>
<!-- top slot -->
<div class="ewToolbar">
<?php if ($Page->Export == "" && (!$Page->DrillDown || !$Page->DrillDownInPanel)) { ?>
<?php if ($ReportBreadcrumb) $ReportBreadcrumb->Render(); ?>
<?php } ?>
<?php
if (!$Page->DrillDownInPanel) {
	$Page->ExportOptions->Render("body");
	$Page->SearchOptions->Render("body");
	$Page->FilterOptions->Render("body");
	$Page->GenerateOptions->Render("body");
}
?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<?php echo $ReportLanguage->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php $Page->ShowPageHeader(); ?>
<?php $Page->ShowMessage(); ?>
<?php if ($Page->Export == "") { ?>
</div>
<!-- top container (end) -->
	<!-- left container (begin) -->
	<div id="ewLeft" class="ewLeft">
<?php } ?>
	<!-- Left slot -->
<?php if ($Page->Export == "") { ?>
	</div>
	<!-- left container (end) -->
	<!-- center container - report (begin) -->
	<div id="ewCenter" class="ewCenter">
<?php } ?>
	<!-- center slot -->
<!-- summary report starts -->
<?php if ($Page->Export <> "pdf") { ?>
<div id="report_summary">
<?php } ?>
<?php

// Set the last group to display if not export all
if ($Page->ExportAll && $Page->Export <> "") {
	$Page->StopGrp = $Page->TotalGrps;
} else {
	$Page->StopGrp = $Page->StartGrp + $Page->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($Page->StopGrp) > intval($Page->TotalGrps))
	$Page->StopGrp = $Page->TotalGrps;
$Page->RecCount = 0;
$Page->RecIndex = 0;

// Get first row
if ($Page->TotalGrps > 0) {
	$Page->GetRow(1);
	$Page->GrpCount = 1;
}
$Page->GrpIdx = ewr_InitArray(2, -1);
$Page->GrpIdx[0] = -1;
$Page->GrpIdx[1] = $Page->StopGrp - $Page->StartGrp + 1;
while ($rs && !$rs->EOF && $Page->GrpCount <= $Page->DisplayGrps || $Page->ShowHeader) {

	// Show dummy header for custom template
	// Show header

	if ($Page->ShowHeader) {
?>
<?php if ($Page->Export <> "pdf") { ?>
<?php if ($Page->Export == "word" || $Page->Export == "excel") { ?>
<div class="ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } else { ?>
<div class="panel panel-default ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } ?>
<?php } ?>
<!-- Report grid (begin) -->
<?php if ($Page->Export <> "pdf") { ?>
<div class="<?php if (ewr_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php } ?>
<table class="<?php echo $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($Page->MaTK->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="MaTK"><div class="tai_khoan_MaTK"><span class="ewTableHeaderCaption"><?php echo $Page->MaTK->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="MaTK">
<?php if ($Page->SortUrl($Page->MaTK) == "") { ?>
		<div class="ewTableHeaderBtn tai_khoan_MaTK">
			<span class="ewTableHeaderCaption"><?php echo $Page->MaTK->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer tai_khoan_MaTK" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->MaTK) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->MaTK->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->MaTK->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->MaTK->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->TenDangNhap->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="TenDangNhap"><div class="tai_khoan_TenDangNhap"><span class="ewTableHeaderCaption"><?php echo $Page->TenDangNhap->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="TenDangNhap">
<?php if ($Page->SortUrl($Page->TenDangNhap) == "") { ?>
		<div class="ewTableHeaderBtn tai_khoan_TenDangNhap">
			<span class="ewTableHeaderCaption"><?php echo $Page->TenDangNhap->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer tai_khoan_TenDangNhap" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->TenDangNhap) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->TenDangNhap->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->TenDangNhap->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->TenDangNhap->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->MatKhau->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="MatKhau"><div class="tai_khoan_MatKhau"><span class="ewTableHeaderCaption"><?php echo $Page->MatKhau->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="MatKhau">
<?php if ($Page->SortUrl($Page->MatKhau) == "") { ?>
		<div class="ewTableHeaderBtn tai_khoan_MatKhau">
			<span class="ewTableHeaderCaption"><?php echo $Page->MatKhau->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer tai_khoan_MatKhau" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->MatKhau) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->MatKhau->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->MatKhau->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->MatKhau->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->LoaiTK->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="LoaiTK"><div class="tai_khoan_LoaiTK"><span class="ewTableHeaderCaption"><?php echo $Page->LoaiTK->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="LoaiTK">
<?php if ($Page->SortUrl($Page->LoaiTK) == "") { ?>
		<div class="ewTableHeaderBtn tai_khoan_LoaiTK">
			<span class="ewTableHeaderCaption"><?php echo $Page->LoaiTK->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer tai_khoan_LoaiTK" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->LoaiTK) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->LoaiTK->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->LoaiTK->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->LoaiTK->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->_Email->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="_Email"><div class="tai_khoan__Email"><span class="ewTableHeaderCaption"><?php echo $Page->_Email->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="_Email">
<?php if ($Page->SortUrl($Page->_Email) == "") { ?>
		<div class="ewTableHeaderBtn tai_khoan__Email">
			<span class="ewTableHeaderCaption"><?php echo $Page->_Email->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer tai_khoan__Email" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->_Email) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->_Email->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->_Email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->_Email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->HoTen->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="HoTen"><div class="tai_khoan_HoTen"><span class="ewTableHeaderCaption"><?php echo $Page->HoTen->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="HoTen">
<?php if ($Page->SortUrl($Page->HoTen) == "") { ?>
		<div class="ewTableHeaderBtn tai_khoan_HoTen">
			<span class="ewTableHeaderCaption"><?php echo $Page->HoTen->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer tai_khoan_HoTen" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->HoTen) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->HoTen->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->HoTen->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->HoTen->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->DiaChi->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="DiaChi"><div class="tai_khoan_DiaChi"><span class="ewTableHeaderCaption"><?php echo $Page->DiaChi->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="DiaChi">
<?php if ($Page->SortUrl($Page->DiaChi) == "") { ?>
		<div class="ewTableHeaderBtn tai_khoan_DiaChi">
			<span class="ewTableHeaderCaption"><?php echo $Page->DiaChi->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer tai_khoan_DiaChi" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->DiaChi) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->DiaChi->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->DiaChi->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->DiaChi->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->NgaySinh->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="NgaySinh"><div class="tai_khoan_NgaySinh"><span class="ewTableHeaderCaption"><?php echo $Page->NgaySinh->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="NgaySinh">
<?php if ($Page->SortUrl($Page->NgaySinh) == "") { ?>
		<div class="ewTableHeaderBtn tai_khoan_NgaySinh">
			<span class="ewTableHeaderCaption"><?php echo $Page->NgaySinh->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer tai_khoan_NgaySinh" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->NgaySinh) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->NgaySinh->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->NgaySinh->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->NgaySinh->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->SDT->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="SDT"><div class="tai_khoan_SDT"><span class="ewTableHeaderCaption"><?php echo $Page->SDT->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="SDT">
<?php if ($Page->SortUrl($Page->SDT) == "") { ?>
		<div class="ewTableHeaderBtn tai_khoan_SDT">
			<span class="ewTableHeaderCaption"><?php echo $Page->SDT->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer tai_khoan_SDT" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->SDT) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->SDT->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->SDT->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->SDT->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->CMND->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="CMND"><div class="tai_khoan_CMND"><span class="ewTableHeaderCaption"><?php echo $Page->CMND->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="CMND">
<?php if ($Page->SortUrl($Page->CMND) == "") { ?>
		<div class="ewTableHeaderBtn tai_khoan_CMND">
			<span class="ewTableHeaderCaption"><?php echo $Page->CMND->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer tai_khoan_CMND" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->CMND) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->CMND->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->CMND->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->CMND->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->DiemThuong->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="DiemThuong"><div class="tai_khoan_DiemThuong"><span class="ewTableHeaderCaption"><?php echo $Page->DiemThuong->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="DiemThuong">
<?php if ($Page->SortUrl($Page->DiemThuong) == "") { ?>
		<div class="ewTableHeaderBtn tai_khoan_DiemThuong">
			<span class="ewTableHeaderCaption"><?php echo $Page->DiemThuong->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer tai_khoan_DiemThuong" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->DiemThuong) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->DiemThuong->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->DiemThuong->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->DiemThuong->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->TenLoaiTK->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="TenLoaiTK"><div class="tai_khoan_TenLoaiTK"><span class="ewTableHeaderCaption"><?php echo $Page->TenLoaiTK->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="TenLoaiTK">
<?php if ($Page->SortUrl($Page->TenLoaiTK) == "") { ?>
		<div class="ewTableHeaderBtn tai_khoan_TenLoaiTK">
			<span class="ewTableHeaderCaption"><?php echo $Page->TenLoaiTK->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer tai_khoan_TenLoaiTK" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->TenLoaiTK) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->TenLoaiTK->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->TenLoaiTK->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->TenLoaiTK->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->ChietKhau->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="ChietKhau"><div class="tai_khoan_ChietKhau"><span class="ewTableHeaderCaption"><?php echo $Page->ChietKhau->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="ChietKhau">
<?php if ($Page->SortUrl($Page->ChietKhau) == "") { ?>
		<div class="ewTableHeaderBtn tai_khoan_ChietKhau">
			<span class="ewTableHeaderCaption"><?php echo $Page->ChietKhau->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer tai_khoan_ChietKhau" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->ChietKhau) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->ChietKhau->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->ChietKhau->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->ChietKhau->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->DiemChuan->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="DiemChuan"><div class="tai_khoan_DiemChuan"><span class="ewTableHeaderCaption"><?php echo $Page->DiemChuan->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="DiemChuan">
<?php if ($Page->SortUrl($Page->DiemChuan) == "") { ?>
		<div class="ewTableHeaderBtn tai_khoan_DiemChuan">
			<span class="ewTableHeaderCaption"><?php echo $Page->DiemChuan->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer tai_khoan_DiemChuan" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->DiemChuan) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->DiemChuan->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->DiemChuan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->DiemChuan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
	</tr>
</thead>
<tbody>
<?php
		if ($Page->TotalGrps == 0) break; // Show header only
		$Page->ShowHeader = FALSE;
	}
	$Page->RecCount++;
	$Page->RecIndex++;
?>
<?php

		// Render detail row
		$Page->ResetAttrs();
		$Page->RowType = EWR_ROWTYPE_DETAIL;
		$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes(); ?>>
<?php if ($Page->MaTK->Visible) { ?>
		<td data-field="MaTK"<?php echo $Page->MaTK->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_tai_khoan_MaTK"<?php echo $Page->MaTK->ViewAttributes() ?>><?php echo $Page->MaTK->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->TenDangNhap->Visible) { ?>
		<td data-field="TenDangNhap"<?php echo $Page->TenDangNhap->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_tai_khoan_TenDangNhap"<?php echo $Page->TenDangNhap->ViewAttributes() ?>><?php echo $Page->TenDangNhap->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->MatKhau->Visible) { ?>
		<td data-field="MatKhau"<?php echo $Page->MatKhau->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_tai_khoan_MatKhau"<?php echo $Page->MatKhau->ViewAttributes() ?>><?php echo $Page->MatKhau->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->LoaiTK->Visible) { ?>
		<td data-field="LoaiTK"<?php echo $Page->LoaiTK->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_tai_khoan_LoaiTK"<?php echo $Page->LoaiTK->ViewAttributes() ?>><?php echo $Page->LoaiTK->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->_Email->Visible) { ?>
		<td data-field="_Email"<?php echo $Page->_Email->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_tai_khoan__Email"<?php echo $Page->_Email->ViewAttributes() ?>><?php echo $Page->_Email->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->HoTen->Visible) { ?>
		<td data-field="HoTen"<?php echo $Page->HoTen->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_tai_khoan_HoTen"<?php echo $Page->HoTen->ViewAttributes() ?>><?php echo $Page->HoTen->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->DiaChi->Visible) { ?>
		<td data-field="DiaChi"<?php echo $Page->DiaChi->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_tai_khoan_DiaChi"<?php echo $Page->DiaChi->ViewAttributes() ?>><?php echo $Page->DiaChi->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->NgaySinh->Visible) { ?>
		<td data-field="NgaySinh"<?php echo $Page->NgaySinh->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_tai_khoan_NgaySinh"<?php echo $Page->NgaySinh->ViewAttributes() ?>><?php echo $Page->NgaySinh->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->SDT->Visible) { ?>
		<td data-field="SDT"<?php echo $Page->SDT->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_tai_khoan_SDT"<?php echo $Page->SDT->ViewAttributes() ?>><?php echo $Page->SDT->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->CMND->Visible) { ?>
		<td data-field="CMND"<?php echo $Page->CMND->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_tai_khoan_CMND"<?php echo $Page->CMND->ViewAttributes() ?>><?php echo $Page->CMND->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->DiemThuong->Visible) { ?>
		<td data-field="DiemThuong"<?php echo $Page->DiemThuong->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_tai_khoan_DiemThuong"<?php echo $Page->DiemThuong->ViewAttributes() ?>><?php echo $Page->DiemThuong->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->TenLoaiTK->Visible) { ?>
		<td data-field="TenLoaiTK"<?php echo $Page->TenLoaiTK->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_tai_khoan_TenLoaiTK"<?php echo $Page->TenLoaiTK->ViewAttributes() ?>><?php echo $Page->TenLoaiTK->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->ChietKhau->Visible) { ?>
		<td data-field="ChietKhau"<?php echo $Page->ChietKhau->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_tai_khoan_ChietKhau"<?php echo $Page->ChietKhau->ViewAttributes() ?>><?php echo $Page->ChietKhau->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->DiemChuan->Visible) { ?>
		<td data-field="DiemChuan"<?php echo $Page->DiemChuan->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_tai_khoan_DiemChuan"<?php echo $Page->DiemChuan->ViewAttributes() ?>><?php echo $Page->DiemChuan->ListViewValue() ?></span></td>
<?php } ?>
	</tr>
<?php

		// Accumulate page summary
		$Page->AccumulateSummary();

		// Get next record
		$Page->GetRow(2);
	$Page->GrpCount++;
} // End while
?>
<?php if ($Page->TotalGrps > 0) { ?>
</tbody>
<tfoot>
	</tfoot>
<?php } elseif (!$Page->ShowHeader && FALSE) { // No header displayed ?>
<?php if ($Page->Export <> "pdf") { ?>
<?php if ($Page->Export == "word" || $Page->Export == "excel") { ?>
<div class="ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } else { ?>
<div class="panel panel-default ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } ?>
<?php } ?>
<!-- Report grid (begin) -->
<?php if ($Page->Export <> "pdf") { ?>
<div class="<?php if (ewr_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php } ?>
<table class="<?php echo $Page->ReportTableClass ?>">
<?php } ?>
<?php if ($Page->TotalGrps > 0 || FALSE) { // Show footer ?>
</table>
<?php if ($Page->Export <> "pdf") { ?>
</div>
<?php } ?>
<?php if ($Page->Export == "" && !($Page->DrillDown && $Page->TotalGrps > 0)) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php include "tai_khoanrptpager.php" ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($Page->Export <> "pdf") { ?>
</div>
<?php } ?>
<?php } ?>
<?php if ($Page->Export <> "pdf") { ?>
</div>
<?php } ?>
<!-- Summary Report Ends -->
<?php if ($Page->Export == "") { ?>
	</div>
	<!-- center container - report (end) -->
	<!-- right container (begin) -->
	<div id="ewRight" class="ewRight">
<?php } ?>
	<!-- Right slot -->
<?php if ($Page->Export == "") { ?>
	</div>
	<!-- right container (end) -->
<div class="clearfix"></div>
<!-- bottom container (begin) -->
<div id="ewBottom" class="ewBottom">
<?php } ?>
	<!-- Bottom slot -->
<?php if ($Page->Export == "") { ?>
	</div>
<!-- Bottom Container (End) -->
</div>
<!-- Table Container (End) -->
<?php } ?>
<?php $Page->ShowPageFooter(); ?>
<?php if (EWR_DEBUG_ENABLED) echo ewr_DebugMsg(); ?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "phprptinc/footer.php" ?>
<?php
$Page->Page_Terminate();
if (isset($OldPage)) $Page = $OldPage;
?>
