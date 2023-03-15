<!DOCTYPE html>
<html lang="ko">
<?php
        $connect = mysqli_connect('localhost', 'root', '1234', 'sample_db');
        $id = $_GET['id'];
        $up_board_id = $_GET['up_board_id'];
        session_start();
        if(!isset($_SESSION["load_id"])) {
            $_SESSION["load_id"] = 1;
        } else {
            $_SESSION["load_id"] = $_SESSION["load_id"] + 1;
        }

        if(!isset($_COOKIE["LOADER"])) {
            setcookie("LOADER", 1, time() + 10, "/");
        } else {
            setcookie("LOADER", $_COOKIE["LOADER"]+1, time() + 10, "/");
        }

        if($_COOKIE["LOADER"] >= 50) {
            echo(" <script> location.href = './session_check.php?id=$id'; </script> ");
        } 

        $query = "select * from board where id =$id";
        $result = $connect->query($query);
        $rows = mysqli_fetch_assoc($result);
        $oper = $_SESSION["oper"];
        if($rows['viewstate'] == '' ) {
            echo "<script>alert('없는 게시물입니다.'); history.back();</script>";
            exit(0);
        } else if($rows['viewstate'] == 'delete_self' ) {
            echo "<script>alert('사용자가 삭제한 게시물입니다.'); history.back();</script>";
            exit(0);
        } else if($rows['viewstate'] == 'delete_admin' ) {
            echo "<script>alert('관리자가 삭제한 게시물입니다.'); history.back();</script>";
            exit(0);
        } else if($rows['viewstate'] == 'delete_force' ) {
            echo "<script>alert('권리자가 삭제 요청한 게시물입니다.'); history.back();</script>";
            exit(0);
        } else if($rows['viewstate'] == 'hidden' && $_SESSION['user_id'] != $rows['user_id'] ) {
            echo "<script>alert('비공개 게시물입니다.'); history.back();</script>";
            exit(0);
        }

        if($_COOKIE["LOADER"] <= 5) {
            $viewtime = $rows['viewtime'] + 1;
            $query2 = "UPDATE board SET viewtime = '$viewtime' where id =$id";
            $result2 = $connect->query($query2);
        } else {
            $viewtime = $rows['viewtime'];
            $query2 = "UPDATE board SET viewtime = '$viewtime' where id =$id";
            $result2 = $connect->query($query2);
        }

        $cmt_load_query = "SELECT * FROM commant where board_id = $id and viewstate = 'view' and sub_cmt_id is NULL";
        $cmt_load_result = $connect->query($cmt_load_query);

        $cmt_load_query2 = "SELECT * FROM commant where board_id = $id and viewstate = 'view'";
        $cmt_load_result2 = $connect->query($cmt_load_query2);
        $cmt_total = mysqli_num_rows($cmt_load_result2);

    ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/ppui_basic.css">
    <link rel="stylesheet" href="./css/ppui_m.css" media="screen and (min-width:680px) and (max-width:1079px)">
    <link rel="stylesheet" href="./css/ppui_mobile.css" media="screen and (max-width:679px)">
    <link rel="stylesheet" href="./css/style.css">
    <title>게시글:
        <?php echo $rows['title']?>
    </title>
    <script>
        var old_cmt_cont = '';
        function delclick() {
            if(<?php if($_SESSION['user_id'] == null) {echo 1;} else {echo 0;} ?>) {
                alert("로그인 하세요.");
                location.href = './login.php';
            } else {
            if (<?php if($oper == null) {echo "100";} else {echo $oper;} ?> == 2) {
                if (event.ctrlKey && event.shiftKey && event.altKey) {
                    if (confirm('이 기능은 DB강제삭제 기능입니다.(개발자)')) {
                        location.href = './delete.php?id=<?=$id?>&get_user_id=<?=$rows['user_id']?>&delete_form=forever'
                    } else {
                        return;
                    }
                } else if (event.ctrlKey && event.shiftKey) {
                    if (confirm('이 기능은 관리자 직권 강제삭제 기능입니다.')) {
                        location.href = './delete.php?id=<?=$id?>&get_user_id=<?=$rows['user_id']?>&delete_form=force_admin'
                    } else {
                        return;
                    }
                } else {
                    if (confirm('정말로 삭제하시겠어요..?')) {
                        location.href = './delete.php?id=<?=$id?>&get_user_id=<?=$rows['user_id']?>'
                    } else {
                        return;
                    }
                }
            } else if (<?php if($oper == null) {echo "100";} else {echo $oper;} ?> == 1) {
                if (event.ctrlKey && event.shiftKey) {
                    if (confirm('이 기능은 관리자 직권 강제삭제 기능입니다.')) {
                        location.href = './delete.php?id=<?=$id?>&get_user_id=<?=$rows['user_id']?>&delete_form=force_admin'
                    } else {
                        return;
                    }
                } else {
                    if (confirm('정말로 삭제하시겠어요..?')) {
                        location.href = './delete.php?id=<?=$id?>&get_user_id=<?=$rows['user_id']?>'
                    } else {
                        return;
                    }
                }
            } else {
                if (confirm('정말로 삭제하시겠어요..?')) {
                    location.href = './delete.php?id=<?=$id?>&get_user_id=<?=$rows['user_id']?>'
                } else {
                    return;
                }
            }
            }

        }

        function addcmt() {
            if(<?php if($_SESSION['user_id'] == null) {echo 1;} else {echo 0;} ?>) {
                alert("로그인 하세요.");
                location.href = './login.php';
            } else {
            if (document.commant_add.cmt_content.value == '') {
                alert('내용이 없어요..');
                return false;
            } else {
                var str = document.commant_add.cmt_content.value;
                document.commant_add.cmt_content.value = str.replace(/(?:\r\n|\r|\n)/g, '</br>');
                document.commant_add.submit();
                document.commant_add.cmt_content.value = '';
            }}

        }

        function cmtedt(cmtId) {
            if(<?php if($_SESSION['user_id'] == null) {echo 1;} else {echo 0;} ?>) {
                alert("로그인 하세요.");
                location.href = './login.php';
            } else if (document.getElementById("btn_edit_" + cmtId).innerHTML == "수정완료") {

                // 수정 완료 클릭 시
                var new_cmt = document.getElementById("cmt_" + cmtId).value.replace(/(?:\r\n|\r|\n)/g, '</br>');
                document.getElementById("commantContent_" + cmtId).innerHTML = new_cmt;
                document.getElementById("btn_edit_" + cmtId).innerHTML = "수정";
                document.getElementById("btn_del_" + cmtId).innerHTML = "삭제";
                location.href = "./cmt_other_action.php?ways=modify&cmt_id=" + cmtId + "&cmt_content=" + new_cmt + "&board_id=" + <?= $id ?>;

            } else {

                // 수정 버튼 클릭 시
                var old_cmt_cont = document.getElementById("commantContent_" + cmtId).innerHTML.replace("</br>", "\n");
                document.getElementById("commantContent_" + cmtId).innerHTML = "<textarea id='cmt_" + cmtId + "'style='height: 50px; width: 500px;'>" + old_cmt_cont + "</textarea>";
                document.getElementById("btn_edit_" + cmtId).innerHTML = "수정완료";
                document.getElementById("btn_del_" + cmtId).innerHTML = "취소";
                return false;
            }

        }

        function reply(cmtId) {
            if(<?php if($_SESSION['user_id'] == null) {echo 1;} else {echo 0;} ?>) {
                alert("로그인 하세요.");
                location.href = './login.php';
            }
            if (document.getElementById("btn_reply_" + cmtId).innerHTML == "답글완료") {

                // 답글 완료 클릭 시
                var new_cmt = document.getElementById("cmt_" + cmtId).value;
                new_cmt = new_cmt.replace(/(?:\r\n|\r|\n)/g, '</br>');
                document.getElementById("commantContent_" + cmtId).innerHTML = new_cmt;
                document.getElementById("btn_reply_" + cmtId).innerHTML = "답글";
                document.getElementById("btn_del_" + cmtId).innerHTML = "삭제";
                location.href = "./cmt_other_action.php?ways=reply&cmt_id=" + cmtId + "&cmt_content=" + new_cmt + "&board_id=" + <?= $id ?>;

            } else {

                // 답글 버튼 클릭 시
                old_cmt_cont = document.getElementById("commantContent_" + cmtId).innerHTML;
                document.getElementById("commantContent_" + cmtId).innerHTML += "<br><textarea id='cmt_" + cmtId + "'></textarea>";
                document.getElementById("btn_reply_" + cmtId).innerHTML = "답글완료";
                document.getElementById("btn_del_" + cmtId).innerHTML = "취소";
                return false;
            }

        }

        function replyPlus(cmtId, usrId, upcmtId) {
            if(<?php if($_SESSION['user_id'] == null) {echo 1;} else {echo 0;} ?>) {
                alert("로그인 하세요.");
                location.href = './login.php';
            }
            if (document.getElementById("btn_reply_" + cmtId).innerHTML == "답글완료") {

                // 답글 완료 클릭 시
                var new_cmt = document.getElementById("cmt_" + cmtId).value;
                new_cmt = new_cmt.replace(/(?:\r\n|\r|\n)/g, '</br>');
                document.getElementById("commantContent_" + cmtId).innerHTML = new_cmt;
                document.getElementById("btn_reply_" + cmtId).innerHTML = "답글";
                document.getElementById("btn_del_" + cmtId).innerHTML = "삭제";
                location.href = "./cmt_other_action.php?ways=reply&cmt_id=" + upcmtId + "&cmt_content=" + new_cmt + "&board_id=" + <?= $id ?>;

            } else {

                // 답글 버튼 클릭 시
                old_cmt_cont = document.getElementById("commantContent_" + cmtId).innerHTML;
                document.getElementById("commantContent_" + cmtId).innerHTML += "<br><textarea id='cmt_" + cmtId + "'>@" + usrId + " </textarea>";
                document.getElementById("btn_reply_" + cmtId).innerHTML = "답글완료";
                document.getElementById("btn_del_" + cmtId).innerHTML = "취소";
                return false;
            }

        }

        function cmtdel(cmtId) {
            if(<?php if($_SESSION['user_id'] == null) {echo 1;} else {echo 0;} ?>) {
                alert("로그인 하세요.");
                location.href = './login.php';
            } else {if (document.getElementById("btn_del_" + cmtId).innerHTML == "취소") {

        // 댓글 수정 취소
        var prev_cmt = document.getElementById("cmt_" + cmtId).innerHTML;
        document.getElementById("commantContent_" + cmtId).innerHTML = prev_cmt;
        document.getElementById("btn_edit_" + cmtId).innerHTML = "수정";
        document.getElementById("btn_del_" + cmtId).innerHTML = "삭제";
        return false;
        } else {
        
        // 댓글 삭제
        if (confirm('댓글을 정말로 삭제하시겠어요..?')) {
            location.href = "./cmt_other_action.php?ways=delete&cmt_id=" + cmtId + "&board_id=" + <?= $id ?>;
        } else {
            return;
        }


        }}
            
        }
    </script>
    
</head>

<body>
<?php include 'header.php' ?>
<div class = "main" >
    <div class="container">
        <h2>
            <?php echo $rows['title']?>
        </h2>
        <p>
            글쓴이:
            <?php echo $rows['user_id']?> | 조회수:
            <?php echo $viewtime?>
        </p>
        <hr>
        <div style="min-height: 300px;"><?php echo $rows['content']?></div>
        <hr>
        <!-- 목록, 수정, 삭제 버튼 -->
        <div class="btn_group">
            <button class="btn" onclick="history.back()">목록으로</button>
            <?php if($rows['up_board_id'] == null) {?><button class="btn btn-primary" onclick="location.href='./write.php?up_board_id=<?=$id?>&title=<?=$rows['title']?>'">답글</button><?php } ?>
            <button class="btn btn-success" onclick="location.href='./modify.php?id=<?=$id?>&user_id=<?=$rows['user_id']?>'">수정</button>
            <button class="btn btn-danger" onclick="delclick()">삭제</button>
        </div>
        <!-- 댓글창 -->
        <div class="add_reply">
            
            <div class="dap_ins">
                <form name="commant_add" action="./commant_action.php" method="post">
                    <input type="hidden" name="user_id" placeholder="아이디">
                    <div style="margin-top:10px;">
                    <h4>댓글 (<?php  if($cmt_total == '' ) {echo "0"; } else {echo $cmt_total;} ?> 개)</h4>
                        <h5>
                            <?php if(isset($_SESSION['user_id'])) { echo "{$_SESSION['user_id']} (으)로 댓글 달기 "; } else { echo "댓글 달기를 원하신다면 로그인 해주세요."; }?>
                        </h5>
                        <input type="hidden" name="cmt_board_id" value="<?php echo $id?>">
                        <textarea name="cmt_content" class="reply_content" id="re_content" width="100px"
                            required></textarea>
                        <button id="rep_bt" class="btn btn-default" onclick="addcmt()">달기</button>
                    </div>
                </form>
            </div>
        </div>
        <hr>


        <?php while($cmt_rows = mysqli_fetch_assoc($cmt_load_result)) { ?>
            <div id="comment">
                <strong><?php echo $cmt_rows['user_id']?></strong> (<?php echo $cmt_rows['releasedate']?>)
                <?php if($cmt_rows['viewstate'] == 'view') { if($cmt_rows['user_id'] == $_SESSION['user_id']) {?>
                    <button onclick="cmtedt(<?php echo $cmt_rows['cmt_id']?>)"
                        id="btn_edit_<?php echo $cmt_rows['cmt_id']?>">수정</button><?php }?>
                    <button onclick="cmtdel(<?php echo $cmt_rows['cmt_id']?>)"
                        id="btn_del_<?php echo $cmt_rows['cmt_id']?>">삭제</button>
                    <button onclick="reply(<?php echo $cmt_rows['cmt_id']?>)"
                        id="btn_reply_<?php echo $cmt_rows['cmt_id']?>">답글</button>
                <?php } ?>
                </br>
                <p id="commantContent_<?php echo $cmt_rows['cmt_id']?>"><?=$cmt_rows['content']?></p>
                <hr>
            </div>

            <?php

            // 답글
            $sub_cmt_id = $cmt_rows['cmt_id'];
            $appl_load_query = "SELECT * FROM commant where viewstate = 'view' and sub_cmt_id = $sub_cmt_id";
            $appl_result = $connect->query($appl_load_query);
            $appl_total = mysqli_num_rows($appl_result);

            while($appl_rows = mysqli_fetch_assoc($appl_result)) { ?>
                <div id="comment-reply" style="margin-left: 30px;">
                    <strong><?php echo $appl_rows['user_id']?></strong> (<?php echo $appl_rows['releasedate']?>)
                    <?php if($appl_rows['viewstate'] == 'view') { if($cmt_rows['user_id'] == $_SESSION['user_id']) {?>
                        <button onclick="cmtedt(<?php echo $appl_rows['cmt_id']?>)"
                            id="btn_edit_<?php echo $appl_rows['cmt_id']?>">수정</button><?php }?>
                        <button onclick="cmtdel(<?php echo $appl_rows['cmt_id']?>)"
                            id="btn_del_<?php echo $appl_rows['cmt_id']?>">삭제</button>
                        <button onclick="replyPlus(<?php echo $appl_rows['cmt_id']?>, '<?php echo $appl_rows['user_id']?>', '<?php echo $cmt_rows['cmt_id']?>')"
                            id="btn_reply_<?php echo $appl_rows['cmt_id']?>">답글</button>
                    <?php } ?>
                    </br>
                    <p id="commantContent_<?php echo $appl_rows['cmt_id']?>"><?= nl2br($appl_rows['content']).ltrim().rtrim()?></p>
                    <hr>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    </div>
</body>

</html>