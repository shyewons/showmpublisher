# LH 공고 DB map 
## 설명
LH 공고와 청약 공고 DB에 포함되어 있는 x,y 좌표 값을 이용하여 지도에 표시함

---

## 사용 DB
- apidb
1. lh_gonggo
2. newhome_apartment
3. newhome_apartment_norank
4. newhome_office
   
---
## 개별 파일 설명
- lh_map.php
  : DB query, js 모두 포함하고 있음 
  : 청약은 3개의 DB를 하나의 배열로 합침 (아파트, 무순위, 오피스텔)

## 변경 내역
231017 : 지역 탭 추가 (혜원)
