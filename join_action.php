<?php
 
        $connect = mysqli_connect('localhost', 'root', '1234', 'sample_db') or die("fail");

        $user_id = $_POST['user_id'];
        $user_pw = $_POST['user_pw'];
        $nickname = $_POST['nickname'];
        $email = $_POST['email'];

        if($user_id == '' || $user_pw == '' || $nickname == '' || $email == '' ) {
                echo "<script>alert('잘못된 방식입니다');</script>";
                echo "<script>history.back();</script>";
                exit(0);
        }

        $query1 = "SELECT * FROM USER WHERE user_id = '$user_id'";
        $resource = $connect->query($query1);
        $num = mysqli_num_rows($resource);
        if( $num > 0 ) {
            echo "<script> alert('이미 존재하는 아이디입니다.'); </script>";
            echo "<script> history.back(); </script>";
            exit(0);
        } else {
        //입력받은 데이터를 DB에 저장
        $query = "insert into user (user_id, user_pw, nickname, email, oper) values ('$user_id', '$user_pw', '$nickname', '$email', DEFAULT)";
        $result = $connect->query($query) or die("Fail");
        }
        //저장이 됬다면 (result = true) 가입 완료
        if ($result) {
                echo "<script> alert('가입에 성공하였습니다. 방금 가입하신 계정으로 로그인 해주세요.');location.href = './login.php'</script> ";
        } else {
        echo "<script> alert('가입에 실패하였습니다.');history.back();</script>";
}
        mysqli_close($connect);
?>