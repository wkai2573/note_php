let map =
`00000100
0C000100
0110Z000
01110000
0X100000
001Y0000
00000000`;

let map2 =
`0000Y100
0C011100
0111X000`;

let map3 =
`0000Y100
0C011100`;

let a = solution(map3);
a


// 1. 建立map
// 2. 紀錄所有貓鼠位置:CXYZ
//*3. 遞迴算出貓鼠各自最短距離
// 4. 迴圈 C>[鼠的排列組合], 得出最短路徑
// 5. 輸出結果
function solution(rawMap) {
	//1. 建立map
	let map = rawMap.split('\n').map(t=>t.split(''));
	let yLen = map.length;    //yLen
	let xLen = map[0].length; //xLen

	//2. 紀錄所有貓鼠位置:CXYZ
	let animalPos = {};
	for (let y = 0; y < yLen; y++) {
		for (let x = 0; x < xLen; x++) {
			let e = map[y][x];
			if (['C','X','Y','Z'].includes(e)) {
				animalPos[e] = [y,x];
			}
		}
	}
	// animalPos

	// return 兩位置最短距離(map, xy(animalPos['C']), xy(animalPos['X'])); //!

	//3. 遞迴算出貓鼠各自最短距離
	let short = {}; //['CX':1, 'CY':2]
	let animalArr = Object.keys(animalPos);
	for (let i = 0; i < animalArr.length - 1; i++) {
		let a1 = animalArr[i]; //a1 = 動物1
		let a1Pos = animalPos[a1];
		for (let j = i+1; j < animalArr.length; j++) {
			let a2 = animalArr[j];
			let a2Pos = animalPos[a2];
			let sDistance = getShortDistance(map, xy(a1Pos), xy(a2Pos));
			if (sDistance=='無解') return '無解';
			short[`${a1},${a2}`] = sDistance;
		}
	}
	// short

	//3a. 整理最短距離
	let shortByAnimal = {};
	Object.keys(short).forEach(key=>{
		let distance = short[key];
		let [a1, a2] = key.split(',');
		if (!shortByAnimal[a1]) shortByAnimal[a1] = {};
		shortByAnimal[a1][a2] = distance;
		if (!shortByAnimal[a2]) shortByAnimal[a2] = {};
		shortByAnimal[a2][a1] = distance;
	});
	shortByAnimal
	
	//4. 迴圈 C>[鼠的排列組合], 得出最短路徑
	let rats = Object.keys(shortByAnimal['C']); //[X,Y,Z]
	let 排列組合 = getAllComb(rats).map(t=>'C'+t);
	let paths = 排列組合.map(組合=>{
		let 組合arr = 組合.split('');
		let total = 0;
		let step = '';
		for (let i = 0; i < 組合arr.length - 1; i++) {
			let now = 組合arr[i];
			let next = 組合arr[i+1];
			let distance = shortByAnimal[now][next];
			total += distance;
			step += `${distance}${next}`;
		}
		return {組合, total, step};
	});
	paths

	//5. 輸出結果
	let min = Math.min(...paths.map(t=>t.total));
	let minPath = paths.find(p=>p.total == min);
	
	return minPath.step;
}

// var aaa = 取得所有組合(['a','b']);
// var aaa = 取得所有組合(['a','b','c']);
function getAllComb(arr) {
	if (arr.length == 1) return [arr[0]];
	
	let 組合 = [];
	for (let i = 0; i < arr.length; i++) {
		let others = arr.slice(0);
		let item = others.splice(i, 1);
		let 所有組合 = getAllComb(others).map(t=>item + t);
		組合.push(...所有組合);
	}
	return 組合;
}

//轉物件xy
function xy(pos) {
	return {y:pos[0], x:pos[1]};
}

//get2位置最短距離
function getShortDistance(map, sPos, tPos, 步數=0, savedPos=[]) {
	//! 加速:保存結果存在外部陣列
	if (步數>12) return '無解';
	//紀錄經過路線
	savedPos.push(sPos);

	//建立上下左右pos
	let 上 = !map[sPos.y-1]? '1' : map[sPos.y-1][sPos.x];
	let 上pos = {y:sPos.y-1, x:sPos.x};
	if (isSome(tPos, 上pos)) return 步數;
	let 下 = !map[sPos.y+1]? '1' : map[sPos.y+1][sPos.x];
	let 下pos = {y:sPos.y+1, x:sPos.x};
	if (isSome(tPos, 下pos)) return 步數;
	let 左 = !map[sPos.y][sPos.x-1]? '1' : map[sPos.y][sPos.x-1];
	let 左pos = {y:sPos.y, x:sPos.x-1};
	if (isSome(tPos, 左pos)) return 步數;
	let 右 = !map[sPos.y][sPos.x+1]? '1' : map[sPos.y][sPos.x+1];
	let 右pos = {y:sPos.y, x:sPos.x+1};
	if (isSome(tPos, 右pos)) return 步數;

	//往上下左右
	let paths = [];
	if (上!=='1' && !isContain(savedPos, 上pos)) {
		let d = getShortDistance(map, 上pos, tPos, 步數+1, savedPos);
		paths.push(d);
	}
	if (下!=='1' && !isContain(savedPos, 下pos)) {
		let d = getShortDistance(map, 下pos, tPos, 步數+1, savedPos);
		paths.push(d);
	}
	if (左!=='1' && !isContain(savedPos, 左pos)) {
		let d = getShortDistance(map, 左pos, tPos, 步數+1, savedPos);
		paths.push(d);
	}
	if (右!=='1' && !isContain(savedPos, 右pos)) {
		let d = getShortDistance(map, 右pos, tPos, 步數+1, savedPos);
		paths.push(d);
	}

	paths = paths.filter(t=>t!='無解');
	if (paths.length == 0) return '無解';
	return Math.min(...paths);
}

function isContain(posArr, pos) {
	return posArr.some(p=>isSome(p,pos));
}

function isSome(pos1, pos2) {
	return pos1.y==pos2.y && pos1.x==pos2.x;
}



