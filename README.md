

## 開発環境（sail&Dockerを使用）

### Laravelアプリケーションの雛形をダウンロードし、プロジェクトの初期セットアップ（最新のPHPバージョンを使用）
```
curl -s "https://laravel.build/example-app" | bash
```
```
cd example-app
```
```
./vendor/bin/sail up -d
```

### 独自の設定を再設定する場合
#### 現在のDockerコンテナを削除
```
docker-compose down -v
```
#### 設定を変更後、Dockerイメージを再ビルド
```
./vendor/bin/sail build --no-cache
```
```
./vendor/bin/sail up
```

### sailコマンド省略設定（推奨）
#### 設定ファイルを開く
```
vim ~/.zshrc
```
#### iキーを入力してインサートモードにし、対のエイリアスを入力
```
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```
完了したらescキーでインサートモード解除、:wqで保存終了
#### 設定ファイルの再読み込み
```
source ~/.zshrc
```

### sailコマンドを使用して、Laravelアプリケーションの初期セットアップ
#### 日本時間に変更
```
sail artisan sail:publish
```
#### Dockerfileを修正（docker/（使用されているバージョン）/Dockerfile）
```
ENV TZ='Asia/Tokyo'
```
#### 再buildコマンド実行
```
sail build --no-cache
```
```
sail up -d
```

## MySQLの文字コードを変更
docker/8.2/my.cnf
```
[myspld]
characeter-set-server=utf8mb4
collation-server=utf8mb4_bin

[client]
default-character-set=utf8mb4
```
docker-compose.yml
```
mysql:
    //省略
    voloumes:
        - './docker/8.2/my.cnf:/etc/my.cnf'
```


## ログイン機能追加（Laravel　Breeze）
```
sail composer require laravel/breeze --dev
```

## 再設定コマンド（再マイグレーション＆シーディング）
```
sail artisan migrate:fresh --seed
```

