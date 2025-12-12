# 新人研修向け ToDoリストアプリケーション開発

このリポジトリは、新人研修（PHP/Laravel/Git/Docker）の成果物であるToDoリストアプリケーションの環境構築手本です。

## 1. 概要

このプロジェクトは、PHPフレームワークであるLaravelと、コンテナ仮想化技術であるDockerを使用して、モダンなWebアプリケーション開発の基礎を学ぶことを目的としています。

### 1.1. 学習目標

- Dockerを使った開発環境の構築と運用
- Laravelの基本的な使い方（MVCアーキテクチャ、ルーティング、Eloquent ORM）
- Gitを使ったバージョン管理とチーム開発の基本フロー
- CRUD（作成、読み取り、更新、削除）機能の実装
- データベース設計とマイグレーション

### 1.2. 開発するアプリケーションの機能

- **タスク管理**
  - タスクの追加、編集、削除 (CRUD)
- **ステータス管理**
  - タスクの状態（未着手、着手中、完了など）を管理
- **検索機能**
  - タスクのタイトルで検索

## 2. 技術スタック

| カテゴリ | 技術 | バージョン | 役割 |
|---|---|---|---|
| バックエンド | PHP | 8.2 | アプリケーションロジック |
| フレームワーク | Laravel | 11.x | Webアプリケーション開発 |
| Webサーバー | Nginx | latest | HTTPリクエスト処理 |
| データベース | MySQL | 8.0 | データ永続化 |
| 環境構築 | Docker / Docker Compose | - | コンテナ管理・開発環境 |
| パッケージ管理 | Composer | latest | PHP依存パッケージ管理 |
| バージョン管理 | Git / GitHub | - | ソースコード管理 |
| 開発ツール | VS Code | - | コードエディタ |
| DB管理ツール | phpMyAdmin | latest | データベースGUI（オプション） |

## 3. ディレクトリ構成

```
laravel-todo-training/
├── docker/                     # Docker設定ファイル
│   ├── php/                    # PHPコンテナ用
│   ├── nginx/                  # Nginxコンテナ用
│   └── mysql/                  # MySQLコンテナ用
├── src/                        # Laravelアプリケーションのソースコード
├── .gitignore                  # Git管理対象外ファイル
├── docker-compose.yml          # Docker Compose設定ファイル
├── GIT_GUIDE.md                # Git運用ガイド
└── README.md                   # このファイル
```

- **`docker/`**: PHP、Nginx、MySQLの各コンテナをビルドするための`Dockerfile`や設定ファイルを格納します。
- **`src/`**: Laravelのソースコードを格納します。開発作業はこのディレクトリが中心となります。
- **`docker-compose.yml`**: 各コンテナの構成と連携を定義するファイルです。
- **`GIT_GUIDE.md`**: 本研修におけるGitの運用ルールやワークフローをまとめたガイドです。

詳細なLaravelプロジェクトの構成については `src/PROJECT_STRUCTURE.md` を参照してください。

## 4. 環境構築手順

以下の手順に従って、開発環境を構築してください。

### 4.1. 前提条件

- [Git](https://git-scm.com/) がインストールされていること
- [Docker](https://www.docker.com/products/docker-desktop/) および [Docker Compose](https://docs.docker.com/compose/install/) がインストールされていること
- [VS Code](https://code.visualstudio.com/) などのコードエディタがインストールされていること

### 4.2. プロジェクトのセットアップ

1.  **リポジトリをクローン**

    ```bash
    git clone https://github.com/your-username/laravel-todo-training.git
    cd laravel-todo-training
    ```

2.  **`.env` ファイルの作成**

    `src` ディレクトリにある `.env.example` ファイルをコピーして `.env` ファイルを作成します。このファイルにはデータベースの接続情報などが含まれます。

    ```bash
    cp src/.env.example src/.env
    ```

### 4.3. Dockerコンテナの起動

1.  **Dockerイメージのビルドとコンテナの起動**

    プロジェクトのルートディレクトリで以下のコマンドを実行します。初回はイメージのビルドに時間がかかります。

    ```bash
    docker-compose up -d --build
    ```

    **【コマンド解説】**
    - `up`: コンテナを作成して起動します。
    - `-d`: バックグラウンドで実行します（デタッチモード）。
    - `--build`: イメージを強制的に再ビルドします。設定ファイルを変更した際に使用します。

2.  **コンテナの確認**

    以下のコマンドで起動中のコンテナ一覧が表示されれば成功です。

    ```bash
    docker-compose ps
    ```

    | Name | Command | State | Ports |
    |---|---|---|---|
| `laravel-todo-mysql` | `...` | `Up` | `3306->3306/tcp` |
| `laravel-todo-nginx` | `...` | `Up` | `0.0.0.0:8000->80/tcp` |
| `laravel-todo-php` | `...` | `Up` | `9000/tcp` |
| `laravel-todo-phpmyadmin` | `...` | `Up` | `0.0.0.0:8001->80/tcp` |

### 4.4. Laravelの初期設定

1.  **PHPコンテナに入る**

    Laravelのコマンド（`artisan`）や`composer`を実行するために、PHPコンテナの中に入ります。

    ```bash
    docker-compose exec php bash
    ```

    これ以降、`$` で始まるコマンドはPHPコンテナ内で実行します。

2.  **Composerパッケージのインストール**

    Laravelが必要とする依存パッケージをインストールします。

    ```bash
    $ composer install
    ```

3.  **アプリケーションキーの生成**

    Laravelアプリケーションの暗号化に必要なキーを生成します。

    ```bash
    $ php artisan key:generate
    ```

4.  **データベースマイグレーションの実行**

    データベースにテーブルを作成します。

    ```bash
    $ php artisan migrate
    ```

    マイグレーションに失敗する場合は、MySQLコンテナが完全に起動するまで少し待ってから再試行してください。

5.  **コンテナから出る**

    ```bash
    $ exit
    ```

### 4.5. アプリケーションへのアクセス

すべての設定が完了したら、Webブラウザで以下のURLにアクセスしてください。

- **ToDoリストアプリケーション**: [http://localhost:8000](http://localhost:8000)
- **phpMyAdmin（DB管理ツール）**: [http://localhost:8001](http://localhost:8001)

Laravelのウェルカムページが表示されれば、環境構築は成功です。

## 5. 開発の進め方

### 5.1. Git運用

開発を始める前に、必ず `GIT_GUIDE.md` を読み、ブランチ戦略やコミットメッセージのルールを理解してください。

### 5.2. よく使うコマンド

- **コンテナの起動**
  ```bash
  docker-compose up -d
  ```

- **コンテナの停止**
  ```bash
  docker-compose down
  ```

- **コンテナの再ビルド**
  ```bash
  docker-compose up -d --build
  ```

- **PHPコンテナに入る**
  ```bash
  docker-compose exec php bash
  ```

- **ログの確認**
  ```bash
  # すべてのコンテナのログ
  docker-compose logs -f

  # 特定のコンテナのログ（例: PHP）
  docker-compose logs -f php
  ```

## 6. トラブルシューティング

- **`localhost:8000` にアクセスできない**
  - `docker-compose ps` で `laravel-todo-nginx` コンテナが `Up` 状態か確認してください。
  - Nginxのログを確認してください: `docker-compose logs -f nginx`

- **データベースに接続できない**
  - `src/.env` の `DB_HOST` が `mysql` になっているか確認してください。
  - `docker-compose ps` で `laravel-todo-mysql` コンテナが `Up` 状態か確認してください。

- **`composer install` でエラーが出る**
  - PHPのバージョンや拡張機能に問題がある可能性があります。`docker/php/Dockerfile` を確認してください。

- **変更が反映されない**
  - ブラウザのキャッシュをクリアしてみてください。
  - Laravelのキャッシュをクリアしてみてください:
    ```bash
    docker-compose exec php php artisan cache:clear
    docker-compose exec php php artisan config:clear
    docker-compose exec php php artisan view:clear
    docker-compose exec php php artisan route:clear
    ```

