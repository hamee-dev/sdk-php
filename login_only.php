<?php
/**
 * ネクストエンジンログインのみのアプリのサンプルです。
 *
 * @since 2013/10/10
 * @copyright Hamee Corp. All Rights Reserved.
 *
*/
require_once('./neApiClient.php') ;

// この値を「アプリを作る->API->テスト環境設定」の値に更新して下さい。
// (アプリを販売する場合は本番環境設定の値に更新して下さい)
// このサンプルでは、利用者情報とマスタ情報にアクセスするため、許可して下さい。
define('CLIENT_ID','XXXXXXXXXXXXXX') ;
define('CLIENT_SECRET', 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX') ;

// 本SDKは、ネクストエンジンログインが必要になるとネクストエンジンのログイン画面に
// リダイレクトします。ログイン成功後に、リダイレクトしたい
// アプリケーションサーバーのURIを指定して下さい。
// 呼び出すAPI毎にリダイレクト先を変更したい場合は、apiExecuteの引数に指定して下さい。
$pathinfo = pathinfo(strtok($_SERVER['REQUEST_URI'],'?')) ;
$redirect_uri = 'https://'.$_SERVER['HTTP_HOST'].$pathinfo['dirname'].'/'.$pathinfo['basename'] ;

$client = new neApiClient(CLIENT_ID, CLIENT_SECRET, $redirect_uri) ;

////////////////////////////////////////////////////////////////////////////////
// NEログインのみ実施し、利用者の基本情報を取得するサンプル
////////////////////////////////////////////////////////////////////////////////
$login = $client->neLogin() ;

?>

<html>
	<head>
		<meta charset="utf-8">
		<script type="text/javascript">
		</script>
	</head>
	<body>
		<pre><?php var_dump($login) ; ?></pre>
	</body>
</html>
