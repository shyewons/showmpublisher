//jQuery time
$(function () {

	var defaultselectbox = $('#cusSelectbox');
	var numOfOptions = $('#cusSelectbox').children('option').length;

	// hide select tag
	defaultselectbox.addClass('s-hidden');

	// wrapping default selectbox into custom select block
	defaultselectbox.wrap('<div class="cusSelBlock"></div>');

	// creating custom select div
	defaultselectbox.after('<div class="selectLabel"></div>');


	// open-list and close-list items functions
	function openList() {
		for (var i = 0; i < numOfOptions; i++) {
			$('.options').children('li').eq(i).attr('tabindex', i).css(
				'transform', 'translateY(' + (i * 100 + 100) + '%)').css(
					'transition-delay', i * 30 + 'ms');
		}
	}

	function closeList() {
		for (var i = 0; i < numOfOptions; i++) {
			$('.options').children('li').eq(i).css(
				'transform', 'translateY(' + i * 0 + 'px)').css('transition-delay', i * 0 + 'ms');
		}
		$('.options').children('li').eq(1).css('transform', 'translateY(' + 2 + 'px)');
		$('.options').children('li').eq(2).css('transform', 'translateY(' + 4 + 'px)');
	}



	$(".options li").on('keypress click', function (e) {
		e.preventDefault();
		$('.options li').siblings().removeClass();
		closeList();
		$('.selectLabel').removeClass('active');
		$('.selectLabel').text($(this).text());
		defaultselectbox.val($(this).text());
		$('.selected-item p span').text($('.selectLabel').text());
	});
	//상환방식 버튼 css 추가
	$('.btnWrap').children().each(function(i,t){
		$(this).on('click',function(){
			$('.btnWrap').children().removeClass('selectLabel');
			$(this).addClass('selectLabel');
		});
	});

});

function focusItems() {

	$('.options').on('focus', 'li', function () {
		$this = $(this);
		$this.addClass('active').siblings().removeClass();
	}).on('keydown', 'li', function (e) {
		$this = $(this);
		if (e.keyCode == 40) {
			$this.next().focus();
			return false;
		} else if (e.keyCode == 38) {
			$this.prev().focus();
			return false;
		}
	}).find('li').first().focus();

}

// features tab
$('.feaTabBtn small').click(function () {
	$('.feaTabCon').toggleClass('active');
	if ($('.feaTabCon').hasClass('active')) {
		$(this).text('hide');
	}
	else {
		$(this).text('show');
	}
});
$('.readmoreBlock span').click(function () {
	$('.readContent').toggleClass('active');
	if ($('.readContent').hasClass('active')) {
		$(this).text('lessmore...');
	}
	else {
		$(this).text('readmore...');
	}
});

function resultFormat(input) {
	var nStr = input + '';
	nStr = nStr.replace(/\,/g, "");
	var x = nStr.split('.');
	var x1 = x[0];
	var x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

// form validation
function validateRegister() {

	var amount, interest, redemption;

	var ExcelFormulas = {

		PVIF: function (rate, nper) {
			return Math.pow(1 + rate, nper);
		},

		FVIFA: function (rate, nper) {
			return rate == 0 ? nper : (this.PVIF(rate, nper) - 1) / rate;
		},

		PMT: function (rate, nper, pv, fv, type) {
			if (!fv) fv = 0;
			if (!type) type = 0;

			if (rate == 0) return -(pv + fv) / nper;

			var pvif = Math.pow(1 + rate, nper);
			var pmt = rate / (pvif - 1) * -(pv * pvif + fv);

			if (type == 1) {
				pmt /= (1 + rate);
			};

			return pmt;
		},

		IPMT: function (pv, pmt, rate, per) {
			var tmp = Math.pow(1 + rate, per);
			return 0 - (pv * tmp * rate + pmt * (tmp - 1));
		},

		PPMT: function (rate, per, nper, pv, fv, type) {
			if (per < 1 || (per >= nper + 1)) return null;
			var pmt = this.PMT(rate, nper, pv, fv, type);
			var ipmt = this.IPMT(pv, pmt, rate, per - 1);
			return pmt - ipmt;
		},

		DaysBetween: function (date1, date2) {
			var oneDay = 24 * 60 * 60 * 1000;
			return Math.round(Math.abs((date1.getTime() - date2.getTime()) / oneDay));
		},

		// Change Date and Flow to date and value fields you use
		XNPV: function (rate, values) {
			var xnpv = 0.0;
			var firstDate = new Date(values[0].Date);
			for (var key in values) {
				var tmp = values[key];
				var value = tmp.Flow;
				var date = new Date(tmp.Date);
				xnpv += value / Math.pow(1 + rate, this.DaysBetween(firstDate, date) / 365);
			};
			return xnpv;
		},

		XIRR: function (values, guess) {
			if (!guess) guess = 0.1;

			var x1 = 0.0;
			var x2 = guess;
			var f1 = this.XNPV(x1, values);
			var f2 = this.XNPV(x2, values);

			for (var i = 0; i < 100; i++) {
				if ((f1 * f2) < 0.0) break;
				if (Math.abs(f1) < Math.abs(f2)) {
					f1 = this.XNPV(x1 += 1.6 * (x1 - x2), values);
				}
				else {
					f2 = this.XNPV(x2 += 1.6 * (x2 - x1), values);
				}
			};

			if ((f1 * f2) > 0.0) return null;

			var f = this.XNPV(x1, values);
			if (f < 0.0) {
				var rtb = x1;
				var dx = x2 - x1;
			}
			else {
				var rtb = x2;
				var dx = x1 - x2;
			};

			for (var i = 0; i < 100; i++) {
				dx *= 0.5;
				var x_mid = rtb + dx;
				var f_mid = this.XNPV(x_mid, values);
				if (f_mid <= 0.0) rtb = x_mid;
				if ((Math.abs(f_mid) < 1.0e-6) || (Math.abs(dx) < 1.0e-6)) return x_mid;
			};

			return null;
		}

	};

	amount_dot = $('#amount').val();
	amount = Number(amount_dot.replaceAll(',', ''));
	interestYear = Number($('#interestYear').val());
	redemption = Number($('#redemption').val());
	isBtnClick = document.querySelectorAll('[class="selectLabel"]').length;
	monthlyRate = interestYear / 12 / 100;
	periodMonth = redemption;
	repayment = $('.selectLabel em').text();
	
	// alert(monthlyRate);

	// if (amount == null || amount == '') {
	// 	$('#regisErr').addClass('error').text('* 대출금액이 비어있습니다 !');
	// 	$('#name').focus();
	// 	$('#result_table').remove();
	// 	return false;
	// }
	if (amount == null || amount == '') {
		alert('* 대출금액이 비어있습니다 !');
		$('#name').focus();
		$('#result_table').remove();
		return false;
	}
	if (interestYear == null || interestYear == '') {
		alert('* 연 이자율이 비어있습니다 !');
		$('#password').focus();
		$('#result_table').remove();
		return false;
	}
	if (redemption == null || redemption == '') {
		alert('* 상환기간이 비어있습니다 !');
		$('#email').focus();
		$('#result_table').remove();
		return false;
	}
	if (isBtnClick == 0) {
		alert('* 상환방식을 선택해주세요 !');
		return false;
	}

	principalPaid = amount / periodMonth;
	principalPaid_r = Math.round(principalPaid);
	principalPaid2 = resultFormat(principalPaid_r);
	exAccumulatedPayment = 0
	balance = amount;
	exBalance = balance;

	turn = _.range(1, (redemption + 1)); // underscore.js

	var showText = `<div class='totalTop'><div class='totalList'><h2>대출금액</h2><p><em class='amount_dot'>${amount_dot}</em><span>원</span></p></div><div class='totalList halfList'><h2>연 이자율</h2><p><em class='interestYear'>${interestYear}</em><span>%</span></p></div><div class='totalList halfList'><h2>상환기간</h2><p><em class='redemption'>${redemption}</em><span>개월</span></p></div><div class='totalList'><h2>상환방식</h2><p><span class='repayment'>${repayment}</span></p></div></div>`;
	
	//   
	// 납입원금 : ${principalPaid2}원
	// 이자 : ${interest2}원
	// 월상환금 : ${monthlyPayment2}원
	// 납임원금누계 : ${accumulatedPayment2}원
	// 잔금 : ${balance2}원

	errorText = `미구현`

	interest = amount - principalPaid;

	if (repayment.indexOf('원금균등상환') >= 0 ) {
		$('#regisErr').removeClass('error');
		$('#regisErr').addClass('success').html(showText);
		$('#regisErr').parent().removeClass('Hide');
		$('#regisErr').parent().addClass('Show');
		$('#result_table').remove();
		$('<div id="result_table"></div>').appendTo('.resultBox');
		$('<h2 id="result_thead">월 상환금액</h2>').appendTo('#result_table');
		$('<div id="result_tbody"></div>').appendTo('#result_table');
		$('#result_table').removeClass('error');
		// $('<th>납임원금누계</th>').appendTo('#result_thead');
		// $('<th>잔금</th>').appendTo('#result_thead');

		totalInterest = 0;

		turn.forEach(function (index, element) {
			interest = exBalance * monthlyRate;
			interest_r = Math.round(interest);
			interest2 = resultFormat(interest_r);
			balance = exBalance - principalPaid;
			balance_r = Math.round(balance);
			balance2 = resultFormat(balance_r);
			monthlyPayment = principalPaid + interest;
			monthlyPayment_r = Math.round(monthlyPayment);
			monthlyPayment2 = resultFormat(monthlyPayment_r);
			accumulatedPayment = exAccumulatedPayment + principalPaid;
			accumulatedPayment_r = Math.round(accumulatedPayment);
			accumulatedPayment2 = resultFormat(accumulatedPayment_r);
			if (index % 3 == 0 | index == 1 | turn.length == index) {
				$(`<div id="result_list_${index}" class="result_list"></div>`).appendTo('#result_tbody');
				$(`<div class="result_title">${index}회차</td>`).appendTo(`#result_list_${index}`);
				$(`<div class="principalPaid2"><span>납입원금</span><em>${principalPaid2}</em></div>`).appendTo(`#result_list_${index}`);
				$(`<div class="principalPaid2"><span>이자</span><em>${interest2}</em></div>`).appendTo(`#result_list_${index}`);
				$(`<div class="principalPaid2"><span>월 상환금</span><em>${monthlyPayment2}</em></div>`).appendTo(`#result_list_${index}`);
				// $(`<td class="td_${element}">${accumulatedPayment2}</td>`).appendTo(`#tr_${element}`);
				// $(`<td class="td_${element}">${balance2}</td>`).appendTo(`#tr_${element}`);
			};
			exBalance = balance;
			exAccumulatedPayment = accumulatedPayment;
			totalInterest += interest;
		});

		// 총 대출이자 & 총 상환금액
		totalRepaymentAmount = amount + totalInterest;
		totalInterest_r = Math.round(totalInterest);
		totalRepaymentAmount_r = Math.round(totalRepaymentAmount);
		totalInterest2 = resultFormat(totalInterest_r);
		totalRepaymentAmount2 = resultFormat(totalRepaymentAmount_r);

		regisErrText = $('#regisErr').html();
		totalText = `<div class="totalBtm"><div class="totalInterest2"><h2>총 대출이자</h2><p><em>${totalInterest2}</em><span>원</span></p></div><div class="totalRepaymentAmount2"><h2>총 상환금액</h2><p><em>${totalRepaymentAmount2}</em><span>원</span></p></div></div>`;
		$('#regisErr').html(`${regisErrText}${totalText}\n`);


	} else if (repayment.indexOf('만기일시상환') >= 0 ) {
		$('#regisErr').removeClass('error');
		$('#regisErr').addClass('success').html(showText);
		$('#regisErr').parent().removeClass('Hide');
		$('#regisErr').parent().addClass('Show');
		$('#result_table').remove();
		$('<div id="result_table"></div>').appendTo('.resultBox');
		$('<h2 id="result_thead">월 상환금액</h2>').appendTo('#result_table');
		$('<ul id="result_tbody"></ul>').appendTo('#result_table');
		$('#result_table').removeClass('error');
		$('<div id="result_list_1" class="result_list"></div>').appendTo('#result_tbody');
		round1 = `1~${periodMonth - 1}`;
		interest = balance * monthlyRate;
		interest_r = Math.round(interest);
		interest2 = resultFormat(interest_r);
		pay = amount + interest;
		pay_r = Math.round(pay);
		pay2 = resultFormat(pay_r);
		$(`<div class="result_title">${round1}회차</div>`).appendTo('#result_list_1');
		$(`<div class="principalPaid2"><span>이자</span><em>${interest2}</em></div>`).appendTo('#result_list_1');
		$(`<div class="principalPaid2"><span>원금</span><em>0</em></div>`).appendTo('#result_list_1');
		$(`<div class="principalPaid2"><span>내야하는 금액</span><em>${interest2}</em></div>`).appendTo('#result_list_1');
		$('<div id="result_list_2" class="result_list"></tr>').appendTo('#result_tbody');
		$(`<div class="result_title">${periodMonth}회차</div>`).appendTo('#result_list_2');
		$(`<div class="principalPaid2"><span>이자</span><em>${interest2}</em></div>`).appendTo('#result_list_2');
		$(`<div class="principalPaid2"><span>원금</span><em>${amount_dot}</em></div>`).appendTo('#result_list_2');
		$(`<div class="principalPaid2"><span>내야하는 금액</span><em>${pay2}</em></div>`).appendTo('#result_list_2');

		// 총 대출이자 & 총 상환금액
		totalInterest = interest * redemption;
		totalInterest_r = Math.round(totalInterest);
		totalRepaymentAmount = amount + totalInterest;
		totalRepaymentAmount_r = Math.round(totalRepaymentAmount);
		totalInterest2 = resultFormat(totalInterest_r);
		totalRepaymentAmount2 = resultFormat(totalRepaymentAmount_r);

		regisErrText = $('#regisErr').html();
		totalText = `<div class="totalBtm"><div class="totalInterest2"><h2>총 대출이자</h2><p><em>${totalInterest2}</em><span>원</span></p></div><div class="totalRepaymentAmount2"><h2>총 상환금액</h2><p><em>${totalRepaymentAmount2}</em><span>원</span></p></div></div>`;
		$('#regisErr').html(`${regisErrText}${totalText}\n`);


	} else if (repayment.indexOf('원리금균등상환') >= 0 ) {
		$('#regisErr').removeClass('error');
		$('#regisErr').addClass('success').html(showText);
		$('#regisErr').parent().removeClass('Hide');
		$('#regisErr').parent().addClass('Show');
		$('#result_table').remove();
		$('<div id="result_table"></div>').appendTo('.resultBox');
		$('<h2 id="result_thead">월 상환금액</h2>').appendTo('#result_table');
		$('<div id="result_tbody"></div>').appendTo('#result_table');
		$('#result_table').removeClass('error');
		// $('<th>납임원금누계</th>').appendTo('#result_thead');
		// $('<th>잔금</th>').appendTo('#result_thead');

		totalInterest = 0;

		turn.forEach(function (element, index) {
			// console.log(element);
			ppmt = Math.abs(ExcelFormulas.PPMT(monthlyRate, element, periodMonth, amount));
			ppmt_r = Math.round(ppmt);
			ppmt2 = resultFormat(ppmt_r);
			pmt = ExcelFormulas.PMT(monthlyRate, periodMonth, amount);
			ipmt = Math.abs(ExcelFormulas.IPMT(amount, pmt, monthlyRate, element - 1));
			impt_r = Math.round(ipmt);
			ipmt2 = resultFormat(impt_r);
			interest = exBalance * monthlyRate;
			interest_r = Math.round(interest);
			interest2 = resultFormat(interest_r);
			balance = exBalance - ppmt;
			balance_r = Math.round(balance);
			balance2 = resultFormat(balance_r);
			monthlyPayment = ppmt + ipmt;
			monthlyPayment_r = Math.round(monthlyPayment);
			monthlyPayment2 = resultFormat(monthlyPayment_r);
			accumulatedPayment = exAccumulatedPayment + ppmt;
			accumulatedPayment_r = Math.round(accumulatedPayment);
			accumulatedPayment2 = resultFormat(accumulatedPayment_r);
			if (element % 3 == 0 | element == 1 | turn.length == element) {
				$(`<div id="result_list_${element}" class="result_list"></div>`).appendTo('#result_tbody');
				$(`<div class="result_title">${element}회차</td>`).appendTo(`#result_list_${element}`);
				$(`<div class="principalPaid2"><span>이자</span><em>${ppmt2}</em></div>`).appendTo(`#result_list_${element}`);
				$(`<div class="principalPaid2"><span>원금</span><em>${ipmt2}</em></div>`).appendTo(`#result_list_${element}`);
				$(`<div class="principalPaid2"><span>내야하는 금액</span><em>${monthlyPayment2}</em></div>`).appendTo(`#result_list_${element}`);
				// $(`<td class="td_${element}">${accumulatedPayment2}</td>`).appendTo(`#tr_${element}`);
				// $(`<td class="td_${element}">${balance2}</td>`).appendTo(`#tr_${element}`);				

			};
			exBalance = balance;
			exAccumulatedPayment = accumulatedPayment;
			totalInterest += interest;

		});

		// 총 대출이자 & 총 상환금액
		totalRepaymentAmount = amount + totalInterest;
		totalInterest_r = Math.round(totalInterest);
		totalRepaymentAmount_r = Math.round(totalRepaymentAmount);
		totalInterest2 = resultFormat(totalInterest_r);
		totalRepaymentAmount2 = resultFormat(totalRepaymentAmount_r);

		regisErrText = $('#regisErr').html();
		totalText = `<div class="totalBtm"><div class="totalInterest2"><h2>총 대출이자</h2><p><em>${totalInterest2}</em><span>원</span></p></div><div class="totalRepaymentAmount2"><h2>총 상환금액</h2><p><em>${totalRepaymentAmount2}</em><span>원</span></p></div></div>`;
		$('#regisErr').html(`${regisErrText}${totalText}\n`);
	} else {
		$('#regisErr').removeClass('success');
		$('#regisErr').addClass('error').text(errorText);
		$('#regisErr').parent().removeClass('Show');
		$('#regisErr').parent().addClass('Hide');
		$('#result_table').remove();
	}

}