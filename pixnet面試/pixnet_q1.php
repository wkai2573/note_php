<?

/**
 * Q1.請改寫這段程式，減少其巢狀結構層數，並且不影響原有程式需求，方法可以參考 Guard Clauses
 */

function getUserArticles($user_id, $article_id) {
	if (!$user_id || !$article_id) return null;

	$user = User::getUser($user_id);
	if (!$user) throw new Exception("查無此帳號!");

	$blog = $user->blog;
	if (!$blog) throw new Exception("帳號尚未有部落格!");

	$article = $blog->getArticle($article_id);
	if (!$article) throw new Exception("此帳號無此文章!");

	return $article;
}

?>