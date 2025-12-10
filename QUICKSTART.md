# クイックスタートガイド

初めてこのプロジェクトに取り組む新人向けの、最短セットアップガイドです。
詳細は README.md や他のドキュメントを参照してください。

## 🎯 このガイドで実現すること

このガイドに従うことで、**15分以内に** 開発環境を構築し、
ブラウザで ToDoリストアプリにアクセスできるようになります。

## 📋 前提条件

以下がインストール済みであることを確認してください。

```bash
# Gitのバージョン確認
git --version

# Dockerのバージョン確認
docker --version

# Docker Composeのバージョン確認
docker-compose --version
```

すべてのコマンドが実行できない場合は、インストールしてください。

## ⚡ 5ステップで環境構築

### ステップ1: リポジトリをクローン（1分）

```bash
git clone https://github.com/your-username/laravel-todo-training.git
cd laravel-todo-training
```

### ステップ2: 環境ファイルを作成（1分）

```bash
cp src/.env.example src/.env
```

### ステップ3: Dockerコンテナを起動（5分）

```bash
docker-compose up -d --build
```

**初回はイメージのビルドに時間がかかります。コーヒーを飲みながら待ってください。**

起動確認:
```bash
docker-compose ps
```

4つのコンテナが `Up` 状態になっていることを確認してください。

### ステップ4: Laravelを初期化（5分）

```bash
# PHPコンテナに入る
docker-compose exec php bash

# Composerパッケージをインストール
$ composer install

# アプリケーションキーを生成
$ php artisan key:generate

# データベースをセットアップ
$ php artisan migrate

# コンテナから出る
$ exit
```

### ステップ5: ブラウザでアクセス（1分）

以下のURLをブラウザで開いてください。

- **ToDoアプリ**: http://localhost:8000
- **データベース管理**: http://localhost:8001 (phpMyAdmin)

Laravelのウェルカムページが表示されれば成功です！🎉

---

## 🚦 次のステップ

環境構築が完了したら、以下の順で進めてください。

### 1. ドキュメントを読む（30分）

```
1. SETUP_OVERVIEW.md    ← ドキュメント全体の説明
2. DIRECTORY_STRUCTURE.md ← プロジェクト構成
3. GIT_GUIDE.md         ← Git運用ルール
4. BEST_PRACTICES.md    ← 開発ルール
```

### 2. Gitの初期設定（5分）

```bash
# ユーザー情報を設定
git config user.name "Your Name"
git config user.email "your.email@example.com"

# 開発ブランチを作成
git checkout -b develop

# リモートにプッシュ
git push -u origin develop
```

### 3. 開発を開始（随時）

研修カリキュラムに沿ってToDoリストアプリを実装してください。

---

## 🆘 トラブルシューティング

### ❌ `docker-compose ps` でコンテナが見つからない

```bash
# ログを確認
docker-compose logs

# コンテナを再起動
docker-compose down
docker-compose up -d --build
```

### ❌ `composer install` でエラー

```bash
# PHPコンテナ内で実行
docker-compose exec php bash
$ composer install --no-cache
```

### ❌ `http://localhost:8000` にアクセスできない

```bash
# Nginxのログを確認
docker-compose logs nginx

# Nginxコンテナを再起動
docker-compose restart nginx
```

### ❌ データベースに接続できない

```bash
# MySQLが起動しているか確認
docker-compose ps mysql

# MySQLのログを確認
docker-compose logs mysql

# MySQLを再起動
docker-compose restart mysql
```

---

## 📚 よく使うコマンド

### Dockerコマンド

```bash
# コンテナを起動
docker-compose up -d

# コンテナを停止
docker-compose down

# PHPコンテナに入る
docker-compose exec php bash

# ログを確認
docker-compose logs -f
```

### Laravelコマンド（PHPコンテナ内）

```bash
# モデルを作成
$ php artisan make:model Task -m

# コントローラーを作成
$ php artisan make:controller TaskController --resource

# マイグレーションを実行
$ php artisan migrate

# キャッシュをクリア
$ php artisan cache:clear
```

### Gitコマンド

```bash
# ステータス確認
git status

# 変更をステージング
git add .

# コミット
git commit -m "feat: 新機能を追加"

# プッシュ
git push origin develop
```

---

## 📖 詳細ドキュメント

クイックスタート後、以下のドキュメントを参照してください。

| ドキュメント | 内容 | 対象 |
|---|---|---|
| **README.md** | プロジェクト概要と環境構築 | 最初に読む |
| **SETUP_OVERVIEW.md** | ドキュメント全体の説明 | 2番目に読む |
| **DIRECTORY_STRUCTURE.md** | ディレクトリ構成の詳細 | 開発前に読む |
| **GIT_GUIDE.md** | Git運用ルール | 開発前に読む |
| **BEST_PRACTICES.md** | Laravel開発ルール | 実装時に参照 |
| **ARTISAN_COMMANDS.md** | Artisanコマンドリファレンス | 開発中に参照 |
| **DOCKER_COMMANDS.md** | Dockerコマンドリファレンス | 環境管理時に参照 |

---

## 💡 Tips

### 開発効率を上げるVS Code拡張機能

以下の拡張機能をインストールすることをお勧めします。

- **Laravel Extension Pack** - Laravel開発に必要な拡張機能をまとめたもの
- **PHP Intelephense** - PHPのコード補完
- **Blade** - Bladeテンプレートのシンタックスハイライト
- **Docker** - Dockerコンテナの管理
- **GitLens** - Gitの履歴表示

### Dockerコンテナ内でのコマンド実行

毎回 `docker-compose exec php bash` でコンテナに入るのが面倒な場合は、
以下のエイリアスを設定すると便利です。

```bash
# ~/.bashrc または ~/.zshrc に追加
alias artisan='docker-compose exec php php artisan'
alias composer='docker-compose exec php composer'

# 使用例
artisan migrate
composer require package/name
```

### ホットリロード

`src/` ディレクトリ内のファイルを編集すると、自動的にコンテナに反映されます。
ブラウザをリロードすれば、変更が確認できます。

---

## 🎓 学習リソース

公式ドキュメント以外の学習リソース：

- [Laravel 日本語ドキュメント](https://readouble.com/laravel/)
- [Docker 入門ガイド](https://docs.docker.com/get-started/)
- [Git 入門ガイド](https://git-scm.com/book/ja/v2)
- [PHP PSR-12 コーディング規約](https://www.php-fig.org/psr/psr-12/)

---

**質問や問題がある場合は、まずドキュメントを検索してから、チームに相談してください。**

Happy coding! 🚀
