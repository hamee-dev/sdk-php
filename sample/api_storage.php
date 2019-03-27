<?php
header('Content-Type: text/html; charset=UTF-8');
/**
 * ストレージAPIを使用するアプリのサンプルです。
 *
 * @since 2016/10/31
 * @copyright Hamee Corp. All Rights Reserved.
 *
*/
use NextEngine\neApiClient;

// この値を「アプリを作る->API->テスト環境設定」の値に更新して下さい。
// (アプリを販売する場合は本番環境設定の値に更新して下さい)
// このサンプルではネクストエンジンストレージにアクセスするため、ネクストエンジンストレージ情報取得とネクストエンジンストレージ情報更新を許可して下さい。
define('CLIENT_ID','XXXXXXXXXXXXXX') ;
define('CLIENT_SECRET', 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX') ;

// 本SDKは、ネクストエンジンログインが必要になるとネクストエンジンのログイン画面に
// リダイレクトします。ログイン成功後に、リダイレクトしたい
// アプリケーションサーバーのURIを指定して下さい。
// 呼び出すAPI毎にリダイレクト先を変更したい場合は、apiExecuteの引数に指定して下さい。
$pathinfo = pathinfo(strtok($_SERVER['REQUEST_URI'],'?')) ;
$redirect_uri = 'https://'.$_SERVER['HTTP_HOST'].$pathinfo['dirname'].'/'.$pathinfo['basename'] ;

$client = new neApiClient(CLIENT_ID, CLIENT_SECRET, $redirect_uri) ;

// アップロードの実行後、ファイル一覧の取得とダウンロードを行います。
if(isset($_FILES['upload_file'])) {
	$params = array() ;
	$params['file_data'] = $_FILES['upload_file']['tmp_name'] ;
	$params['file_name'] = $_FILES['upload_file']['name'] ;

	$upload_result = $client->apiExecute('/api_v1_storage/upload', $params) ;

	////////////////////////////////////////////////////////////////////////////////
	//ストレージAPIを使用するサンプル
	////////////////////////////////////////////////////////////////////////////////
	// ファイル一覧を取得
	$list_storage_files = $client->apiExecute('/api_v1_storage/search');

	// 指定したファイルをダウンロード
	$download_file_name = array();
	$download_file_name['file_name'] = $params['file_name'];
	$download_storage_files = $client->apiExecute('/api_v1_storage/download', $download_file_name);

	// ダウンロードしてきたファイルを解凍します。
	// 解凍してできた文字列をfile_put_contents等でファイルに書き込むことで使用可能です。
	// 参考：http://php.net/manual/ja/function.file-put-contents.php
	// $decompress_file = $client->decompressionFile($download_storage_files);
} 
?>

<html>
	<head>
		<meta charset="utf-8">
		<script type="text/javascript">
		</script>
	</head>
	<body>
		<form method="post" enctype='multipart/form-data'>
			アップロードするファイルを選択して下さい。
			<input type="file" name="upload_file"><br>
			<input type="submit">
		</form>
		<pre>
			<h3>アップロード結果：</h3><?php isset($upload_result) ? var_dump($upload_result) : "" ; ?>
		</pre>
		<pre>
			<h3>保存されているファイルの一覧：</h3><?php isset($list_storage_files) ? var_dump($list_storage_files) : "" ; ?>
		</pre>
		<pre>
			<h3>ダウンロード結果：</h3><?php isset($download_storage_files) ? var_dump($download_storage_files) : "" ; ?>
		</pre>
	</body>
</html>