<?php

// Global variable for table object
$ThF4ng_Tin_S1EA3n_Ph1EA9m = NULL;

//
// Table class for Thông Tin Sản Phẩm
//
class crThF4ng_Tin_S1EA3n_Ph1EA9m extends crTableBase {
	var $ShowGroupHeaderAsRow = FALSE;
	var $ShowCompactSummaryFooter = TRUE;
	var $MaSP;
	var $TenSP;
	var $TenCT;
	var $NoiSX;
	var $DungTich;
	var $GiaNhap;
	var $GiaBan;
	var $SLTon;
	var $TenVietTat;
	var $TenLoaiSP;
	var $TenThuongHieu;
	var $SoLuong;

	//
	// Table class constructor
	//
	function __construct() {
		global $ReportLanguage, $gsLanguage;
		$this->TableVar = 'ThF4ng_Tin_S1EA3n_Ph1EA9m';
		$this->TableName = 'Thông Tin Sản Phẩm';
		$this->TableType = 'REPORT';
		$this->DBID = 'DB';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0;

		// MaSP
		$this->MaSP = new crField('ThF4ng_Tin_S1EA3n_Ph1EA9m', 'Thông Tin Sản Phẩm', 'x_MaSP', 'MaSP', '`MaSP`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->MaSP->Sortable = TRUE; // Allow sort
		$this->MaSP->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['MaSP'] = &$this->MaSP;
		$this->MaSP->DateFilter = "";
		$this->MaSP->SqlSelect = "";
		$this->MaSP->SqlOrderBy = "";

		// TenSP
		$this->TenSP = new crField('ThF4ng_Tin_S1EA3n_Ph1EA9m', 'Thông Tin Sản Phẩm', 'x_TenSP', 'TenSP', '`TenSP`', 200, EWR_DATATYPE_STRING, -1);
		$this->TenSP->Sortable = TRUE; // Allow sort
		$this->fields['TenSP'] = &$this->TenSP;
		$this->TenSP->DateFilter = "";
		$this->TenSP->SqlSelect = "";
		$this->TenSP->SqlOrderBy = "";

		// TenCT
		$this->TenCT = new crField('ThF4ng_Tin_S1EA3n_Ph1EA9m', 'Thông Tin Sản Phẩm', 'x_TenCT', 'TenCT', '`TenCT`', 200, EWR_DATATYPE_STRING, -1);
		$this->TenCT->Sortable = TRUE; // Allow sort
		$this->fields['TenCT'] = &$this->TenCT;
		$this->TenCT->DateFilter = "";
		$this->TenCT->SqlSelect = "";
		$this->TenCT->SqlOrderBy = "";

		// NoiSX
		$this->NoiSX = new crField('ThF4ng_Tin_S1EA3n_Ph1EA9m', 'Thông Tin Sản Phẩm', 'x_NoiSX', 'NoiSX', '`NoiSX`', 200, EWR_DATATYPE_STRING, -1);
		$this->NoiSX->Sortable = TRUE; // Allow sort
		$this->fields['NoiSX'] = &$this->NoiSX;
		$this->NoiSX->DateFilter = "";
		$this->NoiSX->SqlSelect = "";
		$this->NoiSX->SqlOrderBy = "";

		// DungTich
		$this->DungTich = new crField('ThF4ng_Tin_S1EA3n_Ph1EA9m', 'Thông Tin Sản Phẩm', 'x_DungTich', 'DungTich', '`DungTich`', 200, EWR_DATATYPE_STRING, -1);
		$this->DungTich->Sortable = TRUE; // Allow sort
		$this->fields['DungTich'] = &$this->DungTich;
		$this->DungTich->DateFilter = "";
		$this->DungTich->SqlSelect = "";
		$this->DungTich->SqlOrderBy = "";

		// GiaNhap
		$this->GiaNhap = new crField('ThF4ng_Tin_S1EA3n_Ph1EA9m', 'Thông Tin Sản Phẩm', 'x_GiaNhap', 'GiaNhap', '`GiaNhap`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->GiaNhap->Sortable = TRUE; // Allow sort
		$this->GiaNhap->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['GiaNhap'] = &$this->GiaNhap;
		$this->GiaNhap->DateFilter = "";
		$this->GiaNhap->SqlSelect = "SELECT DISTINCT `GiaNhap`, `GiaNhap` AS `DispFld` FROM " . $this->getSqlFrom();
		$this->GiaNhap->SqlOrderBy = "`GiaNhap`";

		// GiaBan
		$this->GiaBan = new crField('ThF4ng_Tin_S1EA3n_Ph1EA9m', 'Thông Tin Sản Phẩm', 'x_GiaBan', 'GiaBan', '`GiaBan`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->GiaBan->Sortable = TRUE; // Allow sort
		$this->GiaBan->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['GiaBan'] = &$this->GiaBan;
		$this->GiaBan->DateFilter = "";
		$this->GiaBan->SqlSelect = "SELECT DISTINCT `GiaBan`, `GiaBan` AS `DispFld` FROM " . $this->getSqlFrom();
		$this->GiaBan->SqlOrderBy = "`GiaBan`";

		// SLTon
		$this->SLTon = new crField('ThF4ng_Tin_S1EA3n_Ph1EA9m', 'Thông Tin Sản Phẩm', 'x_SLTon', 'SLTon', '`SLTon`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->SLTon->Sortable = TRUE; // Allow sort
		$this->SLTon->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['SLTon'] = &$this->SLTon;
		$this->SLTon->DateFilter = "";
		$this->SLTon->SqlSelect = "SELECT DISTINCT `SLTon`, `SLTon` AS `DispFld` FROM " . $this->getSqlFrom();
		$this->SLTon->SqlOrderBy = "`SLTon`";

		// TenVietTat
		$this->TenVietTat = new crField('ThF4ng_Tin_S1EA3n_Ph1EA9m', 'Thông Tin Sản Phẩm', 'x_TenVietTat', 'TenVietTat', '`TenVietTat`', 200, EWR_DATATYPE_STRING, -1);
		$this->TenVietTat->Sortable = TRUE; // Allow sort
		$this->fields['TenVietTat'] = &$this->TenVietTat;
		$this->TenVietTat->DateFilter = "";
		$this->TenVietTat->SqlSelect = "";
		$this->TenVietTat->SqlOrderBy = "";

		// TenLoaiSP
		$this->TenLoaiSP = new crField('ThF4ng_Tin_S1EA3n_Ph1EA9m', 'Thông Tin Sản Phẩm', 'x_TenLoaiSP', 'TenLoaiSP', '`TenLoaiSP`', 200, EWR_DATATYPE_STRING, -1);
		$this->TenLoaiSP->Sortable = TRUE; // Allow sort
		$this->fields['TenLoaiSP'] = &$this->TenLoaiSP;
		$this->TenLoaiSP->DateFilter = "";
		$this->TenLoaiSP->SqlSelect = "";
		$this->TenLoaiSP->SqlOrderBy = "";

		// TenThuongHieu
		$this->TenThuongHieu = new crField('ThF4ng_Tin_S1EA3n_Ph1EA9m', 'Thông Tin Sản Phẩm', 'x_TenThuongHieu', 'TenThuongHieu', '`TenThuongHieu`', 200, EWR_DATATYPE_STRING, -1);
		$this->TenThuongHieu->Sortable = TRUE; // Allow sort
		$this->fields['TenThuongHieu'] = &$this->TenThuongHieu;
		$this->TenThuongHieu->DateFilter = "";
		$this->TenThuongHieu->SqlSelect = "";
		$this->TenThuongHieu->SqlOrderBy = "";

		// SoLuong
		$this->SoLuong = new crField('ThF4ng_Tin_S1EA3n_Ph1EA9m', 'Thông Tin Sản Phẩm', 'x_SoLuong', 'SoLuong', '`SoLuong`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->SoLuong->Sortable = TRUE; // Allow sort
		$this->SoLuong->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['SoLuong'] = &$this->SoLuong;
		$this->SoLuong->DateFilter = "";
		$this->SoLuong->SqlSelect = "";
		$this->SoLuong->SqlOrderBy = "";
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`san_pham`";
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

	// Table Level Group SQL
	// First Group Field

	var $_SqlFirstGroupField = "";

	function getSqlFirstGroupField() {
		return ($this->_SqlFirstGroupField <> "") ? $this->_SqlFirstGroupField : "";
	}

	function SqlFirstGroupField() { // For backward compatibility
		return $this->getSqlFirstGroupField();
	}

	function setSqlFirstGroupField($v) {
		$this->_SqlFirstGroupField = $v;
	}

	// Select Group
	var $_SqlSelectGroup = "";

	function getSqlSelectGroup() {
		return ($this->_SqlSelectGroup <> "") ? $this->_SqlSelectGroup : "SELECT DISTINCT " . $this->getSqlFirstGroupField() . " FROM " . $this->getSqlFrom();
	}

	function SqlSelectGroup() { // For backward compatibility
		return $this->getSqlSelectGroup();
	}

	function setSqlSelectGroup($v) {
		$this->_SqlSelectGroup = $v;
	}

	// Order By Group
	var $_SqlOrderByGroup = "";

	function getSqlOrderByGroup() {
		return ($this->_SqlOrderByGroup <> "") ? $this->_SqlOrderByGroup : "";
	}

	function SqlOrderByGroup() { // For backward compatibility
		return $this->getSqlOrderByGroup();
	}

	function setSqlOrderByGroup($v) {
		$this->_SqlOrderByGroup = $v;
	}

	// Select Aggregate
	var $_SqlSelectAgg = "";

	function getSqlSelectAgg() {
		return ($this->_SqlSelectAgg <> "") ? $this->_SqlSelectAgg : "SELECT SUM(`SoLuong`) AS `sum_soluong` FROM " . $this->getSqlFrom();
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
