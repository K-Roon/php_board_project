<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>글 편집하기</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script>
        function comp() {
            var new_cmt = document.fm_modify.content.value.replace(/(?:\r\n|\r|\n)/g, '</br>');
            document.fm_modify.content.value = new_cmt;
                document.fm_modify.submit();
        }
    </script>
</head>

<body>
    <?php
        $board_id = $_GET['id'];
        $user_id = $_GET['user_id'];
        $connect = mysqli_connect('localhost', 'root', '1234', 'sample_db') or die ("connect fail");
        $query ="select * from board where id = '$board_id' and user_id = '$user_id'";
        $result = $connect->query($query);
        $rows = mysqli_fetch_assoc($result);
        session_start();
        
        $URL = "./login.php";
        if($_SESSION['user_id'] != $user_id) {
            echo "<script>alert('편집 권한이 없습니다.'); location.replace('$URL');</script>";
        }
    ?>
    <?php include 'header.php' ?>
    <div class="jumbotron">
        <div class="container">
            <form class="form-horizontal" method="POST" action="modify_action.php" name="fm_modify">
                <h3>게시글 편집하기</h3>
                <div class="form-group">
                    <div class="col-sm-10"><input type="hidden" name="board_id" class="form-control"
                            value="<?=$_GET['id']?>"><input type="hidden" name="user_id_post" class="form-control"
                            value="<?=$_SESSION['user_id']?>"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">제목</label>
                    <div class="col-sm-10"><input type="text" name="title" class="form-control"
                            value="<?php echo $rows['title']?>" placeholder="제목">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">내용</label>
                    <div class="col-sm-10">
                        <textarea name="content" style="height: 300px;" class="form-control" placeholder="내용"><?= str_replace("</br>", "\n", $rows['content'])?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <input type="checkbox" name="hidden" value="chkbox_unrel" <?php if($rows['viewstate'] == 'hidden') {echo "checked";}?>> 나의 게시글은 나만 보고 싶습니다.
                    <div class="col-sm-0ffset-2 col-sm-10">
                        <input type="button" onClick = "comp()" value="수정" class="btn btn-success">
                    </div>
                </div>

            </form>
        </div>

</body>

</html>