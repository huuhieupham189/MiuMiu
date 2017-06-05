<?php

// Global variable for table object
$hoadon = NULL;

//
// Table class for hoadon
//
class crhoadon extends crTableBase {
	var $ShowGroupHeaderAsRow = FALSE;
	var $ShowCompactSummaryFooter = TRUE;
	var $MaHD;
	var $MaVC;
	var $MaTT;
	var $MaTK;
	var $NgayLap;
	var $TongTien;
	var $DiaChi;
	var $KhoangCach;
	var $TinhTrang;
	var $GhiChu;

	//
	// Table class constructor
	//
	function __construct() {
		global $ReportLanguage, $gsLanguage;
		$this->TableVar = 'hoadon';
		$this->TableName = 'hoadon';
		$this->TableType = 'TABLE';
		$this->DBID = 'DB';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0;

		// MaHD
		$this->MaHD = new crField('hoadon', 'hoadon', 'x_MaHD', 'MaHD', '`MaHD`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->MaHD->Sortable = TRUE; // Allow sort
		$this->MaHD->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['MaHD'] = &$this->MaHD;
		$this->MaHD->DateFilter = "";
		$this->MaHD->SqlSelect = "";
		$this->MaHD->SqlOrderBy = "";

		// MaVC
		$this->MaVC = new crField('hoadon', 'hoadon', 'x_MaVC', 'MaVC', '`MaVC`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->MaVC->Sortable = TRUE; // Allow sort
		$this->MaVC->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['MaVC'] = &$this->MaVC;
		$this->MaVC->DateFilter = "";
		$this->MaVC->SqlSelect = "";
		$this->MaVC->SqlOrderBy = "";

		// MaTT
		$this->MaTT = new crField('hoadon', 'hoadon', 'x_MaTT', 'MaTT', '`MaTT`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->MaTT->Sortable = TRUE; // Allow sort
		$this->MaTT->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['MaTT'] = &$this->MaTT;
		$this->MaTT->DateFilter = "";
		$this->MaTT->SqlSelect = "";
		$this->MaTT->SqlOrderBy = "";

		// MaTK
		$this->MaTK = new crField('hoadon', 'hoadon', 'x_MaTK', 'MaTK', '`MaTK`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->MaTK->Sortable = TRUE; // Allow sort
		$this->MaTK->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['MaTK'] = &$this->MaTK;
		$this->MaTK->DateFilter = "";
		$this->MaTK->SqlSelect = "";
		$this->MaTK->SqlOrderBy = "";

		// NgayLap
		$this->NgayLap = new crField('hoadon', 'hoadon', 'x_NgayLap', 'NgayLap', '`NgayLap`', 133, EWR_DATATYPE_DATE, 0);
		$this->NgayLap->Sortable = TRUE; // Allow sort
		$this->NgayLap->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EWR_DATE_FORMAT"], $ReportLanguage->Phrase("IncorrectDate"));
		$this->fields['NgayLap'] = &$this->NgayLap;
		$this->NgayLap->DateFilter = "";
		$this->NgayLap->SqlSelect = "";
		$this->NgayLap->SqlOrderBy = "";

		// TongTien
		$this->TongTien = new crField('hoadon', 'hoadon', 'x_TongTien', 'TongTien', '`TongTien`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->TongTien->Sortable = TRUE; // Allow sort
		$this->TongTien->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['TongTien'] = &$this->TongTien;
		$this->TongTien->DateFilter = "";
		$this->TongTien->SqlSelect = "";
		$this->TongTien->SqlOrderBy = "";

		// DiaChi
		$this->DiaChi = new crField('hoadon', 'hoadon', 'x_DiaChi', 'DiaChi', '`DiaChi`', 201, EWR_DATATYPE_MEMO, -1);
		$this->DiaChi->Sortable = TRUE; // Allow sort
		$this->fields['DiaChi'] = &$this->DiaChi;
		$this->DiaChi->DateFilter = "";
		$this->DiaChi->SqlSelect = "";
		$this->DiaChi->SqlOrderBy = "";

		// KhoangCach
		$this->KhoangCach = new crField('hoadon', 'hoadon', 'x_KhoangCach', 'KhoangCach', '`KhoangCach`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->KhoangCach->Sortable = TRUE; // Allow sort
		$this->KhoangCach->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['KhoangCach'] = &$this->KhoangCach;
		$this->KhoangCach->DateFilter = "";
		$this->KhoangCach->SqlSelect = "";
		$this->KhoangCach->SqlOrderBy = "";

		// TinhTrang
		$this->TinhTrang = new crField('hoadon', 'hoadon', 'x_TinhTrang', 'TinhTrang', '`TinhTrang`', 200, EWR_DATATYPE_STRING, -1);
		$this->TinhTrang->Sortable = TRUE; // Allow sort
		$this->fields['TinhTrang'] = &$this->TinhTrang;
		$this->TinhTrang->DateFilter = "";
		$this->TinhTrang->SqlSelect = "";
		$this->TinhTrang->SqlOrderBy = "";

		// GhiChu
		$this->GhiChu = new crField('hoadon', 'hoadon', 'x_GhiChu', 'GhiChu', '`GhiChu`', 201, EWR_DATATYPE_MEMO, -1);
		$this->GhiChu->Sortable = TRUE; // Allow sort
		$this->fields['GhiChu'] = &$this->GhiChu;
		$this->GhiChu->DateFilter = "";
		$this->GhiChu->SqlSelect = "";
		$this->GhiChu->SqlOrderBy = "";
	}

	// Set Field Visibility
	function SetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			if ($ofld->GroupingFieldId == 0)
				$this->setDetailOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			if ($ofld->GroupingFieldId == 0) $ofld->setSort("");
		}
	}

	// Get Sort SQL
	function SortSql() {
		$sDtlSortSql = $this->getDetailOrderBy(); // Get ORDER BY for detail fields from session
		$argrps = array();
		foreach ($this->fields as $fld) {
			if ($fld->getSort() <> "") {
				$fldsql = $fld->FldExpression;
				if ($fld->GroupingFieldId > 0) {
					if ($fld->FldGroupSql <> "")
						$argrps[$fld->GroupingFieldId] = str_replace("%s", $fldsql, $fld->FldGroupSql) . " " . $fld->getSort();
					else
						$argrps[$fld->GroupingFieldId] = $fldsql . " " . $fld->getSort();
				}
			}
		}
		$sSortSql = "";
		foreach ($argrps as $grp) {
			if ($sSortSql <> "") $sSortSql .= ", ";
			$sSortSql .= $grp;
		}
		if ($sDtlSortSql <> "") {
			if ($sSortSql <> "") $sSortSql .= ", ";
			$sSortSql .= $sDtlSortSql;
		}
		return $sSortSql;
	}

	// Table level SQL
	// From

	var $_SqlFrom = "";

	function getSqlFrom() {
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`hoadon`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}

	// Select
	var $_SqlSelect = "";

	function getSqlSelect() {
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}

	// Where
	var $_SqlWhere = "";

	function getSqlWhere() {
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}

	// Group By
	var $_SqlGroupBy = "";

	function getSqlGroupBy() {
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}

	// Having
	var $_SqlHaving = "";

	function getSqlHaving() {
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}

	// Order By
	var $_SqlOrderBy = "";

	function getSqlOrderBy() {
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Select Aggregate
	var $_SqlSelectAgg = "";

	function getSqlSelectAgg() {
		return ($this->_SqlSelectAgg <> "") ? $this->_SqlSelectAgg : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelectAgg() { // For backward compatibility
		return $this->getSqlSelectAgg();
	}

	function setSqlSelectAgg($v) {
		$this->_SqlSelectAgg = $v;
	}

	// Aggregate Prefix
	var $_SqlAggPfx = "";

	function getSqlAggPfx() {
		return ($this->_SqlAggPfx <> "") ? $this->_SqlAggPfx : "";
	}

	function SqlAggPfx() { // For backward compatibility
		return $this->getSqlAggPfx();
	}

	function setSqlAggPfx($v) {
		$this->_SqlAggPfx = $v;
	}

	// Aggregate Suffix
	var $_SqlAggSfx = "";

	function getSqlAggSfx() {
		return ($this->_SqlAggSfx <> "") ? $this->_SqlAggSfx : "";
	}

	function SqlAggSfx() { // For backward compatibility
		return $this->getSqlAggSfx();
	}

	function setSqlAggSfx($v) {
		$this->_SqlAggSfx = $v;
	}

	// Select Count
	var $_SqlSelectCount = "";

	function getSqlSelectCount() {
		return ($this->_SqlSelectCount <> "") ? $this->_SqlSelectCount : "SELECT COUNT(*) FROM " . $this->getSqlFrom();
	}

	function SqlSelectCount() { // For backward compatibility
		return $this->getSqlSelectCount();
	}

	function setSqlSelectCount($v) {
		$this->_SqlSelectCount = $v;
	}

	// Sort URL
	function SortUrl(&$fld) {
		return "";
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld) {
		global $gsLanguage;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld) {
		global $gsLanguage;
		switch ($fld->FldVar) {
		}
	}

	// Table level events
	// Page Selecting event
	function Page_Selecting(&$filter) {

		// Enter your code here
	}

	// Page Breaking event
	function Page_Breaking(&$break, &$content) {

		// Example:
		//$break = FALSE; // Skip page break, or
		//$content = "<div style=\"page-break-after:always;\">&nbsp;</div>"; // Modify page break content

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Cell Rendered event
	function Cell_Rendered(&$Field, $CurrentValue, &$ViewValue, &$ViewAttrs, &$CellAttrs, &$HrefValue, &$LinkAttrs) {

		//$ViewValue = "xxx";
		//$ViewAttrs["style"] = "xxx";

	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}

	// Load Filters event
	function Page_FilterLoad() {

		// Enter your code here
		// Example: Register/Unregister Custom Extended Filter
		//ewr_RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A', 'GetStartsWithAFilter'); // With function, or
		//ewr_RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A'); // No function, use Page_Filtering event
		//ewr_UnregisterFilter($this-><Field>, 'StartsWithA');

	}

	// Page Filter Validated event
	function Page_FilterValidated() {

		// Example:
		//$this->MyField1->SearchValue = "your search criteria"; // Search value

	}

	// Page Filtering event
	function Page_Filtering(&$fld, &$filter, $typ, $opr = "", $val = "", $cond = "", $opr2 = "", $val2 = "") {

		// Note: ALWAYS CHECK THE FILTER TYPE ($typ)! Example:
		//if ($typ == "dropdown" && $fld->FldName == "MyField") // Dropdown filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "extended" && $fld->FldName == "MyField") // Extended filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "popup" && $fld->FldName == "MyField") // Popup filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "custom" && $opr == "..." && $fld->FldName == "MyField") // Custom filter, $opr is the custom filter ID
		//	$filter = "..."; // Modify the filter

	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		// Enter your code here
	}
}
?>
