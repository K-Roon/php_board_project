<!DOCTYPE html>
<html lang="kr">
<head>
<meta charset="UTF-8">
<title>PROTECT SYSTEM</title>
<?php
    $connect = mysqli_connect('localhost', 'root', '1234', 'sample_db');
    session_start();
    $id = $_POST["board_id"];
    $problem_id = $_POST["problem_id"];
    $post_answer = $_POST["answer"];
    $query = "select * from traffic_problem where problem_id = $problem_id";
        $result = $connect->query($query);
        $rows = mysqli_fetch_assoc($result);
        $post_answer = preg_replace("/\s+/", "", $post_answer);
        setcookie("TRAFFIC_ATTECH", $_COOKIE["TRAFFIC_ATTECH"] + 1, time() + 3600, "/");
        $_SESSION["TRAFFIC_ATTECH"] = $_SESSION["TRAFFIC_ATTECH"] +1;

        // if($_SESSION["TRAFFIC_ATTECH"] != $_COOKIE["TRAFFIC_ATTECH"]) {
            // setcookie("TRAFFIC_ATTECH", $_COOKIE["TRAFFIC_ATTECH"] + 6, time() + 3600, "/");
            // $_SESSION["TRAFFIC_ATTECH"] = $_SESSION["TRAFFIC_ATTECH"] + 6;
        // }
        if($_COOKIE["TRAFFIC_ATTECH"] >= 6) {
            echo "<script>alert('접속이 거부되었어요. 다음에 다시 시도하세요.'); location.href = './index.php';</script>";
            die();
        } else {
            if($rows['problem_answer'] == $post_answer) {
            setcookie("LOADER", 1, time() + 3600, "/");
            echo "<script>alert('확인되었습니다.'); location.href = './index.php';</script>";
        } else {
            echo "<script>alert('의심됩니다.'); history.back();</script>";
        }
        }
        
    ?>
</head>
</html>