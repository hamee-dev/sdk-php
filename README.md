sdk-php
====

## Overview

ネクストエンジンAPIのSDK(PHP)です。  
ネクストエンジンAPIに関してのリファレンスやコミュニティは[Developer Network](https://developer.next-engine.com)をご利用ください。

## Description

SDKは以下のことが網羅されています。
- ネクストエンジンAPI利用時の認証関連処理
- ネクストエンジンAPI利用時のリクエスト処理
- サンプルリクエストロジック

詳細は[Developer Network](https://developer.next-engine.com/sdk)を参照ください。

## Environment

推奨環境: PHP version 5.6 or greater  
curl 7.25.0以降

## Installing

#### Composerを利用する場合

Composerをインストールしてください。

```
$ curl -s http://getcomposer.org/installer | php
```

以下のようにcomposer.jsonを作成してください。

```
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/hamee-dev/sdk-php"
        }
    ],
    "require": {
        "hamee-dev/sdk-php": "dev-master"
    }
}
```

特定のバージョンを指定したい場合は、タグ名を指定してください。
```
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/hamee-dev/sdk-php"
        }
    ],
    "require": {
        "hamee-dev/sdk-php": "タグ名"
    }
}
```

ライブラリーをインストールします。

```
$ php composer.phar install
```

ご利用環境のディレクトリ構成に応じたパスを指定してautoloaderを読み込んでください。

```
require_once("/path/to/your/vendor/autoload.php");
```

ライブラリーの使い方についてはサンプルコードをご参照ください。

#### ダウンロードする場合

srcディレクトリをinclude_pathに設定してrequireあるいはincludeしてご利用ください。


## Contribution

1. Fork it ( https://github.com/hamee-dev/sdk-php/fork )
2. Create your feature branch (git checkout -b my-new-feature)
3. Commit your changes (git commit -am 'Add some feature')
4. Push to the branch (git push origin my-new-feature)
5. Create new Pull Request

## Licence

[MIT](https://github.com/hamee-dev/sdk-php/blob/master/LICENCE)

## Author

[hamee-dev](https://github.com/hamee-dev)
