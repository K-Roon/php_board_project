<link rel="stylesheet" href="./css/ppui_basic.css">
<link rel="stylesheet" href="./css/ppui_m.css" media="screen and (min-width:680px) and (max-width:1079px)">
<link rel="stylesheet" href="./css/ppui_mobile.css" media="screen and (max-width:679px)">
<header class="site-header">
        <div class="container">
            <h1 class="header-logo"><a href="./index.php" style="text-decoration: none;">PHP BOARD</a></h1> 
            <nav class="gnb">
                <ul class = "nav-links">
                    <li>
                        <a href="./index.php">게시판</a>
                    </li>
                    <li>
                        <a href="./write.php">글쓰기</a>
                    </li>
                    <li>
                        <?php
                            session_start();
                            if(isset($_SESSION['user_id'])) {
                                echo "<a href='./logout.php' style='white-space:nowrap;'>";
                                echo $_SESSION['user_id']; if($_SESSION['oper'] == '1') {echo "<strong style='color: red;'> 관리자</strong> ";} else if($_SESSION['oper'] == '2') {echo " <strong style='color: blue;'> 개발자</strong> ";} else {echo "님";}?>(로그아웃)</a>
                        <?php } else { ?>
                        <a href="./login.php">로그인</a>
                        <?php } ?>
                    </li>
                </ul>
                <ul class = "burger">
                    <li>
                        <a href="./index.php">게시판</a>
                    </li>
                    <li>
                        <a href="./write.php">글쓰기</a>
                    </li>
                    <li>
                        <?php
                            session_start();
                            if(isset($_SESSION['user_id'])) {
                                echo "<a href='./logout.php' style='white-space:nowrap;'>";
                                echo $_SESSION['user_id']; if($_SESSION['oper'] == '1') {echo "<strong style='color: red;'> 관리자</strong> ";} else if($_SESSION['oper'] == '2') {echo " <strong style='color: blue;'> 개발자</strong> ";} else {echo "님";}?>(로그아웃)</a>
                        <?php } else { ?>
                        <a href="./login.php">로그인</a>
                        <?php } ?>
                    </li>
                </ul>
            </nav>
        </div>
    </header>