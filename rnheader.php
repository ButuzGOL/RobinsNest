<?php // rnheader.php
include 'rnfunctions.php';
session_start();

if (isset($_SESSION['user']))
{
  $user = $_SESSION['user'];
  $loggedin = TRUE;
}
else $loggedin = FALSE;

echo "<html><head><title>$appname";
if ($loggedin) echo " ($user)";

echo "</title></head><body><font face='verdana' size='2'>";
echo "<h2>$appname</h2>";

if ($loggedin)
{
  echo "<b>$user</b>:
     <a href='rnmembers.php?view=$user'>Home</a> |
     <a href='rnmembers.php'>Members</a> |
     <a href='rnfriends.php'>Friends</a> |
     <a href='rnmessages.php'>Messages</a> |
     <a href='rnprofile.php'>Profile</a> |
     <a href='rnlogout.php'>Log out</a>";
}
else
{
  echo "<a href='index.php'>Home</a> |
     <a href='rnsignup.php'>Sign up</a> |
     <a href='rnlogin.php'>Log in</a>";
}
?>