<?php // rnmembers.php
include_once 'rnheader.php';

if (!isset($_SESSION['user']))
  die("<br /><br />You must be logged in to view this page");
$user = $_SESSION['user'];

if (isset($_GET['view']))
{
  $view = sanitizeString($_GET['view']);
  
  if ($view == $user) $name = "Your";
  else $name = "$view's";
  
  echo "<h3>$name Page</h3>";
  showProfile($view);
  echo "<a href='rnmessages.php?view=$view'>$name Messages</a><br />";
  die("<a href='rnfriends.php?view=$view'>$name Friends</a><br />");
}

if (isset($_GET['add']))
{
  $add = sanitizeString($_GET['add']);
  $query = "SELECT * FROM rnfriends WHERE user='$add'
        AND friend='$user'";
  
  if (!mysql_num_rows(queryMysql($query)))
  {
    $query = "INSERT INTO rnfriends VALUES ('$add', '$user')";
    queryMysql($query);
  }
}
elseif (isset($_GET['remove']))
{
  $remove = sanitizeString($_GET['remove']);
  $query = "DELETE FROM rnfriends WHERE user='$remove'
        AND friend='$user'";
  queryMysql($query);
}

$result = queryMysql("SELECT user FROM rnmembers ORDER BY user");
$num = mysql_num_rows($result);
echo "<h3>Other Members</h3><ul>";

for ($j = 0 ; $j < $num ; ++$j)
{
  $row = mysql_fetch_row($result);
  if ($row[0] == $user) continue;
  
  echo "<li><a href='rnmembers.php?view=$row[0]'>$row[0]</a>";
  $query = "SELECT * FROM rnfriends WHERE user='$row[0]'
        AND friend='$user'";
  $t1 = mysql_num_rows(queryMysql($query));
  
  $query = "SELECT * FROM rnfriends WHERE user='$user'
        AND friend='$row[0]'";
  $t2 = mysql_num_rows(queryMysql($query));
  $follow = "follow";

  if (($t1 + $t2) > 1)
  {
    echo " &harr; is a mutual friend";
  }
  elseif ($t1)
  {
    echo " &larr; you are following";
  }
  elseif ($t2)
  {
    $follow = "recip";
    echo " &rarr; is following you";
  }
  
  if (!$t1)
  {
    echo " [<a href='rnmembers.php?add=".$row[0] . "'>$follow</a>]";
  }
  else
  {
    echo " [<a href='rnmembers.php?remove=".$row[0] . "'>drop</a>]";
  }
}
?>