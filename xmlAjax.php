<?php
require("db.php");
//error_reporting(E_ALL);

function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
return $xmlStr;
}

// Opens a connection to a MySQL server
$connection=mysqli_connect ($host , $username, $password);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

// Set the active MySQL database
$db_selected = mysqli_select_db($connection,$database);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

// Select all the rows in the markers table
$query = "SELECT * FROM markers WHERE 1";
$result = mysqli_query($connection,$query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

header("Content-type: text/xml");
$total = mysqli_num_rows($result);
$totalRed = 0;
$totalBlue = 0;
$totalGreen = 0;

// Start XML file, echo parent node
echo '<markers>';

// Iterate through the rows, printing XML nodes for each
while ($row = @mysqli_fetch_assoc($result)){
  // ADD TO XML DOCUMENT NODE
  echo '<marker ';
  echo 'name="' . parseToXML($row['name']) . '" ';
  echo 'address="' . parseToXML($row['address']) . '" ';
  echo 'lat="' . $row['lat'] . '" ';
  echo 'lng="' . $row['lng'] . '" ';
  echo 'percent="' . $row['percent'] . '" ';
  echo 'no="' . $row['no'] . '" ';
  echo 'shortcut_dim_6_code="' . $row['shortcut_dim_6_code'] . '" '; 
  echo 'shortcut_dim_7_code="' . $row['shortcut_dim_7_code'] . '" ';
  echo 'city="' . $row['city'] . '" ';
  echo '/>';
}

// End XML file
echo '</markers>';

?>
