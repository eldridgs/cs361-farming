<?php
  //Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","petleya-db","h4QQvoY9jtkpIVYy","petleya-db");
if($mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Find Information</title>
  </head>
  <body>
  <h3 class= "title">Search Plants</h3>
  <form action="findplant.php" method="POST">
    <span class="sectiontitle">Plant:</span><br><br>
<?php
//prepare
    if ( !($stmt = $mysqli->prepare("SELECT plantName FROM zplant2 ORDER BY plantName ASC")) ) {
		echo 'Prepare failed: (' . $mysqli->errno . ') '. $mysqli->error;
    }
//bind and execute
if (!$stmt->execute()) {
	echo 'Execute failed: (' . $mysqli->errno . ') ' . $mysqli->error;
}
if ( !$stmt->bind_result($plantName) ) {
	echo 'Binding output parameters failed: (' .$stmt->errno . ') ' . $stmt->error;
}
echo '<span class="heading"> Name: </span>
    <select name = "plantName">';
$i = 0;
while ( $stmt->fetch() ) {
    $i++;
    echo '<option value="' . $plantName . '">' . $plantName . '</option>';
}
echo '</select>';
/* explicit close recommended */
$stmt->close();
echo '<br><br>
    <span class="heading"> Desired Information:</span><br>
      <input type="checkbox" name="plattribute" value="temp"> Temperature<br>
      <input type="checkbox" name="plattribute" value="water"> Water<br>
      <input type="checkbox" name="plattribute" value="pest"> Pesticide/Disease Susceptibility<br>
      <input type="checkbox" name="plattribute" value="sun"> Sun Needs<br>
      <input type="checkbox" name="plattribute" value="nutrient"> Nutrient Needs<br>
      <input type="checkbox" name="plattribute" value="all"> All<br>
      <br>
      <input type="submit" class="button" value="SUBMIT">
  </form>';
//check for empty form plant name field
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ( empty($_POST["plantName"]) ) {
		echo "You must select a plant.";
	}
	$namePlant = $_POST["plantName"];
echo '<br><br>
    <span class = "sectiontitle">' . $namePlant . '</span>';
echo '<br>';
/*Prepared statement, stage 1: prepare */
if (!($stmt = $mysqli->prepare("SELECT gtype, gxweek, org, oamount, oxweek, pesticide, pamount, pxweek, pFood, pfamount, pfxweek, sunlevel, duration, sxday, wamount, wxday FROM zplant2 WHERE plantName = '$namePlant'"))) {
	echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
//bind and execute
if (!$stmt->execute()) {
	echo 'Execute failed: (' . $mysqli->errno . ') ' . $mysqli->error;
}
if ( !$stmt->bind_result($gtype, $gxweek, $orgName, $oamount, $oxweek, $ptype, $pamount, $pxweek, $ftype, $famount, $pfxweek, $slevel, $sduration, $sxday, $wamount, $wxday) ) {
	echo 'Binding output parameters failed: (' .$stmt->errno . ') ' . $stmt->error;
}
echo '<table class = "outputTable">';
echo '<thead><th>GROOMING</th><th>ORGANIC</th><th>PESTICIDES</th><th>FOOD</th><th>SUN</th><th>WATER</th></thead>';
echo '<tbody>';
$i = 0;
while ( $stmt->fetch() ) {
    $i++;
	//$videoName = $outName;
      echo '<br><br>
            <tr>
              <td class="center">Type: ' . $gtype . '<br>X /week: ' . $gxweek . '</td>
              <td class="center">Name: ' . $orgName . '<br>Amount: ' . $oamount . '<br>X /week: ' . $oxweek . '</td>
              <td class="center">Type: ' . $ptype . '<br>Amount: ' . $pamount . '<br>X /month: ' . $pxweek . '</td>
              <td class="center">Type: ' . $ftype . '<br>Amount: ' . $famount . '<br>X /week: ' . $pfxweek . '</td>
              <td class="center">Level: ' . $slevel . '<br>Duration: ' . $sduration . '<br>X /day: ' . $sxday . '</td>
              <td class="center">Amount: ' . $wamount . '<br>X /day: ' . $wxday . '</td>';
	  echo '</tbody></table><br>';
}
/* explicit close recommended */
	  $stmt->close();
}
?>
    </body>
</html>

