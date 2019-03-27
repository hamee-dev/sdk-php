<?php
/**
 * メイン機能と連携するアプリのサンプルです。
 *
 * @since 2013/10/10
 * @copyright Hamee Corp. All Rights Reserved.
 *
*/
use NextEngine\neApiClient;

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

// CSVファイルをsubmitした場合
if( isset($_FILES['csv_file']) ) {
	$p = array() ;
	$p['data'] = file_get_contents($_FILES['csv_file']['tmp_name']) ;
	$p['data_type'] = 'csv' ;

	/* GZipでアップロードするにはこのコメントを外して下さい。通常はGZipでアップロードして下さい。
	$p['data'] = gzencode($p['data'], 9) ;
	$p['data_type'] = 'gz' ;
    */

	// 商品マスタCSV予約アップロードを実施
	$goods_upload = $client->apiExecute('/api_v1_master_goods/upload', $p) ;
	var_dump($goods_upload) ;

	// アップロードの状況を確認
	$query['fields'] = 'que_id, que_method_name, que_shop_id, que_upload_name, que_client_file_name, que_file_name, que_status_id, que_message, que_deleted_flag, que_creation_date, que_last_modified_date, que_creator_id, que_creator_name, que_last_modified_by_id, que_last_modified_by_name' ;
	$query['que_id-eq'] = $goods_upload['que_id'] ;
	$que = $client->apiExecute('/api_v1_system_que/search', $query) ;
	var_dump($que) ;
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
			商品マスタCSVを選択して下さい。
			<input type="hidden" name="MAX_FILE_SIZE" value="52428800">
			<input type="file" name="csv_file" size="80"><br>
			<input type="submit">
		</form>
	</body>
</html>