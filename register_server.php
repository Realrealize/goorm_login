<?php

include('db.php');

if(isset($_GET['user_id']) && isset($_GET['user_nick']) && isset($_GET['pass1']) && isset($_GET['pass2']))
{
  // 보안을 더욱 강화 (시큐어 코딩, 보안코딩)
  $user_id = mysqli_real_escape_string($db, $_GET['user_id']);
  $user_nick = mysqli_real_escape_string($db, $_GET['user_nick']);
  $pass1 = mysqli_real_escape_string($db, $_GET['pass1']);
  $pass2 = mysqli_real_escape_string($db, $_GET['pass2']);

  //에러를 체크

  if(empty($user_id))
  {
    header("location: register_view.php?error=아이디가 비어있어요");
    exit();
  }
  else if(empty($user_nick))
  {
    header("location: register_view.php?error=닉네임이 비어있어요");
    exit();

  }
  else if(empty($pass1))
  {
    header("location: register_view.php?error=비밀번호가 비어있어요");
    exit();
  }
  else if(empty($pass2))
  {
    header("location: register_view.php?error=비밀번호가 비어있어요");
    exit();
  }
  else if($pass1 !== $pass2)
  {
    header("location: register_view.php?error=비밀번호가 일치하지 않아요");
    exit();
  }
  else
  {
    //암호화
    $pass1 = password_hash($pass1, PASSWORD_DEFAULT); //단방향 암호
   

    //아이디 또는 닉네임, 또는 아이디와 동시에 닉네임 중복 체크
    $sql_same = "SELECT * FROM member where mb_id = '$user_id' and mb_nick = '$user_id' ";
    $order = mysqli_query($db, $sql_same);

    if(mysqli_num_rows($order) > 0)
    {
      header("location: register_view.php?error=아이디 또는 닉네임이 이미 있어요");
      exit();
    }
    else
    {
        $sql_save = "insert into member(mb_id, mb_nick, password) values('$user_id','$user_nick','$pass1')";
        $result = mysqli_query($db, $sql_save);

        if($result)
        {
          header("location: register_view.php?success=성공적으로 가입 되었습니다.");
          exit();
        }
        else
        {
          header("location: register_view.php?error=가입에 실패하였습니다.");
          exit();
        }
      }
  }

}
else
{
  header("location: register_view.php?error=알 수 없는 오류가 발생하였습니다.");
          exit();
}

?>