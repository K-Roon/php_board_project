<!DOCTYPE html>
<html lang="kr">
<?php
    $connect = mysqli_connect('localhost', 'root', '1234', 'sample_db');
    session_start();
    $id = $_GET["id"];
    $problem_id = rand(1, 14);
    $query = "select * from traffic_problem where problem_id = $problem_id";
        $result = $connect->query($query);
        $rows = mysqli_fetch_assoc($result);

        if(!isset($_SESSION["TRAFFIC_ATTECH"])) {
            $_SESSION["TRAFFIC_ATTECH"] = 0;
        }
        if(!isset($_SESSION["TRAFFIC_ATTECH"])) {
            $_COOKIE["TRAFFIC_ATTECH"] = 0;
        }
        $_SESSION["TRAFFIC_ATTECH"] = $_COOKIE["TRAFFIC_ATTECH"];
    ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROTECT SYSTEM</title>
    <link rel="stylesheet" href="./css/ppui_basic.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<div class = "main" margin="10px">
    <h1>트래픽 이상이 감지되었습니다!</h1>
    <h3>계속하시려면 다음 문자를 올바르게 입력하십시오.</h3>
    <hr>
    <h5><?=$rows['problem_name']?></h5>
    <hr>
    <strong color="red">※맞춤법을 준수하시되 문장부호는 입력하지 마십시오.</strong>
    <form name="verify_form" method="POST" action = "./session_check_action.php">
                <input type = "hidden" name = "board_id" value = "<?=$id?>">
                <input type = "hidden" name = "problem_id" value = "<?=$problem_id?>">
                <input type = "text" name = "answer" placeholder = "인증내용">
                <input type = "submit" value = "인증">
            </form>
</div>
</body>
</html>