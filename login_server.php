<?php

include('db.php');

if(isset($_GET['user_id']) && isset($_GET['pass1']))
{
  // 보안을 더욱 강화 (시큐어 코딩, 보안코딩)
  $user_id = mysqli_real_escape_string($db, $_GET['user_id']);  
  $pass1 = mysqli_real_escape_string($db, $_GET['pass1']);

  //에러를 체크

  if(empty($user_id))
  {
    header("location: login_view.php?error=아이디가 비어있어요");
    exit();
  }
  else if(empty($pass1))
  {
    header("location: login_view.php?error=비밀번호가 비어있어요");
    exit();
  }
  else
  {
    $sql ="select * from member where mb_id = '$user_id'";
    $result = mysqli_query($db,$sql);

    if(mysqli_num_rows($result) === 1)
    {

      //1.해당열을 가져왔다
      //2.가져올때 배열의 형태로 가져오는구나
      //3.print_r은 배열을 출력해주는 함수구나
      //4.echo는 쪼개서 가져올 수 있구나

      $row = mysqli_fetch_assoc($result);
      $hash = $row['password']; //db의 암호화된 값을 불러와서 $hash에 담아줌

      if(password_verify($pass1, $hash))//왼쪽 $pass1 : 이용자가 입력한 것과 hash를 매칭시켜서 확인시켜준다.
      {
        header("location: mypage/mypage.php?user_id=$user_id&pass1=$pass1");
        exit();
      }
      else
      {
        header("location: login_view.php?user_id=$user_id&pass1=$pass1&error=로그인에 실패하였습니다.");
        exit();
      }
    
    }
    else
    {
      header("location: login_view.php?user_id=$user_id&pass1=$pass1&error=아이디가 잘못 입력되었습니다.");
        exit();
    }
  }

}
else
{
  header("location: login_view.php?user_id=$user_id&pass1=$pass1&error=알 수 없는 오류가 발생하였습니다.");
          exit();
}

?>