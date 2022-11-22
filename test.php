<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
// define variables and set to empty values
$accountidErr = $whitelisttypeErr = $whitelistingtypeErr = "";
$hwid = $account = $accountid = $whitelisttype = $whitelistingtype = "";//$blacklisthwid = $blacklistaccount = $blacklistaccountid = "";
$error = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["hwid"])) {
    $hwid = "";
  } else {
    $hwid = test_input($_POST["hwid"]);
    // check if hwid only contains letters and whitespace
  }
  
  if (empty($_POST["account"])) {
    $account = "";
  } else {
    $account = test_input($_POST["account"]);
  }
    
  if (empty($_POST["accountid"])) {
    $accountid = "";
  } else {
    $accountid = test_input($_POST["accountid"]);
     if (is_numeric($accountid) == false) {
      $accountid = "";
      $error = true;
      $accountidErr = "Only letters and white space allowed";
    }
  }

  if (empty($_POST["whitelisttype"])) {
    $whitelisttypeErr = "Whitelist Type is required";
    $error = true;
  } else {
    $whitelisttype = test_input($_POST["whitelisttype"]);
  }
  
  if (empty($_POST["whitelistingtype"])) {
    $whitelistingtypeErr = "Whitelisting Type is required";
    $error = true;
  } else {
    $whitelistingtype = test_input($_POST["whitelistingtype"]);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>Assasine03 Whitelisting/Blacklisting</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  HWID: <input type="text" name="hwid" value="<?php echo $hwid;?>">
  <br><br>
  Username: <input type="text" name="account" value="<?php echo $account;?>">
  <br><br>
  UserId: <input type="text" name="accountid" value="<?php echo $accountid;?>">
  <span class="error"><?php echo $accountidErr;?></span>
  <br><br>
  Whitelisting Type:
  <input type="radio" name="whitelistingtype" <?php if (isset($whitelistingtype) && $whitelistingtype=="hwid") echo "checked";?> value="hwid">HWID
  <input type="radio" name="whitelistingtype" <?php if (isset($whitelistingtype) && $whitelistingtype=="account") echo "checked";?> value="account">Account
  <span class="error">* <?php echo $whitelistingtypeErr;?></span>
  <br><br>
  Whitelist Type:
  <input type="radio" name="whitelisttype" <?php if (isset($whitelisttype) && $whitelisttype=="whitelist") echo "checked";?> value="whitelist">Whitelist
  <input type="radio" name="whitelisttype" <?php if (isset($whitelisttype) && $whitelisttype=="blacklist") echo "checked";?> value="blacklist">Blacklist
  <input type="radio" name="whitelisttype" <?php if (isset($whitelisttype) && $whitelisttype=="rwhitelist") echo "checked";?> value="rwhitelist">Remove Whitelist
  <input type="radio" name="whitelisttype" <?php if (isset($whitelisttype) && $whitelisttype=="rblacklist") echo "checked";?> value="rblacklist">Remove Blacklist
  <span class="error">* <?php echo $whitelisttypeErr;?></span>
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>

<?php

if ($whitelisttype != "") {
   
if ($whitelistingtype != "") if ($whitelistingtype == "hwid"){
    
    if ($hwid == ""){
    print("HWID selected: HWID missing");
    $hwid = "";
        $error == true;
    } else {
    print("HWID Selected");
    }
    }
    else 
    {
        if ($whitelistingtype == "account"){
            if ($account == "" or $accountid == ""){
        print("Account selected: Account or UserId missing");
        $account = "";
        $accountid = "";
        $error == true;
    } else {
    print("Account Selected");
    }
        }
    }
}


if ($error == false) {
     
$hwid;
$account;
$accountid;
$whitelisttype;
$whitelistingtype;
if ($_SERVER['REMOTE_ADDR'] == "95.91.211.141" or $_SERVER['REMOTE_ADDR'] == "98.15.34.155") {
    
echo "<br>";
if ($whitelistingtype == "hwid" and $hwid != "") {
echo $hwid; 
echo "<br>";
if ($whitelisttype == "whitelist"){
    $myfile = fopen("Whitelists.txt", "a") or die("Unable to open file!");
    fwrite($myfile,$hwid."\n");
}

if ($whitelisttype == "blacklist"){
    $lines = file( "Whitelists.txt", FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES );
    $co = 0;
    foreach($lines as $tests){
        if ($hwid == $tests){
        echo $co;
        print($lines."/".$tests."<br>");
        $myfile = file("Whitelists.txt") or die("Unable to open file!");
        unset($myfile[$co]);
        file_put_contents("Whitelists.txt", implode("", $myfile));
        break;
        }
        $co = $co +1;
    }
    $lines = file( "Blacklisted_HWID.txt", FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES );
    $fine = true;
    foreach($lines as $tests){
        if ($hwid == $tests) {
            $fine = false;
        }
    }
    if ($fine == true) {
    $myfile = fopen("Blacklisted_HWID.txt", "a") or die("Unable to open file!");
    fwrite($myfile,$hwid."\n");
    }
}

if ($whitelisttype == "rwhitelist"){
    $lines = file( "Whitelists.txt", FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES );
    $co = 0;
    foreach($lines as $tests){
        if ($hwid == $tests){
        $myfile = file("Whitelists.txt") or die("Unable to open file!");
        unset($myfile[$co]);
        file_put_contents("Whitelists.txt", implode("", $myfile));
        break;
        }
        $co = $co +1;
    }
    
}

if ($whitelisttype == "rblacklist"){
    $lines = file( "Blacklisted_HWID.txt", FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES );
    $co = 0;
    foreach($lines as $tests){
        if ($hwid == $tests){
        $myfile = file("Blacklisted_HWID.txt") or die("Unable to open file!");
        unset($myfile[$co]);
        file_put_contents("Blacklisted_HWID.txt", implode("", $myfile));
        break;
        }
        $co = $co +1;
    }
}
}

if ($whitelistingtype == "account" and $account != "" or $accountid != "") {
echo $account;
echo "<br>";
echo $accountid;
echo "<br>";
if ($whitelisttype == "whitelist"){
    $myfile = fopen("Whitelists_UserId.txt", "a") or die("Unable to open file!");
    fwrite($myfile,$account.",".$accountid."\n");
}

if ($whitelisttype == "blacklist"){
    $lines = file( "Whitelists_UserId.txt", FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES );
    $co = 0;
    foreach($lines as $tests){
        if ($account.",".$accountid == $tests){
        echo $co;
        print($lines."/".$tests."<br>");
        $myfile = file("Whitelists_UserId.txt") or die("Unable to open file!");
        unset($myfile[$co]);
        file_put_contents("Whitelists_UserId.txt", implode("", $myfile));
        break;
        }
        $co = $co +1;
    }
    $lines = file( "Blacklisted_UserId.txt", FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES );
    $fine = true;
    foreach($lines as $tests){
        if ($account.",".$accountid == $tests) {
            $fine = false;
        }
    }
    if ($fine == true) {
    $myfile = fopen("Blacklisted_UserId.txt", "a") or die("Unable to open file!");
    fwrite($myfile,$account.",".$accountid."\n");
    }
}

if ($whitelisttype == "rwhitelist"){
    $lines = file( "Whitelists_UserId.txt", FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES );
    $co = 0;
    foreach($lines as $tests){
        if ($account.",".$accountid == $tests){
        echo $co;
        print($lines."/".$tests."<br>");
        $myfile = file("Whitelists_UserId.txt") or die("Unable to open file!");
        unset($myfile[$co]);
        file_put_contents("Whitelists_UserId.txt", implode("", $myfile));
        break;
        }
        $co = $co +1;
    }
    
}

if ($whitelisttype == "rblacklist"){
    $lines = file( "Blacklisted_UserId.txt", FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES );
    $co = 0;
    foreach($lines as $tests){
        if ($account.",".$accountid == $tests){
        echo $co;
        print($lines."/".$tests."<br>");
        $myfile = file("Blacklisted_UserId.txt") or die("Unable to open file!");
        unset($myfile[$co]);
        file_put_contents("Blacklisted_UserId.txt", implode("", $myfile));
        break;
        }
        $co = $co +1;
    }
}
}

}
else {
    echo "<br>";
    print("Error");
    echo "<br>";
    print($_SERVER['REMOTE_ADDR']);
}
}
?>

</body>
</html>