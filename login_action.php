
<?php

$user_id = $_POST['user_id'];
$pass = $_POST['pass'];

$con = mysqli_connect("localhost", "root", "1234", "sample_db");

$sql = "SELECT * FROM user WHERE USER_ID='$user_id'";

$result = mysqli_query($con, $sql);

$num_match = mysqli_num_rows($result);

if (!$num_match) {
    echo(" <script> window.alert('등록되지 않은 아이디입니다!'); history.go(-1); </script> ");
}
else {
    $row = mysqli_fetch_array($result);
    $db_pass = $row["user_pw"];
    mysqli_close($con);
    /* 로그인 화면에서 전송된 $pass와 DB의 $db_pass의 해쉬값 비교 */
    if ($pass != $db_pass) {
        echo("<script>window.alert('비밀번호가 틀립니다!');history.go(-1);</script>");
        exit;
    }
    else {
        session_start();
        $_SESSION["user_id"] = $row["user_id"];
        $_SESSION["user_pw"] = $row["user_pw"];
        $_SESSION["nickname"] = $row["nickname"];
        $_SESSION["oper"] = $row["oper"];
        echo(" <script> location.href = './index.php'; </script> ");
    }
}
?>