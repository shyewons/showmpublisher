<!DOCTYPE html>
<html lang="ko">
<head>
</head>
<?php
    # 12층 쿠팡 계정 적용정보시트 
    // https://docs.google.com/spreadsheets/d/1jPmHmWfjBPkeazWAUt43p1DjE14a6l40ETmpHJnhcZg/edit?usp=sharing

    # 쿠팡적용시 참고해야할 사이트
    // https://partners.coupang.com/#announcements/32

    # 쿠팡링크 생성방법
    // 쿠팡 파트너스 로그인 > 채널아이디 생성 > 간편링크 만들기 > 쿠팡 URL의 '쿠팡 홈' > 링크 생성

    # storage_time
    // 로컬스토리지, 새창열기가 허용된 패키징을 사용해야 함
    // 최소 2시간이어야 함
?>
<style>
    /* reset.css */
    @import url('https://webfontworld.github.io/pretendard/Pretendard.css');
    * {-webkit-tap-highlight-color: transparent;}
    .off {display:none !important;}
    html {font-size: 16px}
    html, body {margin: 0; padding: 0;}
    h1, h2, h3, h4, h5, h6, p, a, span, em, strong, del, s, b, blockquote, br, i, u, dl, dt, dd, table, tr, thead, tbody, tfoot, th, td, img, object, form, fieldset, label, input, textarea, select, option, button, header, main, section, aside, footer, nav, article, div, ol, ul, li, pre {padding: 0; margin: 0; font-family: 'Pretendard', sans-serif; letter-spacing: -0.01rem; line-height: 1; font-weight: normal; font-size: 1rem; color:#333; box-sizing: border-box; word-break: keep-all;}
    #wrap {display:flex;justify-content:center;align-items:center;min-height:100vh;}
    #submit {font-size:2rem;padding:1.5rem 2.5rem;font-weight:bold;color:#666;box-shadow:0 0 .5rem rgba(0,0,0,.3); border-radius:10rem;width:fit-content;}


    /* 광고모달 */
    .coopang_wrap {position:fixed;left: 0;top: 0;width: 100%;height: 100%;display: flex;justify-content: center;align-items: center;flex-direction: column;background-color: #fff;overflow-y: scroll;z-index: 1000;}
    .coopang_wrap .p1 {text-align: center;font-size: 1.8rem;line-height: 1.4;color:#111;margin:3rem 0;font-weight:bold;}
    .coopang_wrap .p2 {text-align: center;font-size: 1.4rem;line-height: 1.2;color:#666;margin-bottom:2rem;}
    .coopang_wrap .p3 {text-align: center;font-size: 1.2rem;line-height: 1.2;color:#aaa;margin-bottom:1rem;}
    .coopang_wrap .link {position:relative;width: calc(100% - 6rem);max-width: 700px;border-radius: 10rem;border:none;background-color: #9ac67d;margin-bottom: 1.5rem;box-shadow: 2px 2px 10px rgba(0, 0, 0, .2);}
    .coopang_wrap .link p {color: #fff;font-size: 1.6rem;font-weight:600;width:calc(100% - 8rem);margin:0 auto;padding:1.5rem 0;}
    .coopang_wrap .link .cancel {position:absolute;right:1rem;top:50%;width:3rem;height:3rem;transform:translateY(-50%);border-radius:10rem;background-color:#fff;}
    .coopang_wrap .link .cancel p {color:#9ac67d;padding: 0;width: 100%;height: 100%;display: flex;align-items: center;justify-content: center;}
    .coopang_wrap .link .cancel span {position: absolute;left:20%;top:50%;width: 60%;height: 2px;transform-origin: center;background-color: #9ac67d;display: none;}
    .coopang_wrap .link .cancel span:nth-of-type(1){transform: rotate(45deg);}
    .coopang_wrap .link .cancel span:nth-of-type(2){transform: rotate(-45deg);}


    /* 전면광고 */
    .fullAd_wrap {position: fixed;left: 0;top: 0;width: 100%;height:100vh;display: flex;align-items: center;flex-direction: column;justify-content: center;background-color: rgba(0, 0, 0, .4);backdrop-filter: blur(3px);z-index: 1000;}
    .fullAd_wrap .info {font-size: 1.6rem;line-height: 1.4;color:#fff;}
    .fullAd_wrap .time {position: absolute;transform: translateX(-50%);left: 50%;top: 1.5rem;padding: 1rem 3rem;color: #666;z-index: 1000;font-weight: 500;border-radius: 10rem;background-color: #fff;box-shadow: 0 0 .5rem rgba(0, 0, 0, .2);font-size: 1.6rem;}
    .fullAd_wrap .ins_wrap {position: absolute;top: 50%;left: 50%;width: 100%;transform: translate(-50%, -50%);height: fit-content;}
</style>
<body>
    <div id="wrap">
        <div id="submit">쿠팡 & 전면광고</div>
    </div>


    <!-- 쿠팡광고 모달 창 -->
    <div class="coopang_wrap off">
        <p class="p1">쿠팡 방문은 앱을 운영할 수 있는 힘이 됩니다.<br>항상 앱을 사랑해주셔서 감사합니다.</p>
        <p class="p2">쿠팡에 잠시 다녀오실 동안<br>결과를 가져오겠습니다.</p>
        <button class="link">
            <p>쿠팡 방문하고 결과보기</p>
            <div class="cancel"><span></span><span></span><p>5</p></div>
        </button>
        <p class="p3">이 포스팅은 쿠팡 파트너스 활동의 일환으로,<br>이에따른 일정액의 수수료를 제공받습니다.</p>
    </div>


    <!-- 전면광고 -->
    <div class="fullAd_wrap off">
        <p class="info">로딩중..</p>
        <P class="time"></P>
        <div class="ins_wrap">
            <ins class="adsbygoogle"
                data-language="ko"
                style="display:inline-block;width:100vw;height:100vh"
                data-ad-client="ca-pub-코드"
                data-ad-slot="코드"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </div>
    
    
    <!-- window.open 오류 방지 -->
    <a href="https://www.naver.com/" style="display:none;" id="coopang_link" target="_blank"></a>


</body>
<script>
    // storage_time : 광고빈도
    // adTime : 다시보지않기 판단
    const percent = 0.8; // 전면광고 보여줄 확률
    var storage_time = 12 * 60 * 60 * 1000; // 12시간 동안 보이지 않게
    // var storage_time = 30 * 1000; // 30초 동안 보이지 않게
    // var storage_time = -1; // 광고가 항상 안보임
    // var storage_time = 0; // 광고가 항상 보임
    const body = document.querySelector('body');
    const submitButton = document.querySelector("#submit");
    const coopang_wrap = document.querySelector('.coopang_wrap');
    const coopang_cancel = document.querySelector('.coopang_wrap .cancel');
    const coopang_wrap_btn = document.querySelector('.coopang_wrap button p');
    const cancelp = document.querySelector('.cancel p');
    const cancelsp = document.querySelectorAll('.cancel span');
    const coopang_link = document.querySelector('#coopang_link');


    // 광고판단
    document.addEventListener("DOMContentLoaded", function () {
        submitButton.addEventListener("click", function () {
            coopang();

            // 쿠팡 타이머
            let mi = 4;
            const intervalId = setInterval(() => {
                cancelp.innerHTML = mi;
                mi--;
                if (mi === -1) {
                    clearInterval(intervalId);
                    cancelsp.forEach(el => {
                        el.style.display = 'block';
                    });
                    cancelp.style.display = 'none';
                    coopang_cancel.addEventListener('click',function () {
                        goNext();
                    })
                }
            }, 1000);


        })
    });
    
    // 쿠팡이동
    coopang_wrap_btn.addEventListener('click', ()=>{
        coopang_link.click();
        setAdTime();
        goNext();
    });
    
    
    function coopang(){ // 광고판단
        var adTime = localStorage.getItem("adTime");
        console.log(adTime);
        if (storage_time >= 0 && (!adTime || new Date() >= new Date(adTime))) {
            console.log('다시보지않음 만료');
            coopang_wrap.classList.remove('off');
            body.classList.add('lock');
        } else {
            console.log('다시보지않음 적용중');

            // +++ 쿠팡 광고를 보여주지 않을 경우에는 애드센스 전면광고 등장
            fullAdShow();
        }
    }

    // 다시보지 않기
    function setAdTime() {
        var adt = new Date();
        adt.setTime(adt.getTime() + storage_time);
        localStorage.setItem("adTime", adt);
        console.log('다시보지않음');
    }
    
    // 쿠팡창 닫고 다음 동작
    function goNext(){
        body.classList.remove('lock');
        coopang_wrap.classList.add('off');
        checkSubmit();
    }
    
    // 다음동작
    function checkSubmit(){
        // 운전면허는 화면을 가리는게 목적이므로 여긴 공란으로 둠
        alert('원하는 동작 실행');
    }
    
    // 전면광고
    function fullAdShow() {
        const fullAd_wrap = document.querySelector('.fullAd_wrap');
        const time = document.querySelector('.time');
        let randomNumber = Math.random();
        console.log('광고확률 : ' + randomNumber);
        function closeAd() { // 창 닫음
            fullAd_wrap.classList.add('off');
            document.querySelector('body').style.overflow = 'auto';
        }

        if(randomNumber < percent){

            document.querySelector('body').style.overflow = 'hidden';
            fullAd_wrap.classList.remove('off');
            
            // 전면광고 타이머
            var timeText = 5;
            time.textContent = timeText + '초';
            var countdown = setInterval(function () {
                timeText -= 1;
                time.textContent = timeText + '초';

                if (timeText <= 0) {
                    time.textContent = '창이 닫힙니다';
                    clearInterval(countdown);
                    
                    setTimeout(function() {
                        closeAd();
                    }, 100);
                }
            }, 1000);

            setTimeout(() => { goNext(); }, 5100);
        }else{
            // 확률에 해당되지 않으면 광고창 제거
            closeAd();
            goNext();
        }
    }
        

</script>
</html>