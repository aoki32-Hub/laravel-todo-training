# Dockerコマンドリファレンス

開発環境の管理に必要なDockerコマンドをまとめました。

## Docker Compose基本コマンド

### コンテナの起動・停止

```bash
# コンテナを起動（バックグラウンド）
docker-compose up -d

# イメージをビルドして起動
docker-compose up -d --build

# コンテナを停止
docker-compose down

# コンテナを停止してボリュームも削除
docker-compose down -v
```

### コンテナ状態確認

```bash
# 起動中のコンテナ一覧
docker-compose ps

# 詳細情報を表示
docker-compose ps -a
```

### ログ確認

```bash
# すべてのコンテナのログをリアルタイム表示
docker-compose logs -f

# 特定のコンテナのログ
docker-compose logs -f php
docker-compose logs -f nginx
docker-compose logs -f mysql

# 最後のN行を表示
docker-compose logs --tail=50 php
```

## コンテナ内での操作

### PHPコンテナに入る

```bash
# Bashシェルで入る
docker-compose exec php bash

# 直接コマンドを実行
docker-compose exec php php artisan migrate

# Composerコマンドを実行
docker-compose exec php composer install
```

### MySQLコンテナに入る

```bash
# MySQLクライアントで接続
docker-compose exec mysql mysql -u laravel_user -p laravel_todo

# パスワード: laravel_password
```

### Nginxコンテナに入る

```bash
# Bashシェルで入る
docker-compose exec nginx bash
```

## イメージ・ボリューム管理

### イメージ確認

```bash
# ローカルのイメージ一覧
docker images

# 特定のイメージを検索
docker images | grep laravel
```

### ボリューム確認

```bash
# ボリューム一覧
docker volume ls

# ボリュームの詳細情報
docker volume inspect laravel-todo-training_mysql-data
```

### 不要なリソースを削除

```bash
# 使用されていないイメージを削除
docker image prune

# 使用されていないボリュームを削除
docker volume prune

# 使用されていないネットワークを削除
docker network prune

# すべての不要なリソースを削除
docker system prune -a
```

## トラブルシューティング

### コンテナが起動しない

```bash
# ログを確認
docker-compose logs php

# コンテナを再ビルド
docker-compose up -d --build

# 既存のイメージを削除して再ビルド
docker-compose down
docker rmi laravel-todo-training_php
docker-compose up -d --build
```

### ポートが既に使用されている

```bash
# ポート8000を使用しているプロセスを確認（Linux/Mac）
lsof -i :8000

# ポート8000を使用しているプロセスを確認（Windows）
netstat -ano | findstr :8000

# 既存のコンテナを停止
docker-compose down

# 別のポートを使用する場合は、docker-compose.ymlを編集
# ports:
#   - "8080:80"  # 8000 → 8080に変更
```

### MySQLに接続できない

```bash
# MySQLコンテナが起動しているか確認
docker-compose ps mysql

# MySQLのログを確認
docker-compose logs mysql

# MySQLコンテナを再起動
docker-compose restart mysql
```

### ディスク容量不足

```bash
# Dockerが使用しているディスク容量を確認
docker system df

# 不要なリソースを削除
docker system prune -a --volumes
```

## よく使うコマンド組み合わせ

### 開発環境をリセット

```bash
# コンテナを停止してボリュームを削除
docker-compose down -v

# イメージをビルドして起動
docker-compose up -d --build

# PHPコンテナに入ってセットアップ
docker-compose exec php bash
# コンテナ内で以下を実行
# composer install
# php artisan key:generate
# php artisan migrate
```

### 新しいパッケージをインストール

```bash
# PHPコンテナに入る
docker-compose exec php bash

# Composerでパッケージをインストール
$ composer require package/name

# コンテナから出る
$ exit

# イメージを再ビルド（composer.lockの変更を反映）
docker-compose up -d --build
```

### 本番環境用にビルド

```bash
# 本番環境用にイメージをビルド
docker-compose -f docker-compose.yml -f docker-compose.prod.yml build

# 本番環境で起動
docker-compose -f docker-compose.yml -f docker-compose.prod.yml up -d
```

## Docker Composeファイルの確認

```bash
# docker-compose.ymlの設定を確認
docker-compose config

# 特定のサービスの設定を確認
docker-compose config --services
```

## 参考資料

- [Docker公式ドキュメント](https://docs.docker.com/)
- [Docker Compose公式ドキュメント](https://docs.docker.com/compose/)
- [Docker Composeコマンドリファレンス](https://docs.docker.com/compose/reference/)
