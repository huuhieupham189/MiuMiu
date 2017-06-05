<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start();
?>
<?php include_once "phprptinc/ewrcfg10.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "phprptinc/ewmysql.php") ?>
<?php include_once "phprptinc/ewrfn10.php" ?>
<?php include_once "phprptinc/ewrusrfn10.php" ?>
<?php include_once "Qu1EA3n_LFD_CF4ng_N1EE3ctbinfo.php" ?>
<?php

//
// Page class
//

$Qu1EA3n_LFD_CF4ng_N1EE3_crosstab = NULL; // Initialize page object first

class crQu1EA3n_LFD_CF4ng_N1EE3_crosstab extends crQu1EA3n_LFD_CF4ng_N1EE3 {

	// Page ID
	var $PageID = 'crosstab';

	// Project ID
	var $ProjectID = "{51aa5d8b-b6cb-4649-8aa4-db7e733e77ad}";

	// Page object name
	var $PageObjName = 'Qu1EA3n_LFD_CF4ng_N1EE3_crosstab';

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

		// Table object (Qu1EA3n_LFD_CF4ng_N1EE3)
		if (!isset($GLOBALS["Qu1EA3n_LFD_CF4ng_N1EE3"])) {
			$GLOBALS["Qu1EA3n_LFD_CF4ng_N1EE3"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["Qu1EA3n_LFD_CF4ng_N1EE3"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";

		// Page ID
		if (!defined("EWR_PAGE_ID"))
			define("EWR_PAGE_ID", 'crosstab', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EWR_TABLE_NAME"))
			define("EWR_TABLE_NAME", 'Quản Lý Công Nợ', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fQu1EA3n_LFD_CF4ng_N1EE3crosstab";

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
		$item->Visible = FALSE;
		$ReportTypes["excel"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormExcel") : "";

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToWord", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToWord", TRUE)) . "\" href=\"" . $this->ExportWordUrl . "\">" . $ReportLanguage->Phrase("ExportToWord") . "</a>";

		//$item->Visible = FALSE;
		$item->Visible = FALSE;
		$ReportTypes["word"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormWord") : "";

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDF", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDF", TRUE)) . "\" href=\"" . $this->ExportPdfUrl . "\">" . $ReportLanguage->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Uncomment codes below to show export to Pdf link
//		$item->Visible = FALSE;

		$ReportTypes["pdf"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormPdf") : "";

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = $this->PageUrl() . "export=email";
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" id=\"emf_Qu1EA3n_LFD_CF4ng_N1EE3\" href=\"javascript:void(0);\" onclick=\"ewr_EmailDialogShow({lnk:'emf_Qu1EA3n_LFD_CF4ng_N1EE3',hdr:ewLanguage.Phrase('ExportToEmail'),url:'$url',exportid:'$exportid',el:this});\">" . $ReportLanguage->Phrase("ExportToEmail") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fQu1EA3n_LFD_CF4ng_N1EE3crosstab\" href=\"#\">" . $ReportLanguage->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fQu1EA3n_LFD_CF4ng_N1EE3crosstab\" href=\"#\">" . $ReportLanguage->Phrase("DeleteFilter") . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-caption=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-toggle=\"button\" data-form=\"fQu1EA3n_LFD_CF4ng_N1EE3crosstab\">" . $ReportLanguage->Phrase("SearchBtn") . "</button>";
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
	var $GenerateOptions; // Generate report options

	// Paging variables
	var $RecIndex = 0; // Record index
	var $RecCount = 0; // Record count
	var $StartGrp = 0; // Start group
	var $StopGrp = 0; // Stop group
	var $TotalGrps = 0; // Total groups
	var $GrpCount = 0; // Group count
	var $DisplayGrps = 3; // Groups per page
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
	var $ColSpan;
	var $GrpIdx;

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

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Get sort
		$this->Sort = $this->GetSort($this->GenOptions);

		// Popup values and selections
		$this->YEAR__NgayLap->SelectionList = "";
		$this->YEAR__NgayLap->DefaultSelectionList = "";
		$this->YEAR__NgayLap->ValueList = "";

		// Load custom filters
		$this->Page_FilterLoad();

		// Set up popup filter
		$this->SetupPopup();

		// Handle Ajax popup
		$this->ProcessAjaxPopup();

		// Restore filter list
		$this->RestoreFilterList();

		// Extended filter
		$sExtendedFilter = "";

		// Add year filter
		if ($this->YEAR__NgayLap->SelectionList <> "") {
			if ($this->Filter <> "") $this->Filter .= " AND ";
			$this->Filter .= "YEAR(`NgayLap`) = " . $this->YEAR__NgayLap->SelectionList;
		}

		// Load columns to array
		$this->GetColumns();

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

		// Get total group count
		$sGrpSort = ewr_UpdateSortFields($this->getSqlOrderByGroup(), $this->Sort, 2); // Get grouping field only
		$sSql = ewr_BuildReportSql($this->getSqlSelectGroup(), $this->getSqlWhere(), $this->getSqlGroupBy(), "", $this->getSqlOrderByGroup(), $this->Filter, $sGrpSort);
		$this->TotalGrps = $this->GetGrpCnt($sSql);
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

		// Get total groups
		$rsgrp = $this->GetGrpRs($sSql, $this->StartGrp, $this->DisplayGrps);

		// Init detail recordset
		$rs = NULL;

		// Set up column attributes
		$this->NgayLap->ViewAttrs["style"] = "";
		$this->NgayLap->CellAttrs["style"] = "vertical-align: top;";
		$this->SetupFieldCount();
	}

	// Get column values
	function GetColumns() {
		global $ReportLanguage;
		$this->LoadColumnValues($this->Filter);

		// Reset summary values
		$this->ResetLevelSummary(0);

		// Get active columns
		if (!is_array($this->NgayLap->SelectionList)) {
			$this->ColSpan = $this->ColCount;
		} else {
			$this->ColSpan = 0;
			for ($i = 1; $i <= $this->ColCount; $i++) {
				$bSelected = FALSE;
				$cntsel = count($this->NgayLap->SelectionList);
				for ($j = 0; $j < $cntsel; $j++) {
					if (ewr_CompareValue($this->NgayLap->SelectionList[$j], $this->Col[$i]->Value, 3)) {
						$this->ColSpan++;
						$bSelected = TRUE;
						break;
					}
				}
				$this->Col[$i]->Visible = $bSelected;
			}
		}
	}

	// Get group count
	function GetGrpCnt($sql) {
		$conn = &$this->Connection();
		$rsgrpcnt = $conn->Execute($sql);
		$grpcnt = ($rsgrpcnt) ? $rsgrpcnt->RecordCount() : 0;
		if ($rsgrpcnt) $rsgrpcnt->Close();
		return $grpcnt;
	}

	// Get group recordset
	function GetGrpRs($wrksql, $start = -1, $grps = -1) {
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EWR_ERROR_FN"];
		$rswrk = $conn->SelectLimit($wrksql, $grps, $start - 1);
		$conn->raiseErrorFn = '';
		return $rswrk;
	}

	// Get group row values
	function GetGrpRow($opt) {
		global $rsgrp;
		if (!$rsgrp)
			return;
		if ($opt == 1) { // Get first group

	//		$rsgrp->MoveFirst(); // NOTE: no need to move position
			$this->MaNPP2->setDbValue(""); // Init first value
		} else { // Get next group
			$rsgrp->MoveNext();
		}
		if (!$rsgrp->EOF) {
			$this->MaNPP2->setDbValue($rsgrp->fields[0]);
		} else {
			$this->MaNPP2->setDbValue("");
		}
	}

	// Get row values
	function GetRow($opt) {
		global $rs;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row

	//		$rs->MoveFirst(); // NOTE: no need to move position
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			if ($opt <> 1)
				$this->MaNPP2->setDbValue($rs->fields('MaNPP2'));
			$this->TenNPP->setDbValue($rs->fields('TenNPP'));
			$cntbase = 3;
			$cnt = count($this->SummaryFields);
			for ($is = 0; $is < $cnt; $is++) {
				$smry = &$this->SummaryFields[$is];
				$cntval = count($smry->SummaryVal);
				for ($ix = 1; $ix < $cntval; $ix++) {
					if ($smry->SummaryType == "AVG") {
						$smry->SummaryVal[$ix] = $rs->fields[$ix*2+$cntbase-2];
						$smry->SummaryValCnt[$ix] = $rs->fields[$ix*2+$cntbase-1];
					} else {
						$smry->SummaryVal[$ix] = $rs->fields[$ix+$cntbase-1];
					}
				}
				$cntbase += ($smry->SummaryType == "AVG") ? 2*($cntval-1) : ($cntval-1);
			}
		} else {
			$this->MaNPP2->setDbValue("");
			$this->TenNPP->setDbValue("");
		}
	}

	// Check level break
	function ChkLvlBreak($lvl) {
		switch ($lvl) {
			case 1:
				return (is_null($this->MaNPP2->CurrentValue) && !is_null($this->MaNPP2->OldValue)) ||
					(!is_null($this->MaNPP2->CurrentValue) && is_null($this->MaNPP2->OldValue)) ||
					($this->MaNPP2->GroupValue() <> $this->MaNPP2->GroupOldValue());
			case 2:
				return (is_null($this->TenNPP->CurrentValue) && !is_null($this->TenNPP->OldValue)) ||
					(!is_null($this->TenNPP->CurrentValue) && is_null($this->TenNPP->OldValue)) ||
					($this->TenNPP->GroupValue() <> $this->TenNPP->GroupOldValue()) || $this->ChkLvlBreak(1); // Recurse upper level
		}
	}

	// Accummulate summary
	function AccumulateSummary() {
		$cnt = count($this->SummaryFields);
		for ($is = 0; $is < $cnt; $is++) {
			$smry = &$this->SummaryFields[$is];
			$cntx = count($smry->SummarySmry);
			for ($ix = 1; $ix < $cntx; $ix++) {
				$cnty = count($smry->SummarySmry[$ix]);
				for ($iy = 0; $iy < $cnty; $iy++) {
					$valwrk = $smry->SummaryVal[$ix];
					$smry->SummaryCnt[$ix][$iy]++;
					$smry->SummarySmry[$ix][$iy] = ewr_SummaryValue($smry->SummarySmry[$ix][$iy], $valwrk, $smry->SummaryType);
					if ($smry->SummaryType == "AVG") {
						$cntwrk = $smry->SummaryValCnt[$ix];
						$smry->SummarySmryCnt[$ix][$iy] += $cntwrk;
					}
				}
			}
		}
	}

	// Reset level summary
	function ResetLevelSummary($lvl) {

		// Clear summary values
		$cnt = count($this->SummaryFields);
		for ($is = 0; $is < $cnt; $is++) {
			$smry = &$this->SummaryFields[$is];
			$cntx = count($smry->SummarySmry);
			for ($ix = 1; $ix < $cntx; $ix++) {
				$cnty = count($smry->SummarySmry[$ix]);
				for ($iy = $lvl; $iy < $cnty; $iy++) {
					$smry->SummaryCnt[$ix][$iy] = 0;
					$smry->SummarySmry[$ix][$iy] = $smry->SummaryInitValue;
					if ($smry->SummaryType == "AVG") {
						$smry->SummarySmryCnt[$ix][$iy] = 0;
					}
				}
			}
		}

		// Reset record count
		$this->RecCount = 0;
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
				$_SESSION["sel_Qu1EA3n_LFD_CF4ng_N1EE3_YEAR__NgayLap"] = "";
				$this->ResetPager();
			}
		}

		// Load selection criteria to array
		// Process query string

		if (@$_GET["YEAR__NgayLap"] <> "") {
			$this->YEAR__NgayLap->setQueryStringValue($_GET["YEAR__NgayLap"]);
			if (is_numeric($this->YEAR__NgayLap->QueryStringValue)) {
				$_SESSION["sel_Qu1EA3n_LFD_CF4ng_N1EE3_YEAR__NgayLap"] = $this->YEAR__NgayLap->QueryStringValue;
				$this->ResetPager();
			}
		}
		$this->YEAR__NgayLap->SelectionList = @$_SESSION["sel_Qu1EA3n_LFD_CF4ng_N1EE3_YEAR__NgayLap"];

		// Get distinct year
		$rsyear = $conn->Execute($this->getSqlCrosstabYear());
		if ($rsyear) {
			while (!$rsyear->EOF) {
				if (!is_null($rsyear->fields[0]))
					$this->YEAR__NgayLap->ValueList[] = $rsyear->fields[0];
				$rsyear->MoveNext();
			}
			$rsyear->Close();
		}
		if (is_array($this->YEAR__NgayLap->ValueList)) {
			if (strval($this->YEAR__NgayLap->SelectionList) == "") {
				$this->YEAR__NgayLap->SelectionList = $this->YEAR__NgayLap->ValueList[0];
			}
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
					$this->DisplayGrps = 3; // Non-numeric, load default
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
				$this->DisplayGrps = 3; // Load default
			}
		}
	}

	// Render row
	function RenderRow() {
		global $Security, $ReportLanguage;
		$conn = &$this->Connection();

		// Set up summary values
		$colcnt = $this->ColCount;
		$this->SummaryCellAttrs = &ewr_InitArray($colcnt, NULL);
		$this->SummaryViewAttrs = &ewr_InitArray($colcnt, NULL);
		$this->SummaryLinkAttrs = &ewr_InitArray($colcnt, NULL);
		$this->SummaryCurrentValue = &ewr_InitArray($colcnt, NULL);
		$this->SummaryViewValue = &ewr_InitArray($colcnt, NULL);
		$cnt = count($this->SummaryFields);
		for ($is = 0; $is < $cnt; $is++) {
			$smry = &$this->SummaryFields[$is];
			$smry->SummaryViewAttrs = &ewr_InitArray($colcnt, NULL);
			$smry->SummaryLinkAttrs = &ewr_InitArray($colcnt, NULL);
			$smry->SummaryCurrentValue = &ewr_InitArray($colcnt, NULL);
			$smry->SummaryViewValue = &ewr_InitArray($colcnt, NULL);
		}
		if ($this->RowTotalType == EWR_ROWTOTAL_GRAND) { // Grand total

			// Aggregate SQL
			$sSql = ewr_BuildReportSql(str_replace("<DistinctColumnFields>", $this->DistinctColumnFields, $this->getSqlSelectAgg()), $this->getSqlWhere(), $this->getSqlGroupByAgg(), "", "", $this->Filter, "");
			$rsagg = $conn->Execute($sSql);
			if ($rsagg && !$rsagg->EOF) $rsagg->MoveFirst();
		}
		for ($i = 1; $i <= $this->ColCount; $i++) {
			if ($this->Col[$i]->Visible) {
				$cntbaseagg = 1;
				$cnt = count($this->SummaryFields);
				for ($is = 0; $is < $cnt; $is++) {
					$smry = &$this->SummaryFields[$is];
					if ($this->RowType == EWR_ROWTYPE_DETAIL) { // Detail row
						$thisval = $smry->SummaryVal[$i];
						if ($smry->SummaryType == "AVG")
							$thiscnt = $smry->SummaryValCnt[$i];
					} elseif ($this->RowTotalType == EWR_ROWTOTAL_GROUP) { // Group total
						$thisval = $smry->SummarySmry[$i][$this->RowGroupLevel];
						if ($smry->SummaryType == "AVG")
							$thiscnt = $smry->SummarySmryCnt[$i][$this->RowGroupLevel];
					} elseif ($this->RowTotalType == EWR_ROWTOTAL_PAGE) { // Page total
						$thisval = $smry->SummarySmry[$i][0];
						if ($smry->SummaryType == "AVG")
							$thiscnt = $smry->SummarySmryCnt[$i][0];
					} elseif ($this->RowTotalType == EWR_ROWTOTAL_GRAND) { // Grand total
						if ($smry->SummaryType == "AVG") {
							$thisval = ($rsagg && !$rsagg->EOF) ? $rsagg->fields[$i*2+$cntbaseagg-2] : 0;
							$thiscnt = ($rsagg && !$rsagg->EOF) ? $rsagg->fields[$i*2+$cntbaseagg-1] : 0;
							$cntbaseagg += $this->ColCount * 2;
						} else {
							$thisval = ($rsagg && !$rsagg->EOF) ? $rsagg->fields[$i+$cntbaseagg-1] : 0;
							$cntbaseagg += $this->ColCount;
						}
					}
					if ($smry->SummaryType == "AVG")
						$smry->SummaryCurrentValue[$i-1] = ($thiscnt > 0) ? $thisval / $thiscnt : 0;
					else
						$smry->SummaryCurrentValue[$i-1] = $thisval;
				}
			}
		}
		if ($this->RowTotalType == EWR_ROWTOTAL_GRAND) { // Grand total
			if ($rsagg) $rsagg->Close();
		}

		// Call Row_Rendering event
		$this->Row_Rendering();

		//
		// Render view codes
		//

		if ($this->RowType == EWR_ROWTYPE_TOTAL) { // Summary row

			// MaNPP2
			$this->MaNPP2->GroupViewValue = $this->MaNPP2->GroupOldValue();
			$this->MaNPP2->CellAttrs["class"] = ($this->RowGroupLevel == 1) ? "ewRptGrpSummary1" : "ewRptGrpField1";

			// TenNPP
			$this->TenNPP->GroupViewValue = $this->TenNPP->GroupOldValue();
			$this->TenNPP->CellAttrs["class"] = ($this->RowGroupLevel == 2) ? "ewRptGrpSummary2" : "ewRptGrpField2";

			// Set up summary values
			$smry = &$this->SummaryFields[0];
			$scvcnt = count($smry->SummaryCurrentValue);
			for ($i = 0; $i < $scvcnt; $i++) {
				$smry->SummaryViewValue[$i] = $smry->SummaryCurrentValue[$i];
				$smry->SummaryViewAttrs[$i]["style"] = "";
				$this->SummaryCellAttrs[$i]["class"] = ($this->RowTotalType == EWR_ROWTOTAL_GROUP) ? "ewRptGrpSummary" . $this->RowGroupLevel : "";
			}

			// Set up summary values
			$smry = &$this->SummaryFields[1];
			$scvcnt = count($smry->SummaryCurrentValue);
			for ($i = 0; $i < $scvcnt; $i++) {
				$smry->SummaryViewValue[$i] = $smry->SummaryCurrentValue[$i];
				$smry->SummaryViewAttrs[$i]["style"] = "";
				$this->SummaryCellAttrs[$i]["class"] = ($this->RowTotalType == EWR_ROWTOTAL_GROUP) ? "ewRptGrpSummary" . $this->RowGroupLevel : "";
			}

			// Set up summary values
			$smry = &$this->SummaryFields[2];
			$scvcnt = count($smry->SummaryCurrentValue);
			for ($i = 0; $i < $scvcnt; $i++) {
				$smry->SummaryViewValue[$i] = $smry->SummaryCurrentValue[$i];
				$smry->SummaryViewAttrs[$i]["style"] = "";
				$this->SummaryCellAttrs[$i]["class"] = ($this->RowTotalType == EWR_ROWTOTAL_GROUP) ? "ewRptGrpSummary" . $this->RowGroupLevel : "";
			}

			// MaNPP2
			$this->MaNPP2->HrefValue = "";

			// TenNPP
			$this->TenNPP->HrefValue = "";
		} else {

			// MaNPP2
			$this->MaNPP2->GroupViewValue = $this->MaNPP2->GroupValue();
			$this->MaNPP2->CellAttrs["class"] = "ewRptGrpField1";
			if ($this->MaNPP2->GroupValue() == $this->MaNPP2->GroupOldValue() && !$this->ChkLvlBreak(1))
				$this->MaNPP2->GroupViewValue = "&nbsp;";

			// TenNPP
			$this->TenNPP->GroupViewValue = $this->TenNPP->GroupValue();
			$this->TenNPP->CellAttrs["class"] = "ewRptGrpField2";
			if ($this->TenNPP->GroupValue() == $this->TenNPP->GroupOldValue() && !$this->ChkLvlBreak(2))
				$this->TenNPP->GroupViewValue = "&nbsp;";

			// Set up summary values
			$smry = &$this->SummaryFields[0];
			$scvcnt = count($smry->SummaryCurrentValue);
			for ($i = 0; $i < $scvcnt; $i++) {
				$smry->SummaryViewValue[$i] = $smry->SummaryCurrentValue[$i];
				$smry->SummaryViewAttrs[$i]["style"] = "";
				$this->SummaryCellAttrs[$i]["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			}

			// Set up summary values
			$smry = &$this->SummaryFields[1];
			$scvcnt = count($smry->SummaryCurrentValue);
			for ($i = 0; $i < $scvcnt; $i++) {
				$smry->SummaryViewValue[$i] = $smry->SummaryCurrentValue[$i];
				$smry->SummaryViewAttrs[$i]["style"] = "";
				$this->SummaryCellAttrs[$i]["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			}

			// Set up summary values
			$smry = &$this->SummaryFields[2];
			$scvcnt = count($smry->SummaryCurrentValue);
			for ($i = 0; $i < $scvcnt; $i++) {
				$smry->SummaryViewValue[$i] = $smry->SummaryCurrentValue[$i];
				$smry->SummaryViewAttrs[$i]["style"] = "";
				$this->SummaryCellAttrs[$i]["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			}

			// MaNPP2
			$this->MaNPP2->HrefValue = "";

			// TenNPP
			$this->TenNPP->HrefValue = "";
		}

		// Call Cell_Rendered event
		if ($this->RowType == EWR_ROWTYPE_TOTAL) { // Summary row

			// MaNPP2
			$this->CurrentIndex = 0; // Current index
			$CurrentValue = $this->MaNPP2->GroupOldValue();
			$ViewValue = &$this->MaNPP2->GroupViewValue;
			$ViewAttrs = &$this->MaNPP2->ViewAttrs;
			$CellAttrs = &$this->MaNPP2->CellAttrs;
			$HrefValue = &$this->MaNPP2->HrefValue;
			$LinkAttrs = &$this->MaNPP2->LinkAttrs;
			$this->Cell_Rendered($this->MaNPP2, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// TenNPP
			$this->CurrentIndex = 1; // Current index
			$CurrentValue = $this->TenNPP->GroupOldValue();
			$ViewValue = &$this->TenNPP->GroupViewValue;
			$ViewAttrs = &$this->TenNPP->ViewAttrs;
			$CellAttrs = &$this->TenNPP->CellAttrs;
			$HrefValue = &$this->TenNPP->HrefValue;
			$LinkAttrs = &$this->TenNPP->LinkAttrs;
			$this->Cell_Rendered($this->TenNPP, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
			for ($i = 0; $i < $scvcnt; $i++) {
				$this->CurrentIndex = $i;
				$cnt = count($this->SummaryFields);
				for ($is = 0; $is < $cnt; $is++) {
					$smry = &$this->SummaryFields[$is];
					$CurrentValue = $smry->SummaryCurrentValue[$i];
					$ViewValue = &$smry->SummaryViewValue[$i];
					$ViewAttrs = &$smry->SummaryViewAttrs[$i];
					$CellAttrs = &$this->SummaryCellAttrs[$i];
					$HrefValue = "";
					$LinkAttrs = &$smry->SummaryLinkAttrs[$i];
					$this->Cell_Rendered($smry, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
				}
			}
		} else {

			// MaNPP2
			$this->CurrentIndex = 0; // Group index
			$CurrentValue = $this->MaNPP2->GroupValue();
			$ViewValue = &$this->MaNPP2->GroupViewValue;
			$ViewAttrs = &$this->MaNPP2->ViewAttrs;
			$CellAttrs = &$this->MaNPP2->CellAttrs;
			$HrefValue = &$this->MaNPP2->HrefValue;
			$LinkAttrs = &$this->MaNPP2->LinkAttrs;
			$this->Cell_Rendered($this->MaNPP2, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// TenNPP
			$this->CurrentIndex = 1; // Group index
			$CurrentValue = $this->TenNPP->GroupValue();
			$ViewValue = &$this->TenNPP->GroupViewValue;
			$ViewAttrs = &$this->TenNPP->ViewAttrs;
			$CellAttrs = &$this->TenNPP->CellAttrs;
			$HrefValue = &$this->TenNPP->HrefValue;
			$LinkAttrs = &$this->TenNPP->LinkAttrs;
			$this->Cell_Rendered($this->TenNPP, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
			for ($i = 0; $i < $scvcnt; $i++) {
				$this->CurrentIndex = $i;
				$cnt = count($this->SummaryFields);
				for ($is = 0; $is < $cnt; $is++) {
					$smry = &$this->SummaryFields[$is];
					$CurrentValue = $smry->SummaryCurrentValue[$i];
					$ViewValue = &$smry->SummaryViewValue[$i];
					$ViewAttrs = &$smry->SummaryViewAttrs[$i];
					$CellAttrs = &$this->SummaryCellAttrs[$i];
					$HrefValue = "";
					$LinkAttrs = &$smry->SummaryLinkAttrs[$i];
					$this->Cell_Rendered($smry, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
				}
			}
		}

		// Call Row_Rendered event
		$this->Row_Rendered();
		$this->SetupFieldCount();
	}

	// Setup field count
	function SetupFieldCount() {
		$this->GrpColumnCount = 0;
		if ($this->MaNPP2->Visible) $this->GrpColumnCount += 1;
		if ($this->TenNPP->Visible) $this->GrpColumnCount += 1;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $ReportBreadcrumb;
		$ReportBreadcrumb = new crBreadcrumb();
		$url = substr(ewr_CurrentUrl(), strrpos(ewr_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$ReportBreadcrumb->Add("crosstab", $this->TableVar, $url, "", $this->TableVar, TRUE);
	}

	function SetupExportOptionsExt() {
		global $ReportLanguage, $ReportOptions;
		$ReportTypes = $ReportOptions["ReportTypes"];
		$ReportOptions["ReportTypes"] = $ReportTypes;
	}

	// Check if filter applied
	function CheckFilter() {

		// Year Filter
		if (@$_SESSION["sel_Qu1EA3n_LFD_CF4ng_N1EE3_YEAR__NgayLap"] <> "")
			return TRUE;
		return FALSE;
	}

	// Show list of filters
	function ShowFilterList($showDate = FALSE) {
		global $ReportLanguage;

		// Initialize
		$sFilterList = "";

		// Year Filter
		if (strval($this->YEAR__NgayLap->SelectionList) <> "") {
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $ReportLanguage->Phrase("Year") . "</span>";
			$sFilterList .= "<span class=\"ewFilterValue\">" . $this->YEAR__NgayLap->SelectionList . "</span></div>";
		}
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

		// Year Filter
		if (strval($this->YEAR__NgayLap->SelectionList) <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= "\"sel_YEAR__NgayLap\":\"" . ewr_JsEncode2($this->YEAR__NgayLap->SelectionList) . "\"";
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

		// Year Filter
		if (array_key_exists("sel_YEAR__NgayLap", $filter)) {
			$ar = $filter["sel_YEAR__NgayLap"];
			$this->YEAR__NgayLap->SelectionList = $ar;
			$_SESSION["sel_Qu1EA3n_LFD_CF4ng_N1EE3_YEAR__NgayLap"] = $ar;
		}
		return TRUE;
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
			$this->MaNPP2->setSort("");
			$this->TenNPP->setSort("");

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
if (!isset($Qu1EA3n_LFD_CF4ng_N1EE3_crosstab)) $Qu1EA3n_LFD_CF4ng_N1EE3_crosstab = new crQu1EA3n_LFD_CF4ng_N1EE3_crosstab();
if (isset($Page)) $OldPage = $Page;
$Page = &$Qu1EA3n_LFD_CF4ng_N1EE3_crosstab;

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
<script type="text/javascript">

// Create page object
var Qu1EA3n_LFD_CF4ng_N1EE3_crosstab = new ewr_Page("Qu1EA3n_LFD_CF4ng_N1EE3_crosstab");

// Page properties
Qu1EA3n_LFD_CF4ng_N1EE3_crosstab.PageID = "crosstab"; // Page ID
var EWR_PAGE_ID = Qu1EA3n_LFD_CF4ng_N1EE3_crosstab.PageID;

// Extend page with Chart_Rendering function
Qu1EA3n_LFD_CF4ng_N1EE3_crosstab.Chart_Rendering = 
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }

// Extend page with Chart_Rendered function
Qu1EA3n_LFD_CF4ng_N1EE3_crosstab.Chart_Rendered = 
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }
</script>
<?php if (!$Page->DrillDown) { ?>
<script type="text/javascript">

// Form object
var CurrentForm = fQu1EA3n_LFD_CF4ng_N1EE3crosstab = new ewr_Form("fQu1EA3n_LFD_CF4ng_N1EE3crosstab");

// Validate method
fQu1EA3n_LFD_CF4ng_N1EE3crosstab.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate method
fQu1EA3n_LFD_CF4ng_N1EE3crosstab.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }
<?php if (EWR_CLIENT_VALIDATE) { ?>
fQu1EA3n_LFD_CF4ng_N1EE3crosstab.ValidateRequired = true; // Uses JavaScript validation
<?php } else { ?>
fQu1EA3n_LFD_CF4ng_N1EE3crosstab.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Use Ajax
</script>
<?php } ?>
<?php if (!$Page->DrillDown) { ?>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$Page->DrillDown) { ?>
<?php } ?>
<!-- container (begin) -->
<div id="ewContainer" class="ewContainer">
<!-- top container (begin) -->
<div id="ewTop" class="ewTop">
<a id="top"></a>
<?php if (@$Page->GenOptions["showfilter"] == "1") { ?>
<?php $Page->ShowFilterList(TRUE) ?>
<?php } ?>
<!-- top slot -->
<div class="ewToolbar">
<?php if (!$Page->DrillDown || !$Page->DrillDownInPanel) { ?>
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
<?php if (!$Page->DrillDown) { ?>
<?php echo $ReportLanguage->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php $Page->ShowPageHeader(); ?>
<?php $Page->ShowMessage(); ?>
</div>
<!-- Top container (end) -->
	<!-- left container (begin) -->
	<div id="ewLeft" class="ewLeft">
	<!-- left slot -->
	</div>
	<!-- left container (end) -->
	<!-- center container (report) (begin) -->
	<div id="ewCenter" class="ewCenter">
	<!-- center slot -->
<!-- crosstab report starts -->
<div id="report_crosstab">
<?php if (!$Page->DrillDown) { ?>
<!-- Search form (begin) -->
<form name="fQu1EA3n_LFD_CF4ng_N1EE3crosstab" id="fQu1EA3n_LFD_CF4ng_N1EE3crosstab" class="form-inline ewForm ewExtFilterForm" action="<?php echo ewr_CurrentPage() ?>">
<?php $SearchPanelClass = ($Page->Filter <> "") ? " in" : " in"; ?>
<div id="fQu1EA3n_LFD_CF4ng_N1EE3crosstab_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<!-- Year selection -->
<div id="r_1" class="ewRow">
<div id="c_YEAR__NgayLap" class="ewCell form-group">
	<label for="YEAR__NgayLap" class="ewSearchCaption ewLabel"><?php echo $ReportLanguage->Phrase("Year"); ?></label>
	<span class="control-group ewSearchField">
	<select id="YEAR__NgayLap" class="form-control" name="YEAR__NgayLap" onchange="ewrForms['fQu1EA3n_LFD_CF4ng_N1EE3crosstab'].Submit();">
<?php

// Set up array
if (is_array($Page->YEAR__NgayLap->ValueList)) {
	$cntyr = count($Page->YEAR__NgayLap->ValueList);
	for ($yearIdx = 0; $yearIdx < $cntyr; $yearIdx++) {
		$yearValue = $Page->YEAR__NgayLap->ValueList[$yearIdx];
		$yearSelected = (strval($yearValue) == strval($Page->YEAR__NgayLap->SelectionList)) ? " selected" : "";
?>
	<option value="<?php echo $yearValue ?>"<?php echo $yearSelected ?>><?php echo $yearValue ?></option>
<?php
	}
}
?>
	</select>
	</span>
</div>
</div>
</div>
</form>
<script type="text/javascript">
fQu1EA3n_LFD_CF4ng_N1EE3crosstab.Init();
fQu1EA3n_LFD_CF4ng_N1EE3crosstab.FilterList = <?php echo $Page->GetFilterList() ?>;
</script>
<!-- Search form (end) -->
<?php } ?>
<?php

// Set the last group to display if not export all
if ($Page->ExportAll && $Page->Export <> "") {
	$Page->StopGrp = $Page->TotalGrps;
} else {
	$Page->StopGrp = $Page->StartGrp + $Page->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($Page->StopGrp) > intval($Page->TotalGrps)) {
	$Page->StopGrp = $Page->TotalGrps;
}

// Navigate
$Page->RecCount = 0;
$Page->RecIndex = 0;

// Get first row
if ($Page->TotalGrps > 0) {
	$Page->GetGrpRow(1);
	$Page->GrpCount = 1;
}
while ($rsgrp && !$rsgrp->EOF && $Page->GrpCount <= $Page->DisplayGrps || $Page->ShowHeader) {

	// Show header
	if ($Page->ShowHeader) {
?>
<?php if ($Page->GrpCount > 1) { ?>
</tbody>
</table>
</div>
<?php if (!($Page->DrillDown && $Page->TotalGrps > 0)) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php include "Qu1EA3n_LFD_CF4ng_N1EE3ctbpager.php" ?>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php echo $Page->PageBreakContent ?>
<?php } ?>
<?php if ($Page->Export == "word" || $Page->Export == "excel") { ?>
<div class="ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } else { ?>
<div class="panel panel-default ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } ?>
<!-- Report grid (begin) -->
<div class="<?php if (ewr_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="<?php echo $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($Page->GrpColumnCount > 0) { ?>
		<td class="ewRptColSummary" colspan="<?php echo $Page->GrpColumnCount ?>"><div><?php echo $Page->RenderSummaryCaptions() ?></div></td>
<?php } ?>
		<td class="ewRptColHeader" colspan="<?php echo @$Page->ColSpan ?>">
			<div class="ewTableHeaderBtn">
				<span class="ewTableHeaderCaption"><?php echo $Page->NgayLap->FldCaption() ?></span>
			</div>
		</td>
	</tr>
	<tr class="ewTableHeader">
<?php if ($Page->MaNPP2->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="MaNPP2">
		<div class="Qu1EA3n_LFD_CF4ng_N1EE3_MaNPP2"><span class="ewTableHeaderCaption"><?php echo $Page->MaNPP2->FldCaption() ?></span></div>
	</td>
<?php } else { ?>
	<td data-field="MaNPP2">
<?php if ($Page->SortUrl($Page->MaNPP2) == "") { ?>
		<div class="ewTableHeaderBtn Qu1EA3n_LFD_CF4ng_N1EE3_MaNPP2">
			<span class="ewTableHeaderCaption"><?php echo $Page->MaNPP2->FldCaption() ?></span>			
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer Qu1EA3n_LFD_CF4ng_N1EE3_MaNPP2" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->MaNPP2) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->MaNPP2->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->MaNPP2->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->MaNPP2->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->TenNPP->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="TenNPP">
		<div class="Qu1EA3n_LFD_CF4ng_N1EE3_TenNPP"><span class="ewTableHeaderCaption"><?php echo $Page->TenNPP->FldCaption() ?></span></div>
	</td>
<?php } else { ?>
	<td data-field="TenNPP">
<?php if ($Page->SortUrl($Page->TenNPP) == "") { ?>
		<div class="ewTableHeaderBtn Qu1EA3n_LFD_CF4ng_N1EE3_TenNPP">
			<span class="ewTableHeaderCaption"><?php echo $Page->TenNPP->FldCaption() ?></span>			
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer Qu1EA3n_LFD_CF4ng_N1EE3_TenNPP" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->TenNPP) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->TenNPP->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->TenNPP->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->TenNPP->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<!-- Dynamic columns begin -->
<?php
	$cntval = count($Page->Col);
	for ($iy = 1; $iy < $cntval; $iy++) {
		if ($Page->Col[$iy]->Visible) {
			$Page->SummaryCurrentValue[$iy-1] = $Page->Col[$iy]->Caption;
			$Page->SummaryViewValue[$iy-1] = ewr_FormatDateTime($Page->SummaryCurrentValue[$iy-1], 0);
?>
		<td class="ewTableHeader"<?php echo $Page->NgayLap->CellAttributes() ?>><div<?php echo $Page->NgayLap->ViewAttributes() ?>><?php echo $Page->SummaryViewValue[$iy-1]; ?></div></td>
<?php
		}
	}
?>
<!-- Dynamic columns end -->
	</tr>
</thead>
<tbody>
<?php
		if ($Page->TotalGrps == 0) break; // Show header only
		$Page->ShowHeader = FALSE;
	}

	// Build detail SQL
	$sWhere = ewr_DetailFilterSQL($Page->MaNPP2, $Page->getSqlFirstGroupField(), $Page->MaNPP2->GroupValue(), $Page->DBID);
	if ($Page->PageFirstGroupFilter <> "") $Page->PageFirstGroupFilter .= " OR ";
	$Page->PageFirstGroupFilter .= $sWhere;
	if ($Page->Filter != "")
		$sWhere = "($Page->Filter) AND ($sWhere)";
	$sSql = ewr_BuildReportSql(str_replace("<DistinctColumnFields>", $Page->DistinctColumnFields, $Page->getSqlSelect()), $Page->getSqlWhere(), $Page->getSqlGroupBy(), "", $Page->getSqlOrderBy(), $sWhere, $Page->Sort);
	$rs = $conn->Execute($sSql);
	$rsdtlcnt = ($rs) ? $rs->RecordCount() : 0;
	if ($rsdtlcnt > 0)
		$Page->GetRow(1);
	while ($rs && !$rs->EOF) {
		$Page->RecCount++;
		$Page->RecIndex++;

		// Render row
		$Page->ResetAttrs();
		$Page->RowType = EWR_ROWTYPE_DETAIL;
		$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes(); ?>>
<?php if ($Page->MaNPP2->Visible) { ?>
		<!-- MaNPP2 -->
		<td data-field="MaNPP2"<?php echo $Page->MaNPP2->CellAttributes(); ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_Qu1EA3n_LFD_CF4ng_N1EE3_MaNPP2"<?php echo $Page->MaNPP2->ViewAttributes() ?>><?php echo $Page->MaNPP2->GroupViewValue ?></span></td>
<?php } ?>
<?php if ($Page->TenNPP->Visible) { ?>
		<!-- TenNPP -->
		<td data-field="TenNPP"<?php echo $Page->TenNPP->CellAttributes(); ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_Qu1EA3n_LFD_CF4ng_N1EE3_TenNPP"<?php echo $Page->TenNPP->ViewAttributes() ?>><?php echo $Page->TenNPP->GroupViewValue ?></span></td>
<?php } ?>
<!-- Dynamic columns begin -->
<?php
		$cntcol = count($Page->SummaryViewValue);
		for ($iy = 1; $iy <= $cntcol; $iy++) {
			$bColShow = ($iy <= $Page->ColCount) ? $Page->Col[$iy]->Visible : TRUE;
			$sColDesc = ($iy <= $Page->ColCount) ? $Page->Col[$iy]->Caption : $ReportLanguage->Phrase("Summary");
			if ($bColShow) {
?>
		<!-- <?php echo $sColDesc; ?> -->
		<td<?php echo $Page->SummaryCellAttributes($iy-1) ?>><?php echo $Page->RenderSummaryFields($iy-1) ?></td>
<?php
			}
		}
?>
<!-- Dynamic columns end -->
	</tr>
<?php

		// Accumulate page summary
		$Page->AccumulateSummary();

		// Get next record
		$Page->GetRow(2);
?>
<?php
	} // End detail records loop
?>
<?php
	$Page->GetGrpRow(2);

	// Show header if page break
	if ($Page->Export <> "")
		$Page->ShowHeader = ($Page->ExportPageBreakCount == 0) ? FALSE : ($Page->GrpCount % $Page->ExportPageBreakCount == 0);

	// Page_Breaking server event
	if ($Page->ShowHeader)
		$Page->Page_Breaking($Page->ShowHeader, $Page->PageBreakContent);
	$Page->GrpCount++;

	// Handle EOF
	if (!$rsgrp || $rsgrp->EOF)
		$Page->ShowHeader = FALSE;
}
?>
<?php if ($Page->TotalGrps > 0) { ?>
</tbody>
<tfoot>
</tfoot>
<?php } elseif (!$Page->ShowHeader && FALSE) { // No header displayed ?>
<?php if ($Page->Export == "word" || $Page->Export == "excel") { ?>
<div class="ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } else { ?>
<div class="panel panel-default ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } ?>
<!-- Report grid (begin) -->
<div class="<?php if (ewr_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="<?php echo $Page->ReportTableClass ?>">
<?php } ?>
<?php if ($Page->TotalGrps > 0 || FALSE) { // Show footer ?>
</table>
</div>
<?php if (!($Page->DrillDown && $Page->TotalGrps > 0)) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php include "Qu1EA3n_LFD_CF4ng_N1EE3ctbpager.php" ?>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
</div>
<!-- Crosstab report ends -->
	</div>
	<!-- center container (report) (end) -->
	<!-- right container (begin) -->
	<div id="ewRight" class="ewRight">
	<!-- Right slot -->
	</div>
	<!-- right container (end) -->
<div class="clearfix"></div>
<!-- bottom container (begin) -->
<div id="ewBottom" class="ewBottom">
	<!-- Bottom slot -->
	</div>
<!-- Bottom container (end) -->
</div>
<!-- container (end) -->
<?php $Page->ShowPageFooter(); ?>
<?php if (EWR_DEBUG_ENABLED) echo ewr_DebugMsg(); ?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if (!$Page->DrillDown) { ?>
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
