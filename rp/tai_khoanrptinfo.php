<?php

// Global variable for table object
$tai_khoan = NULL;

//
// Table class for tai_khoan
//
class crtai_khoan extends crTableBase {
	var $ShowGroupHeaderAsRow = FALSE;
	var $ShowCompactSummaryFooter = TRUE;
	var $MaTK;
	var $TenDangNhap;
	var $MatKhau;
	var $LoaiTK;
	var $_Email;
	var $HoTen;
	var $DiaChi;
	var $NgaySinh;
	var $SDT;
	var $CMND;
	var $DiemThuong;
	var $TenLoaiTK;
	var $ChietKhau;
	var $DiemChuan;
	var $GhiChu;

	//
	// Table class constructor
	//
	function __construct() {
		global $ReportLanguage, $gsLanguage;
		$this->TableVar = 'tai_khoan';
		$this->TableName = 'tai_khoan';
		$this->TableType = 'VIEW';
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0;

		// MaTK
		$this->MaTK = new crField('tai_khoan', 'tai_khoan', 'x_MaTK', 'MaTK', '`MaTK`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->MaTK->Sortable = TRUE; // Allow sort
		$this->MaTK->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['MaTK'] = &$this->MaTK;
		$this->MaTK->DateFilter = "";
		$this->MaTK->SqlSelect = "";
		$this->MaTK->SqlOrderBy = "";

		// TenDangNhap
		$this->TenDangNhap = new crField('tai_khoan', 'tai_khoan', 'x_TenDangNhap', 'TenDangNhap', '`TenDangNhap`', 200, EWR_DATATYPE_STRING, -1);
		$this->TenDangNhap->Sortable = TRUE; // Allow sort
		$this->fields['TenDangNhap'] = &$this->TenDangNhap;
		$this->TenDangNhap->DateFilter = "";
		$this->TenDangNhap->SqlSelect = "";
		$this->TenDangNhap->SqlOrderBy = "";

		// MatKhau
		$this->MatKhau = new crField('tai_khoan', 'tai_khoan', 'x_MatKhau', 'MatKhau', '`MatKhau`', 200, EWR_DATATYPE_STRING, -1);
		$this->MatKhau->Sortable = TRUE; // Allow sort
		$this->fields['MatKhau'] = &$this->MatKhau;
		$this->MatKhau->DateFilter = "";
		$this->MatKhau->SqlSelect = "";
		$this->MatKhau->SqlOrderBy = "";

		// LoaiTK
		$this->LoaiTK = new crField('tai_khoan', 'tai_khoan', 'x_LoaiTK', 'LoaiTK', '`LoaiTK`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->LoaiTK->Sortable = TRUE; // Allow sort
		$this->LoaiTK->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['LoaiTK'] = &$this->LoaiTK;
		$this->LoaiTK->DateFilter = "";
		$this->LoaiTK->SqlSelect = "";
		$this->LoaiTK->SqlOrderBy = "";

		// Email
		$this->_Email = new crField('tai_khoan', 'tai_khoan', 'x__Email', 'Email', '`Email`', 200, EWR_DATATYPE_STRING, -1);
		$this->_Email->Sortable = TRUE; // Allow sort
		$this->fields['Email'] = &$this->_Email;
		$this->_Email->DateFilter = "";
		$this->_Email->SqlSelect = "";
		$this->_Email->SqlOrderBy = "";

		// HoTen
		$this->HoTen = new crField('tai_khoan', 'tai_khoan', 'x_HoTen', 'HoTen', '`HoTen`', 200, EWR_DATATYPE_STRING, -1);
		$this->HoTen->Sortable = TRUE; // Allow sort
		$this->fields['HoTen'] = &$this->HoTen;
		$this->HoTen->DateFilter = "";
		$this->HoTen->SqlSelect = "";
		$this->HoTen->SqlOrderBy = "";

		// DiaChi
		$this->DiaChi = new crField('tai_khoan', 'tai_khoan', 'x_DiaChi', 'DiaChi', '`DiaChi`', 200, EWR_DATATYPE_STRING, -1);
		$this->DiaChi->Sortable = TRUE; // Allow sort
		$this->fields['DiaChi'] = &$this->DiaChi;
		$this->DiaChi->DateFilter = "";
		$this->DiaChi->SqlSelect = "";
		$this->DiaChi->SqlOrderBy = "";

		// NgaySinh
		$this->NgaySinh = new crField('tai_khoan', 'tai_khoan', 'x_NgaySinh', 'NgaySinh', '`NgaySinh`', 133, EWR_DATATYPE_DATE, 0);
		$this->NgaySinh->Sortable = TRUE; // Allow sort
		$this->NgaySinh->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EWR_DATE_FORMAT"], $ReportLanguage->Phrase("IncorrectDate"));
		$this->fields['NgaySinh'] = &$this->NgaySinh;
		$this->NgaySinh->DateFilter = "";
		$this->NgaySinh->SqlSelect = "";
		$this->NgaySinh->SqlOrderBy = "";

		// SDT
		$this->SDT = new crField('tai_khoan', 'tai_khoan', 'x_SDT', 'SDT', '`SDT`', 200, EWR_DATATYPE_STRING, -1);
		$this->SDT->Sortable = TRUE; // Allow sort
		$this->fields['SDT'] = &$this->SDT;
		$this->SDT->DateFilter = "";
		$this->SDT->SqlSelect = "";
		$this->SDT->SqlOrderBy = "";

		// CMND
		$this->CMND = new crField('tai_khoan', 'tai_khoan', 'x_CMND', 'CMND', '`CMND`', 200, EWR_DATATYPE_STRING, -1);
		$this->CMND->Sortable = TRUE; // Allow sort
		$this->fields['CMND'] = &$this->CMND;
		$this->CMND->DateFilter = "";
		$this->CMND->SqlSelect = "";
		$this->CMND->SqlOrderBy = "";

		// DiemThuong
		$this->DiemThuong = new crField('tai_khoan', 'tai_khoan', 'x_DiemThuong', 'DiemThuong', '`DiemThuong`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->DiemThuong->Sortable = TRUE; // Allow sort
		$this->DiemThuong->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['DiemThuong'] = &$this->DiemThuong;
		$this->DiemThuong->DateFilter = "";
		$this->DiemThuong->SqlSelect = "";
		$this->DiemThuong->SqlOrderBy = "";

		// TenLoaiTK
		$this->TenLoaiTK = new crField('tai_khoan', 'tai_khoan', 'x_TenLoaiTK', 'TenLoaiTK', '`TenLoaiTK`', 200, EWR_DATATYPE_STRING, -1);
		$this->TenLoaiTK->Sortable = TRUE; // Allow sort
		$this->fields['TenLoaiTK'] = &$this->TenLoaiTK;
		$this->TenLoaiTK->DateFilter = "";
		$this->TenLoaiTK->SqlSelect = "";
		$this->TenLoaiTK->SqlOrderBy = "";

		// ChietKhau
		$this->ChietKhau = new crField('tai_khoan', 'tai_khoan', 'x_ChietKhau', 'ChietKhau', '`ChietKhau`', 4, EWR_DATATYPE_NUMBER, -1);
		$this->ChietKhau->Sortable = TRUE; // Allow sort
		$this->ChietKhau->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['ChietKhau'] = &$this->ChietKhau;
		$this->ChietKhau->DateFilter = "";
		$this->ChietKhau->SqlSelect = "";
		$this->ChietKhau->SqlOrderBy = "";

		// DiemChuan
		$this->DiemChuan = new crField('tai_khoan', 'tai_khoan', 'x_DiemChuan', 'DiemChuan', '`DiemChuan`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->DiemChuan->Sortable = TRUE; // Allow sort
		$this->DiemChuan->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['DiemChuan'] = &$this->DiemChuan;
		$this->DiemChuan->DateFilter = "";
		$this->DiemChuan->SqlSelect = "";
		$this->DiemChuan->SqlOrderBy = "";

		// GhiChu
		$this->GhiChu = new crField('tai_khoan', 'tai_khoan', 'x_GhiChu', 'GhiChu', '`GhiChu`', 201, EWR_DATATYPE_MEMO, -1);
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`tai_khoan`";
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
