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

$map = <<<s
0000Y100
0C011100
s;

die(json_encode(solution($map)));

function solution($map) {

	$mapArr = preg_split("/\r\n/", $map);


	return $mapArr;

}



?>