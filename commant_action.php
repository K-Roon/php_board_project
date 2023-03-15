<?php
                $connect = mysqli_connect("localhost", "root", "1234", "sample_db") or die("fail");
                
                $cmt_board_id = $_POST['cmt_board_id'];
                $cmt_content = $_POST['cmt_content'];

                // return URL
                $URL = './index.php';
        session_start();
        $URL = "./login.php";
        if(!isset($_SESSION['user_id'])) {
    ?>

    <script>
        alert("로그인이 필요해요.");
        location.replace("<?php echo $URL?>");
    </script>
    <?php } 
    $session_user_id = $_SESSION['user_id'];
                if($session_user_id == '' || $cmt_board_id == '' || $cmt_content == '' ) {
                        echo "<script>alert('잘못된 방식입니다');</script>";
                        echo "<script>history.back();</script>";
                        exit(0);
                }
                $session_user_id = $_SESSION['user_id'];
                $query = "INSERT INTO commant (cmt_id, content, user_id, board_id, releasedate, viewstate) VALUES (DEFAULT, '$cmt_content', '$session_user_id', '$cmt_board_id', DEFAULT, DEFAULT)";
 
 
                $result = $connect->query($query);
                if($result){
?>                  <script>
                        alert("<?php echo "댓글이 등록되었습니다."?>");
                        history.back();
                    </script>
<?php
                }
                else{
                        echo "<script>alert('잘못된 방식입니다');</script>";
                        echo "<script>history.back();</script>";
                }
 
                mysqli_close($connect);
?>