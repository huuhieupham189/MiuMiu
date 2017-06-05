<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start();
?>
<?php include_once "phprptinc/ewrcfg10.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "phprptinc/ewmysql.php") ?>
<?php include_once "phprptinc/ewrfn10.php" ?>
<?php include_once "phprptinc/ewrusrfn10.php" ?>
<?php
ewr_Header(FALSE);
$session = new crsession;
$session->Page_Main();

//
// Page class for session
//
class crsession {

	// Page ID
	var $PageID = "session";

	// Project ID
	var $ProjectID = "{705b20ae-0753-4f10-b61e-0599083300cb}";

	// Page object name
	var $PageObjName = "session";

	// Page name
	function PageName() {
		return ewr_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		return ewr_CurrentPage() . "?";
	}

	// Main
	// - Uncomment ** for database connectivity / Page_Loading / Page_Unloaded server event
	function Page_Main() {
		global $conn;
		$GLOBALS["Page"] = &$this;

		//**$conn = ewr_Connect();
		// Global Page Loading event (in userfn*.php)
		//**Page_Loading();

		if (ob_get_length())
			ob_end_clean();
		$time = time();
		$_SESSION["EWR_LAST_REFRESH_TIME"] = $time;
		echo ewr_Encrypt($time);

		// Global Page Unloaded event (in userfn*.php)
		//**Page_Unloaded();
		 // Close connection
		//**ewr_CloseConn();

	}
}
?>
