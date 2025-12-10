# Artisanコマンドリファレンス

Laravelの `artisan` コマンドは、開発を効率化するための強力なツールです。
新人研修で頻繁に使用するコマンドをまとめました。

## 基本コマンド

### サーバー起動

```bash
# Laravelの開発サーバーを起動（本研修ではDocker/Nginxを使用するため不要）
$ php artisan serve

# ポート指定
$ php artisan serve --port=8001
```

### キャッシュクリア

開発中は、キャッシュが古い情報を保持していることがあります。以下のコマンドでクリアしてください。

```bash
# すべてのキャッシュをクリア
$ php artisan cache:clear

# 設定キャッシュをクリア
$ php artisan config:clear

# ビューキャッシュをクリア
$ php artisan view:clear

# ルートキャッシュをクリア
$ php artisan route:clear

# 一括クリア
$ php artisan optimize:clear
```

## マイグレーション関連

### マイグレーション実行

```bash
# すべての未実行マイグレーションを実行
$ php artisan migrate

# ロールバック（最後のマイグレーションバッチを取り消す）
$ php artisan migrate:rollback

# すべてのマイグレーションをリセット
$ php artisan migrate:reset

# すべてのマイグレーションをリセットして再実行
$ php artisan migrate:refresh

# リセット後、シーダーも実行
$ php artisan migrate:refresh --seed
```

### マイグレーション作成

```bash
# マイグレーションファイルを作成
$ php artisan make:migration create_tasks_table

# テーブル作成用マイグレーション
$ php artisan make:migration create_tasks_table --create=tasks

# テーブル修正用マイグレーション
$ php artisan make:migration add_status_to_tasks_table --table=tasks
```

## モデル・コントローラー・リクエスト作成

### モデル作成

```bash
# モデルを作成
$ php artisan make:model Task

# マイグレーション付きでモデルを作成
$ php artisan make:model Task -m

# マイグレーション・コントローラー・リソースファイル付きで作成
$ php artisan make:model Task -mcr
```

### コントローラー作成

```bash
# コントローラーを作成
$ php artisan make:controller TaskController

# リソースコントローラー（CRUD用メソッド付き）を作成
$ php artisan make:controller TaskController --resource

# モデル指定でリソースコントローラーを作成
$ php artisan make:controller TaskController --resource --model=Task
```

### フォームリクエスト作成

```bash
# フォームリクエストを作成
$ php artisan make:request StoreTaskRequest
```

### ファクトリー・シーダー作成

```bash
# ファクトリーを作成
$ php artisan make:factory TaskFactory

# シーダーを作成
$ php artisan make:seeder TaskSeeder
```

## データベース関連

### シード実行

```bash
# すべてのシーダーを実行
$ php artisan db:seed

# 特定のシーダーを実行
$ php artisan db:seed --class=TaskSeeder
```

### テーブル情報確認

```bash
# テーブル一覧を表示
$ php artisan db:table tasks

# テーブルのカラム情報を表示
$ php artisan db:show tasks
```

## ルート関連

### ルート確認

```bash
# 定義されているすべてのルートを表示
$ php artisan route:list

# 特定のルートを検索
$ php artisan route:list --name=tasks
```

## Tinker（対話型シェル）

Tinkerは、Laravelアプリケーションと対話的に操作できるREPL（Read-Eval-Print Loop）です。
データベースクエリのテストやデバッグに便利です。

```bash
# Tinkerを起動
$ php artisan tinker

# Tinker内でのコマンド例
>>> $task = Task::first();
>>> $task->title;
>>> Task::where('status', 'completed')->count();
>>> exit;
```

## 開発効率化コマンド

### 設定発行

Laravelのパッケージが設定ファイルを公開する際に使用します。

```bash
# すべての設定ファイルを公開
$ php artisan vendor:publish

# 特定のパッケージの設定を公開
$ php artisan vendor:publish --provider="Package\ServiceProvider"
```

### ストレージリンク作成

ユーザーアップロードファイルなどを `storage/` ディレクトリに保存する場合、`public/` からシンボリックリンクを作成します。

```bash
$ php artisan storage:link
```

## よく使うコマンド組み合わせ

### 開発環境をリセット

```bash
# キャッシュをクリアしてマイグレーションをリセット
$ php artisan optimize:clear && php artisan migrate:refresh --seed
```

### 新しい機能開発を開始

```bash
# モデル・マイグレーション・コントローラーを一括作成
$ php artisan make:model Task -mcr

# フォームリクエストを作成
$ php artisan make:request StoreTaskRequest
```

## トラブルシューティング

### コマンドが見つからない

```bash
# Composerの自動ロードを再生成
$ composer dump-autoload
```

### マイグレーションが実行されない

```bash
# マイグレーション履歴をリセット
$ php artisan migrate:reset

# 再度実行
$ php artisan migrate
```

## 参考資料

- [Laravel Artisan コンソール](https://laravel.com/docs/11.x/artisan)
- [マイグレーション](https://laravel.com/docs/11.x/migrations)
- [Eloquent ORM](https://laravel.com/docs/11.x/eloquent)
