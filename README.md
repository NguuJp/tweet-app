

## 開発環境（sail&Dockerを使用）

### Laravelアプリケーションの雛形をダウンロードし、プロジェクトの初期セットアップ（最新のPHPバージョンを使用）
```
curl -s "https://laravel.build/example-app?php=latest" | bash
```
```
cd example-app
```

### 現在のDockerコンテナを削除
```
docker-compose down -v
```
### Dockerイメージを再ビルド
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

## ログイン機能追加（Laravel　Breeze）
```
sail composer require laravel/breeze --dev
```

## 再設定コマンド（再マイグレーション＆シーディング）
```
sail artisan migrate:fresh --seed
```

