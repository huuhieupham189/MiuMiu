<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start();
?>
<?php include_once "phprptinc/ewrcfg10.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "phprptinc/ewmysql.php") ?>
<?php include_once "phprptinc/ewrfn10.php" ?>
<?php include_once "phprptinc/ewrusrfn10.php" ?>
<?php include_once "ThF4ng_Tin_TE0i_Kho1EA3nsmryinfo.php" ?>
<?php

//
// Page class
//

$ThF4ng_Tin_TE0i_Kho1EA3n_summary = NULL; // Initialize page object first

class crThF4ng_Tin_TE0i_Kho1EA3n_summary extends crThF4ng_Tin_TE0i_Kho1EA3n {

	// Page ID
	var $PageID = 'summary';

	// Project ID
	var $ProjectID = "{f7ff2bd7-f7a1-4d6f-a653-75acc9a37b4e}";

	// Page object name
	var $PageObjName = 'ThF4ng_Tin_TE0i_Kho1EA3n_summary';

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

		// Table object (ThF4ng_Tin_TE0i_Kho1EA3n)
		if (!isset($GLOBALS["ThF4ng_Tin_TE0i_Kho1EA3n"])) {
			$GLOBALS["ThF4ng_Tin_TE0i_Kho1EA3n"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ThF4ng_Tin_TE0i_Kho1EA3n"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";

		// Page ID
		if (!defined("EWR_PAGE_ID"))
			define("EWR_PAGE_ID", 'summary', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EWR_TABLE_NAME"))
			define("EWR_TABLE_NAME", 'Thông Tin Tài Khoản', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fThF4ng_Tin_TE0i_Kho1EA3nsummary";

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
		$this->LoaiTK->PlaceHolder = $this->LoaiTK->FldCaption();
		$this->DiemThuong->PlaceHolder = $this->DiemThuong->FldCaption();

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
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" id=\"emf_ThF4ng_Tin_TE0i_Kho1EA3n\" href=\"javascript:void(0);\" onclick=\"ewr_EmailDialogShow({lnk:'emf_ThF4ng_Tin_TE0i_Kho1EA3n',hdr:ewLanguage.Phrase('ExportToEmail'),url:'$url',exportid:'$exportid',el:this});\">" . $ReportLanguage->Phrase("ExportToEmail") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fThF4ng_Tin_TE0i_Kho1EA3nsummary\" href=\"#\">" . $ReportLanguage->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fThF4ng_Tin_TE0i_Kho1EA3nsummary\" href=\"#\">" . $ReportLanguage->Phrase("DeleteFilter") . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-caption=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-toggle=\"button\" data-form=\"fThF4ng_Tin_TE0i_Kho1EA3nsummary\">" . $ReportLanguage->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Reset filter
		$item = &$this->SearchOptions->Add("resetfilter");
		$item->Body = "<button type=\"button\" class=\"btn btn-default\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ResetAllFilter", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ResetAllFilter", TRUE)) . "\" onclick=\"location='" . ewr_CurrentPage() . "?cmd=reset'\">" . $ReportLanguage->Phrase("ResetAllFilter") . "</button>";
		$item->Visible = TRUE && $this->FilterApplied;

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

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 12;
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
		$this->Col = array(array(FALSE, FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE));

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();
		$this->LoaiTK->SelectionList = "";
		$this->LoaiTK->DefaultSelectionList = "";
		$this->LoaiTK->ValueList = "";
		$this->DiemThuong->SelectionList = "";
		$this->DiemThuong->DefaultSelectionList = "";
		$this->DiemThuong->ValueList = "";

		// Check if search command
		$this->SearchCommand = (@$_GET["cmd"] == "search");

		// Load default filter values
		$this->LoadDefaultFilters();

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

		// Restore filter list
		$this->RestoreFilterList();

		// Build extended filter
		$sExtendedFilter = $this->GetExtendedFilter();
		ewr_AddFilter($this->Filter, $sExtendedFilter);

		// Build popup filter
		$sPopupFilter = $this->GetPopupFilter();

		//ewr_SetDebugMsg("popup filter: " . $sPopupFilter);
		ewr_AddFilter($this->Filter, $sPopupFilter);

		// Check if filter applied
		$this->FilterApplied = $this->CheckFilter();

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
		$this->ShowHeader = TRUE;

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
			// Build distinct values for LoaiTK

			if ($popupname == 'ThF4ng_Tin_TE0i_Kho1EA3n_LoaiTK') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;

				// Call Page Filtering event
				$this->Page_Filtering($this->LoaiTK, $sFilter, "popup");
				$sSql = ewr_BuildReportSql($this->LoaiTK->SqlSelect, $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->LoaiTK->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->LoaiTK->setDbValue($rswrk->fields[0]);
					$this->LoaiTK->ViewValue = @$rswrk->fields[1];
					if (is_null($this->LoaiTK->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->LoaiTK->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						ewr_SetupDistinctValues($this->LoaiTK->ValueList, $this->LoaiTK->CurrentValue, $this->LoaiTK->ViewValue, FALSE, $this->LoaiTK->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->LoaiTK->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->LoaiTK->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->LoaiTK;
			}

			// Build distinct values for DiemThuong
			if ($popupname == 'ThF4ng_Tin_TE0i_Kho1EA3n_DiemThuong') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;

				// Call Page Filtering event
				$this->Page_Filtering($this->DiemThuong, $sFilter, "popup");
				$sSql = ewr_BuildReportSql($this->DiemThuong->SqlSelect, $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->DiemThuong->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->DiemThuong->setDbValue($rswrk->fields[0]);
					$this->DiemThuong->ViewValue = @$rswrk->fields[1];
					if (is_null($this->DiemThuong->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->DiemThuong->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						ewr_SetupDistinctValues($this->DiemThuong->ValueList, $this->DiemThuong->CurrentValue, $this->DiemThuong->ViewValue, FALSE, $this->DiemThuong->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->DiemThuong->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->DiemThuong->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->DiemThuong;
			}

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
					$this->PopupName = $sName;
					if (ewr_IsAdvancedFilterValue($arValues) || $arValues == EWR_INIT_VALUE)
						$this->PopupValue = $arValues;
					if (!ewr_MatchedArray($arValues, $_SESSION["sel_$sName"])) {
						if ($this->HasSessionFilterValues($sName))
							$this->ClearExtFilter = $sName; // Clear extended filter for this field
					}
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
				$this->ClearSessionSelection('LoaiTK');
				$this->ClearSessionSelection('DiemThuong');
				$this->ResetPager();
			}
		}

		// Load selection criteria to array
		// Get LoaiTK selected values

		if (is_array(@$_SESSION["sel_ThF4ng_Tin_TE0i_Kho1EA3n_LoaiTK"])) {
			$this->LoadSelectionFromSession('LoaiTK');
		} elseif (@$_SESSION["sel_ThF4ng_Tin_TE0i_Kho1EA3n_LoaiTK"] == EWR_INIT_VALUE) { // Select all
			$this->LoaiTK->SelectionList = "";
		}

		// Get DiemThuong selected values
		if (is_array(@$_SESSION["sel_ThF4ng_Tin_TE0i_Kho1EA3n_DiemThuong"])) {
			$this->LoadSelectionFromSession('DiemThuong');
		} elseif (@$_SESSION["sel_ThF4ng_Tin_TE0i_Kho1EA3n_DiemThuong"] == EWR_INIT_VALUE) { // Select all
			$this->DiemThuong->SelectionList = "";
		}
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
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $ReportBreadcrumb;
		$ReportBreadcrumb = new crBreadcrumb();
		$url = substr(ewr_CurrentUrl(), strrpos(ewr_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$ReportBreadcrumb->Add("summary", $this->TableVar, $url, "", $this->TableVar, TRUE);
	}

	function SetupExportOptionsExt() {
		global $ReportLanguage, $ReportOptions;
		$ReportTypes = $ReportOptions["ReportTypes"];
		$ReportOptions["ReportTypes"] = $ReportTypes;
	}

	// Return extended filter
	function GetExtendedFilter() {
		global $gsFormError;
		$sFilter = "";
		if ($this->DrillDown)
			return "";
		$bPostBack = ewr_IsHttpPost();
		$bRestoreSession = TRUE;
		$bSetupFilter = FALSE;

		// Reset extended filter if filter changed
		if ($bPostBack) {

			// Clear extended filter for field LoaiTK
			if ($this->ClearExtFilter == 'ThF4ng_Tin_TE0i_Kho1EA3n_LoaiTK')
				$this->SetSessionFilterValues('', '=', 'AND', '', '=', 'LoaiTK');

			// Clear extended filter for field DiemThuong
			if ($this->ClearExtFilter == 'ThF4ng_Tin_TE0i_Kho1EA3n_DiemThuong')
				$this->SetSessionFilterValues('', '=', 'AND', '', '=', 'DiemThuong');

		// Reset search command
		} elseif (@$_GET["cmd"] == "reset") {

			// Load default values
			$this->SetSessionFilterValues($this->LoaiTK->SearchValue, $this->LoaiTK->SearchOperator, $this->LoaiTK->SearchCondition, $this->LoaiTK->SearchValue2, $this->LoaiTK->SearchOperator2, 'LoaiTK'); // Field LoaiTK
			$this->SetSessionFilterValues($this->DiemThuong->SearchValue, $this->DiemThuong->SearchOperator, $this->DiemThuong->SearchCondition, $this->DiemThuong->SearchValue2, $this->DiemThuong->SearchOperator2, 'DiemThuong'); // Field DiemThuong

			//$bSetupFilter = TRUE; // No need to set up, just use default
		} else {
			$bRestoreSession = !$this->SearchCommand;

			// Field LoaiTK
			if ($this->GetFilterValues($this->LoaiTK)) {
				$bSetupFilter = TRUE;
			}

			// Field DiemThuong
			if ($this->GetFilterValues($this->DiemThuong)) {
				$bSetupFilter = TRUE;
			}
			if (!$this->ValidateForm()) {
				$this->setFailureMessage($gsFormError);
				return $sFilter;
			}
		}

		// Restore session
		if ($bRestoreSession) {
			$this->GetSessionFilterValues($this->LoaiTK); // Field LoaiTK
			$this->GetSessionFilterValues($this->DiemThuong); // Field DiemThuong
		}

		// Call page filter validated event
		$this->Page_FilterValidated();

		// Build SQL
		$this->BuildExtendedFilter($this->LoaiTK, $sFilter, FALSE, TRUE); // Field LoaiTK
		$this->BuildExtendedFilter($this->DiemThuong, $sFilter, FALSE, TRUE); // Field DiemThuong

		// Save parms to session
		$this->SetSessionFilterValues($this->LoaiTK->SearchValue, $this->LoaiTK->SearchOperator, $this->LoaiTK->SearchCondition, $this->LoaiTK->SearchValue2, $this->LoaiTK->SearchOperator2, 'LoaiTK'); // Field LoaiTK
		$this->SetSessionFilterValues($this->DiemThuong->SearchValue, $this->DiemThuong->SearchOperator, $this->DiemThuong->SearchCondition, $this->DiemThuong->SearchValue2, $this->DiemThuong->SearchOperator2, 'DiemThuong'); // Field DiemThuong

		// Setup filter
		if ($bSetupFilter) {

			// Field LoaiTK
			$sWrk = "";
			$this->BuildExtendedFilter($this->LoaiTK, $sWrk);
			ewr_LoadSelectionFromFilter($this->LoaiTK, $sWrk, $this->LoaiTK->SelectionList);
			$_SESSION['sel_ThF4ng_Tin_TE0i_Kho1EA3n_LoaiTK'] = ($this->LoaiTK->SelectionList == "") ? EWR_INIT_VALUE : $this->LoaiTK->SelectionList;

			// Field DiemThuong
			$sWrk = "";
			$this->BuildExtendedFilter($this->DiemThuong, $sWrk);
			ewr_LoadSelectionFromFilter($this->DiemThuong, $sWrk, $this->DiemThuong->SelectionList);
			$_SESSION['sel_ThF4ng_Tin_TE0i_Kho1EA3n_DiemThuong'] = ($this->DiemThuong->SelectionList == "") ? EWR_INIT_VALUE : $this->DiemThuong->SelectionList;
		}
		return $sFilter;
	}

	// Build dropdown filter
	function BuildDropDownFilter(&$fld, &$FilterClause, $FldOpr, $Default = FALSE, $SaveFilter = FALSE) {
		$FldVal = ($Default) ? $fld->DefaultDropDownValue : $fld->DropDownValue;
		$sSql = "";
		if (is_array($FldVal)) {
			foreach ($FldVal as $val) {
				$sWrk = $this->GetDropDownFilter($fld, $val, $FldOpr);

				// Call Page Filtering event
				if (substr($val, 0, 2) <> "@@") $this->Page_Filtering($fld, $sWrk, "dropdown", $FldOpr, $val);
				if ($sWrk <> "") {
					if ($sSql <> "")
						$sSql .= " OR " . $sWrk;
					else
						$sSql = $sWrk;
				}
			}
		} else {
			$sSql = $this->GetDropDownFilter($fld, $FldVal, $FldOpr);

			// Call Page Filtering event
			if (substr($FldVal, 0, 2) <> "@@") $this->Page_Filtering($fld, $sSql, "dropdown", $FldOpr, $FldVal);
		}
		if ($sSql <> "") {
			ewr_AddFilter($FilterClause, $sSql);
			if ($SaveFilter) $fld->CurrentFilter = $sSql;
		}
	}

	function GetDropDownFilter(&$fld, $FldVal, $FldOpr) {
		$FldName = $fld->FldName;
		$FldExpression = $fld->FldExpression;
		$FldDataType = $fld->FldDataType;
		$FldDelimiter = $fld->FldDelimiter;
		$FldVal = strval($FldVal);
		if ($FldOpr == "") $FldOpr = "=";
		$sWrk = "";
		if (ewr_SameStr($FldVal, EWR_NULL_VALUE)) {
			$sWrk = $FldExpression . " IS NULL";
		} elseif (ewr_SameStr($FldVal, EWR_NOT_NULL_VALUE)) {
			$sWrk = $FldExpression . " IS NOT NULL";
		} elseif (ewr_SameStr($FldVal, EWR_EMPTY_VALUE)) {
			$sWrk = $FldExpression . " = ''";
		} elseif (ewr_SameStr($FldVal, EWR_ALL_VALUE)) {
			$sWrk = "1 = 1";
		} else {
			if (substr($FldVal, 0, 2) == "@@") {
				$sWrk = $this->GetCustomFilter($fld, $FldVal, $this->DBID);
			} elseif ($FldDelimiter <> "" && trim($FldVal) <> "" && ($FldDataType == EWR_DATATYPE_STRING || $FldDataType == EWR_DATATYPE_MEMO)) {
				$sWrk = ewr_GetMultiSearchSql($FldExpression, trim($FldVal), $this->DBID);
			} else {
				if ($FldVal <> "" && $FldVal <> EWR_INIT_VALUE) {
					if ($FldDataType == EWR_DATATYPE_DATE && $FldOpr <> "") {
						$sWrk = ewr_DateFilterString($FldExpression, $FldOpr, $FldVal, $FldDataType, $this->DBID);
					} else {
						$sWrk = ewr_FilterString($FldOpr, $FldVal, $FldDataType, $this->DBID);
						if ($sWrk <> "") $sWrk = $FldExpression . $sWrk;
					}
				}
			}
		}
		return $sWrk;
	}

	// Get custom filter
	function GetCustomFilter(&$fld, $FldVal, $dbid = 0) {
		$sWrk = "";
		if (is_array($fld->AdvancedFilters)) {
			foreach ($fld->AdvancedFilters as $filter) {
				if ($filter->ID == $FldVal && $filter->Enabled) {
					$sFld = $fld->FldExpression;
					$sFn = $filter->FunctionName;
					$wrkid = (substr($filter->ID,0,2) == "@@") ? substr($filter->ID,2) : $filter->ID;
					if ($sFn <> "")
						$sWrk = $sFn($sFld, $dbid);
					else
						$sWrk = "";
					$this->Page_Filtering($fld, $sWrk, "custom", $wrkid);
					break;
				}
			}
		}
		return $sWrk;
	}

	// Build extended filter
	function BuildExtendedFilter(&$fld, &$FilterClause, $Default = FALSE, $SaveFilter = FALSE) {
		$sWrk = ewr_GetExtendedFilter($fld, $Default, $this->DBID);
		if (!$Default)
			$this->Page_Filtering($fld, $sWrk, "extended", $fld->SearchOperator, $fld->SearchValue, $fld->SearchCondition, $fld->SearchOperator2, $fld->SearchValue2);
		if ($sWrk <> "") {
			ewr_AddFilter($FilterClause, $sWrk);
			if ($SaveFilter) $fld->CurrentFilter = $sWrk;
		}
	}

	// Get drop down value from querystring
	function GetDropDownValue(&$fld) {
		$parm = substr($fld->FldVar, 2);
		if (ewr_IsHttpPost())
			return FALSE; // Skip post back
		if (isset($_GET["so_$parm"]))
			$fld->SearchOperator = ewr_StripSlashes(@$_GET["so_$parm"]);
		if (isset($_GET["sv_$parm"])) {
			$fld->DropDownValue = ewr_StripSlashes(@$_GET["sv_$parm"]);
			return TRUE;
		}
		return FALSE;
	}

	// Get filter values from querystring
	function GetFilterValues(&$fld) {
		$parm = substr($fld->FldVar, 2);
		if (ewr_IsHttpPost())
			return; // Skip post back
		$got = FALSE;
		if (isset($_GET["sv_$parm"])) {
			$fld->SearchValue = ewr_StripSlashes(@$_GET["sv_$parm"]);
			$got = TRUE;
		}
		if (isset($_GET["so_$parm"])) {
			$fld->SearchOperator = ewr_StripSlashes(@$_GET["so_$parm"]);
			$got = TRUE;
		}
		if (isset($_GET["sc_$parm"])) {
			$fld->SearchCondition = ewr_StripSlashes(@$_GET["sc_$parm"]);
			$got = TRUE;
		}
		if (isset($_GET["sv2_$parm"])) {
			$fld->SearchValue2 = ewr_StripSlashes(@$_GET["sv2_$parm"]);
			$got = TRUE;
		}
		if (isset($_GET["so2_$parm"])) {
			$fld->SearchOperator2 = ewr_StripSlashes($_GET["so2_$parm"]);
			$got = TRUE;
		}
		return $got;
	}

	// Set default ext filter
	function SetDefaultExtFilter(&$fld, $so1, $sv1, $sc, $so2, $sv2) {
		$fld->DefaultSearchValue = $sv1; // Default ext filter value 1
		$fld->DefaultSearchValue2 = $sv2; // Default ext filter value 2 (if operator 2 is enabled)
		$fld->DefaultSearchOperator = $so1; // Default search operator 1
		$fld->DefaultSearchOperator2 = $so2; // Default search operator 2 (if operator 2 is enabled)
		$fld->DefaultSearchCondition = $sc; // Default search condition (if operator 2 is enabled)
	}

	// Apply default ext filter
	function ApplyDefaultExtFilter(&$fld) {
		$fld->SearchValue = $fld->DefaultSearchValue;
		$fld->SearchValue2 = $fld->DefaultSearchValue2;
		$fld->SearchOperator = $fld->DefaultSearchOperator;
		$fld->SearchOperator2 = $fld->DefaultSearchOperator2;
		$fld->SearchCondition = $fld->DefaultSearchCondition;
	}

	// Check if Text Filter applied
	function TextFilterApplied(&$fld) {
		return (strval($fld->SearchValue) <> strval($fld->DefaultSearchValue) ||
			strval($fld->SearchValue2) <> strval($fld->DefaultSearchValue2) ||
			(strval($fld->SearchValue) <> "" &&
				strval($fld->SearchOperator) <> strval($fld->DefaultSearchOperator)) ||
			(strval($fld->SearchValue2) <> "" &&
				strval($fld->SearchOperator2) <> strval($fld->DefaultSearchOperator2)) ||
			strval($fld->SearchCondition) <> strval($fld->DefaultSearchCondition));
	}

	// Check if Non-Text Filter applied
	function NonTextFilterApplied(&$fld) {
		if (is_array($fld->DropDownValue)) {
			if (is_array($fld->DefaultDropDownValue)) {
				if (count($fld->DefaultDropDownValue) <> count($fld->DropDownValue))
					return TRUE;
				else
					return (count(array_diff($fld->DefaultDropDownValue, $fld->DropDownValue)) <> 0);
			} else {
				return TRUE;
			}
		} else {
			if (is_array($fld->DefaultDropDownValue))
				return TRUE;
			else
				$v1 = strval($fld->DefaultDropDownValue);
			if ($v1 == EWR_INIT_VALUE)
				$v1 = "";
			$v2 = strval($fld->DropDownValue);
			if ($v2 == EWR_INIT_VALUE || $v2 == EWR_ALL_VALUE)
				$v2 = "";
			return ($v1 <> $v2);
		}
	}

	// Get dropdown value from session
	function GetSessionDropDownValue(&$fld) {
		$parm = substr($fld->FldVar, 2);
		$this->GetSessionValue($fld->DropDownValue, 'sv_ThF4ng_Tin_TE0i_Kho1EA3n_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so_ThF4ng_Tin_TE0i_Kho1EA3n_' . $parm);
	}

	// Get filter values from session
	function GetSessionFilterValues(&$fld) {
		$parm = substr($fld->FldVar, 2);
		$this->GetSessionValue($fld->SearchValue, 'sv_ThF4ng_Tin_TE0i_Kho1EA3n_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so_ThF4ng_Tin_TE0i_Kho1EA3n_' . $parm);
		$this->GetSessionValue($fld->SearchCondition, 'sc_ThF4ng_Tin_TE0i_Kho1EA3n_' . $parm);
		$this->GetSessionValue($fld->SearchValue2, 'sv2_ThF4ng_Tin_TE0i_Kho1EA3n_' . $parm);
		$this->GetSessionValue($fld->SearchOperator2, 'so2_ThF4ng_Tin_TE0i_Kho1EA3n_' . $parm);
	}

	// Get value from session
	function GetSessionValue(&$sv, $sn) {
		if (array_key_exists($sn, $_SESSION))
			$sv = $_SESSION[$sn];
	}

	// Set dropdown value to session
	function SetSessionDropDownValue($sv, $so, $parm) {
		$_SESSION['sv_ThF4ng_Tin_TE0i_Kho1EA3n_' . $parm] = $sv;
		$_SESSION['so_ThF4ng_Tin_TE0i_Kho1EA3n_' . $parm] = $so;
	}

	// Set filter values to session
	function SetSessionFilterValues($sv1, $so1, $sc, $sv2, $so2, $parm) {
		$_SESSION['sv_ThF4ng_Tin_TE0i_Kho1EA3n_' . $parm] = $sv1;
		$_SESSION['so_ThF4ng_Tin_TE0i_Kho1EA3n_' . $parm] = $so1;
		$_SESSION['sc_ThF4ng_Tin_TE0i_Kho1EA3n_' . $parm] = $sc;
		$_SESSION['sv2_ThF4ng_Tin_TE0i_Kho1EA3n_' . $parm] = $sv2;
		$_SESSION['so2_ThF4ng_Tin_TE0i_Kho1EA3n_' . $parm] = $so2;
	}

	// Check if has Session filter values
	function HasSessionFilterValues($parm) {
		return ((@$_SESSION['sv_' . $parm] <> "" && @$_SESSION['sv_' . $parm] <> EWR_INIT_VALUE) ||
			(@$_SESSION['sv_' . $parm] <> "" && @$_SESSION['sv_' . $parm] <> EWR_INIT_VALUE) ||
			(@$_SESSION['sv2_' . $parm] <> "" && @$_SESSION['sv2_' . $parm] <> EWR_INIT_VALUE));
	}

	// Dropdown filter exist
	function DropDownFilterExist(&$fld, $FldOpr) {
		$sWrk = "";
		$this->BuildDropDownFilter($fld, $sWrk, $FldOpr);
		return ($sWrk <> "");
	}

	// Extended filter exist
	function ExtendedFilterExist(&$fld) {
		$sExtWrk = "";
		$this->BuildExtendedFilter($fld, $sExtWrk);
		return ($sExtWrk <> "");
	}

	// Validate form
	function ValidateForm() {
		global $ReportLanguage, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EWR_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!ewr_CheckInteger($this->LoaiTK->SearchValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $this->LoaiTK->FldErrMsg();
		}
		if (!ewr_CheckInteger($this->DiemThuong->SearchValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $this->DiemThuong->FldErrMsg();
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			$gsFormError .= ($gsFormError <> "") ? "<p>&nbsp;</p>" : "";
			$gsFormError .= $sFormCustomError;
		}
		return $ValidateForm;
	}

	// Clear selection stored in session
	function ClearSessionSelection($parm) {
		$_SESSION["sel_ThF4ng_Tin_TE0i_Kho1EA3n_$parm"] = "";
		$_SESSION["rf_ThF4ng_Tin_TE0i_Kho1EA3n_$parm"] = "";
		$_SESSION["rt_ThF4ng_Tin_TE0i_Kho1EA3n_$parm"] = "";
	}

	// Load selection from session
	function LoadSelectionFromSession($parm) {
		$fld = &$this->FieldByParm($parm);
		$fld->SelectionList = @$_SESSION["sel_ThF4ng_Tin_TE0i_Kho1EA3n_$parm"];
		$fld->RangeFrom = @$_SESSION["rf_ThF4ng_Tin_TE0i_Kho1EA3n_$parm"];
		$fld->RangeTo = @$_SESSION["rt_ThF4ng_Tin_TE0i_Kho1EA3n_$parm"];
	}

	// Load default value for filters
	function LoadDefaultFilters() {
		/**
		* Set up default values for non Text filters
		*/
		/**
		* Set up default values for extended filters
		* function SetDefaultExtFilter(&$fld, $so1, $sv1, $sc, $so2, $sv2)
		* Parameters:
		* $fld - Field object
		* $so1 - Default search operator 1
		* $sv1 - Default ext filter value 1
		* $sc - Default search condition (if operator 2 is enabled)
		* $so2 - Default search operator 2 (if operator 2 is enabled)
		* $sv2 - Default ext filter value 2 (if operator 2 is enabled)
		*/

		// Field LoaiTK
		$this->SetDefaultExtFilter($this->LoaiTK, "USER SELECT", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->LoaiTK);
		$sWrk = "";
		$this->BuildExtendedFilter($this->LoaiTK, $sWrk, TRUE);
		ewr_LoadSelectionFromFilter($this->LoaiTK, $sWrk, $this->LoaiTK->DefaultSelectionList);
		if (!$this->SearchCommand) $this->LoaiTK->SelectionList = $this->LoaiTK->DefaultSelectionList;

		// Field DiemThuong
		$this->SetDefaultExtFilter($this->DiemThuong, "USER SELECT", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->DiemThuong);
		$sWrk = "";
		$this->BuildExtendedFilter($this->DiemThuong, $sWrk, TRUE);
		ewr_LoadSelectionFromFilter($this->DiemThuong, $sWrk, $this->DiemThuong->DefaultSelectionList);
		if (!$this->SearchCommand) $this->DiemThuong->SelectionList = $this->DiemThuong->DefaultSelectionList;
		/**
		* Set up default values for popup filters
		*/

		// Field LoaiTK
		// $this->LoaiTK->DefaultSelectionList = array("val1", "val2");
		// Field DiemThuong
		// $this->DiemThuong->DefaultSelectionList = array("val1", "val2");

	}

	// Check if filter applied
	function CheckFilter() {

		// Check LoaiTK text filter
		if ($this->TextFilterApplied($this->LoaiTK))
			return TRUE;

		// Check LoaiTK popup filter
		if (!ewr_MatchedArray($this->LoaiTK->DefaultSelectionList, $this->LoaiTK->SelectionList))
			return TRUE;

		// Check DiemThuong text filter
		if ($this->TextFilterApplied($this->DiemThuong))
			return TRUE;

		// Check DiemThuong popup filter
		if (!ewr_MatchedArray($this->DiemThuong->DefaultSelectionList, $this->DiemThuong->SelectionList))
			return TRUE;
		return FALSE;
	}

	// Show list of filters
	function ShowFilterList($showDate = FALSE) {
		global $ReportLanguage;

		// Initialize
		$sFilterList = "";

		// Field LoaiTK
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($this->LoaiTK, $sExtWrk);
		if (is_array($this->LoaiTK->SelectionList))
			$sWrk = ewr_JoinArray($this->LoaiTK->SelectionList, ", ", EWR_DATATYPE_NUMBER, 0, $this->DBID);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->LoaiTK->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field DiemThuong
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($this->DiemThuong, $sExtWrk);
		if (is_array($this->DiemThuong->SelectionList))
			$sWrk = ewr_JoinArray($this->DiemThuong->SelectionList, ", ", EWR_DATATYPE_NUMBER, 0, $this->DBID);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->DiemThuong->FldCaption() . "</span>" . $sFilter . "</div>";
		$divstyle = "";
		$divdataclass = "";

		// Show Filters
		if ($sFilterList <> "" || $showDate) {
			$sMessage = "<div" . $divstyle . $divdataclass . "><div id=\"ewrFilterList\" class=\"alert alert-info ewDisplayTable\">";
			if ($showDate)
				$sMessage .= "<div id=\"ewrCurrentDate\">" . $ReportLanguage->Phrase("ReportGeneratedDate") . ewr_FormatDateTime(date("Y-m-d H:i:s"), 1) . "</div>";
			if ($sFilterList <> "")
				$sMessage .= "<div id=\"ewrCurrentFilters\">" . $ReportLanguage->Phrase("CurrentFilters") . "</div>" . $sFilterList;
			$sMessage .= "</div></div>";
			$this->Message_Showing($sMessage, "");
			echo $sMessage;
		}
	}

	// Get list of filters
	function GetFilterList() {

		// Initialize
		$sFilterList = "";

		// Field LoaiTK
		$sWrk = "";
		if ($this->LoaiTK->SearchValue <> "" || $this->LoaiTK->SearchValue2 <> "") {
			$sWrk = "\"sv_LoaiTK\":\"" . ewr_JsEncode2($this->LoaiTK->SearchValue) . "\"," .
				"\"so_LoaiTK\":\"" . ewr_JsEncode2($this->LoaiTK->SearchOperator) . "\"," .
				"\"sc_LoaiTK\":\"" . ewr_JsEncode2($this->LoaiTK->SearchCondition) . "\"," .
				"\"sv2_LoaiTK\":\"" . ewr_JsEncode2($this->LoaiTK->SearchValue2) . "\"," .
				"\"so2_LoaiTK\":\"" . ewr_JsEncode2($this->LoaiTK->SearchOperator2) . "\"";
		}
		if ($sWrk == "") {
			$sWrk = ($this->LoaiTK->SelectionList <> EWR_INIT_VALUE) ? $this->LoaiTK->SelectionList : "";
			if (is_array($sWrk))
				$sWrk = implode("||", $sWrk);
			if ($sWrk <> "")
				$sWrk = "\"sel_LoaiTK\":\"" . ewr_JsEncode2($sWrk) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Field DiemThuong
		$sWrk = "";
		if ($this->DiemThuong->SearchValue <> "" || $this->DiemThuong->SearchValue2 <> "") {
			$sWrk = "\"sv_DiemThuong\":\"" . ewr_JsEncode2($this->DiemThuong->SearchValue) . "\"," .
				"\"so_DiemThuong\":\"" . ewr_JsEncode2($this->DiemThuong->SearchOperator) . "\"," .
				"\"sc_DiemThuong\":\"" . ewr_JsEncode2($this->DiemThuong->SearchCondition) . "\"," .
				"\"sv2_DiemThuong\":\"" . ewr_JsEncode2($this->DiemThuong->SearchValue2) . "\"," .
				"\"so2_DiemThuong\":\"" . ewr_JsEncode2($this->DiemThuong->SearchOperator2) . "\"";
		}
		if ($sWrk == "") {
			$sWrk = ($this->DiemThuong->SelectionList <> EWR_INIT_VALUE) ? $this->DiemThuong->SelectionList : "";
			if (is_array($sWrk))
				$sWrk = implode("||", $sWrk);
			if ($sWrk <> "")
				$sWrk = "\"sel_DiemThuong\":\"" . ewr_JsEncode2($sWrk) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Return filter list in json
		if ($sFilterList <> "")
			return "{" . $sFilterList . "}";
		else
			return "null";
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(ewr_StripSlashes(@$_POST["filter"]), TRUE);
		return $this->SetupFilterList($filter);
	}

	// Setup list of filters
	function SetupFilterList($filter) {
		if (!is_array($filter))
			return FALSE;

		// Field LoaiTK
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_LoaiTK", $filter) || array_key_exists("so_LoaiTK", $filter) ||
			array_key_exists("sc_LoaiTK", $filter) ||
			array_key_exists("sv2_LoaiTK", $filter) || array_key_exists("so2_LoaiTK", $filter)) {
			$this->SetSessionFilterValues(@$filter["sv_LoaiTK"], @$filter["so_LoaiTK"], @$filter["sc_LoaiTK"], @$filter["sv2_LoaiTK"], @$filter["so2_LoaiTK"], "LoaiTK");
			$bRestoreFilter = TRUE;
		}
		if (array_key_exists("sel_LoaiTK", $filter)) {
			$sWrk = $filter["sel_LoaiTK"];
			$sWrk = explode("||", $sWrk);
			$this->LoaiTK->SelectionList = $sWrk;
			$_SESSION["sel_ThF4ng_Tin_TE0i_Kho1EA3n_LoaiTK"] = $sWrk;
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "LoaiTK"); // Clear extended filter
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "LoaiTK");
			$this->LoaiTK->SelectionList = "";
			$_SESSION["sel_ThF4ng_Tin_TE0i_Kho1EA3n_LoaiTK"] = "";
		}

		// Field DiemThuong
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_DiemThuong", $filter) || array_key_exists("so_DiemThuong", $filter) ||
			array_key_exists("sc_DiemThuong", $filter) ||
			array_key_exists("sv2_DiemThuong", $filter) || array_key_exists("so2_DiemThuong", $filter)) {
			$this->SetSessionFilterValues(@$filter["sv_DiemThuong"], @$filter["so_DiemThuong"], @$filter["sc_DiemThuong"], @$filter["sv2_DiemThuong"], @$filter["so2_DiemThuong"], "DiemThuong");
			$bRestoreFilter = TRUE;
		}
		if (array_key_exists("sel_DiemThuong", $filter)) {
			$sWrk = $filter["sel_DiemThuong"];
			$sWrk = explode("||", $sWrk);
			$this->DiemThuong->SelectionList = $sWrk;
			$_SESSION["sel_ThF4ng_Tin_TE0i_Kho1EA3n_DiemThuong"] = $sWrk;
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "DiemThuong"); // Clear extended filter
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "DiemThuong");
			$this->DiemThuong->SelectionList = "";
			$_SESSION["sel_ThF4ng_Tin_TE0i_Kho1EA3n_DiemThuong"] = "";
		}
		return TRUE;
	}

	// Return popup filter
	function GetPopupFilter() {
		$sWrk = "";
		if ($this->DrillDown)
			return "";
		if (!$this->ExtendedFilterExist($this->LoaiTK)) {
			if (is_array($this->LoaiTK->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->LoaiTK, "`LoaiTK`", EWR_DATATYPE_NUMBER, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->LoaiTK, $sFilter, "popup");
				$this->LoaiTK->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
		}
		if (!$this->ExtendedFilterExist($this->DiemThuong)) {
			if (is_array($this->DiemThuong->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->DiemThuong, "`DiemThuong`", EWR_DATATYPE_NUMBER, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->DiemThuong, $sFilter, "popup");
				$this->DiemThuong->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
		}
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
if (!isset($ThF4ng_Tin_TE0i_Kho1EA3n_summary)) $ThF4ng_Tin_TE0i_Kho1EA3n_summary = new crThF4ng_Tin_TE0i_Kho1EA3n_summary();
if (isset($Page)) $OldPage = $Page;
$Page = &$ThF4ng_Tin_TE0i_Kho1EA3n_summary;

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
var ThF4ng_Tin_TE0i_Kho1EA3n_summary = new ewr_Page("ThF4ng_Tin_TE0i_Kho1EA3n_summary");

// Page properties
ThF4ng_Tin_TE0i_Kho1EA3n_summary.PageID = "summary"; // Page ID
var EWR_PAGE_ID = ThF4ng_Tin_TE0i_Kho1EA3n_summary.PageID;

// Extend page with Chart_Rendering function
ThF4ng_Tin_TE0i_Kho1EA3n_summary.Chart_Rendering = 
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }

// Extend page with Chart_Rendered function
ThF4ng_Tin_TE0i_Kho1EA3n_summary.Chart_Rendered = 
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }
</script>
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<script type="text/javascript">

// Form object
var CurrentForm = fThF4ng_Tin_TE0i_Kho1EA3nsummary = new ewr_Form("fThF4ng_Tin_TE0i_Kho1EA3nsummary");

// Validate method
fThF4ng_Tin_TE0i_Kho1EA3nsummary.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	var elm = fobj.sv_LoaiTK;
	if (elm && !ewr_CheckInteger(elm.value)) {
		if (!this.OnError(elm, "<?php echo ewr_JsEncode2($Page->LoaiTK->FldErrMsg()) ?>"))
			return false;
	}
	var elm = fobj.sv_DiemThuong;
	if (elm && !ewr_CheckInteger(elm.value)) {
		if (!this.OnError(elm, "<?php echo ewr_JsEncode2($Page->DiemThuong->FldErrMsg()) ?>"))
			return false;
	}

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate method
fThF4ng_Tin_TE0i_Kho1EA3nsummary.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }
<?php if (EWR_CLIENT_VALIDATE) { ?>
fThF4ng_Tin_TE0i_Kho1EA3nsummary.ValidateRequired = true; // Uses JavaScript validation
<?php } else { ?>
fThF4ng_Tin_TE0i_Kho1EA3nsummary.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Use Ajax
</script>
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
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<!-- Search form (begin) -->
<form name="fThF4ng_Tin_TE0i_Kho1EA3nsummary" id="fThF4ng_Tin_TE0i_Kho1EA3nsummary" class="form-inline ewForm ewExtFilterForm" action="<?php echo ewr_CurrentPage() ?>">
<?php $SearchPanelClass = ($Page->Filter <> "") ? " in" : " in"; ?>
<div id="fThF4ng_Tin_TE0i_Kho1EA3nsummary_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<div id="r_1" class="ewRow">
<div id="c_LoaiTK" class="ewCell form-group">
	<label for="sv_LoaiTK" class="ewSearchCaption ewLabel"><?php echo $Page->LoaiTK->FldCaption() ?></label>
	<span class="ewSearchOperator"><select name="so_LoaiTK" id="so_LoaiTK" class="form-control" onchange="ewrForms(this).SrchOprChanged(this);"><option value="="<?php if ($Page->LoaiTK->SearchOperator == "=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("EQUAL"); ?></option><option value="<>"<?php if ($Page->LoaiTK->SearchOperator == "<>") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<>"); ?></option><option value="<"<?php if ($Page->LoaiTK->SearchOperator == "<") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<"); ?></option><option value="<="<?php if ($Page->LoaiTK->SearchOperator == "<=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<="); ?></option><option value=">"<?php if ($Page->LoaiTK->SearchOperator == ">") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">"); ?></option><option value=">="<?php if ($Page->LoaiTK->SearchOperator == ">=") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">="); ?></option><option value="BETWEEN"<?php if ($Page->LoaiTK->SearchOperator == "BETWEEN") echo " selected" ?>><?php echo $ReportLanguage->Phrase("BETWEEN"); ?></option></select></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->LoaiTK->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="ThF4ng_Tin_TE0i_Kho1EA3n" data-field="x_LoaiTK" id="sv_LoaiTK" name="sv_LoaiTK" size="30" placeholder="<?php echo $Page->LoaiTK->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->LoaiTK->SearchValue) ?>"<?php echo $Page->LoaiTK->EditAttributes() ?>>
</span>
	<span class="ewSearchCond btw1_LoaiTK" style="display: none"><?php echo $ReportLanguage->Phrase("AND") ?></span>
	<span class="ewSearchField btw1_LoaiTK" style="display: none">
<?php ewr_PrependClass($Page->LoaiTK->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="ThF4ng_Tin_TE0i_Kho1EA3n" data-field="x_LoaiTK" id="sv2_LoaiTK" name="sv2_LoaiTK" size="30" placeholder="<?php echo $Page->LoaiTK->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->LoaiTK->SearchValue2) ?>"<?php echo $Page->LoaiTK->EditAttributes() ?>>
</span>
</div>
</div>
<div id="r_2" class="ewRow">
<div id="c_DiemThuong" class="ewCell form-group">
	<label for="sv_DiemThuong" class="ewSearchCaption ewLabel"><?php echo $Page->DiemThuong->FldCaption() ?></label>
	<span class="ewSearchOperator"><select name="so_DiemThuong" id="so_DiemThuong" class="form-control" onchange="ewrForms(this).SrchOprChanged(this);"><option value="="<?php if ($Page->DiemThuong->SearchOperator == "=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("EQUAL"); ?></option><option value="<>"<?php if ($Page->DiemThuong->SearchOperator == "<>") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<>"); ?></option><option value="<"<?php if ($Page->DiemThuong->SearchOperator == "<") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<"); ?></option><option value="<="<?php if ($Page->DiemThuong->SearchOperator == "<=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<="); ?></option><option value=">"<?php if ($Page->DiemThuong->SearchOperator == ">") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">"); ?></option><option value=">="<?php if ($Page->DiemThuong->SearchOperator == ">=") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">="); ?></option><option value="BETWEEN"<?php if ($Page->DiemThuong->SearchOperator == "BETWEEN") echo " selected" ?>><?php echo $ReportLanguage->Phrase("BETWEEN"); ?></option></select></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->DiemThuong->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="ThF4ng_Tin_TE0i_Kho1EA3n" data-field="x_DiemThuong" id="sv_DiemThuong" name="sv_DiemThuong" size="30" placeholder="<?php echo $Page->DiemThuong->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->DiemThuong->SearchValue) ?>"<?php echo $Page->DiemThuong->EditAttributes() ?>>
</span>
	<span class="ewSearchCond btw1_DiemThuong" style="display: none"><?php echo $ReportLanguage->Phrase("AND") ?></span>
	<span class="ewSearchField btw1_DiemThuong" style="display: none">
<?php ewr_PrependClass($Page->DiemThuong->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="ThF4ng_Tin_TE0i_Kho1EA3n" data-field="x_DiemThuong" id="sv2_DiemThuong" name="sv2_DiemThuong" size="30" placeholder="<?php echo $Page->DiemThuong->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->DiemThuong->SearchValue2) ?>"<?php echo $Page->DiemThuong->EditAttributes() ?>>
</span>
</div>
</div>
<div class="ewRow"><input type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-primary" value="<?php echo $ReportLanguage->Phrase("Search") ?>">
<input type="reset" name="btnreset" id="btnreset" class="btn hide" value="<?php echo $ReportLanguage->Phrase("Reset") ?>"></div>
</div>
</form>
<script type="text/javascript">
fThF4ng_Tin_TE0i_Kho1EA3nsummary.Init();
fThF4ng_Tin_TE0i_Kho1EA3nsummary.FilterList = <?php echo $Page->GetFilterList() ?>;
</script>
<!-- Search form (end) -->
<?php } ?>
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->ShowFilterList() ?>
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
	<td data-field="MaTK"><div class="ThF4ng_Tin_TE0i_Kho1EA3n_MaTK"><span class="ewTableHeaderCaption"><?php echo $Page->MaTK->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="MaTK">
<?php if ($Page->SortUrl($Page->MaTK) == "") { ?>
		<div class="ewTableHeaderBtn ThF4ng_Tin_TE0i_Kho1EA3n_MaTK">
			<span class="ewTableHeaderCaption"><?php echo $Page->MaTK->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer ThF4ng_Tin_TE0i_Kho1EA3n_MaTK" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->MaTK) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->MaTK->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->MaTK->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->MaTK->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->TenDangNhap->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="TenDangNhap"><div class="ThF4ng_Tin_TE0i_Kho1EA3n_TenDangNhap"><span class="ewTableHeaderCaption"><?php echo $Page->TenDangNhap->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="TenDangNhap">
<?php if ($Page->SortUrl($Page->TenDangNhap) == "") { ?>
		<div class="ewTableHeaderBtn ThF4ng_Tin_TE0i_Kho1EA3n_TenDangNhap">
			<span class="ewTableHeaderCaption"><?php echo $Page->TenDangNhap->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer ThF4ng_Tin_TE0i_Kho1EA3n_TenDangNhap" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->TenDangNhap) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->TenDangNhap->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->TenDangNhap->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->TenDangNhap->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->MatKhau->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="MatKhau"><div class="ThF4ng_Tin_TE0i_Kho1EA3n_MatKhau"><span class="ewTableHeaderCaption"><?php echo $Page->MatKhau->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="MatKhau">
<?php if ($Page->SortUrl($Page->MatKhau) == "") { ?>
		<div class="ewTableHeaderBtn ThF4ng_Tin_TE0i_Kho1EA3n_MatKhau">
			<span class="ewTableHeaderCaption"><?php echo $Page->MatKhau->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer ThF4ng_Tin_TE0i_Kho1EA3n_MatKhau" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->MatKhau) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->MatKhau->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->MatKhau->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->MatKhau->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->LoaiTK->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="LoaiTK"><div class="ThF4ng_Tin_TE0i_Kho1EA3n_LoaiTK"><span class="ewTableHeaderCaption"><?php echo $Page->LoaiTK->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="LoaiTK">
<?php if ($Page->SortUrl($Page->LoaiTK) == "") { ?>
		<div class="ewTableHeaderBtn ThF4ng_Tin_TE0i_Kho1EA3n_LoaiTK">
			<span class="ewTableHeaderCaption"><?php echo $Page->LoaiTK->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'ThF4ng_Tin_TE0i_Kho1EA3n_LoaiTK', true, '<?php echo $Page->LoaiTK->RangeFrom; ?>', '<?php echo $Page->LoaiTK->RangeTo; ?>');" id="x_LoaiTK<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer ThF4ng_Tin_TE0i_Kho1EA3n_LoaiTK" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->LoaiTK) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->LoaiTK->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->LoaiTK->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->LoaiTK->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'ThF4ng_Tin_TE0i_Kho1EA3n_LoaiTK', true, '<?php echo $Page->LoaiTK->RangeFrom; ?>', '<?php echo $Page->LoaiTK->RangeTo; ?>');" id="x_LoaiTK<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->_Email->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="_Email"><div class="ThF4ng_Tin_TE0i_Kho1EA3n__Email"><span class="ewTableHeaderCaption"><?php echo $Page->_Email->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="_Email">
<?php if ($Page->SortUrl($Page->_Email) == "") { ?>
		<div class="ewTableHeaderBtn ThF4ng_Tin_TE0i_Kho1EA3n__Email">
			<span class="ewTableHeaderCaption"><?php echo $Page->_Email->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer ThF4ng_Tin_TE0i_Kho1EA3n__Email" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->_Email) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->_Email->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->_Email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->_Email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->HoTen->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="HoTen"><div class="ThF4ng_Tin_TE0i_Kho1EA3n_HoTen"><span class="ewTableHeaderCaption"><?php echo $Page->HoTen->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="HoTen">
<?php if ($Page->SortUrl($Page->HoTen) == "") { ?>
		<div class="ewTableHeaderBtn ThF4ng_Tin_TE0i_Kho1EA3n_HoTen">
			<span class="ewTableHeaderCaption"><?php echo $Page->HoTen->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer ThF4ng_Tin_TE0i_Kho1EA3n_HoTen" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->HoTen) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->HoTen->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->HoTen->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->HoTen->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->DiaChi->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="DiaChi"><div class="ThF4ng_Tin_TE0i_Kho1EA3n_DiaChi"><span class="ewTableHeaderCaption"><?php echo $Page->DiaChi->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="DiaChi">
<?php if ($Page->SortUrl($Page->DiaChi) == "") { ?>
		<div class="ewTableHeaderBtn ThF4ng_Tin_TE0i_Kho1EA3n_DiaChi">
			<span class="ewTableHeaderCaption"><?php echo $Page->DiaChi->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer ThF4ng_Tin_TE0i_Kho1EA3n_DiaChi" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->DiaChi) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->DiaChi->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->DiaChi->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->DiaChi->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->NgaySinh->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="NgaySinh"><div class="ThF4ng_Tin_TE0i_Kho1EA3n_NgaySinh"><span class="ewTableHeaderCaption"><?php echo $Page->NgaySinh->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="NgaySinh">
<?php if ($Page->SortUrl($Page->NgaySinh) == "") { ?>
		<div class="ewTableHeaderBtn ThF4ng_Tin_TE0i_Kho1EA3n_NgaySinh">
			<span class="ewTableHeaderCaption"><?php echo $Page->NgaySinh->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer ThF4ng_Tin_TE0i_Kho1EA3n_NgaySinh" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->NgaySinh) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->NgaySinh->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->NgaySinh->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->NgaySinh->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->SDT->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="SDT"><div class="ThF4ng_Tin_TE0i_Kho1EA3n_SDT"><span class="ewTableHeaderCaption"><?php echo $Page->SDT->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="SDT">
<?php if ($Page->SortUrl($Page->SDT) == "") { ?>
		<div class="ewTableHeaderBtn ThF4ng_Tin_TE0i_Kho1EA3n_SDT">
			<span class="ewTableHeaderCaption"><?php echo $Page->SDT->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer ThF4ng_Tin_TE0i_Kho1EA3n_SDT" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->SDT) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->SDT->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->SDT->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->SDT->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->CMND->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="CMND"><div class="ThF4ng_Tin_TE0i_Kho1EA3n_CMND"><span class="ewTableHeaderCaption"><?php echo $Page->CMND->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="CMND">
<?php if ($Page->SortUrl($Page->CMND) == "") { ?>
		<div class="ewTableHeaderBtn ThF4ng_Tin_TE0i_Kho1EA3n_CMND">
			<span class="ewTableHeaderCaption"><?php echo $Page->CMND->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer ThF4ng_Tin_TE0i_Kho1EA3n_CMND" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->CMND) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->CMND->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->CMND->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->CMND->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->DiemThuong->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="DiemThuong"><div class="ThF4ng_Tin_TE0i_Kho1EA3n_DiemThuong"><span class="ewTableHeaderCaption"><?php echo $Page->DiemThuong->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="DiemThuong">
<?php if ($Page->SortUrl($Page->DiemThuong) == "") { ?>
		<div class="ewTableHeaderBtn ThF4ng_Tin_TE0i_Kho1EA3n_DiemThuong">
			<span class="ewTableHeaderCaption"><?php echo $Page->DiemThuong->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'ThF4ng_Tin_TE0i_Kho1EA3n_DiemThuong', true, '<?php echo $Page->DiemThuong->RangeFrom; ?>', '<?php echo $Page->DiemThuong->RangeTo; ?>');" id="x_DiemThuong<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer ThF4ng_Tin_TE0i_Kho1EA3n_DiemThuong" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->DiemThuong) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->DiemThuong->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->DiemThuong->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->DiemThuong->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'ThF4ng_Tin_TE0i_Kho1EA3n_DiemThuong', true, '<?php echo $Page->DiemThuong->RangeFrom; ?>', '<?php echo $Page->DiemThuong->RangeTo; ?>');" id="x_DiemThuong<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
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
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_ThF4ng_Tin_TE0i_Kho1EA3n_MaTK"<?php echo $Page->MaTK->ViewAttributes() ?>><?php echo $Page->MaTK->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->TenDangNhap->Visible) { ?>
		<td data-field="TenDangNhap"<?php echo $Page->TenDangNhap->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_ThF4ng_Tin_TE0i_Kho1EA3n_TenDangNhap"<?php echo $Page->TenDangNhap->ViewAttributes() ?>><?php echo $Page->TenDangNhap->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->MatKhau->Visible) { ?>
		<td data-field="MatKhau"<?php echo $Page->MatKhau->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_ThF4ng_Tin_TE0i_Kho1EA3n_MatKhau"<?php echo $Page->MatKhau->ViewAttributes() ?>><?php echo $Page->MatKhau->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->LoaiTK->Visible) { ?>
		<td data-field="LoaiTK"<?php echo $Page->LoaiTK->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_ThF4ng_Tin_TE0i_Kho1EA3n_LoaiTK"<?php echo $Page->LoaiTK->ViewAttributes() ?>><?php echo $Page->LoaiTK->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->_Email->Visible) { ?>
		<td data-field="_Email"<?php echo $Page->_Email->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_ThF4ng_Tin_TE0i_Kho1EA3n__Email"<?php echo $Page->_Email->ViewAttributes() ?>><?php echo $Page->_Email->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->HoTen->Visible) { ?>
		<td data-field="HoTen"<?php echo $Page->HoTen->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_ThF4ng_Tin_TE0i_Kho1EA3n_HoTen"<?php echo $Page->HoTen->ViewAttributes() ?>><?php echo $Page->HoTen->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->DiaChi->Visible) { ?>
		<td data-field="DiaChi"<?php echo $Page->DiaChi->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_ThF4ng_Tin_TE0i_Kho1EA3n_DiaChi"<?php echo $Page->DiaChi->ViewAttributes() ?>><?php echo $Page->DiaChi->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->NgaySinh->Visible) { ?>
		<td data-field="NgaySinh"<?php echo $Page->NgaySinh->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_ThF4ng_Tin_TE0i_Kho1EA3n_NgaySinh"<?php echo $Page->NgaySinh->ViewAttributes() ?>><?php echo $Page->NgaySinh->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->SDT->Visible) { ?>
		<td data-field="SDT"<?php echo $Page->SDT->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_ThF4ng_Tin_TE0i_Kho1EA3n_SDT"<?php echo $Page->SDT->ViewAttributes() ?>><?php echo $Page->SDT->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->CMND->Visible) { ?>
		<td data-field="CMND"<?php echo $Page->CMND->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_ThF4ng_Tin_TE0i_Kho1EA3n_CMND"<?php echo $Page->CMND->ViewAttributes() ?>><?php echo $Page->CMND->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->DiemThuong->Visible) { ?>
		<td data-field="DiemThuong"<?php echo $Page->DiemThuong->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_ThF4ng_Tin_TE0i_Kho1EA3n_DiemThuong"<?php echo $Page->DiemThuong->ViewAttributes() ?>><?php echo $Page->DiemThuong->ListViewValue() ?></span></td>
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
<?php
	$Page->ResetAttrs();
	$Page->RowType = EWR_ROWTYPE_TOTAL;
	$Page->RowTotalType = EWR_ROWTOTAL_GRAND;
	$Page->RowTotalSubType = EWR_ROWTOTAL_FOOTER;
	$Page->RowAttrs["class"] = "ewRptGrandSummary";
	$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes() ?>><td colspan="<?php echo ($Page->GrpColumnCount + $Page->DtlColumnCount) ?>"><?php echo $ReportLanguage->Phrase("RptGrandSummary") ?> <span class="ewDirLtr">(<?php echo ewr_FormatNumber($Page->TotCount,0,-2,-2,-2); ?><?php echo $ReportLanguage->Phrase("RptDtlRec") ?>)</span></td></tr>
	</tfoot>
<?php } elseif (!$Page->ShowHeader && TRUE) { // No header displayed ?>
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
<?php if ($Page->TotalGrps > 0 || TRUE) { // Show footer ?>
</table>
<?php if ($Page->Export <> "pdf") { ?>
</div>
<?php } ?>
<?php if ($Page->Export == "" && !($Page->DrillDown && $Page->TotalGrps > 0)) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php include "ThF4ng_Tin_TE0i_Kho1EA3nsmrypager.php" ?>
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
