<?php

// Global variable for table object
$QL_Doanh_Thu = NULL;

//
// Table class for QL Doanh Thu
//
class crQL_Doanh_Thu extends crTableCrosstab {
	var $MaHD;
	var $NgayLap;
	var $TongTien;
	var $TinhTrang;
	var $TenTT;
	var $TenVC;
	var $MaTK;
	var $YEAR__NgayLap;

	//
	// Table class constructor
	//
	function __construct() {
		global $ReportLanguage, $gsLanguage;
		$this->TableVar = 'QL_Doanh_Thu';
		$this->TableName = 'QL Doanh Thu';
		$this->TableType = 'REPORT';
		$this->DBID = 'DB';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0;

		// MaHD
		$this->MaHD = new crField('QL_Doanh_Thu', 'QL Doanh Thu', 'x_MaHD', 'MaHD', '`MaHD`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->MaHD->Sortable = TRUE; // Allow sort
		$this->MaHD->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['MaHD'] = &$this->MaHD;
		$this->MaHD->DateFilter = "";
		$this->MaHD->SqlSelect = "";
		$this->MaHD->SqlOrderBy = "";
		$this->MaHD->DrillDownUrl = "cthdrpt.php?d=1&t=cthd&s=QL_Doanh_Thu&MaHD=f0";

		// NgayLap
		$this->NgayLap = new crField('QL_Doanh_Thu', 'QL Doanh Thu', 'x_NgayLap', 'NgayLap', '`NgayLap`', 133, EWR_DATATYPE_DATE, 0);
		$this->NgayLap->Sortable = TRUE; // Allow sort
		$this->NgayLap->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EWR_DATE_FORMAT"], $ReportLanguage->Phrase("IncorrectDate"));
		$this->fields['NgayLap'] = &$this->NgayLap;
		$this->NgayLap->DateFilter = "";
		$this->NgayLap->SqlSelect = "SELECT DISTINCT `NgayLap`, `NgayLap` AS `DispFld` FROM " . $this->getSqlFrom();
		$this->NgayLap->SqlOrderBy = "`NgayLap`";

		// TongTien
		$this->TongTien = new crField('QL_Doanh_Thu', 'QL Doanh Thu', 'x_TongTien', 'TongTien', '`TongTien`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->TongTien->Sortable = TRUE; // Allow sort
		$this->TongTien->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['TongTien'] = &$this->TongTien;
		$this->TongTien->DateFilter = "";
		$this->TongTien->SqlSelect = "";
		$this->TongTien->SqlOrderBy = "";

		// TinhTrang
		$this->TinhTrang = new crField('QL_Doanh_Thu', 'QL Doanh Thu', 'x_TinhTrang', 'TinhTrang', '`TinhTrang`', 200, EWR_DATATYPE_STRING, -1);
		$this->TinhTrang->Sortable = TRUE; // Allow sort
		$this->fields['TinhTrang'] = &$this->TinhTrang;
		$this->TinhTrang->DateFilter = "";
		$this->TinhTrang->SqlSelect = "";
		$this->TinhTrang->SqlOrderBy = "";

		// TenTT
		$this->TenTT = new crField('QL_Doanh_Thu', 'QL Doanh Thu', 'x_TenTT', 'TenTT', '`TenTT`', 200, EWR_DATATYPE_STRING, -1);
		$this->TenTT->Sortable = TRUE; // Allow sort
		$this->fields['TenTT'] = &$this->TenTT;
		$this->TenTT->DateFilter = "";
		$this->TenTT->SqlSelect = "";
		$this->TenTT->SqlOrderBy = "";

		// TenVC
		$this->TenVC = new crField('QL_Doanh_Thu', 'QL Doanh Thu', 'x_TenVC', 'TenVC', '`TenVC`', 200, EWR_DATATYPE_STRING, -1);
		$this->TenVC->Sortable = TRUE; // Allow sort
		$this->fields['TenVC'] = &$this->TenVC;
		$this->TenVC->DateFilter = "";
		$this->TenVC->SqlSelect = "";
		$this->TenVC->SqlOrderBy = "";

		// MaTK
		$this->MaTK = new crField('QL_Doanh_Thu', 'QL Doanh Thu', 'x_MaTK', 'MaTK', '`MaTK`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->MaTK->Sortable = TRUE; // Allow sort
		$this->MaTK->GroupingFieldId = 1;
		$this->MaTK->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['MaTK'] = &$this->MaTK;
		$this->MaTK->DateFilter = "";
		$this->MaTK->SqlSelect = "";
		$this->MaTK->SqlOrderBy = "";
		$this->MaTK->DrillDownUrl = "hoa_donrpt.php?d=1&t=hoa_don&s=QL_Doanh_Thu&MaTK=f0";

		// YEAR__NgayLap
		$this->YEAR__NgayLap = new crField('QL_Doanh_Thu', 'QL Doanh Thu', 'x_YEAR__NgayLap', 'YEAR__NgayLap', 'YEAR(`NgayLap`)', 3, EWR_DATATYPE_NUMBER, 0, FALSE);
		$this->fields['YEAR__NgayLap'] = &$this->YEAR__NgayLap;
		$this->YEAR__NgayLap->SqlSelect = "SELECT DISTINCT YEAR(`NgayLap`), YEAR(`NgayLap`) AS `DispFld` FROM " . $this->getSqlFrom();
		$this->YEAR__NgayLap->SqlOrderBy = "YEAR(`NgayLap`)";
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
	// Column field

	var $ColumnField = "";

	function getColumnField() {
		return ($this->ColumnField <> "") ? $this->ColumnField : "`NgayLap`";
	}

	function setColumnField($v) {
		$this->ColumnField = $v;
	}

	// Column date type
	var $ColumnDateType = "";

	function getColumnDateType() {
		return ($this->ColumnDateType <> "") ? $this->ColumnDateType : "q";
	}

	function setColumnDateType($v) {
		$this->ColumnDateType = $v;
	}

	// Column captions
	var $ColumnCaptions = "";

	function getColumnCaptions() {
		global $ReportLanguage;
		return ($this->ColumnCaptions <> "") ? $this->ColumnCaptions : $ReportLanguage->Phrase("Qtr1") . "," . $ReportLanguage->Phrase("Qtr2") . "," . $ReportLanguage->Phrase("Qtr3") . "," . $ReportLanguage->Phrase("Qtr4");
	}

	function setColumnCaptions($v) {
		$this->ColumnCaptions = $v;
	}

	// Column names
	var $ColumnNames = "";

	function getColumnNames() {
		return ($this->ColumnNames <> "") ? $this->ColumnNames : "Qtr1,Qtr2,Qtr3,Qtr4";
	}

	function setColumnNames($v) {
		$this->ColumnNames = $v;
	}

	// Column values
	var $ColumnValues = "";

	function getColumnValues() {
		return ($this->ColumnValues <> "") ? $this->ColumnValues : "1,2,3,4";
	}

	function setColumnValues($v) {
		$this->ColumnValues = $v;
	}

	// From
	var $_SqlFrom = "";

	function getSqlFrom() {
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`hoa_don`";
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
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT `MaTK`, YEAR(`NgayLap`) AS `YEAR__NgayLap`, <DistinctColumnFields> FROM " . $this->getSqlFrom();
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
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "`MaTK`, YEAR(`NgayLap`)";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`MaTK` ASC, YEAR(`NgayLap`)";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}
	var $ColCount;
	var $Col;
	var $DistinctColumnFields = "";

	// Load column values
	function LoadColumnValues($filter = "") {
		global $ReportLanguage;
		$conn = &$this->Connection();
		$arColumnCaptions = explode(",", $this->getColumnCaptions());
		$arColumnNames = explode(",", $this->getColumnNames());
		$arColumnValues = explode(",", $this->getColumnValues());

		// Get distinct column count
		$this->ColCount = count($arColumnNames);
		$this->Col = &ewr_Init2DArray($this->ColCount+1, 3, NULL);
		for ($colcnt = 1; $colcnt <= $this->ColCount; $colcnt++) {
			$this->Col[$colcnt] = new crCrosstabColumn($arColumnValues[$colcnt-1], $arColumnCaptions[$colcnt-1], TRUE);
		}

		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of distinct values

		$nGrps = 2;
		$this->SummaryFields[0] = new crSummaryField('x_TongTien', 'TongTien', '`TongTien`', 'SUM');
		$this->SummaryFields[0]->SummaryCaption = $ReportLanguage->Phrase("RptSum");
		$this->SummaryFields[0]->SummaryVal = &ewr_InitArray($this->ColCount+1, NULL);
		$this->SummaryFields[0]->SummaryValCnt = &ewr_InitArray($this->ColCount+1, NULL);
		$this->SummaryFields[0]->SummaryCnt = &ewr_Init2DArray($this->ColCount+1, $nGrps+1, NULL);
		$this->SummaryFields[0]->SummarySmry = &ewr_Init2DArray($this->ColCount+1, $nGrps+1, NULL);
		$this->SummaryFields[0]->SummarySmryCnt = &ewr_Init2DArray($this->ColCount+1, $nGrps+1, NULL);
		$this->SummaryFields[0]->SummaryInitValue = 0;
		$this->SummaryFields[1] = new crSummaryField('x_TinhTrang', 'TinhTrang', '`TinhTrang`', 'COUNT');
		$this->SummaryFields[1]->SummaryCaption = $ReportLanguage->Phrase("RptCnt");
		$this->SummaryFields[1]->SummaryVal = &ewr_InitArray($this->ColCount+1, NULL);
		$this->SummaryFields[1]->SummaryValCnt = &ewr_InitArray($this->ColCount+1, NULL);
		$this->SummaryFields[1]->SummaryCnt = &ewr_Init2DArray($this->ColCount+1, $nGrps+1, NULL);
		$this->SummaryFields[1]->SummarySmry = &ewr_Init2DArray($this->ColCount+1, $nGrps+1, NULL);
		$this->SummaryFields[1]->SummarySmryCnt = &ewr_Init2DArray($this->ColCount+1, $nGrps+1, NULL);
		$this->SummaryFields[1]->SummaryInitValue = 0;

		// Update crosstab sql
		$sSqlFlds = "";
		$cnt = count($this->SummaryFields);
		for ($is = 0; $is < $cnt; $is++) {
			$smry = &$this->SummaryFields[$is];
			for ($i = 0; $i < $this->ColCount; $i++) {
				$sFld = ewr_CrossTabField($smry->SummaryType, $smry->FldExpression,
					$this->getColumnField(), $this->getColumnDateType(), $arColumnValues[$i], "", $arColumnNames[$i] . $is, $this->DBID);
				if ($sSqlFlds <> "")
					$sSqlFlds .= ", ";
				$sSqlFlds .= $sFld;
			}
		}
		$this->DistinctColumnFields = $sSqlFlds;
	}

	// Table Level Group SQL
	// First Group Field

	var $_SqlFirstGroupField = "";

	function getSqlFirstGroupField() {
		return ($this->_SqlFirstGroupField <> "") ? $this->_SqlFirstGroupField : "`MaTK`";
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
		return ($this->_SqlOrderByGroup <> "") ? $this->_SqlOrderByGroup : "`MaTK` ASC";
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
		return ($this->_SqlSelectAgg <> "") ? $this->_SqlSelectAgg : "SELECT <DistinctColumnFields> FROM " . $this->getSqlFrom();
	}

	function SqlSelectAgg() { // For backward compatibility
		return $this->getSqlSelectAgg();
	}

	function setSqlSelectAgg($v) {
		$this->_SqlSelectAgg = $v;
	}

	// Group By Aggregate
	var $_SqlGroupByAgg = "";

	function getSqlGroupByAgg() {
		return ($this->_SqlGroupByAgg <> "") ? $this->_SqlGroupByAgg : "";
	}

	function SqlGroupByAgg() { // For backward compatibility
		return $this->getSqlGroupByAgg();
	}

	function setSqlGroupByAgg($v) {
		$this->_SqlGroupByAgg = $v;
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
