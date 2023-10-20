<!DOCTYPE html>
<html lang="ko">
<head>
<?php include './front_header.php';?>
<link rel="stylesheet" href="./css/commmon.css">
<link rel="stylesheet" href="./css/calc.css">
</head>
<body>
	<div id="wrap">
		<header class="contentHeader">
		<a href="./home.php">
		  <button>
			<img src="./img/subpage/back.png" alt="">
		  </button>
		</a>
		<div>
		  <h1>대출이자 계산기</h1>
		</div>
		</header>
		<div class="mainContainer">
			<div class="container">
				<form name="registerForm" class="formBlock">
					<div class="amoutWrap">
						<h3>대출금액을 입력해 주세요!</h3>
						<label>
							<input type="text" value="100,000,000" id="amount" placeholder="ex) 100,000,000" autocomplete="off"/>
							<span>원</span>
						</label>
					</div>

					<script>
						const numberInput = document.getElementById("amount");

						numberInput.addEventListener("input", function(event) {
						const formattedValue = event.target.value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
						
						event.target.value = formattedValue;
						});
					</script>


					<div class="yearInterestWrap">
						<h3>연 이자율을 입력해 주세요!</h3>
						<label>
							<input type="text" value="3.0" id="interestYear" placeholder="ex) 3.0"/>
							<span>%</span>
						</label>
					</div>
					<div class="redempWrap">
						<h3>상환기간을 입력해 주세요!</h3>
						<label>
							<input type="text" value="24" id="redemption" placeholder="ex) 24" autocomplete="off"/>
							<span>개월</span>
						</label>
					</div>
					<div class="wayWrap">
						<h3>상환방식</h3>
						<ul class="btnWrap">
							<li class="selectLabel"><em>원리금균등상환</em><span>대출 원금과 이자를 더한 금액을 만기일까지 동일하게 상환</span></li>
							<li><em>만기일시상환</em><span>매월 이자만 납부 후, 만기일에 대출원금 일시 상환(총 이자 금액 가장 많음)</span></li>
							<li><em>원금균등상환</em><span>매월 동일한 원금과 남은 잔금에 대한 이자를 상환(총 이자 금액 가장 적음)</span></li>
						</ul>
					</div>
					<div class="btnBlock">
						<button type="button" onclick="return validateRegister();" class="btn">계산하기</button>
					</div>
				</form>
			</div>

			<div class="errorBlock">
				<div class="resultBox">
					<div id="regisErr"></div>
					<div id="result_table">
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/underscore@1.13.6/underscore-umd-min.js"></script>
	<script src="/js/calc.js"></script>
	
</body>
</html>