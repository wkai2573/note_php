let map =
`0X00Y10Z
0C011100`;

let a = solution(map);

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

	//3. 遞迴算出貓鼠各自最短距離
	let short = {}; //['CX':1, 'CY':2]
	let animalArr = Object.keys(animalPos);
	for (let i = 0; i < animalArr.length - 1; i++) {
		let a1 = animalArr[i]; //a1 = 動物1
		let a1Pos = animalPos[a1];
		for (let j = i+1; j < animalArr.length; j++) {
			let a2 = animalArr[j];
			let a2Pos = animalPos[a2];
			short[`${a1},${a2}`] = 取得2位置最短路徑(map, a1Pos, a2Pos);
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
	let paths = [];

	let rats = Object.keys(shortByAnimal['C']); //[X,Y,Z]
	let 排列組合 = 取得所有組合(rats).map(t=>'C'+t);
	let 距離 = 排列組合.map(組合=>{
		let 組合arr = 組合.split('');

		let total = 0;
		for (let i = 0; i < 組合arr.length - 1; i++) {
			total += shortByAnimal[組合arr[0]][組合arr[1]];
		}
		return {組合, total};
	});

	距離
	//5. 輸出結果

	

	return 'OuO';
}

// var aaa = 取得所有組合(['a','b']);
// var aaa = 取得所有組合(['a','b','c']);

function 取得所有組合(arr) {
	if (arr.length == 1) return [arr[0]];
	
	let 組合 = [];
	for (let i = 0; i < arr.length; i++) {
		let others = arr.slice(0);
		let item = others.splice(i, 1);
		let 所有組合 = 取得所有組合(others).map(t=>item + t);
		組合.push(...所有組合);
	}
	return 組合;
}

function 取得2位置最短路徑(map, pos1, pos2) {
	return pos1[0] + pos1[1] + pos2[0] + pos2[1];
}
