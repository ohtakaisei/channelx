<?PHP

$link = mysql_connect('localhost','root','orehakami','oneline-bbs');
if (!$link) {
    die('データベースに接続できません:'.mysql_error());
}

mysql_select_db('online_bbs',$link);

$errors = array();

if ($_SERVER['REQUEST_METHOD'] ==='POST') {
    $name = null;
    if (!isset($_POST['name']) || !strlen($_POST['name'])) {
        $errors['name'] = '名前書いてくださいな';
    } else if (strlen($_POST['name']) > 40) {
        $errors['name'] = '名前は40文字以内で入力してね！';
    }else {
        $name = $_POST['name'];
    }


// 投稿がちゃんと入力されているかのチェック
$comment = null;
if(!isset($_POST['comment']) || !strlen($_POST['comment'])) {
    $errors['comment'] = '何かを入力してください';
} else if (strlen($_POST['comment']) > 200) {
    $errors['comment'] = '投稿は200字以内で入力してください';
}else {
    $comment = $_POST['comment'];
}

// エラーがなければ保存する
if (count($errors) === 0) {
    // 保存するためのSQL文を作成
    $sql = "INSERT INTO `post` (`name`,`comment`,`created_at`) VALUES ('"
    .mysql_real_escape_string($name)."','"
    .mysql_real_escape_string($comment)."','"
    .date('Y-m-d H:i:s'). "')";
    
    // 保存する
    mysql_query($sql,$link);

}

}

?>



<!DOCTYPE html>
<html>
    <head>
        <title>オリジナル掲示板</title>
    </head>
    <body>
        <h1>オリジナル掲示板</h1>
        
        
        <form action="index.php" method="post">
            名前：<input type="text" name="name"/><br>
            投稿内容<input type="text" name="comment" size="60" /><br>
            <input type="submit" name="submit" value="送信" />
        </form>
    </body>
</html>