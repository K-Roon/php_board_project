<?php
                $connect = mysqli_connect("localhost", "root", "1234", "sample_db") or die("fail");
                
                $board_id = $_POST['board_id'];
                $user_id = $_POST['user_id_post'];
                $title = $_POST['title'];
                $content = $_POST['content'];
                $hidden = $_POST['hidden'];

                session_start();
                $session_user_id = $_SESSION['user_id'];
                //return URL
                $URL = './index.php';

                if($title == '' || $content == '') {
                        echo "<script>alert('제목과 내용이 비어있습니다.');history.back();</script>";
                        exit(0);
                }
                if($user_id == '' || $session_user_id != $user_id ) {
                        echo "<script>alert('잘못된 접근 방식입니다.');location.href='./index.php';</script>";
                        exit(0);
                }
                $query = "";
                if($hidden != "") {
                        $query = "UPDATE board SET title = '$title', content = '$content', viewstate = 'hidden' where id = '$board_id' and user_id = '$user_id'";
                } else {
                        $query = "UPDATE board SET title = '$title', content = '$content', viewstate = 'view' where id = '$board_id' and user_id = '$user_id'";
                }
                
 
 
                $result = $connect->query($query);
                if($result){
?>                  <script>
                        <?php if($hidden != "") {echo "alert('앞으로 이 글은 나만 볼 수 있습니다.');";} ?>
                        alert("<?php echo "글이 수정되었습니다."?>");
                        location.replace("<?php echo $URL?>");
                    </script>
<?php
                }
                else{
                        echo "<script>alert('글 수정에 실패하였습니다.');</script>";
                }
 
                mysqli_close($connect);
?>