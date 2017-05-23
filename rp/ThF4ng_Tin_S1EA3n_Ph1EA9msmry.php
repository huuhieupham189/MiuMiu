<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start();
?>
<?php include_once "phprptinc/ewrcfg10.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "phprptinc/ewmysql.php") ?>
<?php include_once "phprptinc/ewrfn10.php" ?>
<?php include_once "phprptinc/ewrusrfn10.php" ?>
<?php include_once "ThF4ng_Tin_S1EA3n_Ph1EA9msmryinfo.php" ?>
<?php

//
// Page class
//

$ThF4ng_Tin_S1EA3n_Ph1EA9m_summary = NULL; // Initialize page object first

class crThF4ng_Tin_S1EA3n_Ph1EA9m_summary extends crThF4ng_Tin_S1EA3n_Ph1EA9m {

	// Page ID
	var $PageID = 'summary';

	// Project ID
	var $ProjectID = "{f7ff2bd7-f7a1-4d6f-a653-75acc9a37b4e}";

	// Page object name
	var $PageObjName = 'ThF4ng_Tin_S1EA3n_Ph1EA9m_summary';

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

		// Table object (ThF4ng_Tin_S1EA3n_Ph1EA9m)
		if (!isset($GLOBALS["ThF4ng_Tin_S1EA3n_Ph1EA9m"])) {
			$GLOBALS["ThF4ng_Tin_S1EA3n_Ph1EA9m"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ThF4ng_Tin_S1EA3n_Ph1EA9m"];
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
			define("EWR_TABLE_NAME", 'Thông Tin Sản Phẩm', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fThF4ng_Tin_S1EA3n_Ph1EA9msummary";

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
		$this->GiaNhap->PlaceHolder = $this->GiaNhap->FldCaption();
		$this->GiaBan->PlaceHolder = $this->GiaBan->FldCaption();
		$this->SLTon->PlaceHolder = $this->SLTon->FldCaption();
		$this->SoLuong->PlaceHolder = $this->SoLuong->FldCaption();

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
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" id=\"emf_ThF4ng_Tin_S1EA3n_Ph1EA9m\" href=\"javascript:void(0);\" onclick=\"ewr_EmailDialogShow({lnk:'emf_ThF4ng_Tin_S1EA3n_Ph1EA9m',hdr:ewLanguage.Phrase('ExportToEmail'),url:'$url',exportid:'$exportid',el:this});\">" . $ReportLanguage->Phrase("ExportToEmail") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fThF4ng_Tin_S1EA3n_Ph1EA9msummary\" href=\"#\">" . $ReportLanguage->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fThF4ng_Tin_S1EA3n_Ph1EA9msummary\" href=\"#\">" . $ReportLanguage->Phrase("DeleteFilter") . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-caption=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-toggle=\"button\" data-form=\"fThF4ng_Tin_S1EA3n_Ph1EA9msummary\">" . $ReportLanguage->Phrase("SearchBtn") . "</button>";
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
		$this->MaSP->SetVisibility();
		$this->TenSP->SetVisibility();
		$this->TenCT->SetVisibility();
		$this->NoiSX->SetVisibility();
		$this->DungTich->SetVisibility();
		$this->GiaNhap->SetVisibility();
		$this->GiaBan->SetVisibility();
		$this->SLTon->SetVisibility();
		$this->TenVietTat->SetVisibility();
		$this->TenLoaiSP->SetVisibility();
		$this->TenThuongHieu->SetVisibility();
		$this->SoLuong->SetVisibility();

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 13;
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
		$this->Col = array(array(FALSE, FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(TRUE,FALSE));

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();
		$this->GiaNhap->SelectionList = "";
		$this->GiaNhap->DefaultSelectionList = "";
		$this->GiaNhap->ValueList = "";
		$this->GiaBan->SelectionList = "";
		$this->GiaBan->DefaultSelectionList = "";
		$this->GiaBan->ValueList = "";
		$this->SLTon->SelectionList = "";
		$this->SLTon->DefaultSelectionList = "";
		$this->SLTon->ValueList = "";

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
				$this->FirstRowData['MaSP'] = ewr_Conv($rs->fields('MaSP'), 3);
				$this->FirstRowData['TenSP'] = ewr_Conv($rs->fields('TenSP'), 200);
				$this->FirstRowData['TenCT'] = ewr_Conv($rs->fields('TenCT'), 200);
				$this->FirstRowData['NoiSX'] = ewr_Conv($rs->fields('NoiSX'), 200);
				$this->FirstRowData['DungTich'] = ewr_Conv($rs->fields('DungTich'), 200);
				$this->FirstRowData['GiaNhap'] = ewr_Conv($rs->fields('GiaNhap'), 3);
				$this->FirstRowData['GiaBan'] = ewr_Conv($rs->fields('GiaBan'), 3);
				$this->FirstRowData['SLTon'] = ewr_Conv($rs->fields('SLTon'), 3);
				$this->FirstRowData['TenVietTat'] = ewr_Conv($rs->fields('TenVietTat'), 200);
				$this->FirstRowData['TenLoaiSP'] = ewr_Conv($rs->fields('TenLoaiSP'), 200);
				$this->FirstRowData['TenThuongHieu'] = ewr_Conv($rs->fields('TenThuongHieu'), 200);
				$this->FirstRowData['SoLuong'] = ewr_Conv($rs->fields('SoLuong'), 3);
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$this->MaSP->setDbValue($rs->fields('MaSP'));
			$this->TenSP->setDbValue($rs->fields('TenSP'));
			$this->TenCT->setDbValue($rs->fields('TenCT'));
			$this->NoiSX->setDbValue($rs->fields('NoiSX'));
			$this->DungTich->setDbValue($rs->fields('DungTich'));
			$this->GiaNhap->setDbValue($rs->fields('GiaNhap'));
			$this->GiaBan->setDbValue($rs->fields('GiaBan'));
			$this->SLTon->setDbValue($rs->fields('SLTon'));
			$this->TenVietTat->setDbValue($rs->fields('TenVietTat'));
			$this->TenLoaiSP->setDbValue($rs->fields('TenLoaiSP'));
			$this->TenThuongHieu->setDbValue($rs->fields('TenThuongHieu'));
			$this->SoLuong->setDbValue($rs->fields('SoLuong'));
			$this->Val[1] = $this->MaSP->CurrentValue;
			$this->Val[2] = $this->TenSP->CurrentValue;
			$this->Val[3] = $this->TenCT->CurrentValue;
			$this->Val[4] = $this->NoiSX->CurrentValue;
			$this->Val[5] = $this->DungTich->CurrentValue;
			$this->Val[6] = $this->GiaNhap->CurrentValue;
			$this->Val[7] = $this->GiaBan->CurrentValue;
			$this->Val[8] = $this->SLTon->CurrentValue;
			$this->Val[9] = $this->TenVietTat->CurrentValue;
			$this->Val[10] = $this->TenLoaiSP->CurrentValue;
			$this->Val[11] = $this->TenThuongHieu->CurrentValue;
			$this->Val[12] = $this->SoLuong->CurrentValue;
		} else {
			$this->MaSP->setDbValue("");
			$this->TenSP->setDbValue("");
			$this->TenCT->setDbValue("");
			$this->NoiSX->setDbValue("");
			$this->DungTich->setDbValue("");
			$this->GiaNhap->setDbValue("");
			$this->GiaBan->setDbValue("");
			$this->SLTon->setDbValue("");
			$this->TenVietTat->setDbValue("");
			$this->TenLoaiSP->setDbValue("");
			$this->TenThuongHieu->setDbValue("");
			$this->SoLuong->setDbValue("");
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
			// Build distinct values for GiaNhap

			if ($popupname == 'ThF4ng_Tin_S1EA3n_Ph1EA9m_GiaNhap') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;

				// Call Page Filtering event
				$this->Page_Filtering($this->GiaNhap, $sFilter, "popup");
				$sSql = ewr_BuildReportSql($this->GiaNhap->SqlSelect, $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->GiaNhap->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->GiaNhap->setDbValue($rswrk->fields[0]);
					$this->GiaNhap->ViewValue = @$rswrk->fields[1];
					if (is_null($this->GiaNhap->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->GiaNhap->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						ewr_SetupDistinctValues($this->GiaNhap->ValueList, $this->GiaNhap->CurrentValue, $this->GiaNhap->ViewValue, FALSE, $this->GiaNhap->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->GiaNhap->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->GiaNhap->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->GiaNhap;
			}

			// Build distinct values for GiaBan
			if ($popupname == 'ThF4ng_Tin_S1EA3n_Ph1EA9m_GiaBan') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;

				// Call Page Filtering event
				$this->Page_Filtering($this->GiaBan, $sFilter, "popup");
				$sSql = ewr_BuildReportSql($this->GiaBan->SqlSelect, $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->GiaBan->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->GiaBan->setDbValue($rswrk->fields[0]);
					$this->GiaBan->ViewValue = @$rswrk->fields[1];
					if (is_null($this->GiaBan->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->GiaBan->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						ewr_SetupDistinctValues($this->GiaBan->ValueList, $this->GiaBan->CurrentValue, $this->GiaBan->ViewValue, FALSE, $this->GiaBan->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->GiaBan->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->GiaBan->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->GiaBan;
			}

			// Build distinct values for SLTon
			if ($popupname == 'ThF4ng_Tin_S1EA3n_Ph1EA9m_SLTon') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;

				// Call Page Filtering event
				$this->Page_Filtering($this->SLTon, $sFilter, "popup");
				$sSql = ewr_BuildReportSql($this->SLTon->SqlSelect, $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->SLTon->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->SLTon->setDbValue($rswrk->fields[0]);
					$this->SLTon->ViewValue = @$rswrk->fields[1];
					if (is_null($this->SLTon->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->SLTon->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						ewr_SetupDistinctValues($this->SLTon->ValueList, $this->SLTon->CurrentValue, $this->SLTon->ViewValue, FALSE, $this->SLTon->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->SLTon->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->SLTon->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->SLTon;
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
				$this->ClearSessionSelection('GiaNhap');
				$this->ClearSessionSelection('GiaBan');
				$this->ClearSessionSelection('SLTon');
				$this->ResetPager();
			}
		}

		// Load selection criteria to array
		// Get GiaNhap selected values

		if (is_array(@$_SESSION["sel_ThF4ng_Tin_S1EA3n_Ph1EA9m_GiaNhap"])) {
			$this->LoadSelectionFromSession('GiaNhap');
		} elseif (@$_SESSION["sel_ThF4ng_Tin_S1EA3n_Ph1EA9m_GiaNhap"] == EWR_INIT_VALUE) { // Select all
			$this->GiaNhap->SelectionList = "";
		}

		// Get GiaBan selected values
		if (is_array(@$_SESSION["sel_ThF4ng_Tin_S1EA3n_Ph1EA9m_GiaBan"])) {
			$this->LoadSelectionFromSession('GiaBan');
		} elseif (@$_SESSION["sel_ThF4ng_Tin_S1EA3n_Ph1EA9m_GiaBan"] == EWR_INIT_VALUE) { // Select all
			$this->GiaBan->SelectionList = "";
		}

		// Get SLTon selected values
		if (is_array(@$_SESSION["sel_ThF4ng_Tin_S1EA3n_Ph1EA9m_SLTon"])) {
			$this->LoadSelectionFromSession('SLTon');
		} elseif (@$_SESSION["sel_ThF4ng_Tin_S1EA3n_Ph1EA9m_SLTon"] == EWR_INIT_VALUE) { // Select all
			$this->SLTon->SelectionList = "";
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

			// Get total from sql directly
			$sSql = ewr_BuildReportSql($this->getSqlSelectAgg(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
			$sSql = $this->getSqlAggPfx() . $sSql . $this->getSqlAggSfx();
			$rsagg = $conn->Execute($sSql);
			if ($rsagg) {
				$this->GrandCnt[1] = $this->TotCount;
				$this->GrandCnt[2] = $this->TotCount;
				$this->GrandCnt[3] = $this->TotCount;
				$this->GrandCnt[4] = $this->TotCount;
				$this->GrandCnt[5] = $this->TotCount;
				$this->GrandCnt[6] = $this->TotCount;
				$this->GrandCnt[7] = $this->TotCount;
				$this->GrandCnt[8] = $this->TotCount;
				$this->GrandCnt[9] = $this->TotCount;
				$this->GrandCnt[10] = $this->TotCount;
				$this->GrandCnt[11] = $this->TotCount;
				$this->GrandCnt[12] = $this->TotCount;
				$this->GrandSmry[12] = $rsagg->fields("sum_soluong");
				$rsagg->Close();
				$bGotSummary = TRUE;
			}

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

			// SoLuong
			$this->SoLuong->SumViewValue = $this->SoLuong->SumValue;
			$this->SoLuong->CellAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// MaSP
			$this->MaSP->HrefValue = "";

			// TenSP
			$this->TenSP->HrefValue = "";

			// TenCT
			$this->TenCT->HrefValue = "";

			// NoiSX
			$this->NoiSX->HrefValue = "";

			// DungTich
			$this->DungTich->HrefValue = "";

			// GiaNhap
			$this->GiaNhap->HrefValue = "";

			// GiaBan
			$this->GiaBan->HrefValue = "";

			// SLTon
			$this->SLTon->HrefValue = "";

			// TenVietTat
			$this->TenVietTat->HrefValue = "";

			// TenLoaiSP
			$this->TenLoaiSP->HrefValue = "";

			// TenThuongHieu
			$this->TenThuongHieu->HrefValue = "";

			// SoLuong
			$this->SoLuong->HrefValue = "";
		} else {
			if ($this->RowTotalType == EWR_ROWTOTAL_GROUP && $this->RowTotalSubType == EWR_ROWTOTAL_HEADER) {
			} else {
			}

			// MaSP
			$this->MaSP->ViewValue = $this->MaSP->CurrentValue;
			$this->MaSP->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// TenSP
			$this->TenSP->ViewValue = $this->TenSP->CurrentValue;
			$this->TenSP->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// TenCT
			$this->TenCT->ViewValue = $this->TenCT->CurrentValue;
			$this->TenCT->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// NoiSX
			$this->NoiSX->ViewValue = $this->NoiSX->CurrentValue;
			$this->NoiSX->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// DungTich
			$this->DungTich->ViewValue = $this->DungTich->CurrentValue;
			$this->DungTich->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// GiaNhap
			$this->GiaNhap->ViewValue = $this->GiaNhap->CurrentValue;
			$this->GiaNhap->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// GiaBan
			$this->GiaBan->ViewValue = $this->GiaBan->CurrentValue;
			$this->GiaBan->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// SLTon
			$this->SLTon->ViewValue = $this->SLTon->CurrentValue;
			$this->SLTon->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// TenVietTat
			$this->TenVietTat->ViewValue = $this->TenVietTat->CurrentValue;
			$this->TenVietTat->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// TenLoaiSP
			$this->TenLoaiSP->ViewValue = $this->TenLoaiSP->CurrentValue;
			$this->TenLoaiSP->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// TenThuongHieu
			$this->TenThuongHieu->ViewValue = $this->TenThuongHieu->CurrentValue;
			$this->TenThuongHieu->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// SoLuong
			$this->SoLuong->ViewValue = $this->SoLuong->CurrentValue;
			$this->SoLuong->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// MaSP
			$this->MaSP->HrefValue = "";

			// TenSP
			$this->TenSP->HrefValue = "";

			// TenCT
			$this->TenCT->HrefValue = "";

			// NoiSX
			$this->NoiSX->HrefValue = "";

			// DungTich
			$this->DungTich->HrefValue = "";

			// GiaNhap
			$this->GiaNhap->HrefValue = "";

			// GiaBan
			$this->GiaBan->HrefValue = "";

			// SLTon
			$this->SLTon->HrefValue = "";

			// TenVietTat
			$this->TenVietTat->HrefValue = "";

			// TenLoaiSP
			$this->TenLoaiSP->HrefValue = "";

			// TenThuongHieu
			$this->TenThuongHieu->HrefValue = "";

			// SoLuong
			$this->SoLuong->HrefValue = "";
		}

		// Call Cell_Rendered event
		if ($this->RowType == EWR_ROWTYPE_TOTAL) { // Summary row

			// SoLuong
			$CurrentValue = $this->SoLuong->SumValue;
			$ViewValue = &$this->SoLuong->SumViewValue;
			$ViewAttrs = &$this->SoLuong->ViewAttrs;
			$CellAttrs = &$this->SoLuong->CellAttrs;
			$HrefValue = &$this->SoLuong->HrefValue;
			$LinkAttrs = &$this->SoLuong->LinkAttrs;
			$this->Cell_Rendered($this->SoLuong, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
		} else {

			// MaSP
			$CurrentValue = $this->MaSP->CurrentValue;
			$ViewValue = &$this->MaSP->ViewValue;
			$ViewAttrs = &$this->MaSP->ViewAttrs;
			$CellAttrs = &$this->MaSP->CellAttrs;
			$HrefValue = &$this->MaSP->HrefValue;
			$LinkAttrs = &$this->MaSP->LinkAttrs;
			$this->Cell_Rendered($this->MaSP, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// TenSP
			$CurrentValue = $this->TenSP->CurrentValue;
			$ViewValue = &$this->TenSP->ViewValue;
			$ViewAttrs = &$this->TenSP->ViewAttrs;
			$CellAttrs = &$this->TenSP->CellAttrs;
			$HrefValue = &$this->TenSP->HrefValue;
			$LinkAttrs = &$this->TenSP->LinkAttrs;
			$this->Cell_Rendered($this->TenSP, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// TenCT
			$CurrentValue = $this->TenCT->CurrentValue;
			$ViewValue = &$this->TenCT->ViewValue;
			$ViewAttrs = &$this->TenCT->ViewAttrs;
			$CellAttrs = &$this->TenCT->CellAttrs;
			$HrefValue = &$this->TenCT->HrefValue;
			$LinkAttrs = &$this->TenCT->LinkAttrs;
			$this->Cell_Rendered($this->TenCT, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// NoiSX
			$CurrentValue = $this->NoiSX->CurrentValue;
			$ViewValue = &$this->NoiSX->ViewValue;
			$ViewAttrs = &$this->NoiSX->ViewAttrs;
			$CellAttrs = &$this->NoiSX->CellAttrs;
			$HrefValue = &$this->NoiSX->HrefValue;
			$LinkAttrs = &$this->NoiSX->LinkAttrs;
			$this->Cell_Rendered($this->NoiSX, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// DungTich
			$CurrentValue = $this->DungTich->CurrentValue;
			$ViewValue = &$this->DungTich->ViewValue;
			$ViewAttrs = &$this->DungTich->ViewAttrs;
			$CellAttrs = &$this->DungTich->CellAttrs;
			$HrefValue = &$this->DungTich->HrefValue;
			$LinkAttrs = &$this->DungTich->LinkAttrs;
			$this->Cell_Rendered($this->DungTich, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// GiaNhap
			$CurrentValue = $this->GiaNhap->CurrentValue;
			$ViewValue = &$this->GiaNhap->ViewValue;
			$ViewAttrs = &$this->GiaNhap->ViewAttrs;
			$CellAttrs = &$this->GiaNhap->CellAttrs;
			$HrefValue = &$this->GiaNhap->HrefValue;
			$LinkAttrs = &$this->GiaNhap->LinkAttrs;
			$this->Cell_Rendered($this->GiaNhap, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// GiaBan
			$CurrentValue = $this->GiaBan->CurrentValue;
			$ViewValue = &$this->GiaBan->ViewValue;
			$ViewAttrs = &$this->GiaBan->ViewAttrs;
			$CellAttrs = &$this->GiaBan->CellAttrs;
			$HrefValue = &$this->GiaBan->HrefValue;
			$LinkAttrs = &$this->GiaBan->LinkAttrs;
			$this->Cell_Rendered($this->GiaBan, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// SLTon
			$CurrentValue = $this->SLTon->CurrentValue;
			$ViewValue = &$this->SLTon->ViewValue;
			$ViewAttrs = &$this->SLTon->ViewAttrs;
			$CellAttrs = &$this->SLTon->CellAttrs;
			$HrefValue = &$this->SLTon->HrefValue;
			$LinkAttrs = &$this->SLTon->LinkAttrs;
			$this->Cell_Rendered($this->SLTon, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// TenVietTat
			$CurrentValue = $this->TenVietTat->CurrentValue;
			$ViewValue = &$this->TenVietTat->ViewValue;
			$ViewAttrs = &$this->TenVietTat->ViewAttrs;
			$CellAttrs = &$this->TenVietTat->CellAttrs;
			$HrefValue = &$this->TenVietTat->HrefValue;
			$LinkAttrs = &$this->TenVietTat->LinkAttrs;
			$this->Cell_Rendered($this->TenVietTat, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// TenLoaiSP
			$CurrentValue = $this->TenLoaiSP->CurrentValue;
			$ViewValue = &$this->TenLoaiSP->ViewValue;
			$ViewAttrs = &$this->TenLoaiSP->ViewAttrs;
			$CellAttrs = &$this->TenLoaiSP->CellAttrs;
			$HrefValue = &$this->TenLoaiSP->HrefValue;
			$LinkAttrs = &$this->TenLoaiSP->LinkAttrs;
			$this->Cell_Rendered($this->TenLoaiSP, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// TenThuongHieu
			$CurrentValue = $this->TenThuongHieu->CurrentValue;
			$ViewValue = &$this->TenThuongHieu->ViewValue;
			$ViewAttrs = &$this->TenThuongHieu->ViewAttrs;
			$CellAttrs = &$this->TenThuongHieu->CellAttrs;
			$HrefValue = &$this->TenThuongHieu->HrefValue;
			$LinkAttrs = &$this->TenThuongHieu->LinkAttrs;
			$this->Cell_Rendered($this->TenThuongHieu, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// SoLuong
			$CurrentValue = $this->SoLuong->CurrentValue;
			$ViewValue = &$this->SoLuong->ViewValue;
			$ViewAttrs = &$this->SoLuong->ViewAttrs;
			$CellAttrs = &$this->SoLuong->CellAttrs;
			$HrefValue = &$this->SoLuong->HrefValue;
			$LinkAttrs = &$this->SoLuong->LinkAttrs;
			$this->Cell_Rendered($this->SoLuong, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
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
		if ($this->MaSP->Visible) $this->DtlColumnCount += 1;
		if ($this->TenSP->Visible) $this->DtlColumnCount += 1;
		if ($this->TenCT->Visible) $this->DtlColumnCount += 1;
		if ($this->NoiSX->Visible) $this->DtlColumnCount += 1;
		if ($this->DungTich->Visible) $this->DtlColumnCount += 1;
		if ($this->GiaNhap->Visible) $this->DtlColumnCount += 1;
		if ($this->GiaBan->Visible) $this->DtlColumnCount += 1;
		if ($this->SLTon->Visible) $this->DtlColumnCount += 1;
		if ($this->TenVietTat->Visible) $this->DtlColumnCount += 1;
		if ($this->TenLoaiSP->Visible) $this->DtlColumnCount += 1;
		if ($this->TenThuongHieu->Visible) $this->DtlColumnCount += 1;
		if ($this->SoLuong->Visible) $this->DtlColumnCount += 1;
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

			// Clear extended filter for field GiaNhap
			if ($this->ClearExtFilter == 'ThF4ng_Tin_S1EA3n_Ph1EA9m_GiaNhap')
				$this->SetSessionFilterValues('', '=', 'AND', '', '=', 'GiaNhap');

			// Clear extended filter for field GiaBan
			if ($this->ClearExtFilter == 'ThF4ng_Tin_S1EA3n_Ph1EA9m_GiaBan')
				$this->SetSessionFilterValues('', '=', 'AND', '', '=', 'GiaBan');

			// Clear extended filter for field SLTon
			if ($this->ClearExtFilter == 'ThF4ng_Tin_S1EA3n_Ph1EA9m_SLTon')
				$this->SetSessionFilterValues('', '=', 'AND', '', '=', 'SLTon');

		// Reset search command
		} elseif (@$_GET["cmd"] == "reset") {

			// Load default values
			$this->SetSessionFilterValues($this->GiaNhap->SearchValue, $this->GiaNhap->SearchOperator, $this->GiaNhap->SearchCondition, $this->GiaNhap->SearchValue2, $this->GiaNhap->SearchOperator2, 'GiaNhap'); // Field GiaNhap
			$this->SetSessionFilterValues($this->GiaBan->SearchValue, $this->GiaBan->SearchOperator, $this->GiaBan->SearchCondition, $this->GiaBan->SearchValue2, $this->GiaBan->SearchOperator2, 'GiaBan'); // Field GiaBan
			$this->SetSessionFilterValues($this->SLTon->SearchValue, $this->SLTon->SearchOperator, $this->SLTon->SearchCondition, $this->SLTon->SearchValue2, $this->SLTon->SearchOperator2, 'SLTon'); // Field SLTon
			$this->SetSessionFilterValues($this->SoLuong->SearchValue, $this->SoLuong->SearchOperator, $this->SoLuong->SearchCondition, $this->SoLuong->SearchValue2, $this->SoLuong->SearchOperator2, 'SoLuong'); // Field SoLuong

			//$bSetupFilter = TRUE; // No need to set up, just use default
		} else {
			$bRestoreSession = !$this->SearchCommand;

			// Field GiaNhap
			if ($this->GetFilterValues($this->GiaNhap)) {
				$bSetupFilter = TRUE;
			}

			// Field GiaBan
			if ($this->GetFilterValues($this->GiaBan)) {
				$bSetupFilter = TRUE;
			}

			// Field SLTon
			if ($this->GetFilterValues($this->SLTon)) {
				$bSetupFilter = TRUE;
			}

			// Field SoLuong
			if ($this->GetFilterValues($this->SoLuong)) {
				$bSetupFilter = TRUE;
			}
			if (!$this->ValidateForm()) {
				$this->setFailureMessage($gsFormError);
				return $sFilter;
			}
		}

		// Restore session
		if ($bRestoreSession) {
			$this->GetSessionFilterValues($this->GiaNhap); // Field GiaNhap
			$this->GetSessionFilterValues($this->GiaBan); // Field GiaBan
			$this->GetSessionFilterValues($this->SLTon); // Field SLTon
			$this->GetSessionFilterValues($this->SoLuong); // Field SoLuong
		}

		// Call page filter validated event
		$this->Page_FilterValidated();

		// Build SQL
		$this->BuildExtendedFilter($this->GiaNhap, $sFilter, FALSE, TRUE); // Field GiaNhap
		$this->BuildExtendedFilter($this->GiaBan, $sFilter, FALSE, TRUE); // Field GiaBan
		$this->BuildExtendedFilter($this->SLTon, $sFilter, FALSE, TRUE); // Field SLTon
		$this->BuildExtendedFilter($this->SoLuong, $sFilter, FALSE, TRUE); // Field SoLuong

		// Save parms to session
		$this->SetSessionFilterValues($this->GiaNhap->SearchValue, $this->GiaNhap->SearchOperator, $this->GiaNhap->SearchCondition, $this->GiaNhap->SearchValue2, $this->GiaNhap->SearchOperator2, 'GiaNhap'); // Field GiaNhap
		$this->SetSessionFilterValues($this->GiaBan->SearchValue, $this->GiaBan->SearchOperator, $this->GiaBan->SearchCondition, $this->GiaBan->SearchValue2, $this->GiaBan->SearchOperator2, 'GiaBan'); // Field GiaBan
		$this->SetSessionFilterValues($this->SLTon->SearchValue, $this->SLTon->SearchOperator, $this->SLTon->SearchCondition, $this->SLTon->SearchValue2, $this->SLTon->SearchOperator2, 'SLTon'); // Field SLTon
		$this->SetSessionFilterValues($this->SoLuong->SearchValue, $this->SoLuong->SearchOperator, $this->SoLuong->SearchCondition, $this->SoLuong->SearchValue2, $this->SoLuong->SearchOperator2, 'SoLuong'); // Field SoLuong

		// Setup filter
		if ($bSetupFilter) {

			// Field GiaNhap
			$sWrk = "";
			$this->BuildExtendedFilter($this->GiaNhap, $sWrk);
			ewr_LoadSelectionFromFilter($this->GiaNhap, $sWrk, $this->GiaNhap->SelectionList);
			$_SESSION['sel_ThF4ng_Tin_S1EA3n_Ph1EA9m_GiaNhap'] = ($this->GiaNhap->SelectionList == "") ? EWR_INIT_VALUE : $this->GiaNhap->SelectionList;

			// Field GiaBan
			$sWrk = "";
			$this->BuildExtendedFilter($this->GiaBan, $sWrk);
			ewr_LoadSelectionFromFilter($this->GiaBan, $sWrk, $this->GiaBan->SelectionList);
			$_SESSION['sel_ThF4ng_Tin_S1EA3n_Ph1EA9m_GiaBan'] = ($this->GiaBan->SelectionList == "") ? EWR_INIT_VALUE : $this->GiaBan->SelectionList;

			// Field SLTon
			$sWrk = "";
			$this->BuildExtendedFilter($this->SLTon, $sWrk);
			ewr_LoadSelectionFromFilter($this->SLTon, $sWrk, $this->SLTon->SelectionList);
			$_SESSION['sel_ThF4ng_Tin_S1EA3n_Ph1EA9m_SLTon'] = ($this->SLTon->SelectionList == "") ? EWR_INIT_VALUE : $this->SLTon->SelectionList;
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
		$this->GetSessionValue($fld->DropDownValue, 'sv_ThF4ng_Tin_S1EA3n_Ph1EA9m_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so_ThF4ng_Tin_S1EA3n_Ph1EA9m_' . $parm);
	}

	// Get filter values from session
	function GetSessionFilterValues(&$fld) {
		$parm = substr($fld->FldVar, 2);
		$this->GetSessionValue($fld->SearchValue, 'sv_ThF4ng_Tin_S1EA3n_Ph1EA9m_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so_ThF4ng_Tin_S1EA3n_Ph1EA9m_' . $parm);
		$this->GetSessionValue($fld->SearchCondition, 'sc_ThF4ng_Tin_S1EA3n_Ph1EA9m_' . $parm);
		$this->GetSessionValue($fld->SearchValue2, 'sv2_ThF4ng_Tin_S1EA3n_Ph1EA9m_' . $parm);
		$this->GetSessionValue($fld->SearchOperator2, 'so2_ThF4ng_Tin_S1EA3n_Ph1EA9m_' . $parm);
	}

	// Get value from session
	function GetSessionValue(&$sv, $sn) {
		if (array_key_exists($sn, $_SESSION))
			$sv = $_SESSION[$sn];
	}

	// Set dropdown value to session
	function SetSessionDropDownValue($sv, $so, $parm) {
		$_SESSION['sv_ThF4ng_Tin_S1EA3n_Ph1EA9m_' . $parm] = $sv;
		$_SESSION['so_ThF4ng_Tin_S1EA3n_Ph1EA9m_' . $parm] = $so;
	}

	// Set filter values to session
	function SetSessionFilterValues($sv1, $so1, $sc, $sv2, $so2, $parm) {
		$_SESSION['sv_ThF4ng_Tin_S1EA3n_Ph1EA9m_' . $parm] = $sv1;
		$_SESSION['so_ThF4ng_Tin_S1EA3n_Ph1EA9m_' . $parm] = $so1;
		$_SESSION['sc_ThF4ng_Tin_S1EA3n_Ph1EA9m_' . $parm] = $sc;
		$_SESSION['sv2_ThF4ng_Tin_S1EA3n_Ph1EA9m_' . $parm] = $sv2;
		$_SESSION['so2_ThF4ng_Tin_S1EA3n_Ph1EA9m_' . $parm] = $so2;
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
		if (!ewr_CheckInteger($this->GiaNhap->SearchValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $this->GiaNhap->FldErrMsg();
		}
		if (!ewr_CheckInteger($this->GiaBan->SearchValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $this->GiaBan->FldErrMsg();
		}
		if (!ewr_CheckInteger($this->SLTon->SearchValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $this->SLTon->FldErrMsg();
		}
		if (!ewr_CheckInteger($this->SoLuong->SearchValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $this->SoLuong->FldErrMsg();
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
		$_SESSION["sel_ThF4ng_Tin_S1EA3n_Ph1EA9m_$parm"] = "";
		$_SESSION["rf_ThF4ng_Tin_S1EA3n_Ph1EA9m_$parm"] = "";
		$_SESSION["rt_ThF4ng_Tin_S1EA3n_Ph1EA9m_$parm"] = "";
	}

	// Load selection from session
	function LoadSelectionFromSession($parm) {
		$fld = &$this->FieldByParm($parm);
		$fld->SelectionList = @$_SESSION["sel_ThF4ng_Tin_S1EA3n_Ph1EA9m_$parm"];
		$fld->RangeFrom = @$_SESSION["rf_ThF4ng_Tin_S1EA3n_Ph1EA9m_$parm"];
		$fld->RangeTo = @$_SESSION["rt_ThF4ng_Tin_S1EA3n_Ph1EA9m_$parm"];
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

		// Field GiaNhap
		$this->SetDefaultExtFilter($this->GiaNhap, "USER SELECT", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->GiaNhap);
		$sWrk = "";
		$this->BuildExtendedFilter($this->GiaNhap, $sWrk, TRUE);
		ewr_LoadSelectionFromFilter($this->GiaNhap, $sWrk, $this->GiaNhap->DefaultSelectionList);
		if (!$this->SearchCommand) $this->GiaNhap->SelectionList = $this->GiaNhap->DefaultSelectionList;

		// Field GiaBan
		$this->SetDefaultExtFilter($this->GiaBan, "USER SELECT", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->GiaBan);
		$sWrk = "";
		$this->BuildExtendedFilter($this->GiaBan, $sWrk, TRUE);
		ewr_LoadSelectionFromFilter($this->GiaBan, $sWrk, $this->GiaBan->DefaultSelectionList);
		if (!$this->SearchCommand) $this->GiaBan->SelectionList = $this->GiaBan->DefaultSelectionList;

		// Field SLTon
		$this->SetDefaultExtFilter($this->SLTon, "USER SELECT", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->SLTon);
		$sWrk = "";
		$this->BuildExtendedFilter($this->SLTon, $sWrk, TRUE);
		ewr_LoadSelectionFromFilter($this->SLTon, $sWrk, $this->SLTon->DefaultSelectionList);
		if (!$this->SearchCommand) $this->SLTon->SelectionList = $this->SLTon->DefaultSelectionList;

		// Field SoLuong
		$this->SetDefaultExtFilter($this->SoLuong, "USER SELECT", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->SoLuong);
		/**
		* Set up default values for popup filters
		*/

		// Field GiaNhap
		// $this->GiaNhap->DefaultSelectionList = array("val1", "val2");
		// Field GiaBan
		// $this->GiaBan->DefaultSelectionList = array("val1", "val2");
		// Field SLTon
		// $this->SLTon->DefaultSelectionList = array("val1", "val2");

	}

	// Check if filter applied
	function CheckFilter() {

		// Check GiaNhap text filter
		if ($this->TextFilterApplied($this->GiaNhap))
			return TRUE;

		// Check GiaNhap popup filter
		if (!ewr_MatchedArray($this->GiaNhap->DefaultSelectionList, $this->GiaNhap->SelectionList))
			return TRUE;

		// Check GiaBan text filter
		if ($this->TextFilterApplied($this->GiaBan))
			return TRUE;

		// Check GiaBan popup filter
		if (!ewr_MatchedArray($this->GiaBan->DefaultSelectionList, $this->GiaBan->SelectionList))
			return TRUE;

		// Check SLTon text filter
		if ($this->TextFilterApplied($this->SLTon))
			return TRUE;

		// Check SLTon popup filter
		if (!ewr_MatchedArray($this->SLTon->DefaultSelectionList, $this->SLTon->SelectionList))
			return TRUE;

		// Check SoLuong text filter
		if ($this->TextFilterApplied($this->SoLuong))
			return TRUE;
		return FALSE;
	}

	// Show list of filters
	function ShowFilterList($showDate = FALSE) {
		global $ReportLanguage;

		// Initialize
		$sFilterList = "";

		// Field GiaNhap
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($this->GiaNhap, $sExtWrk);
		if (is_array($this->GiaNhap->SelectionList))
			$sWrk = ewr_JoinArray($this->GiaNhap->SelectionList, ", ", EWR_DATATYPE_NUMBER, 0, $this->DBID);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->GiaNhap->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field GiaBan
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($this->GiaBan, $sExtWrk);
		if (is_array($this->GiaBan->SelectionList))
			$sWrk = ewr_JoinArray($this->GiaBan->SelectionList, ", ", EWR_DATATYPE_NUMBER, 0, $this->DBID);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->GiaBan->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field SLTon
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($this->SLTon, $sExtWrk);
		if (is_array($this->SLTon->SelectionList))
			$sWrk = ewr_JoinArray($this->SLTon->SelectionList, ", ", EWR_DATATYPE_NUMBER, 0, $this->DBID);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->SLTon->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field SoLuong
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($this->SoLuong, $sExtWrk);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->SoLuong->FldCaption() . "</span>" . $sFilter . "</div>";
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

		// Field GiaNhap
		$sWrk = "";
		if ($this->GiaNhap->SearchValue <> "" || $this->GiaNhap->SearchValue2 <> "") {
			$sWrk = "\"sv_GiaNhap\":\"" . ewr_JsEncode2($this->GiaNhap->SearchValue) . "\"," .
				"\"so_GiaNhap\":\"" . ewr_JsEncode2($this->GiaNhap->SearchOperator) . "\"," .
				"\"sc_GiaNhap\":\"" . ewr_JsEncode2($this->GiaNhap->SearchCondition) . "\"," .
				"\"sv2_GiaNhap\":\"" . ewr_JsEncode2($this->GiaNhap->SearchValue2) . "\"," .
				"\"so2_GiaNhap\":\"" . ewr_JsEncode2($this->GiaNhap->SearchOperator2) . "\"";
		}
		if ($sWrk == "") {
			$sWrk = ($this->GiaNhap->SelectionList <> EWR_INIT_VALUE) ? $this->GiaNhap->SelectionList : "";
			if (is_array($sWrk))
				$sWrk = implode("||", $sWrk);
			if ($sWrk <> "")
				$sWrk = "\"sel_GiaNhap\":\"" . ewr_JsEncode2($sWrk) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Field GiaBan
		$sWrk = "";
		if ($this->GiaBan->SearchValue <> "" || $this->GiaBan->SearchValue2 <> "") {
			$sWrk = "\"sv_GiaBan\":\"" . ewr_JsEncode2($this->GiaBan->SearchValue) . "\"," .
				"\"so_GiaBan\":\"" . ewr_JsEncode2($this->GiaBan->SearchOperator) . "\"," .
				"\"sc_GiaBan\":\"" . ewr_JsEncode2($this->GiaBan->SearchCondition) . "\"," .
				"\"sv2_GiaBan\":\"" . ewr_JsEncode2($this->GiaBan->SearchValue2) . "\"," .
				"\"so2_GiaBan\":\"" . ewr_JsEncode2($this->GiaBan->SearchOperator2) . "\"";
		}
		if ($sWrk == "") {
			$sWrk = ($this->GiaBan->SelectionList <> EWR_INIT_VALUE) ? $this->GiaBan->SelectionList : "";
			if (is_array($sWrk))
				$sWrk = implode("||", $sWrk);
			if ($sWrk <> "")
				$sWrk = "\"sel_GiaBan\":\"" . ewr_JsEncode2($sWrk) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Field SLTon
		$sWrk = "";
		if ($this->SLTon->SearchValue <> "" || $this->SLTon->SearchValue2 <> "") {
			$sWrk = "\"sv_SLTon\":\"" . ewr_JsEncode2($this->SLTon->SearchValue) . "\"," .
				"\"so_SLTon\":\"" . ewr_JsEncode2($this->SLTon->SearchOperator) . "\"," .
				"\"sc_SLTon\":\"" . ewr_JsEncode2($this->SLTon->SearchCondition) . "\"," .
				"\"sv2_SLTon\":\"" . ewr_JsEncode2($this->SLTon->SearchValue2) . "\"," .
				"\"so2_SLTon\":\"" . ewr_JsEncode2($this->SLTon->SearchOperator2) . "\"";
		}
		if ($sWrk == "") {
			$sWrk = ($this->SLTon->SelectionList <> EWR_INIT_VALUE) ? $this->SLTon->SelectionList : "";
			if (is_array($sWrk))
				$sWrk = implode("||", $sWrk);
			if ($sWrk <> "")
				$sWrk = "\"sel_SLTon\":\"" . ewr_JsEncode2($sWrk) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Field SoLuong
		$sWrk = "";
		if ($this->SoLuong->SearchValue <> "" || $this->SoLuong->SearchValue2 <> "") {
			$sWrk = "\"sv_SoLuong\":\"" . ewr_JsEncode2($this->SoLuong->SearchValue) . "\"," .
				"\"so_SoLuong\":\"" . ewr_JsEncode2($this->SoLuong->SearchOperator) . "\"," .
				"\"sc_SoLuong\":\"" . ewr_JsEncode2($this->SoLuong->SearchCondition) . "\"," .
				"\"sv2_SoLuong\":\"" . ewr_JsEncode2($this->SoLuong->SearchValue2) . "\"," .
				"\"so2_SoLuong\":\"" . ewr_JsEncode2($this->SoLuong->SearchOperator2) . "\"";
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

		// Field GiaNhap
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_GiaNhap", $filter) || array_key_exists("so_GiaNhap", $filter) ||
			array_key_exists("sc_GiaNhap", $filter) ||
			array_key_exists("sv2_GiaNhap", $filter) || array_key_exists("so2_GiaNhap", $filter)) {
			$this->SetSessionFilterValues(@$filter["sv_GiaNhap"], @$filter["so_GiaNhap"], @$filter["sc_GiaNhap"], @$filter["sv2_GiaNhap"], @$filter["so2_GiaNhap"], "GiaNhap");
			$bRestoreFilter = TRUE;
		}
		if (array_key_exists("sel_GiaNhap", $filter)) {
			$sWrk = $filter["sel_GiaNhap"];
			$sWrk = explode("||", $sWrk);
			$this->GiaNhap->SelectionList = $sWrk;
			$_SESSION["sel_ThF4ng_Tin_S1EA3n_Ph1EA9m_GiaNhap"] = $sWrk;
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "GiaNhap"); // Clear extended filter
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "GiaNhap");
			$this->GiaNhap->SelectionList = "";
			$_SESSION["sel_ThF4ng_Tin_S1EA3n_Ph1EA9m_GiaNhap"] = "";
		}

		// Field GiaBan
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_GiaBan", $filter) || array_key_exists("so_GiaBan", $filter) ||
			array_key_exists("sc_GiaBan", $filter) ||
			array_key_exists("sv2_GiaBan", $filter) || array_key_exists("so2_GiaBan", $filter)) {
			$this->SetSessionFilterValues(@$filter["sv_GiaBan"], @$filter["so_GiaBan"], @$filter["sc_GiaBan"], @$filter["sv2_GiaBan"], @$filter["so2_GiaBan"], "GiaBan");
			$bRestoreFilter = TRUE;
		}
		if (array_key_exists("sel_GiaBan", $filter)) {
			$sWrk = $filter["sel_GiaBan"];
			$sWrk = explode("||", $sWrk);
			$this->GiaBan->SelectionList = $sWrk;
			$_SESSION["sel_ThF4ng_Tin_S1EA3n_Ph1EA9m_GiaBan"] = $sWrk;
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "GiaBan"); // Clear extended filter
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "GiaBan");
			$this->GiaBan->SelectionList = "";
			$_SESSION["sel_ThF4ng_Tin_S1EA3n_Ph1EA9m_GiaBan"] = "";
		}

		// Field SLTon
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_SLTon", $filter) || array_key_exists("so_SLTon", $filter) ||
			array_key_exists("sc_SLTon", $filter) ||
			array_key_exists("sv2_SLTon", $filter) || array_key_exists("so2_SLTon", $filter)) {
			$this->SetSessionFilterValues(@$filter["sv_SLTon"], @$filter["so_SLTon"], @$filter["sc_SLTon"], @$filter["sv2_SLTon"], @$filter["so2_SLTon"], "SLTon");
			$bRestoreFilter = TRUE;
		}
		if (array_key_exists("sel_SLTon", $filter)) {
			$sWrk = $filter["sel_SLTon"];
			$sWrk = explode("||", $sWrk);
			$this->SLTon->SelectionList = $sWrk;
			$_SESSION["sel_ThF4ng_Tin_S1EA3n_Ph1EA9m_SLTon"] = $sWrk;
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "SLTon"); // Clear extended filter
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "SLTon");
			$this->SLTon->SelectionList = "";
			$_SESSION["sel_ThF4ng_Tin_S1EA3n_Ph1EA9m_SLTon"] = "";
		}

		// Field SoLuong
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_SoLuong", $filter) || array_key_exists("so_SoLuong", $filter) ||
			array_key_exists("sc_SoLuong", $filter) ||
			array_key_exists("sv2_SoLuong", $filter) || array_key_exists("so2_SoLuong", $filter)) {
			$this->SetSessionFilterValues(@$filter["sv_SoLuong"], @$filter["so_SoLuong"], @$filter["sc_SoLuong"], @$filter["sv2_SoLuong"], @$filter["so2_SoLuong"], "SoLuong");
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "SoLuong");
		}
		return TRUE;
	}

	// Return popup filter
	function GetPopupFilter() {
		$sWrk = "";
		if ($this->DrillDown)
			return "";
		if (!$this->ExtendedFilterExist($this->GiaNhap)) {
			if (is_array($this->GiaNhap->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->GiaNhap, "`GiaNhap`", EWR_DATATYPE_NUMBER, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->GiaNhap, $sFilter, "popup");
				$this->GiaNhap->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
		}
		if (!$this->ExtendedFilterExist($this->GiaBan)) {
			if (is_array($this->GiaBan->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->GiaBan, "`GiaBan`", EWR_DATATYPE_NUMBER, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->GiaBan, $sFilter, "popup");
				$this->GiaBan->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
		}
		if (!$this->ExtendedFilterExist($this->SLTon)) {
			if (is_array($this->SLTon->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->SLTon, "`SLTon`", EWR_DATATYPE_NUMBER, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->SLTon, $sFilter, "popup");
				$this->SLTon->CurrentFilter = $sFilter;
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
			$this->MaSP->setSort("");
			$this->TenSP->setSort("");
			$this->TenCT->setSort("");
			$this->NoiSX->setSort("");
			$this->DungTich->setSort("");
			$this->GiaNhap->setSort("");
			$this->GiaBan->setSort("");
			$this->SLTon->setSort("");
			$this->TenVietTat->setSort("");
			$this->TenLoaiSP->setSort("");
			$this->TenThuongHieu->setSort("");
			$this->SoLuong->setSort("");

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
if (!isset($ThF4ng_Tin_S1EA3n_Ph1EA9m_summary)) $ThF4ng_Tin_S1EA3n_Ph1EA9m_summary = new crThF4ng_Tin_S1EA3n_Ph1EA9m_summary();
if (isset($Page)) $OldPage = $Page;
$Page = &$ThF4ng_Tin_S1EA3n_Ph1EA9m_summary;

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
var ThF4ng_Tin_S1EA3n_Ph1EA9m_summary = new ewr_Page("ThF4ng_Tin_S1EA3n_Ph1EA9m_summary");

// Page properties
ThF4ng_Tin_S1EA3n_Ph1EA9m_summary.PageID = "summary"; // Page ID
var EWR_PAGE_ID = ThF4ng_Tin_S1EA3n_Ph1EA9m_summary.PageID;

// Extend page with Chart_Rendering function
ThF4ng_Tin_S1EA3n_Ph1EA9m_summary.Chart_Rendering = 
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }

// Extend page with Chart_Rendered function
ThF4ng_Tin_S1EA3n_Ph1EA9m_summary.Chart_Rendered = 
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }
</script>
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<script type="text/javascript">

// Form object
var CurrentForm = fThF4ng_Tin_S1EA3n_Ph1EA9msummary = new ewr_Form("fThF4ng_Tin_S1EA3n_Ph1EA9msummary");

// Validate method
fThF4ng_Tin_S1EA3n_Ph1EA9msummary.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	var elm = fobj.sv_GiaNhap;
	if (elm && !ewr_CheckInteger(elm.value)) {
		if (!this.OnError(elm, "<?php echo ewr_JsEncode2($Page->GiaNhap->FldErrMsg()) ?>"))
			return false;
	}
	var elm = fobj.sv_GiaBan;
	if (elm && !ewr_CheckInteger(elm.value)) {
		if (!this.OnError(elm, "<?php echo ewr_JsEncode2($Page->GiaBan->FldErrMsg()) ?>"))
			return false;
	}
	var elm = fobj.sv_SLTon;
	if (elm && !ewr_CheckInteger(elm.value)) {
		if (!this.OnError(elm, "<?php echo ewr_JsEncode2($Page->SLTon->FldErrMsg()) ?>"))
			return false;
	}
	var elm = fobj.sv_SoLuong;
	if (elm && !ewr_CheckInteger(elm.value)) {
		if (!this.OnError(elm, "<?php echo ewr_JsEncode2($Page->SoLuong->FldErrMsg()) ?>"))
			return false;
	}

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate method
fThF4ng_Tin_S1EA3n_Ph1EA9msummary.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }
<?php if (EWR_CLIENT_VALIDATE) { ?>
fThF4ng_Tin_S1EA3n_Ph1EA9msummary.ValidateRequired = true; // Uses JavaScript validation
<?php } else { ?>
fThF4ng_Tin_S1EA3n_Ph1EA9msummary.ValidateRequired = false; // No JavaScript validation
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
<form name="fThF4ng_Tin_S1EA3n_Ph1EA9msummary" id="fThF4ng_Tin_S1EA3n_Ph1EA9msummary" class="form-inline ewForm ewExtFilterForm" action="<?php echo ewr_CurrentPage() ?>">
<?php $SearchPanelClass = ($Page->Filter <> "") ? " in" : " in"; ?>
<div id="fThF4ng_Tin_S1EA3n_Ph1EA9msummary_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<div id="r_1" class="ewRow">
<div id="c_GiaNhap" class="ewCell form-group">
	<label for="sv_GiaNhap" class="ewSearchCaption ewLabel"><?php echo $Page->GiaNhap->FldCaption() ?></label>
	<span class="ewSearchOperator"><select name="so_GiaNhap" id="so_GiaNhap" class="form-control" onchange="ewrForms(this).SrchOprChanged(this);"><option value="="<?php if ($Page->GiaNhap->SearchOperator == "=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("EQUAL"); ?></option><option value="<>"<?php if ($Page->GiaNhap->SearchOperator == "<>") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<>"); ?></option><option value="<"<?php if ($Page->GiaNhap->SearchOperator == "<") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<"); ?></option><option value="<="<?php if ($Page->GiaNhap->SearchOperator == "<=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<="); ?></option><option value=">"<?php if ($Page->GiaNhap->SearchOperator == ">") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">"); ?></option><option value=">="<?php if ($Page->GiaNhap->SearchOperator == ">=") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">="); ?></option><option value="BETWEEN"<?php if ($Page->GiaNhap->SearchOperator == "BETWEEN") echo " selected" ?>><?php echo $ReportLanguage->Phrase("BETWEEN"); ?></option></select></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->GiaNhap->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="ThF4ng_Tin_S1EA3n_Ph1EA9m" data-field="x_GiaNhap" id="sv_GiaNhap" name="sv_GiaNhap" size="30" placeholder="<?php echo $Page->GiaNhap->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->GiaNhap->SearchValue) ?>"<?php echo $Page->GiaNhap->EditAttributes() ?>>
</span>
	<span class="ewSearchCond btw1_GiaNhap" style="display: none"><?php echo $ReportLanguage->Phrase("AND") ?></span>
	<span class="ewSearchField btw1_GiaNhap" style="display: none">
<?php ewr_PrependClass($Page->GiaNhap->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="ThF4ng_Tin_S1EA3n_Ph1EA9m" data-field="x_GiaNhap" id="sv2_GiaNhap" name="sv2_GiaNhap" size="30" placeholder="<?php echo $Page->GiaNhap->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->GiaNhap->SearchValue2) ?>"<?php echo $Page->GiaNhap->EditAttributes() ?>>
</span>
</div>
</div>
<div id="r_2" class="ewRow">
<div id="c_GiaBan" class="ewCell form-group">
	<label for="sv_GiaBan" class="ewSearchCaption ewLabel"><?php echo $Page->GiaBan->FldCaption() ?></label>
	<span class="ewSearchOperator"><select name="so_GiaBan" id="so_GiaBan" class="form-control" onchange="ewrForms(this).SrchOprChanged(this);"><option value="="<?php if ($Page->GiaBan->SearchOperator == "=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("EQUAL"); ?></option><option value="<>"<?php if ($Page->GiaBan->SearchOperator == "<>") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<>"); ?></option><option value="<"<?php if ($Page->GiaBan->SearchOperator == "<") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<"); ?></option><option value="<="<?php if ($Page->GiaBan->SearchOperator == "<=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<="); ?></option><option value=">"<?php if ($Page->GiaBan->SearchOperator == ">") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">"); ?></option><option value=">="<?php if ($Page->GiaBan->SearchOperator == ">=") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">="); ?></option><option value="BETWEEN"<?php if ($Page->GiaBan->SearchOperator == "BETWEEN") echo " selected" ?>><?php echo $ReportLanguage->Phrase("BETWEEN"); ?></option></select></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->GiaBan->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="ThF4ng_Tin_S1EA3n_Ph1EA9m" data-field="x_GiaBan" id="sv_GiaBan" name="sv_GiaBan" size="30" placeholder="<?php echo $Page->GiaBan->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->GiaBan->SearchValue) ?>"<?php echo $Page->GiaBan->EditAttributes() ?>>
</span>
	<span class="ewSearchCond btw1_GiaBan" style="display: none"><?php echo $ReportLanguage->Phrase("AND") ?></span>
	<span class="ewSearchField btw1_GiaBan" style="display: none">
<?php ewr_PrependClass($Page->GiaBan->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="ThF4ng_Tin_S1EA3n_Ph1EA9m" data-field="x_GiaBan" id="sv2_GiaBan" name="sv2_GiaBan" size="30" placeholder="<?php echo $Page->GiaBan->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->GiaBan->SearchValue2) ?>"<?php echo $Page->GiaBan->EditAttributes() ?>>
</span>
</div>
</div>
<div id="r_3" class="ewRow">
<div id="c_SLTon" class="ewCell form-group">
	<label for="sv_SLTon" class="ewSearchCaption ewLabel"><?php echo $Page->SLTon->FldCaption() ?></label>
	<span class="ewSearchOperator"><select name="so_SLTon" id="so_SLTon" class="form-control" onchange="ewrForms(this).SrchOprChanged(this);"><option value="="<?php if ($Page->SLTon->SearchOperator == "=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("EQUAL"); ?></option><option value="<>"<?php if ($Page->SLTon->SearchOperator == "<>") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<>"); ?></option><option value="<"<?php if ($Page->SLTon->SearchOperator == "<") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<"); ?></option><option value="<="<?php if ($Page->SLTon->SearchOperator == "<=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<="); ?></option><option value=">"<?php if ($Page->SLTon->SearchOperator == ">") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">"); ?></option><option value=">="<?php if ($Page->SLTon->SearchOperator == ">=") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">="); ?></option><option value="BETWEEN"<?php if ($Page->SLTon->SearchOperator == "BETWEEN") echo " selected" ?>><?php echo $ReportLanguage->Phrase("BETWEEN"); ?></option></select></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->SLTon->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="ThF4ng_Tin_S1EA3n_Ph1EA9m" data-field="x_SLTon" id="sv_SLTon" name="sv_SLTon" size="30" placeholder="<?php echo $Page->SLTon->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->SLTon->SearchValue) ?>"<?php echo $Page->SLTon->EditAttributes() ?>>
</span>
	<span class="ewSearchCond btw1_SLTon" style="display: none"><?php echo $ReportLanguage->Phrase("AND") ?></span>
	<span class="ewSearchField btw1_SLTon" style="display: none">
<?php ewr_PrependClass($Page->SLTon->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="ThF4ng_Tin_S1EA3n_Ph1EA9m" data-field="x_SLTon" id="sv2_SLTon" name="sv2_SLTon" size="30" placeholder="<?php echo $Page->SLTon->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->SLTon->SearchValue2) ?>"<?php echo $Page->SLTon->EditAttributes() ?>>
</span>
</div>
</div>
<div id="r_4" class="ewRow">
<div id="c_SoLuong" class="ewCell form-group">
	<label for="sv_SoLuong" class="ewSearchCaption ewLabel"><?php echo $Page->SoLuong->FldCaption() ?></label>
	<span class="ewSearchOperator"><select name="so_SoLuong" id="so_SoLuong" class="form-control" onchange="ewrForms(this).SrchOprChanged(this);"><option value="="<?php if ($Page->SoLuong->SearchOperator == "=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("EQUAL"); ?></option><option value="<>"<?php if ($Page->SoLuong->SearchOperator == "<>") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<>"); ?></option><option value="<"<?php if ($Page->SoLuong->SearchOperator == "<") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<"); ?></option><option value="<="<?php if ($Page->SoLuong->SearchOperator == "<=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<="); ?></option><option value=">"<?php if ($Page->SoLuong->SearchOperator == ">") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">"); ?></option><option value=">="<?php if ($Page->SoLuong->SearchOperator == ">=") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">="); ?></option><option value="IS NULL"<?php if ($Page->SoLuong->SearchOperator == "IS NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NULL"); ?></option><option value="IS NOT NULL"<?php if ($Page->SoLuong->SearchOperator == "IS NOT NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NOT NULL"); ?></option><option value="BETWEEN"<?php if ($Page->SoLuong->SearchOperator == "BETWEEN") echo " selected" ?>><?php echo $ReportLanguage->Phrase("BETWEEN"); ?></option></select></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->SoLuong->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="ThF4ng_Tin_S1EA3n_Ph1EA9m" data-field="x_SoLuong" id="sv_SoLuong" name="sv_SoLuong" size="30" placeholder="<?php echo $Page->SoLuong->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->SoLuong->SearchValue) ?>"<?php echo $Page->SoLuong->EditAttributes() ?>>
</span>
	<span class="ewSearchCond btw1_SoLuong" style="display: none"><?php echo $ReportLanguage->Phrase("AND") ?></span>
	<span class="ewSearchField btw1_SoLuong" style="display: none">
<?php ewr_PrependClass($Page->SoLuong->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="ThF4ng_Tin_S1EA3n_Ph1EA9m" data-field="x_SoLuong" id="sv2_SoLuong" name="sv2_SoLuong" size="30" placeholder="<?php echo $Page->SoLuong->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->SoLuong->SearchValue2) ?>"<?php echo $Page->SoLuong->EditAttributes() ?>>
</span>
</div>
</div>
<div class="ewRow"><input type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-primary" value="<?php echo $ReportLanguage->Phrase("Search") ?>">
<input type="reset" name="btnreset" id="btnreset" class="btn hide" value="<?php echo $ReportLanguage->Phrase("Reset") ?>"></div>
</div>
</form>
<script type="text/javascript">
fThF4ng_Tin_S1EA3n_Ph1EA9msummary.Init();
fThF4ng_Tin_S1EA3n_Ph1EA9msummary.FilterList = <?php echo $Page->GetFilterList() ?>;
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
<?php if ($Page->MaSP->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="MaSP"><div class="ThF4ng_Tin_S1EA3n_Ph1EA9m_MaSP"><span class="ewTableHeaderCaption"><?php echo $Page->MaSP->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="MaSP">
<?php if ($Page->SortUrl($Page->MaSP) == "") { ?>
		<div class="ewTableHeaderBtn ThF4ng_Tin_S1EA3n_Ph1EA9m_MaSP">
			<span class="ewTableHeaderCaption"><?php echo $Page->MaSP->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer ThF4ng_Tin_S1EA3n_Ph1EA9m_MaSP" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->MaSP) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->MaSP->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->MaSP->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->MaSP->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->TenSP->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="TenSP"><div class="ThF4ng_Tin_S1EA3n_Ph1EA9m_TenSP"><span class="ewTableHeaderCaption"><?php echo $Page->TenSP->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="TenSP">
<?php if ($Page->SortUrl($Page->TenSP) == "") { ?>
		<div class="ewTableHeaderBtn ThF4ng_Tin_S1EA3n_Ph1EA9m_TenSP">
			<span class="ewTableHeaderCaption"><?php echo $Page->TenSP->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer ThF4ng_Tin_S1EA3n_Ph1EA9m_TenSP" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->TenSP) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->TenSP->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->TenSP->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->TenSP->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->TenCT->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="TenCT"><div class="ThF4ng_Tin_S1EA3n_Ph1EA9m_TenCT"><span class="ewTableHeaderCaption"><?php echo $Page->TenCT->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="TenCT">
<?php if ($Page->SortUrl($Page->TenCT) == "") { ?>
		<div class="ewTableHeaderBtn ThF4ng_Tin_S1EA3n_Ph1EA9m_TenCT">
			<span class="ewTableHeaderCaption"><?php echo $Page->TenCT->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer ThF4ng_Tin_S1EA3n_Ph1EA9m_TenCT" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->TenCT) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->TenCT->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->TenCT->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->TenCT->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->NoiSX->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="NoiSX"><div class="ThF4ng_Tin_S1EA3n_Ph1EA9m_NoiSX"><span class="ewTableHeaderCaption"><?php echo $Page->NoiSX->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="NoiSX">
<?php if ($Page->SortUrl($Page->NoiSX) == "") { ?>
		<div class="ewTableHeaderBtn ThF4ng_Tin_S1EA3n_Ph1EA9m_NoiSX">
			<span class="ewTableHeaderCaption"><?php echo $Page->NoiSX->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer ThF4ng_Tin_S1EA3n_Ph1EA9m_NoiSX" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->NoiSX) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->NoiSX->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->NoiSX->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->NoiSX->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->DungTich->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="DungTich"><div class="ThF4ng_Tin_S1EA3n_Ph1EA9m_DungTich"><span class="ewTableHeaderCaption"><?php echo $Page->DungTich->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="DungTich">
<?php if ($Page->SortUrl($Page->DungTich) == "") { ?>
		<div class="ewTableHeaderBtn ThF4ng_Tin_S1EA3n_Ph1EA9m_DungTich">
			<span class="ewTableHeaderCaption"><?php echo $Page->DungTich->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer ThF4ng_Tin_S1EA3n_Ph1EA9m_DungTich" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->DungTich) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->DungTich->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->DungTich->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->DungTich->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->GiaNhap->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="GiaNhap"><div class="ThF4ng_Tin_S1EA3n_Ph1EA9m_GiaNhap"><span class="ewTableHeaderCaption"><?php echo $Page->GiaNhap->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="GiaNhap">
<?php if ($Page->SortUrl($Page->GiaNhap) == "") { ?>
		<div class="ewTableHeaderBtn ThF4ng_Tin_S1EA3n_Ph1EA9m_GiaNhap">
			<span class="ewTableHeaderCaption"><?php echo $Page->GiaNhap->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'ThF4ng_Tin_S1EA3n_Ph1EA9m_GiaNhap', true, '<?php echo $Page->GiaNhap->RangeFrom; ?>', '<?php echo $Page->GiaNhap->RangeTo; ?>');" id="x_GiaNhap<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer ThF4ng_Tin_S1EA3n_Ph1EA9m_GiaNhap" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->GiaNhap) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->GiaNhap->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->GiaNhap->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->GiaNhap->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'ThF4ng_Tin_S1EA3n_Ph1EA9m_GiaNhap', true, '<?php echo $Page->GiaNhap->RangeFrom; ?>', '<?php echo $Page->GiaNhap->RangeTo; ?>');" id="x_GiaNhap<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->GiaBan->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="GiaBan"><div class="ThF4ng_Tin_S1EA3n_Ph1EA9m_GiaBan"><span class="ewTableHeaderCaption"><?php echo $Page->GiaBan->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="GiaBan">
<?php if ($Page->SortUrl($Page->GiaBan) == "") { ?>
		<div class="ewTableHeaderBtn ThF4ng_Tin_S1EA3n_Ph1EA9m_GiaBan">
			<span class="ewTableHeaderCaption"><?php echo $Page->GiaBan->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'ThF4ng_Tin_S1EA3n_Ph1EA9m_GiaBan', true, '<?php echo $Page->GiaBan->RangeFrom; ?>', '<?php echo $Page->GiaBan->RangeTo; ?>');" id="x_GiaBan<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer ThF4ng_Tin_S1EA3n_Ph1EA9m_GiaBan" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->GiaBan) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->GiaBan->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->GiaBan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->GiaBan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'ThF4ng_Tin_S1EA3n_Ph1EA9m_GiaBan', true, '<?php echo $Page->GiaBan->RangeFrom; ?>', '<?php echo $Page->GiaBan->RangeTo; ?>');" id="x_GiaBan<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->SLTon->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="SLTon"><div class="ThF4ng_Tin_S1EA3n_Ph1EA9m_SLTon"><span class="ewTableHeaderCaption"><?php echo $Page->SLTon->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="SLTon">
<?php if ($Page->SortUrl($Page->SLTon) == "") { ?>
		<div class="ewTableHeaderBtn ThF4ng_Tin_S1EA3n_Ph1EA9m_SLTon">
			<span class="ewTableHeaderCaption"><?php echo $Page->SLTon->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'ThF4ng_Tin_S1EA3n_Ph1EA9m_SLTon', true, '<?php echo $Page->SLTon->RangeFrom; ?>', '<?php echo $Page->SLTon->RangeTo; ?>');" id="x_SLTon<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer ThF4ng_Tin_S1EA3n_Ph1EA9m_SLTon" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->SLTon) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->SLTon->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->SLTon->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->SLTon->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'ThF4ng_Tin_S1EA3n_Ph1EA9m_SLTon', true, '<?php echo $Page->SLTon->RangeFrom; ?>', '<?php echo $Page->SLTon->RangeTo; ?>');" id="x_SLTon<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->TenVietTat->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="TenVietTat"><div class="ThF4ng_Tin_S1EA3n_Ph1EA9m_TenVietTat"><span class="ewTableHeaderCaption"><?php echo $Page->TenVietTat->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="TenVietTat">
<?php if ($Page->SortUrl($Page->TenVietTat) == "") { ?>
		<div class="ewTableHeaderBtn ThF4ng_Tin_S1EA3n_Ph1EA9m_TenVietTat">
			<span class="ewTableHeaderCaption"><?php echo $Page->TenVietTat->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer ThF4ng_Tin_S1EA3n_Ph1EA9m_TenVietTat" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->TenVietTat) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->TenVietTat->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->TenVietTat->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->TenVietTat->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->TenLoaiSP->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="TenLoaiSP"><div class="ThF4ng_Tin_S1EA3n_Ph1EA9m_TenLoaiSP"><span class="ewTableHeaderCaption"><?php echo $Page->TenLoaiSP->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="TenLoaiSP">
<?php if ($Page->SortUrl($Page->TenLoaiSP) == "") { ?>
		<div class="ewTableHeaderBtn ThF4ng_Tin_S1EA3n_Ph1EA9m_TenLoaiSP">
			<span class="ewTableHeaderCaption"><?php echo $Page->TenLoaiSP->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer ThF4ng_Tin_S1EA3n_Ph1EA9m_TenLoaiSP" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->TenLoaiSP) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->TenLoaiSP->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->TenLoaiSP->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->TenLoaiSP->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->TenThuongHieu->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="TenThuongHieu"><div class="ThF4ng_Tin_S1EA3n_Ph1EA9m_TenThuongHieu"><span class="ewTableHeaderCaption"><?php echo $Page->TenThuongHieu->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="TenThuongHieu">
<?php if ($Page->SortUrl($Page->TenThuongHieu) == "") { ?>
		<div class="ewTableHeaderBtn ThF4ng_Tin_S1EA3n_Ph1EA9m_TenThuongHieu">
			<span class="ewTableHeaderCaption"><?php echo $Page->TenThuongHieu->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer ThF4ng_Tin_S1EA3n_Ph1EA9m_TenThuongHieu" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->TenThuongHieu) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->TenThuongHieu->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->TenThuongHieu->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->TenThuongHieu->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->SoLuong->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="SoLuong"><div class="ThF4ng_Tin_S1EA3n_Ph1EA9m_SoLuong"><span class="ewTableHeaderCaption"><?php echo $Page->SoLuong->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="SoLuong">
<?php if ($Page->SortUrl($Page->SoLuong) == "") { ?>
		<div class="ewTableHeaderBtn ThF4ng_Tin_S1EA3n_Ph1EA9m_SoLuong">
			<span class="ewTableHeaderCaption"><?php echo $Page->SoLuong->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer ThF4ng_Tin_S1EA3n_Ph1EA9m_SoLuong" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->SoLuong) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->SoLuong->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->SoLuong->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->SoLuong->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
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
<?php if ($Page->MaSP->Visible) { ?>
		<td data-field="MaSP"<?php echo $Page->MaSP->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_ThF4ng_Tin_S1EA3n_Ph1EA9m_MaSP"<?php echo $Page->MaSP->ViewAttributes() ?>><?php echo $Page->MaSP->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->TenSP->Visible) { ?>
		<td data-field="TenSP"<?php echo $Page->TenSP->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_ThF4ng_Tin_S1EA3n_Ph1EA9m_TenSP"<?php echo $Page->TenSP->ViewAttributes() ?>><?php echo $Page->TenSP->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->TenCT->Visible) { ?>
		<td data-field="TenCT"<?php echo $Page->TenCT->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_ThF4ng_Tin_S1EA3n_Ph1EA9m_TenCT"<?php echo $Page->TenCT->ViewAttributes() ?>><?php echo $Page->TenCT->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->NoiSX->Visible) { ?>
		<td data-field="NoiSX"<?php echo $Page->NoiSX->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_ThF4ng_Tin_S1EA3n_Ph1EA9m_NoiSX"<?php echo $Page->NoiSX->ViewAttributes() ?>><?php echo $Page->NoiSX->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->DungTich->Visible) { ?>
		<td data-field="DungTich"<?php echo $Page->DungTich->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_ThF4ng_Tin_S1EA3n_Ph1EA9m_DungTich"<?php echo $Page->DungTich->ViewAttributes() ?>><?php echo $Page->DungTich->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->GiaNhap->Visible) { ?>
		<td data-field="GiaNhap"<?php echo $Page->GiaNhap->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_ThF4ng_Tin_S1EA3n_Ph1EA9m_GiaNhap"<?php echo $Page->GiaNhap->ViewAttributes() ?>><?php echo $Page->GiaNhap->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->GiaBan->Visible) { ?>
		<td data-field="GiaBan"<?php echo $Page->GiaBan->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_ThF4ng_Tin_S1EA3n_Ph1EA9m_GiaBan"<?php echo $Page->GiaBan->ViewAttributes() ?>><?php echo $Page->GiaBan->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->SLTon->Visible) { ?>
		<td data-field="SLTon"<?php echo $Page->SLTon->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_ThF4ng_Tin_S1EA3n_Ph1EA9m_SLTon"<?php echo $Page->SLTon->ViewAttributes() ?>><?php echo $Page->SLTon->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->TenVietTat->Visible) { ?>
		<td data-field="TenVietTat"<?php echo $Page->TenVietTat->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_ThF4ng_Tin_S1EA3n_Ph1EA9m_TenVietTat"<?php echo $Page->TenVietTat->ViewAttributes() ?>><?php echo $Page->TenVietTat->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->TenLoaiSP->Visible) { ?>
		<td data-field="TenLoaiSP"<?php echo $Page->TenLoaiSP->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_ThF4ng_Tin_S1EA3n_Ph1EA9m_TenLoaiSP"<?php echo $Page->TenLoaiSP->ViewAttributes() ?>><?php echo $Page->TenLoaiSP->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->TenThuongHieu->Visible) { ?>
		<td data-field="TenThuongHieu"<?php echo $Page->TenThuongHieu->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_ThF4ng_Tin_S1EA3n_Ph1EA9m_TenThuongHieu"<?php echo $Page->TenThuongHieu->ViewAttributes() ?>><?php echo $Page->TenThuongHieu->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->SoLuong->Visible) { ?>
		<td data-field="SoLuong"<?php echo $Page->SoLuong->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_ThF4ng_Tin_S1EA3n_Ph1EA9m_SoLuong"<?php echo $Page->SoLuong->ViewAttributes() ?>><?php echo $Page->SoLuong->ListViewValue() ?></span></td>
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
	$Page->SoLuong->Count = $Page->GrandCnt[12];
	$Page->SoLuong->SumValue = $Page->GrandSmry[12]; // Load SUM
	$Page->ResetAttrs();
	$Page->RowType = EWR_ROWTYPE_TOTAL;
	$Page->RowTotalType = EWR_ROWTOTAL_GRAND;
	$Page->RowTotalSubType = EWR_ROWTOTAL_FOOTER;
	$Page->RowAttrs["class"] = "ewRptGrandSummary";
	$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes() ?>><td colspan="<?php echo ($Page->GrpColumnCount + $Page->DtlColumnCount) ?>"><?php echo $ReportLanguage->Phrase("RptGrandSummary") ?> <span class="ewDirLtr">(<?php echo ewr_FormatNumber($Page->TotCount,0,-2,-2,-2); ?><?php echo $ReportLanguage->Phrase("RptDtlRec") ?>)</span></td></tr>
	<tr<?php echo $Page->RowAttributes() ?>>
<?php if ($Page->MaSP->Visible) { ?>
		<td data-field="MaSP"<?php echo $Page->MaSP->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->TenSP->Visible) { ?>
		<td data-field="TenSP"<?php echo $Page->TenSP->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->TenCT->Visible) { ?>
		<td data-field="TenCT"<?php echo $Page->TenCT->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->NoiSX->Visible) { ?>
		<td data-field="NoiSX"<?php echo $Page->NoiSX->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->DungTich->Visible) { ?>
		<td data-field="DungTich"<?php echo $Page->DungTich->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->GiaNhap->Visible) { ?>
		<td data-field="GiaNhap"<?php echo $Page->GiaNhap->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->GiaBan->Visible) { ?>
		<td data-field="GiaBan"<?php echo $Page->GiaBan->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->SLTon->Visible) { ?>
		<td data-field="SLTon"<?php echo $Page->SLTon->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->TenVietTat->Visible) { ?>
		<td data-field="TenVietTat"<?php echo $Page->TenVietTat->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->TenLoaiSP->Visible) { ?>
		<td data-field="TenLoaiSP"<?php echo $Page->TenLoaiSP->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->TenThuongHieu->Visible) { ?>
		<td data-field="TenThuongHieu"<?php echo $Page->TenThuongHieu->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->SoLuong->Visible) { ?>
		<td data-field="SoLuong"<?php echo $Page->SoLuong->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptSum") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tpts_ThF4ng_Tin_S1EA3n_Ph1EA9m_SoLuong"<?php echo $Page->SoLuong->ViewAttributes() ?>><?php echo $Page->SoLuong->SumViewValue ?></span></td>
<?php } ?>
	</tr>
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
<?php include "ThF4ng_Tin_S1EA3n_Ph1EA9msmrypager.php" ?>
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
