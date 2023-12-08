<?php
$db = mysqli_connect('localhost','root','ghddudckd','test');

if(!$db)
{
  echo "db접속 실패";
}
else
{
  echo "db접속 성공";
}
?>