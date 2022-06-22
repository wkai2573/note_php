<?
// $a = 1;
// die(json_encode($a));


// $a1 = getUserArticles_原題目('123', '456');
// $a2 = getUserArticles_new('123', '456');



//Q1__________________________________________________

class Blog {
	public $article_id = "";

	function __construct($article_id) {
		$this->article_id = $article_id;
	}

	function getArticle($article_id) {
		return $article_id;
	}
}

class User {
	public $user_id = "";
	public $blog = null;

	function __construct($user_id){
		$this->user_id = $user_id;
		$this->blog = new Blog($user_id . "_art");
	}

	public static function getUser($user_id) {
		return new User($user_id);
	}
}

function getUserArticles_原題目($user_id, $article_id) {
	if ($user_id && $article_id) {
		if ($user = User::getUser($user_id)) {
			if ($blog = $user->blog) {
				if ($article = $blog->getArticle($article_id)) {
					return $article;
				} else {
					throw new Exception("此帳號無此文章!");
				}
			} else {
				throw new Exception("帳號尚未有部落格!");
			}
		} else {
			throw new Exception("查無此帳號!");
		}
	}

	return null;
}

function getUserArticles_new($user_id, $article_id) {
	if (!$user_id || !$article_id) return null;

	$user = User::getUser($user_id);
	if (!$user) throw new Exception("查無此帳號!");

	$blog = $user->blog;
	if (!$blog) throw new Exception("帳號尚未有部落格!");

	$article = $blog->getArticle($article_id);
	if (!$article) throw new Exception("此帳號無此文章!");

	return $article;
}

//!Q2__________________________________________________


function getPrice($貨運商, $地區, $重量) {
	//向上取整數
	$重量 = ceil($重量);

	if ($貨運商 == 'Dog') {
		if ($地區 == '美國') return $重量 * 60;
		throw new Exception("無效地區");

	} else if ($貨運商 == 'Falcon') {
		if ($地區 == '大陸') return 200 + $重量 * 20;
		if ($地區 == '台灣') {
			if ($重量 <= 5) return 150;
			return 150 + ($重量-5) * 30;
		}
		throw new Exception("無效地區");

	} else if ($貨運商 == 'Cat') {
		if ($地區 == '台灣') {
			return 100 + ceil($重量/3) * 10;
		}
		throw new Exception("無效地區");
	}
 
	throw new Exception("無效貨運商");
}

//Q3__________________________________________________

$map1 = <<<s
00000100
0C000100
0110Z000
01110000
0X100000
001Y0000
00000000
s;

$map2 = <<<s
0000Y100
0C011100
0111X000
s;

$map3 = <<<s
0000Y100
0C011100
s;


$ans = solution($map1);
die($ans);

function solution($rawMap) {
	//1. 建立map
	$map = preg_split("/[\r\n]+/", $rawMap);
	$yLen = count($map);
	$xLen = strlen($map[0]);

	//2. 紀錄所有貓鼠位置:CXYZ
	$animalPos = [];
	for ($y = 0; $y < $yLen; $y++) {
		for ($x = 0; $x < $xLen; $x++) {
			$e = $map[$y][$x];
			if (in_array($e, ['C','X','Y','Z'])) {
				$animalPos[$e] = [$y, $x];
			}
		}
	}

	//3. 遞迴算出貓鼠各自最短距離
	$short = []; //['CX':1, 'CY':2]
	$animalArr = array_keys($animalPos);
	for ($i = 0; $i < count($animalArr) - 1; $i++) {
		$a1 = $animalArr[$i]; //a1 = 動物1
		$a1Pos = $animalPos[$a1];
		for ($j = $i+1; $j < count($animalArr); $j++) {
			$a2 = $animalArr[$j];
			$a2Pos = $animalPos[$a2];
			$sDistance = getShortDistance($map, xy($a1Pos), xy($a2Pos));
			if ($sDistance=='無解') return '無解';
			$short["$a1,$a2"] = $sDistance;
		}
	}

	//3a. 整理最短距離
	$shortByAnimal = [];
	foreach ($short as $key => $distance) {
		list($a1, $a2) = explode(',', $key);
		if (!isset($shortByAnimal[$a1])) $shortByAnimal[$a1] = [];
		$shortByAnimal[$a1][$a2] = $distance;
		if (!isset($shortByAnimal[$a2])) $shortByAnimal[$a2] = [];
		$shortByAnimal[$a2][$a1] = $distance;
	}
	
	//4. 迴圈 C>[鼠的排列組合], 得出最短路徑
	$rats = array_keys($shortByAnimal['C']); //[X,Y,Z]
	$排列組合 = array_map(function($t){return "C$t";}, getAllComb($rats));
	$paths = array_map(function($組合) use($shortByAnimal) {
		$組合arr = preg_split("//", $組合, -1, PREG_SPLIT_NO_EMPTY);
		$total = 0;
		$step = '';
		for ($i = 0; $i < count($組合arr) - 1; $i++) {
			$now = $組合arr[$i];
			$next = $組合arr[$i+1];
			$distance = $shortByAnimal[$now][$next];
			$total += $distance;
			$step .= $distance.$next;
		}
		return ['組合'=>$組合, 'total'=>$total, 'step'=>$step];
	}, $排列組合);

	//5. 輸出結果
	$totalArr = array_map(function($t){return $t['total'];}, $paths);
	$min = min($totalArr);
	
	foreach ($paths as $p) {
		if ($p['total'] === $min) return $p['step'];
	}
	return '無解';
}

//取得所有組合
function getAllComb($arr) {
	if (count($arr) == 1) return [$arr[0]];
	
	$組合 = [];
	for ($i = 0; $i < count($arr); $i++) {
		$others = [];
		$item = '';
		foreach ($arr as $j => $t) {
			if ($i==$j) $item = $t;
			else $others[] = $t;
		}

		// getAllComb(others).map(t=>item + t);
		$所有組合 = array_map(function($t)use($item){return $item.$t;}, getAllComb($others));

		foreach ($所有組合 as $item)
			$組合[] = $item; //組合.push(...所有組合);
	}
	return $組合;
}

//轉物件xy
function xy($pos) {
	return ['y'=>$pos[0], 'x'=>$pos[1]];
}

//get2位置最短距離
function getShortDistance($map, $sPos, $tPos, $步數=0, $savedPos=[]) {
	//! 加速:保存結果存在外部陣列
	if ($步數>12) return '無解';
	//紀錄經過路線
	$savedPos[] = $sPos;

	//建立上下左右pos
	$上 = !isset($map[$sPos['y']-1])? '1' : $map[$sPos['y']-1][$sPos['x']];
	$上pos = ['y'=>$sPos['y']-1, 'x'=>$sPos['x']];
	if (isSome($tPos, $上pos)) return $步數;
	$下 = !isset($map[$sPos['y']+1])? '1' : $map[$sPos['y']+1][$sPos['x']];
	$下pos = ['y'=>$sPos['y']+1, 'x'=>$sPos['x']];
	if (isSome($tPos, $下pos)) return $步數;
	$左 = !isset($map[$sPos['y']][$sPos['x']-1])? '1' : $map[$sPos['y']][$sPos['x']-1];
	$左pos = ['y'=>$sPos['y'], 'x'=>$sPos['x']-1];
	if (isSome($tPos, $左pos)) return $步數;
	$右 = !isset($map[$sPos['y']][$sPos['x']+1])? '1' : $map[$sPos['y']][$sPos['x']+1];
	$右pos = ['y'=>$sPos['y'], 'x'=>$sPos['x']+1];
	if (isSome($tPos, $右pos)) return $步數;

	//往上下左右
	$paths = [];
	if ($上!=='1' && !isContain($savedPos, $上pos)) {
		$d = getShortDistance($map, $上pos, $tPos, $步數+1, $savedPos);
		$paths[] = $d;
	}
	if ($下!=='1' && !isContain($savedPos, $下pos)) {
		$d = getShortDistance($map, $下pos, $tPos, $步數+1, $savedPos);
		$paths[] = $d;
	}
	if ($左!=='1' && !isContain($savedPos, $左pos)) {
		$d = getShortDistance($map, $左pos, $tPos, $步數+1, $savedPos);
		$paths[] = $d;
	}
	if ($右!=='1' && !isContain($savedPos, $右pos)) {
		$d = getShortDistance($map, $右pos, $tPos, $步數+1, $savedPos);
		$paths[] = $d;
	}

	$paths = array_filter($paths, function($t){return $t!='無解';});
	if (count($paths) == 0) return '無解';
	return min($paths);
}

function isContain($posArr, $pos) {
	foreach ($posArr as $p) {
		if (isSome($p,$pos)) return true;
	}
	return false;
}

function isSome($pos1, $pos2) {
	return $pos1['y']==$pos2['y'] && $pos1['x']==$pos2['x'];
}


?>