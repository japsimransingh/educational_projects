<html>
<head>
<title>Student Management Program</title>
<!--IMPORT STYLESHEET AND SCRIPT-->
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/master.css">
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>

<!--PHP BACKEND and FrontEnd-->
<?php
session_start();
if(isset($_POST['login']))
{
  include_once 'dbconnection.php';
  if($connection)
  {
    $name = $_POST['inuser'];
    $pass = $_POST['inpass'];
    $sql = "SELECT * FROM `stumanage_users` WHERE name='$name' and passwd='$pass'";
    $result = $connection->query($sql);
    if($result)
    {
      $row = $result->fetch_assoc();
      if($row)
      {
        $_SESSION['slogin'] = true;
        $_SESSION['suser'] = $name;
      }
      else
      {
        echo "<script>alert('Error : User $name is not registered');</script>";
      }
    }
    else
    {
      echo "<script>alert('Error : Can\'t Run Query');</script>";
    }
    $connection->close();
  }
  else
  {
    echo "<script>alert('Error : Can\'t Establish DB Connection');</script>";
  }
}
if(isset($_POST['signup']))
{
include_once 'dbconnection.php';
if($connection)
{
  $name = $_POST['upuser'];
  $pass = $_POST['uppass'];
  $name = str_replace("<","&lt;",$name);
  $name = str_replace(">","&gt;",$name);
  $name = str_replace("'","\\'",$name);
  $name = str_replace("\"","\\\"",$name);
  $pass = str_replace("'","\\'",$pass);
  $pass = str_replace("\"","\\\"",$pass);
  $pass = str_replace("<","&gt;",$pass);
  $pass = str_replace(">","&gt;",$pass);
  $pass = str_replace(">","&gt;",$pass);
  $pass = str_replace(">","&gt;",$pass);
  $sql = "INSERT INTO `stumanage_users`(`name`, `passwd`) VALUES ('$name','$pass')";
  $result = $connection->query($sql);
  if($result)
  {
      echo "<script>alert('Error : User $name is registered');</script>";
  }
  else
  {
    echo "<script>alert('Error : Can\'t Run Query');</script>";
  }
  $connection->close();
}
else
{
  echo "<script>alert('Error : Can\'t Establish DB Connection');</script>";
}
}
if(!isset($_SESSION['slogin']))
{
  index();
}
else
{
  panel();
}
function panel()
{
  header("location:manager/dashboard.php");
}
function index()
{
  include_once 'info.php';
  echo "<center><div class='container margin-bottom-20 jumbotron header'><h2 class=top>Project Name : ".@$project."<br>Coded By : ".@$coder."<br>Submitted To :".@$submited_to."</h1></div>";
  echo "<form method=post action='' class=form-horizontal>
  <div class=container>
  <div class=col-md-6><h3 class='underline bold'>Sign in Form</h3><div class=form-group><input type=text name=inuser placeholder='enter username' class='form-control index-ip '></div><div class=form-group><input type=password name=inpass placeholder='enter password' size=10 class='form-control index-ip'></div><div class=form-group><button type=submit name=login class='btn btn-info'><i class='glyphicon glyphicon-log-in'></i> Sign In</button></div></div>
  <div class=col-md-6><h3 class='underline bold'>Sign up Form</h3><div class=form-group><input type=text name=upuser placeholder='enter username' class='form-control index-ip '></div><div class=form-group><input type=password name=uppass placeholder='enter password' size=10 class='form-control index-ip'></div><div class=form-group><button type=submit name=signup class='btn btn-warning'>Sign Up</button></div></div>
  </form></center>
  ";
}
?>