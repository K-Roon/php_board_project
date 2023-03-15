<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width" initial-scale="1"> <!-- 스타일 시트 참조 / css폴더의 bootstrap.css 참조 -->
    <title>PHP 게시판 웹 사이트</title>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="./css/ppui_basic.css">
    <link rel="stylesheet" href="./css/ppui_m.css" media="screen and (min-width:680px) and (max-width:1079px)">
    <link rel="stylesheet" href="./css/ppui_mobile.css" media="screen and (max-width:679px)">
    <script src="/board_project/js/login.js"></script>
</head>

<body>
<?php include 'header.php' ?>
    <div class="main">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <div class="container" style="padding-top: 20px;">
                <form name="loginSbmt" id="loginSbmt" method="POST" action="/board_project/login_action.php">
                    <h3 style="text-align: center">Log In</h3>
                    <div class="col-lg-4"></div>
                    <div class="form-group"> <input type="text" class="form-control" placeholder="아이디" name="user_id"
                            maxlength="15" required> </div>
                    <div class="form-group"> <input type="password" class="form-control" placeholder="비밀번호" name="pass"
                            maxlength="20" required> </div> <a href="#"><button class="btn-primary"
                            onclick="check_input()">로그인</button></a>
                            <a href="join.php">회원가입을 해보세요.</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>