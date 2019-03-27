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

////////////////////////////////////////////////////////////////////////////////
// 契約企業一覧を取得するサンプル
////////////////////////////////////////////////////////////////////////////////
$under_contract_company = $client->apiExecuteNoRequiredLogin('/api_app/company') ;

////////////////////////////////////////////////////////////////////////////////
// 利用者情報を取得するサンプル
////////////////////////////////////////////////////////////////////////////////
$user = $client->apiExecute('/api_v1_login_user/info') ;

////////////////////////////////////////////////////////////////////////////////
// 商品マスタ情報を取得するサンプル
////////////////////////////////////////////////////////////////////////////////
$query = array() ;
// 検索結果のフィールド：商品コード、商品名、商品区分名、在庫数、引当数、フリー在庫数
$query['fields'] = 'goods_id, goods_name, goods_type_name, stock_quantity, stock_allocation_quantity, stock_free_quantity' ;
// 検索条件：商品コードがredで終了している、かつ商品マスタの作成日が2013/10/31の20時より前
$query['goods_id-like'] = '%red' ;
$query['goods_creation_date-lt'] = '2013-10-31 20:00:00' ;
// 検索は0～50件まで
$query['offset'] = '0' ;
$query['limit'] = '50' ;

// アクセス制限中はアクセス制限が終了するまで待つ。
// (1以外/省略時にアクセス制限になった場合はエラーのレスポンスが返却される)
$query['wait_flag'] = '1' ;

// 検索対象の総件数を取得
$goods_cnt = $client->apiExecute('/api_v1_master_goods/count', $query) ;
// 検索実行
$goods = $client->apiExecute('/api_v1_master_goods/search', $query) ;
?>

<html>
	<head>
		<meta charset="utf-8">
		<script type="text/javascript">
		</script>
	</head>
	<body>
		<pre><?php var_dump($user) ; ?></pre>
		<pre><?php var_dump($under_contract_company) ; ?></pre>
		<pre><?php var_dump($goods_cnt) ; ?></pre>
		<pre><?php var_dump($goods) ; ?></pre>
	</body>
</html>