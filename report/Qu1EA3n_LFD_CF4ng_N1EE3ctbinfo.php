<?php

// Global variable for table object
$Qu1EA3n_LFD_CF4ng_N1EE3 = NULL;

//
// Table class for Quản Lý Công Nợ
//
class crQu1EA3n_LFD_CF4ng_N1EE3 extends crTableCrosstab {
	var $MaNPP2;
	var $TenNPP;
	var $CongNo;
	var $TongTien;
	var $SoTien;
	var $NgayLap;
	var $YEAR__NgayLap;

	//
	// Table class constructor
	//
	function __construct() {
		global $ReportLanguage, $gsLanguage;
		$this->TableVar = 'Qu1EA3n_LFD_CF4ng_N1EE3';
		$this->TableName = 'Quản Lý Công Nợ';
		$this->TableType = 'REPORT';
		$this->DBID = 'DB';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0;

		// MaNPP2
		$this->MaNPP2 = new crField('Qu1EA3n_LFD_CF4ng_N1EE3', 'Quản Lý Công Nợ', 'x_MaNPP2', 'MaNPP2', '`MaNPP2`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->MaNPP2->Sortable = TRUE; // Allow sort
		$this->MaNPP2->GroupingFieldId = 1;
		$this->MaNPP2->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['MaNPP2'] = &$this->MaNPP2;
		$this->MaNPP2->DateFilter = "";
		$this->MaNPP2->SqlSelect = "";
		$this->MaNPP2->SqlOrderBy = "";

		// TenNPP
		$this->TenNPP = new crField('Qu1EA3n_LFD_CF4ng_N1EE3', 'Quản Lý Công Nợ', 'x_TenNPP', 'TenNPP', '`TenNPP`', 200, EWR_DATATYPE_STRING, -1);
		$this->TenNPP->Sortable = TRUE; // Allow sort
		$this->TenNPP->GroupingFieldId = 2;
		$this->fields['TenNPP'] = &$this->TenNPP;
		$this->TenNPP->DateFilter = "";
		$this->TenNPP->SqlSelect = "";
		$this->TenNPP->SqlOrderBy = "";

		// CongNo
		$this->CongNo = new crField('Qu1EA3n_LFD_CF4ng_N1EE3', 'Quản Lý Công Nợ', 'x_CongNo', 'CongNo', '`CongNo`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->CongNo->Sortable = TRUE; // Allow sort
		$this->CongNo->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['CongNo'] = &$this->CongNo;
		$this->CongNo->DateFilter = "";
		$this->CongNo->SqlSelect = "";
		$this->CongNo->SqlOrderBy = "";

		// TongTien
		$this->TongTien = new crField('Qu1EA3n_LFD_CF4ng_N1EE3', 'Quản Lý Công Nợ', 'x_TongTien', 'TongTien', '`TongTien`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->TongTien->Sortable = TRUE; // Allow sort
		$this->TongTien->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['TongTien'] = &$this->TongTien;
		$this->TongTien->DateFilter = "";
		$this->TongTien->SqlSelect = "";
		$this->TongTien->SqlOrderBy = "";

		// SoTien
		$this->SoTien = new crField('Qu1EA3n_LFD_CF4ng_N1EE3', 'Quản Lý Công Nợ', 'x_SoTien', 'SoTien', '`SoTien`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->SoTien->Sortable = TRUE; // Allow sort
		$this->SoTien->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['SoTien'] = &$this->SoTien;
		$this->SoTien->DateFilter = "";
		$this->SoTien->SqlSelect = "";
		$this->SoTien->SqlOrderBy = "";

		// NgayLap
		$this->NgayLap = new crField('Qu1EA3n_LFD_CF4ng_N1EE3', 'Quản Lý Công Nợ', 'x_NgayLap', 'NgayLap', '`NgayLap`', 133, EWR_DATATYPE_DATE, 0);
		$this->NgayLap->Sortable = TRUE; // Allow sort
		$this->NgayLap->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EWR_DATE_FORMAT"], $ReportLanguage->Phrase("IncorrectDate"));
		$this->fields['NgayLap'] = &$this->NgayLap;
		$this->NgayLap->DateFilter = "";
		$this->NgayLap->SqlSelect = "";
		$this->NgayLap->SqlOrderBy = "";

		// YEAR__NgayLap
		$this->YEAR__NgayLap = new crField('Qu1EA3n_LFD_CF4ng_N1EE3', 'Quản Lý Công Nợ', 'x_YEAR__NgayLap', 'YEAR__NgayLap', 'YEAR(`NgayLap`)', 3, EWR_DATATYPE_NUMBER, 0, FALSE);
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
		return ($this->ColumnDateType <> "") ? $this->ColumnDateType : "m";
	}

	function setColumnDateType($v) {
		$this->ColumnDateType = $v;
	}

	// Column captions
	var $ColumnCaptions = "";

	function getColumnCaptions() {
		global $ReportLanguage;
		return ($this->ColumnCaptions <> "") ? $this->ColumnCaptions : $ReportLanguage->Phrase("MonthJan") . "," . $ReportLanguage->Phrase("MonthFeb") . "," . $ReportLanguage->Phrase("MonthMar") . "," . $ReportLanguage->Phrase("MonthApr") . "," . $ReportLanguage->Phrase("MonthMay") . "," . $ReportLanguage->Phrase("MonthJun") . "," . $ReportLanguage->Phrase("MonthJul") . "," . $ReportLanguage->Phrase("MonthAug") . "," . $ReportLanguage->Phrase("MonthSep") . "," . $ReportLanguage->Phrase("MonthOct") . "," . $ReportLanguage->Phrase("MonthNov") . "," . $ReportLanguage->Phrase("MonthDec");
	}

	function setColumnCaptions($v) {
		$this->ColumnCaptions = $v;
	}

	// Column names
	var $ColumnNames = "";

	function getColumnNames() {
		return ($this->ColumnNames <> "") ? $this->ColumnNames : "MonthJan,MonthFeb,MonthMar,MonthApr,MonthMay,MonthJun,MonthJul,MonthAug,MonthSep,MonthOct,MonthNov,MonthDec";
	}

	function setColumnNames($v) {
		$this->ColumnNames = $v;
	}

	// Column values
	var $ColumnValues = "";

	function getColumnValues() {
		return ($this->ColumnValues <> "") ? $this->ColumnValues : "1,2,3,4,5,6,7,8,9,10,11,12";
	}

	function setColumnValues($v) {
		$this->ColumnValues = $v;
	}

	// From
	var $_SqlFrom = "";

	function getSqlFrom() {
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`viewcongno`";
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
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT `MaNPP2`, `TenNPP`, YEAR(`NgayLap`) AS `YEAR__NgayLap`, <DistinctColumnFields> FROM " . $this->getSqlFrom();
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
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "`MaNPP2`, `TenNPP`, YEAR(`NgayLap`)";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`MaNPP2` ASC, `TenNPP` ASC, YEAR(`NgayLap`)";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Crosstab Year
	var $_SqlCrosstabYear = "";

	function getSqlCrosstabYear() {
		return ($this->_SqlCrosstabYear <> "") ? $this->_SqlCrosstabYear : "SELECT DISTINCT YEAR(`NgayLap`) AS `YEAR__NgayLap` FROM `viewcongno` ORDER BY YEAR(`NgayLap`)";
	}

	function SqlCrosstabYear() { // For backward compatibility
		return $this->getSqlCrosstabYear();
	}

	function setSqlCrosstabYear($v) {
		$this->_SqlCrosstabYear = $v;
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
		$this->SummaryFields[0] = new crSummaryField('x_CongNo', 'CongNo', '`CongNo`', 'SUM');
		$this->SummaryFields[0]->SummaryCaption = $ReportLanguage->Phrase("RptSum");
		$this->SummaryFields[0]->SummaryVal = &ewr_InitArray($this->ColCount+1, NULL);
		$this->SummaryFields[0]->SummaryValCnt = &ewr_InitArray($this->ColCount+1, NULL);
		$this->SummaryFields[0]->SummaryCnt = &ewr_Init2DArray($this->ColCount+1, $nGrps+1, NULL);
		$this->SummaryFields[0]->SummarySmry = &ewr_Init2DArray($this->ColCount+1, $nGrps+1, NULL);
		$this->SummaryFields[0]->SummarySmryCnt = &ewr_Init2DArray($this->ColCount+1, $nGrps+1, NULL);
		$this->SummaryFields[0]->SummaryInitValue = 0;
		$this->SummaryFields[1] = new crSummaryField('x_TongTien', 'TongTien', '`TongTien`', 'SUM');
		$this->SummaryFields[1]->SummaryCaption = $ReportLanguage->Phrase("RptSum");
		$this->SummaryFields[1]->SummaryVal = &ewr_InitArray($this->ColCount+1, NULL);
		$this->SummaryFields[1]->SummaryValCnt = &ewr_InitArray($this->ColCount+1, NULL);
		$this->SummaryFields[1]->SummaryCnt = &ewr_Init2DArray($this->ColCount+1, $nGrps+1, NULL);
		$this->SummaryFields[1]->SummarySmry = &ewr_Init2DArray($this->ColCount+1, $nGrps+1, NULL);
		$this->SummaryFields[1]->SummarySmryCnt = &ewr_Init2DArray($this->ColCount+1, $nGrps+1, NULL);
		$this->SummaryFields[1]->SummaryInitValue = 0;
		$this->SummaryFields[2] = new crSummaryField('x_SoTien', 'SoTien', '`SoTien`', 'SUM');
		$this->SummaryFields[2]->SummaryCaption = $ReportLanguage->Phrase("RptSum");
		$this->SummaryFields[2]->SummaryVal = &ewr_InitArray($this->ColCount+1, NULL);
		$this->SummaryFields[2]->SummaryValCnt = &ewr_InitArray($this->ColCount+1, NULL);
		$this->SummaryFields[2]->SummaryCnt = &ewr_Init2DArray($this->ColCount+1, $nGrps+1, NULL);
		$this->SummaryFields[2]->SummarySmry = &ewr_Init2DArray($this->ColCount+1, $nGrps+1, NULL);
		$this->SummaryFields[2]->SummarySmryCnt = &ewr_Init2DArray($this->ColCount+1, $nGrps+1, NULL);
		$this->SummaryFields[2]->SummaryInitValue = 0;

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
		return ($this->_SqlFirstGroupField <> "") ? $this->_SqlFirstGroupField : "`MaNPP2`";
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
		return ($this->_SqlOrderByGroup <> "") ? $this->_SqlOrderByGroup : "`MaNPP2` ASC";
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
		return ($this->_SqlSelectAgg <> "") ? $this->_SqlSelectAgg : "SELECT YEAR(`NgayLap`) AS `YEAR__NgayLap`, <DistinctColumnFields> FROM " . $this->getSqlFrom();
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
		return ($this->_SqlGroupByAgg <> "") ? $this->_SqlGroupByAgg : "YEAR(`NgayLap`)";
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
