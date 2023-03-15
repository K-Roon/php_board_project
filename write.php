<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>글 작성하기</title>
    <link rel="stylesheet" href="./css/ppui_basic.css">
    <link rel="stylesheet" href="./css/ppui_m.css" media="screen and (min-width:680px) and (max-width:1079px)">
    <link rel="stylesheet" href="./css/ppui_mobile.css" media="screen and (max-width:679px)">
    <script>
        function comp() {
            var new_cmt = document.fm_write.content.value.replace(/(?:\r\n|\r|\n)/g, '</br>');
            document.fm_write.content.value = new_cmt;
                document.fm_write.submit();
        }
    </script>
</head>

<body>
    <?php
        session_start();
        $up_board_id = $_GET['up_board_id'];
        $up_board_title = $_GET['title'];
        $URL = "./login.php";
        if(!isset($_SESSION['user_id'])) {
    ?>

    <script>
        alert("로그인이 필요해요.");
        location.replace("<?php echo $URL?>");
    </script>
    <?php } ?>
    <?php include 'header.php' ?>
    <div class="main">
        <div class="container">
            <form class="form-horizontal" method="POST" name="fm_write" action="write_action.php">
                    <div class="form-group">
                        <div class="col-sm-10"><input type="hidden" name="id" class="form-control"
                                value="<?=$_SESSION['user_id']?>"><input type="hidden" name="up_board_id" class="form-control"
                                value="<?=$up_board_id?>"></div>
                    </div>
                    <div class="form-group">
                        <h3>글쓰기</h3><h6><?php if($up_board_id != '') echo "$up_board_title 에 대한 답글 쓰기"; ?></h6>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">제목</label>
                        <div class="col-sm-10"><input type="text" name="title" class="form-control" placeholder="제목">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">내용</label>
                        <div class="col-sm-10">
                            <textarea name="content" style="height: 300px;" class="form-control" placeholder="내용"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                    <input type="checkbox" name="hidden" value="chkbox_unrel" <?php if($rows['viewstate'] == 'hidden') {echo "checked";}?>> 나의 게시글은 나만 보고 싶습니다.
                    
                    <div class="col-sm-0ffset-2 col-sm-10">
                    <input type="button" class="btn-success" onClick = "comp()" value="작성">
                </div>
                </div>
            </form>
        </div>

</body>

</html>