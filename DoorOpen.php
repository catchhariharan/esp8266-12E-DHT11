<?php
/*
 * DoorOpen.php
 * 
 * Copyright 2017  <pi@raspberrypi>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
 * 
 */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>DoorOpen</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.24.1" />
</head>

<body>

<?PHP
// define variables and set to empty values
$nameErr = $emailErr = $DoorStatusErr = $websiteErr = "";
$name = $email = $DoorStatus = $comment = $website = "";

// define variables and set to empty values
$nameErr = $emailErr = $DoorStatusErr = $websiteErr = "";
$name = $email = $DoorStatus = $comment = $website = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed"; 
    }
  }

  if (empty($_POST["DoorStatus"])) {
    $DoorStatusErr = "DoorStatus is required";
  } else {
    $DoorStatus = test_input($_POST["DoorStatus"]);
  }  
  
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>Door Open</h2>
<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Name: <input type="text" name="name" value="<?php echo $name;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
  DoorStatus:
  <input type="radio" name="DoorStatus" <?php if (isset($DoorStatus) && $DoorStatus=="Open") echo "checked";?> value="Open">Open
  <input type="radio" name="DoorStatus" <?php if (isset($DoorStatus) && $DoorStatus=="Close") echo "checked";?> value="Close">Close
  <span class="error">* <?php echo $genderErr;?></span>
  <br><br>
  
  <input type="submit" name="DoorOpen" value="Submit">  
</form>

<?php
echo "<h2>Your Input:</h2>";
echo $name;
echo "<br>";
echo $DoorStatus;
echo "<br>";
?>

<?php
$Cmp = strcmp ($DoorStatus,"Open");
$myfile = 'DoorSts.txt';
if ($Cmp == 0) {
   $txt = "Open\n";
   file_put_contents($myfile, $txt);//   fwrite($myfile, $txt);

   usleep(5000000);
   $txt = "Close\n";
   file_put_contents($myfile, $txt);//   fwrite($myfile, $txt);   
}
else {
   $txt = "Close\n";
   file_put_contents($myfile, $txt);
}	

//fclose($myfile);
?>

</body>

</html>
