<?php
    $connect = mysqli_connect("localhost", "root", "1234", "sample_db") or die("fail");
                    
    $board_id = $_GET['id'];
    $get_user_id = $_GET['get_user_id'];
    $delete_form = $_GET['delete_form'];
    session_start();
    $session_user_id = $_SESSION['user_id'];
    $session_oper = $_SESSION['oper'];
    //return URL
    $URL = './index.php';
    if($delete_form == "forever") {
        // 완전삭제

        if($session_user_id == '' || $sission_oper) {
            echo "<script>alert('권한이 없습니다.');location.href='./index.php';</script>";
            exit(0);
        }

        $query2 = "DELETE FROM board where id = '$board_id'";
        $result = $connect->query($query2);
        if($result) {
            echo "<script>alert('글을 DB에서 완전히 삭제시켰습니다. 이제 아무도 모릅니다.');location.href='./index.php';</script>";
            exit(0);
        } else {
            echo "<script>alert('글 삭제를 실패했습니다. 권한이 있는지 확인하십시오.');location.replace('$URL');</script>";
        }
        mysqli_close($connect);
    } else if($delete_form == "force_admin") {
        // 완전삭제

        if($session_user_id == '' || $session_oper == '0' || $session_oper == '') {
            echo "<script>alert('권한이 없습니다.');location.href='./index.php';</script>";
            exit(0);
        }

        $query2 = "UPDATE board SET viewstate = 'delete_admin' where id = '$board_id'";
        $result = $connect->query($query2);
        if($result) {
            echo "<script>alert('관리자에 의해 강제로 삭제되었습니다.');location.href='./index.php';</script>";
            exit(0);
        } else {
            echo "<script>alert('글 삭제를 실패했습니다. 권한이 있는지 확인하십시오.');location.replace('$URL');</script>";
        }
        mysqli_close($connect);
    } else {
        if($get_user_id == '' || $session_user_id != $get_user_id ) {
            echo "<script>alert('권한이 없습니다.');location.href='./index.php';</script>";
            exit(0);
        }
        
        // 자진삭제
        $query2 = "UPDATE board SET viewstate = 'delete_self' where id = '$board_id' and user_id = '$session_user_id'";
        $result = $connect->query($query2);
        if($result) {
    ?>                  
    <script>
        alert("<?php echo "글이 삭제되었습니다."?>");
        location.replace("<?php echo $URL?>");
    </script>
    <?php
        } else {
            echo "<script>alert('글 삭제를 실패했습니다. 권한이 있는지 확인하십시오.');location.replace('$URL');</script>";
        }
        mysqli_close($connect);
    }
?>