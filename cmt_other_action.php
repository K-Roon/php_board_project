<?php
                $connect = mysqli_connect("localhost", "root", "1234", "sample_db") or die("fail");
                
                $cmt_id = $_GET['cmt_id'];
                $cmt_board_id = $_GET['board_id'];
                $cmt_user_id = $_GET['get_user_id'];
                $cmt_content = $_GET['cmt_content'];
                $cmt_ways = $_GET['ways'];
                $cmt_reply = $_GET['reply'];

                // return URL
                $URL = './index.php';
        session_start();
        if(!isset($_SESSION['user_id'])) {
    ?>

<script>
    alert("로그인이 필요해요.");
    location.replace("./login.php");
</script>
<?php } 
    $session_user_id = $_SESSION['user_id'];
    if($session_user_id == '' || $cmt_board_id == '' || $cmt_ways == '') {
        echo "<script>alert('잘못된 접근입니다.');</script>";
        echo "<script>history.back();</script>";
        exit(0);
    } else {
            // 댓글 삭제 버튼 누름
            if($cmt_ways == "delete"){
                $session_user_id = $_SESSION['user_id'];
                $session_oper = $_SESSION['oper'];
                if($session_oper == '1' || $session_oper == '2') {
                        $del_query = "UPDATE commant SET viewstate = 'delete_admin' where cmt_id = '$cmt_id'";
         $del_result = $connect->query($del_query);
         if($del_result){
                 echo "<script>alert('관리자의 직권으로 댓글이 삭제되었습니다.');</script>";
                 echo "<script>history.back();</script>";
                 exit(0);
         } else {
                 echo "<script>alert('잘못된 방식입니다.');</script>";
                 echo "<script>history.back();</script>";
         }   
                 }
                        $del_query = "UPDATE commant SET viewstate = 'delete_self' where cmt_id = '$cmt_id' and user_id = '$session_user_id'";
                        $del_result = $connect->query($del_query);
                        if($del_result){
                                echo "<script>alert('댓글을 스스로 삭제하였습니다.');</script>";
                                echo "<script>history.back();</script>";
                        } else {
                        
                                echo "<script>alert('잘못된 방식입니다.');</script>";
                                echo "<script>history.back();</script>";
                        }
                
           
                mysqli_close($connect); 

                // 댓글 답글완료 버튼 누름
            } else if ($cmt_ways == "reply") {
                if($cmt_content == '') {
                        echo "<script>alert('댓글을 입력하세요.');</script>";
                        echo "<script>history.back();</script>";
                        exit(0);
                }
                $session_user_id = $_SESSION['user_id'];
                $query = "INSERT INTO commant (cmt_id, content, user_id, board_id, releasedate, viewstate, sub_cmt_id) VALUES (DEFAULT, '$cmt_content', '$session_user_id', '$cmt_board_id', DEFAULT, DEFAULT, $cmt_id)";
                $reply_result = $connect->query($query);

                if($reply_result){
                        echo "<script>alert('답글을 달았습니다.');</script>";
                        echo "<script>history.back();</script>";
                } else {
                        echo "<script>alert('잘못된 방식입니다.');</script>";
                        echo "<script>history.back();</script>";
                }
                mysqli_close($connect);

                // 수정 완료 버튼 누름
            } else if ($cmt_ways == "modify") {
                if($cmt_content == '') {
                        echo "<script>alert('댓글을 입력하세요.');</script>";
                        echo "<script>history.back();</script>";
                        exit(0);
                }
                $session_user_id = $_SESSION['user_id'];
                $modi_query = "UPDATE commant SET content = '$cmt_content' where cmt_id = '$cmt_id' and user_id = '$session_user_id'";
                $modi_result = $connect->query($modi_query);

                if($modi_result){
                        echo "<script>alert('댓글이 수정되었습니다.');</script>";
                        echo "<script>history.back();</script>";
                } else {
                        echo "<script>alert('잘못된 방식입니다.');</script>";
                        echo "<script>history.back();</script>";
                }
                mysqli_close($connect); 
            } else {
                echo "<script>alert('잘못된 접근입니다.');</script>";
                echo "<script>history.back();</script>";
            }
        
    }
        
?>