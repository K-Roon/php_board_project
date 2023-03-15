<?php
                $connect = mysqli_connect("localhost", "root", "1234", "sample_db") or die("fail");
                
                $user_id = $_POST['id'];
                $title = $_POST['title'];
                $content = $_POST['content'];
                $hidden = $_POST['hidden'];
                $up_board_id = $_POST['up_board_id'];

                // return URL
                $URL = './index.php';
        session_start();
        $URL = "./index.php";
        if(!isset($_SESSION['user_id'])) {
    ?>

    <script>
        alert("로그인이 필요해요.");
        location.replace("<?php echo $URL?>");
    </script>
    <?php } ?>
<?php
                if($user_id == '' || $title == '' || $content == '' ) {
                        echo "<script>alert('잘못된 방식입니다');</script>";
                        echo "<script>history.back();</script>";
                        exit(0);
                }
                if ($up_board_id == null || $up_board_id == '') {
                    $up_board_id = 'DEFAULT';
                }
                $query = "";
                if($hidden != "") {
                    $query = "INSERT INTO board (id, title, content, user_id, writedate, viewstate, viewtime, up_board_id) VALUES (DEFAULT, '$title', '$content', '$user_id', DEFAULT, 'hidden', DEFAULT, $up_board_id)";
                } else {
                    $query = "INSERT INTO board (id, title, content, user_id, writedate, viewstate, viewtime, up_board_id) VALUES (DEFAULT, '$title', '$content', '$user_id', DEFAULT, DEFAULT, DEFAULT, $up_board_id)";
                }

                $result = $connect->query($query);
                if($result){
?>                  
                    <script>
                        <?php if($hidden != "") {echo "alert('앞으로 이 글은 나만 볼 수 있습니다.');";} ?>
                        alert("<?php echo "글이 등록되었습니다."?>");
                        location.replace("<?php echo $URL?>");
                    </script>
<?php
                }
                else {
                    ?>                  
                    <script>
                        alert("<?php echo "글 작성에 실패했습니다. 잘못된 접근입니다."?>");
                        location.replace("<?php echo $URL?>");
                    </script>
<?php
                }
 
                mysqli_close($connect);
?>