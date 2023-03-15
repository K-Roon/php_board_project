function menu() {
    $('ul', this).stop().slideToggle(300)
}

function layerToggle() {
    $('.layer').toggle()
}

function slide(){
    var pos=0;  //현재 슬라이드의 위치

    function play() {
        var main_slide_height=$('.slide ul').clientHeight;
        pos=(pos+1)%3   //0.1.2가 들어감
        $('.slide ul')  //애니메이션 실행
        .animate({
            marginTop: (-1 * main_slide_height)*pos+"px"
        }, 500) // 0.5s간 애니메이션 진행
    }
    setInterval(play,2000) //2초마다 슬라이드 애니메이션, 실행
}

$(document)
.on('ready', slide) // 준비가 되어있고, 그렇다면 슬라이드 함수를 사용함.
.on('mouseenter mouseleave', '.gnb>ul>li', menu)    //.gnb>ul 이면, 서브메뉴 전체가 나타남.
.on('click', '.notice li:eq(0), .layer__close', layerToggle); //공지사항의 첫번째 게시물을 클릭하면, 레이어팝업이 실행되고, 닫기버튼을 누르면 팝업이 사라진다.