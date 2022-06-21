var map =
`0000Y100
0C011100`;

var a = solution(map);

a


// 1. 建立map
// 2. 找出所有貓鼠 CXYZ, 紀錄位置
//*3. 遞迴算出貓鼠各自"最短"距離
// 4. 迴圈 C>[鼠的排列組合], 得出最短路徑
// 5. 輸出結果
function solution(map) {
	var mapArr = map.split('\n').map(t=>t.split(''));
	var yLen = mapArr.length;    yLen
	var xLen = mapArr[0].length; xLen


	return mapArr;
}