<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/ppui_basic.css">
    <link rel="stylesheet" href="./css/style.css">
    <title>회원가입 페이지</title>
</head>

<body>
        <!-- 표준 네비게이션 바 (화면 상단에 위치, 화면에 의존하여 확대 및 축소) -->
        <nav class="navbar navbar-default navbar-fixed-top">
        <div class = "container">
            <div class = "navbar-header">
                <a class="navbar-brand" href="index.php">PHP 게시판 웹 사이트</a>
            </div>
            <ul class = "nav navbar-nav">
                <li><a class="navbar-brand" href="index.php">홈</a></li>
                <li><a class="navbar-brand" href="write.php">글쓰기</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
    <div class="col-lg-4"></div>
        <div class="col-lg-4" style="padding-top: 20px;">
            <form method="POST" action="join_action.php">
                <h2 class="form-signin-heading">회원가입</h2>
                <!-- 아이디 -->
                <div class="form-group">
                    <input type="text" name="user_id" class="form-control" placeholder="User ID" maxlength="15" required
                        autofocus>
                </div>

                <!-- 비밀번호 -->
                <div class="form-group">
                    <input type="password" name="user_pw" class="form-control" placeholder="Password" maxlength="20"
                        required>
                </div>

                <!-- 닉네임 -->
                <div class="form-group">
                    <input type="text" name="nickname" class="form-control" placeholder="nickname" maxlength="20"
                        required>
                </div>

                <!-- 이메일 -->
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="User Email" required>
                </div>
                <input type="submit" class="btn btn-primary form-control" value="회원가입">
            </form>
        </div>

    </div>
</body>

</html>