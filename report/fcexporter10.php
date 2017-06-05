<?php

// FusionCharts 3.4+ exporter for PHP Report Maker 8+
// (C) 2007-2014 e.World Technology Limited

include_once "phprptinc/ewrcfg10.php";
include_once "phprptinc/ewrfn10.php";
$CheckTokenFn = "ewr_CheckToken";

// Send 500 server error
function ServerError($msg) {
	header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', TRUE, 500);
	die($msg);
}

// Valid Post
function ValidPost() {
	global $CheckTokenFn;
	if (!EWR_CHECK_TOKEN || !ewr_IsHttpPost())
		return TRUE;
	if (!isset($_POST[EWR_TOKEN_NAME]))
		return FALSE;
	if (is_callable($CheckTokenFn))
		return $CheckTokenFn($_POST[EWR_TOKEN_NAME]);
	return FALSE;
}

// Check token
if (!ValidPost())
	ServerError("Invalid post request.");

// Convert SVG string to image
if (class_exists("Imagick")) { // Use Imagick if available
	try {
		$img = new Imagick();
		$svg = '<?xml version="1.0" encoding="utf-8" standalone="no"?>' . ewr_StripSlashes(@$_POST["stream"]); // Get SVG string

		// Replace, for example, fill="url('#10-270-rgba_255_0_0_1_-rgba_255_255_255_1_')" by fill="rgb(255, 0, 0)" 
		//$svg = preg_replace('/fill="url\(\'#[\w-]+rgba_(\d+)_(\d+)_(\d+)_(\d+)_-[\w-]+\'\)"/', 'fill="rgb($1, $2, $3)"', $svg);

		$svg = preg_replace('/fill="url\(\'\#[\w-]+rgba_(\d+)_(\d+)_(\d+)_(\d+\.?\d?)_-[\w-\.?]+\'\)"/', 'fill="rgb($1, $2, $3)"', $svg);
		$img->readImageBlob($svg);
		$img->setImageBackgroundColor(new ImagickPixel("transparent"));
		$img->setImageFormat("png24");
	} catch (Exception $e) {
		ServerError($e->getMessage());
	}
} elseif (function_exists("curl_init")) { // Use export.api3.fusioncharts.com and curl
	$postdata = file_get_contents("php://input"); // Get POST data
	$img = ewr_ClientUrl("export.api3.fusioncharts.com", $postdata, "POST"); // Get the chart from fusioncharts.com
	if ($img === FALSE)
		ServerError("Failed to get chart image from export server. Make sure your web server is online.");
} else {
	ServerError("Both Imagick and cURL not installed on this server.");
}

// Save the file
$params = ewr_StripSlashes(@$_POST["parameters"]);
$filename = "";
if (preg_match('/exportfilename=(\w+\.png)\|/', $params, $matches)) // Must be .png for security
	$filename = $matches[1];
if ($filename == "")
	ServerError("Missing file name.");
$path = ewr_ServerMapPath(EWR_UPLOAD_DEST_PATH);
$realpath = realpath($path);
if (!file_exists($realpath))
	ServerError("Upload folder does not exist.");
if (!is_writable($realpath))
	ServerError("Upload folder is not writable.");
$filepath = realpath($path) . EWR_PATH_DELIMITER . $filename;
file_put_contents($filepath, $img);
?>
