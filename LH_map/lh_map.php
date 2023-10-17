<?php

include './db2.php';

$sql = query("SELECT * FROM lh_gonggo WHERE PAN_SS != '접수마감' AND LGDN_ADR1 != ''");

// 지역 선택 기능 추가
// $region = $_GET['region'];
// $sql = query("SELECT * FROM lh_gonggo WHERE PAN_SS != '접수마감' AND LGDN_ADR1 != '' AND CNP_CD_NM LIKE '%{$region}%'");

$dataArr = array();

foreach ($sql as $val) {
	$item = [
		'x' => $val['Longitude'],
		'y' => $val['Latitude'],
		'AIS_TP_CD_NM' => $val['AIS_TP_CD_NM'],
		'CNP_CD_NM' => $val['CNP_CD_NM'],
		'PAN_NM' => $val['PAN_NM'],
		'PAN_SS' => $val['PAN_SS'],
		'DTL_URL_MOB' => $val['DTL_URL_MOB'],
		'LGDN_ADR1' => $val['LGDN_ADR1'],
		'LGDN_ADR2' => $val['LGDN_ADR2'],
		'LCC_NT_NM' => $val['LCC_NT_NM'],
		'PAN_DT' => $val['PAN_DT'],
		'CLSG_DT' => $val['CLSG_DT']
	];

	array_push($dataArr, $item);
}
$jsonData = json_encode($dataArr, JSON_UNESCAPED_UNICODE);

// ======= LH ↑ / 청약 ↓ =======
$dataArr2 = array();
$today = date('Y-m-d');

// 아파트
$sql2 = query("SELECT * FROM newhome_apartment");
foreach ($sql2 as $val) {
	$startDate = $val['RCEPT_BGNDE'];
	$endDate = $val['RCEPT_ENDDE'];

	if(strtotime($endDate) >= strtotime($today) && strtotime($startDate) < strtotime($today)) {
		$item2 = [
			'x' => $val['Longitude'],
			'y' => $val['Latitude'],
			'HOUSE_NM' => $val['HOUSE_NM'],
			'PBLANC_URL' => $val['PBLANC_URL'],
			'RCEPT_BGNDE' => $val['RCEPT_BGNDE'],
			'RCEPT_ENDDE' => $val['RCEPT_ENDDE'],
			'SUBSCRPT_AREA_CODE_NM' => $val['SUBSCRPT_AREA_CODE_NM'],
			'HSSPLY_ADRES' => $val['HSSPLY_ADRES'],
			'state' => '공고중',
			'cls' => '청약 (아파트)'
		];
		array_push($dataArr2, $item2);		
	} else if (strtotime($startDate) > strtotime($today)) {
		$item2 = [
			'x' => $val['Longitude'],
			'y' => $val['Latitude'],
			'HOUSE_NM' => $val['HOUSE_NM'],
			'PBLANC_URL' => $val['PBLANC_URL'],
			'RCEPT_BGNDE' => $val['RCEPT_BGNDE'],
			'RCEPT_ENDDE' => $val['RCEPT_ENDDE'],
			'SUBSCRPT_AREA_CODE_NM' => $val['SUBSCRPT_AREA_CODE_NM'],
			'HSSPLY_ADRES' => $val['HSSPLY_ADRES'],
			'state' => '공고 대기중',
			'cls' => '청약 (아파트)'
		];
		array_push($dataArr2, $item2);		
	}
}

// 아파트 무순위
$sql3 = query("SELECT * FROM newhome_apartment_norank");
foreach ($sql3 as $val) {
	$startDate = $val['SUBSCRPT_RCEPT_BGNDE'];
	$endDate = $val['SUBSCRPT_RCEPT_ENDDE'];

	if(strtotime($endDate) >= strtotime($today) && strtotime($startDate) < strtotime($today)) {
		$item2 = [
			'x' => $val['Longitude'],
			'y' => $val['Latitude'],
			'HOUSE_NM' => $val['HOUSE_NM'],
			'PBLANC_URL' => $val['PBLANC_URL'],
			'RCEPT_BGNDE' => $val['SUBSCRPT_RCEPT_BGNDE'],
			'RCEPT_ENDDE' => $val['SUBSCRPT_RCEPT_ENDDE'],
			'HSSPLY_ADRES' => $val['HSSPLY_ADRES'],
			'state' => '공고중',
			'cls' => '청약 (아파트 무순위)'
		];
		array_push($dataArr2, $item2);		
	} else if (strtotime($startDate) > strtotime($today)) {
		$item2 = [
			'x' => $val['Longitude'],
			'y' => $val['Latitude'],
			'HOUSE_NM' => $val['HOUSE_NM'],
			'PBLANC_URL' => $val['PBLANC_URL'],
			'RCEPT_BGNDE' => $val['SUBSCRPT_RCEPT_BGNDE'],
			'RCEPT_ENDDE' => $val['SUBSCRPT_RCEPT_ENDDE'],
			'HSSPLY_ADRES' => $val['HSSPLY_ADRES'],
			'state' => '공고 대기중',
			'cls' => '청약 (아파트 무순위)'
		];
		array_push($dataArr2, $item2);		
	}
}

//오피스텔
$sql4 = query("SELECT * FROM newhome_office");
foreach ($sql4 as $val) {
	$startDate = $val['SUBSCRPT_RCEPT_BGNDE'];
	$endDate = $val['SUBSCRPT_RCEPT_ENDDE'];

	if(strtotime($endDate) >= strtotime($today) && strtotime($startDate) < strtotime($today)) {
		$item2 = [
			'x' => $val['Longitude'],
			'y' => $val['Latitude'],
			'HOUSE_NM' => $val['HOUSE_NM'],
			'PBLANC_URL' => $val['PBLANC_URL'],
			'RCEPT_BGNDE' => $val['SUBSCRPT_RCEPT_BGNDE'],
			'RCEPT_ENDDE' => $val['SUBSCRPT_RCEPT_ENDDE'],
			'HSSPLY_ADRES' => $val['HSSPLY_ADRES'],
			'state' => '공고중',
			'cls' => '청약 (오피스텔)'
		];
		array_push($dataArr2, $item2);		
	} else if (strtotime($startDate) > strtotime($today)) {
		$item2 = [
			'x' => $val['Longitude'],
			'y' => $val['Latitude'],
			'HOUSE_NM' => $val['HOUSE_NM'],
			'PBLANC_URL' => $val['PBLANC_URL'],
			'RCEPT_BGNDE' => $val['SUBSCRPT_RCEPT_BGNDE'],
			'RCEPT_ENDDE' => $val['SUBSCRPT_RCEPT_ENDDE'],
			'HSSPLY_ADRES' => $val['HSSPLY_ADRES'],
			'state' => '공고 대기중',
			'cls' => '청약 (오피스텔)'
		];
		array_push($dataArr2, $item2);		
	}
}

$jsonData2 = json_encode($dataArr2, JSON_UNESCAPED_UNICODE);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<?php include "./front_header.php";?>
	<!-- Leaflet -->
	<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
	<!-- Leaflet.markercluster 플러그인 -->
	<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
	<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
	<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>

	<link rel="stylesheet" href="./css/lh_map.css">
</head>
<body>
	<div id="wrap">
 		<!--지역선택 탭 -->
<!-- 		<div class="area_wrap">
			<a href="?region=전국">전국</a>
			<a href="?region=서울">서울</a>
			<a href="?region=경기">경기</a>
			<a href="?region=인천">인천</a>
			<a href="?region=부산">부산</a>
			<a href="?region=대구">대구</a>
			<a href="?region=대전">대전</a>
			<a href="?region=세종">세종</a>
			<a href="?region=강원">강원</a>
			<a href="?region=울산">울산</a>
			<a href="?region=경북">경북</a>
			<a href="?region=경남">경남</a>
			<a href="?region=광주">광주</a>
			<a href="?region=전북">전북</a>
			<a href="?region=전남">전남</a>
			<a href="?region=충북">충북</a>
			<a href="?region=충남">충남</a>
			<a href="?region=제주도">제주도</a>
		</div>		 -->
		<div id="map"></div>
		<div class="marker_info">
			<p><img src="./img/map-1.png" alt="임대"> 임대</p>
			<p><img src="./img/map-2.png" alt="청약"> 청약</p>
		</div>
		<div id="info_box"></div>
	</div>
</body>
<script>
var addresses1 = <?php echo $jsonData; ?>;
var addresses2 = <?php echo $jsonData2; ?>;
console.log(addresses2);

var map = L.map('map').setView([36.2, 127.7], 7);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);



// LH 마커
var markers1 = L.markerClusterGroup({
    maxClusterRadius: 80,
});


addresses1.forEach(arr => {
	var latArr = arr['x'].split('||');
    	var lonArr = arr['y'].split('||');
	var name = arr['LCC_NT_NM'].split('||');
	var url = arr['DTL_URL_MOB'];
	
	var lh_m_remove =  url.replace('https://m.', 'https://');

	latArr.forEach(function(lat, idx) {
		var lon = lonArr[idx];
		var customMarker1 = L.divIcon({
			className: 'custom_marker_red',
			iconAnchor: [17, 40]
		});

		var markerVal1 = L.marker([lon, lat], { icon: customMarker1 });
		markerVal1.on('click', function () {
			$('#info_box').empty();
			map.setView([lon, lat], 17);
			var infoBox = document.querySelector('#info_box');
			if(infoBox.classList.contains('newhome')) {
				infoBox.classList.remove('newhome');
			}
			infoBox.classList.add('lh');
			var detailDiv = document.createElement('div');
			detailDiv.classList.add('detail_wrap');

			// 청약명
			var nameA = document.createElement('a');
			nameA.classList.add('name_link');
			nameA.href = lh_m_remove;
			nameA.textContent = name[idx];
			infoBox.appendChild(nameA);

			// 공고 분류
			var clsP = document.createElement('p');
			clsP.classList.add('cls');
			clsP.textContent = arr['AIS_TP_CD_NM'];
			detailDiv.appendChild(clsP);
			
			// 공고 상황
			var stateP = document.createElement('p');
			stateP.classList.add('state');
			stateP.textContent = arr['PAN_SS'];
			detailDiv.appendChild(stateP);

			// 공고기간
			var periodP = document.createElement('p');
			var str = arr['PAN_DT'].replace(/^(.{4})(.{2})/, '$1.$2.');
			var end = arr['CLSG_DT'];
			periodP.textContent = `${str} ~ ${end}`;
			periodP.classList.add('period');
			detailDiv.appendChild(periodP);

			infoBox.appendChild(detailDiv);

        });
        markers1.addLayer(markerVal1);
		markerVal1.bindPopup(arr['AIS_TP_CD_NM']).openPopup();
	});
});

map.addLayer(markers1);


//청약 마커
var markers2 = L.markerClusterGroup({
    maxClusterRadius: 80
});

addresses2.forEach(arr => {
    	var latArr = arr['x'].split('||');
    	var lonArr = arr['y'].split('||');
	var name = arr['HOUSE_NM'].split('||');
	var url = arr['PBLANC_URL'];
	var lh_m_remove =  url.replace('https://m.', 'https://');

	latArr.forEach(function(lat, idx) {
		var lon = lonArr[idx];
		var customMarker1 = L.divIcon({
			className: 'custom_marker_blue',
			iconAnchor: [17, 40]
		});

		var markerVal2 = L.marker([lon, lat], { icon: customMarker1 });
		markerVal2.on('click', function () {
			$('#info_box').empty();
			map.setView([lon, lat], 17);
			var infoBox = document.querySelector('#info_box');
			if(infoBox.classList.contains('lh')) {
				infoBox.classList.remove('lh');
			}
			infoBox.classList.add('newhome');
			var detailDiv = document.createElement('div');
			detailDiv.classList.add('detail_wrap');

			// 청약명
			var nameA = document.createElement('a');
			nameA.classList.add('name_link');
			nameA.href = lh_m_remove;
			nameA.textContent = name[idx];
			infoBox.appendChild(nameA);

			// 공고 분류
			var clsP = document.createElement('p');
			clsP.classList.add('cls');
			clsP.textContent = arr['cls'];
			detailDiv.appendChild(clsP);
			
			// 공고 상황
			var stateP = document.createElement('p');
			stateP.classList.add('state');
			stateP.textContent = arr['state'];
			detailDiv.appendChild(stateP);

			// 공고기간
			var periodP = document.createElement('p');
			var str = arr['RCEPT_BGNDE'];
			var end = arr['RCEPT_ENDDE'];
			periodP.textContent = `${str} ~ ${end}`;
			periodP.classList.add('period');
			detailDiv.appendChild(periodP);

			infoBox.appendChild(detailDiv);

        });
        markers1.addLayer(markerVal2);
		markerVal2.bindPopup(arr['cls']).openPopup();
	});

});

map.addLayer(markers2);


// 클러스터 컬러 변환
function zoomInOut() {
	var clusterAll = document.querySelectorAll('.marker-cluster');
	clusterAll.forEach(arr => {
		if(Number(arr.innerText) > 50){
			//console.log('50보다 큼');
			arr.classList.add('lg');
		} else if (Number(arr.innerText) > 29) {
			//console.log('29보다 큼');
			arr.classList.add('md');
		} else {
			//console.log('29보다 작음');
			arr.classList.add('sm');		
		}
	});
}

window.onload = function() {
	zoomInOut();
}

map.on('zoomend, moveend', function () {
	zoomInOut();
});
</script>
</html>
