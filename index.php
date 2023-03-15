<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>홈</title>
        <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <?php include 'header.php' ?>
    <div class="main">
            <?php
            $connect = mysqli_connect('localhost', 'root', '1234', 'sample_db') or die ("connect fail");
            $page = $_GET['page'];
            $search = $_GET['search'];
            $list_per_page = 10; // 한 페이지 당 보여지는 게시물들
            $block_ct = 5;
            if(isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }

            $start_num = ($page - 1) * 10;

            if(!isset($_COOKIE["LOADER"])) {
                setcookie("LOADER", 1, time() + 30, "/");
            } else {
                setcookie("LOADER", $_COOKIE["LOADER"]+1, time() + 30, "/");
            }
    
            if($_COOKIE["LOADER"] >= 60) {
                echo(" <script> location.href = './session_check.php?id=$id'; </script> ");
            } 

            if(isset($_GET['search'])) {
                $query2 = "select * from board where (viewstate = 'view' or viewstate = 'hidden') and (title LIKE ('%$search%') or content LIKE ('%$search%')) order by id desc"; // 검색된 게시판의 모든 게시글 수합
                $query = "select * from board where (viewstate = 'view' or viewstate = 'hidden') and up_board_id is NULL and (title LIKE ('%$search%') or content LIKE ('%$search%')) order by id desc LIMIT $start_num, $list_per_page"; // 답글을 제외한 모든 게시글
            } else {
                $query2 = "select * from board where viewstate = 'view' or viewstate = 'hidden' order by id desc"; // 게시판의 모든 게시글 수합
                $query = "select * from board where (viewstate = 'view' or viewstate = 'hidden') and up_board_id is NULL order by id desc LIMIT $start_num, $list_per_page"; // 답글을 제외한 모든 게시글
            }
            
            $result = $connect->query($query);
            $result2 = $connect->query($query2);
            $total = mysqli_num_rows($result2);
            session_start();
            ?>
            <form name="search_form" action = "./index.php">
                <input type = "text" name = "search" value = "<?=$search?>" placeholder = "검색(제목과 내용)">
                <input type = "submit" value = "찾기" class = "btn-big">
            </form>
        <table class="board">
            <thead>
                <tr class="board-general">
                    <td style="max-width: 80px;" align="center">글 번호</td>
                    <td style="max-width: 500px;" align="center">제목</td>
                    <td style="max-width: 100px;" align="center">글쓴이</td>
                    <td style="max-width: 200px;" align="center">글쓴 날</td>
                    <td style="max-width: 70px;" align="center">조회수</td>
                </tr>
                <tr class="board-mini">
                    <td style="max-width: 80px;" align="center">No.</td>
                    <td style="width: calc( 100% - 80px )">제목</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    while($rows = mysqli_fetch_assoc($result)) {
                        //DB에 저장된 데이터 수 (열 기준)?>
                <tr class="board-general">
                    <td align="center">
                        <?php echo $rows['id']?>
                    </td>
                    <td width="500">
                        <a href="view.php?id=<?=$rows['id']?>">
                            <?php echo str_replace($search, "<b class = 'fo_re'>$search</b>", $rows['title'])?>
                    </td>
                    <td width="100" align="center">
                        <?php echo $rows['user_id']?>
                    </td>
                    <td width="200" align="center">
                        <?php echo $rows['writedate']?>
                    </td>
                    <td width="50" align="center">
                        <?php echo $rows['viewtime']?>
                    </td>
                </tr>
                <tr class="board-mini">
                    <td align="center" style="min-width: 30px;">
                        <?php echo $rows['id']?>
                    </td>
                    <td>
                        <a href="view.php?id=<?=$rows['id']?>">
                            <?php echo str_replace($search, "<b class = 'fo_re'>$search</b>", $rows['title'])?>
                    <p class="mini-descr">글쓴이: <?php echo $rows['user_id']?> | 조회수: <?php echo $rows['viewtime']?> | <?php echo $rows['writedate']?></p>
                    </td>
                </tr>
                    
                <?php
                    $sub_query ="select * from board where (viewstate = 'view' or viewstate = 'hidden') and up_board_id = {$rows['id']} order by id desc";
                    $sub_result = $connect->query($sub_query);
                    $sub_total = mysqli_num_rows($sub_result);
                        while($sub_rows = mysqli_fetch_assoc($sub_result)) {
                            //DB에 저장된 데이터 수 (열 기준)
                    ?>
                        <a href="view.php?id=<?=$sub_rows['id']?>&up_board_id=<?=$sub_rows['up_board_id']?>">
                        <tr class="even board-general">
                            <td align="center">
                                └
                            </td>
                            <td width="500">
                                <a href="view.php?id=<?=$sub_rows['id']?>&up_board_id=<?=$sub_rows['up_board_id']?>">
                                <?php echo str_replace($search, "<b class = 'fo_re'>$search</b>", $sub_rows['title'])?>
                            </td>
                            <td width="100" align="center">
                                <?php echo $sub_rows['user_id']?>
                            </td>
                            <td width="200" align="center">
                                <?php echo $sub_rows['writedate']?>
                            </td>
                            <td width="50" align="center">
                                <?php echo $sub_rows['viewtime']?>
                            </td>
                        </tr>
                        <tr class="even board-mini">
                            <td align="center" style="min-width: 30px;">
                                └
                            </td>
                            <td>
                                <a href="view.php?id=<?=$sub_rows['id']?>&up_board_id=<?=$sub_rows['up_board_id']?>">
                                <?php echo str_replace($search, "<b class = 'fo_re'>$search</b>", $sub_rows['title'])?>
                                <p class="mini-descr">글쓴이: <?php echo $sub_rows['user_id']?> | 조회수: <?php echo $sub_rows['viewtime']?> | <?php echo $sub_rows['writedate']?></p>
                            </td>
                        </tr></a>
                <?php } ?>
                <?php } ?>
            </tbody>
        </table>
        
        <br>
        <div id="page_num">
            <?php
            $block_num = ceil($page/$block_ct); // 현재 페이지 블록 구하기
            $block_start = (($block_num - 1) * $block_ct) + 1; // 블록의 시작번호
            $block_end = $block_start + $block_ct - 1; 

            if($total/$list_per_page < $block_end) {
                if($total%$list_per_page == 0) {
                    $block_end = floor($total/$list_per_page);
                } else {
                    $block_end = floor($total/$list_per_page) + 1;
                }
            }

            $pre = $page - 1; //이전 페이지로 이동
            if($page > 1) {
                echo "<a href='?page=1&search=$search'>처음</a>"; //처음으로
                echo "<a href='?page=$pre&search=$search'>이전</a>";
            } else {
                echo "<a class='fo_re'>처음</li>";
            }
            

              for($i = $block_start; $i <= $block_end ; $i++) { 
                //for문 반복문을 사용하여, 초기값을 블록의 시작번호를 조건으로 블록시작번호가 마지박블록보다 작거나 같을 때까지 $i를 반복시킨다
                if($page == $i){ //만약 page가 $i와 같다면 
                  echo "<a class='fo_re'>[$i]</a>"; //현재 페이지에 해당하는 번호에 굵은 빨간색을 적용한다
                } else {
                  echo "<a href='?page=$i&search=$search'>[$i]</a>"; //아니라면 $i
                }
              }

              $next = $page + 1;
              if($page + 1 <= $block_end) {
                echo "<a href='?page=$next&search=$search'>다음</a>";
            }
              if($page < floor($block_end)) {
                  echo "<a href='?page=$block_end&search=$search'>마지막</a>";
              } else {
                echo "<a class='fo_re'>마지막</a>";
              }
            ?>
        </div>
    </div>
    
</body>

</html>