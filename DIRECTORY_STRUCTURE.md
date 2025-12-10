# プロジェクトディレクトリ構成

新人研修向けLaravel ToDoアプリケーションの完全なディレクトリ構成を説明します。

## 全体構成

```
laravel-todo-training/
├── docker/                          # Docker設定ファイル
│   ├── php/
│   │   ├── Dockerfile              # PHP-FMMコンテナの定義
│   │   └── php.ini                 # PHP設定ファイル
│   ├── nginx/
│   │   ├── Dockerfile              # Nginxコンテナの定義
│   │   └── default.conf            # Nginx設定ファイル
│   └── mysql/
│       └── my.cnf                  # MySQL設定ファイル
├── src/                             # Laravelアプリケーション
│   ├── app/                         # アプリケーションのコア
│   │   ├── Models/                 # Eloquentモデル
│   │   ├── Http/
│   │   │   ├── Controllers/        # コントローラー
│   │   │   ├── Requests/           # フォームリクエスト
│   │   │   └── Middleware/         # ミドルウェア
│   │   ├── Exceptions/             # カスタム例外
│   │   ├── Console/                # Artisanコマンド
│   │   ├── Jobs/                   # キュージョブ
│   │   ├── Listeners/              # イベントリスナー
│   │   ├── Mail/                   # メール
│   │   ├── Notifications/          # 通知
│   │   ├── Providers/              # サービスプロバイダー
│   │   └── Rules/                  # カスタムバリデーションルール
│   ├── bootstrap/                  # アプリケーション起動
│   │   ├── app.php                 # アプリケーション初期化
│   │   └── cache/                  # キャッシュディレクトリ
│   ├── config/                     # 設定ファイル
│   │   ├── app.php                 # アプリケーション設定
│   │   ├── database.php            # データベース設定
│   │   ├── cache.php               # キャッシュ設定
│   │   ├── logging.php             # ログ設定
│   │   ├── mail.php                # メール設定
│   │   ├── queue.php               # キュー設定
│   │   └── session.php             # セッション設定
│   ├── database/                   # データベース関連
│   │   ├── migrations/             # マイグレーション
│   │   ├── seeders/                # シーダー
│   │   └── factories/              # ファクトリー
│   ├── public/                     # Webサーバーのドキュメントルート
│   │   ├── index.php               # エントリーポイント
│   │   ├── css/                    # CSSファイル
│   │   ├── js/                     # JavaScriptファイル
│   │   └── images/                 # 画像ファイル
│   ├── resources/                  # ビュー・アセット
│   │   ├── views/                  # Bladeテンプレート
│   │   │   ├── layouts/            # レイアウトテンプレート
│   │   │   ├── tasks/              # タスク関連ビュー
│   │   │   └── components/         # 再利用可能なコンポーネント
│   │   ├── css/                    # ソースCSS
│   │   └── js/                     # ソースJavaScript
│   ├── routes/                     # ルーティング定義
│   │   ├── web.php                 # Webルート
│   │   ├── api.php                 # APIルート
│   │   └── console.php             # Artisanコマンド
│   ├── storage/                    # ログ・キャッシュ・ファイル
│   │   ├── app/                    # アプリケーションファイル
│   │   ├── framework/              # フレームワークキャッシュ
│   │   ├── logs/                   # ログファイル
│   │   └── uploads/                # ユーザーアップロード
│   ├── tests/                      # テストコード
│   │   ├── Unit/                   # ユニットテスト
│   │   ├── Feature/                # 機能テスト
│   │   ├── CreatesApplication.php  # テスト用アプリケーション作成
│   │   └── TestCase.php            # テストケース基底クラス
│   ├── vendor/                     # Composer依存パッケージ（自動生成）
│   ├── .env                        # 環境設定（Gitで管理しない）
│   ├── .env.example                # 環境設定テンプレート
│   ├── .gitignore                  # Git管理対象外ファイル
│   ├── artisan                     # Laravelコマンドラインツール
│   ├── composer.json               # Composer設定ファイル
│   ├── composer.lock               # 依存パッケージロックファイル
│   ├── phpunit.xml                 # PHPUnit設定ファイル
│   ├── PROJECT_STRUCTURE.md        # Laravelプロジェクト構成説明
│   └── README.md                   # プロジェクト説明書
├── storage/                         # ホスト側のログ・データ永続化
│   └── logs/                       # Dockerコンテナのログ
│       ├── mysql/                  # MySQLログ
│       ├── nginx/                  # Nginxログ
│       └── php/                    # PHPログ
├── .gitignore                      # Git管理対象外ファイル（プロジェクト全体）
├── docker-compose.yml              # Docker Compose設定ファイル
├── README.md                       # プロジェクト説明書
├── GIT_GUIDE.md                    # Git運用ガイド
├── BEST_PRACTICES.md               # Laravel開発ベストプラクティス
├── ARTISAN_COMMANDS.md             # Artisanコマンドリファレンス
├── DOCKER_COMMANDS.md              # Dockerコマンドリファレンス
└── DIRECTORY_STRUCTURE.md          # このファイル
```

## 主要ディレクトリの説明

### `docker/` - Docker設定

Dockerコンテナをビルドするための設定ファイルを格納します。

| ファイル | 説明 |
|---|---|
| `php/Dockerfile` | PHP-FPMコンテナの定義。PHPバージョン、拡張機能、ユーザー設定など |
| `php/php.ini` | PHP設定ファイル。メモリ制限、タイムゾーン、エラー表示など |
| `nginx/Dockerfile` | Nginxコンテナの定義 |
| `nginx/default.conf` | Nginx設定ファイル。ルーティング、ログ設定など |
| `mysql/my.cnf` | MySQL設定ファイル。文字コード、タイムゾーン、ログ設定など |

### `src/` - Laravelアプリケーション

実際の開発作業の中心となるディレクトリです。

| ディレクトリ | 説明 |
|---|---|
| `app/Models/` | Eloquentモデル。`Task.php` はタスクのデータモデル |
| `app/Http/Controllers/` | コントローラー。`TaskController.php` はタスク操作のビジネスロジック |
| `app/Http/Requests/` | フォームリクエスト。入力値のバリデーション |
| `database/migrations/` | マイグレーション。テーブル定義の変更履歴 |
| `database/seeders/` | シーダー。テストデータの生成 |
| `database/factories/` | ファクトリー。テストデータの生成テンプレート |
| `resources/views/` | Bladeテンプレート。UI表示 |
| `routes/web.php` | Webルーティング。URLとコントローラーのマッピング |
| `public/` | Webサーバーが直接アクセスできるディレクトリ。`index.php` がエントリーポイント |
| `storage/logs/` | ログファイル。アプリケーションエラーやデバッグ情報 |
| `config/` | 設定ファイル。データベース、キャッシュ、メールなど |

### `storage/logs/` - ホスト側のログ永続化

Dockerコンテナ内のログをホスト側に永続化するためのディレクトリです。
コンテナが削除されてもログが残ります。

## ファイルの役割と関連性

開発の流れに沿ったファイルの関連性を示します。

### タスク一覧表示の流れ

```
1. routes/web.php
   ↓ ルート定義: GET /tasks → TaskController@index
   ↓
2. app/Http/Controllers/TaskController.php
   ↓ public function index()
   ↓
3. app/Models/Task.php
   ↓ Task::all() でデータベースから取得
   ↓
4. database/migrations/create_tasks_table.php
   ↓ テーブル構造
   ↓
5. resources/views/tasks/index.blade.php
   ↓ ビュー表示
```

### タスク作成の流れ

```
1. routes/web.php
   ↓ ルート定義: POST /tasks → TaskController@store
   ↓
2. app/Http/Requests/StoreTaskRequest.php
   ↓ バリデーション
   ↓
3. app/Http/Controllers/TaskController.php
   ↓ public function store()
   ↓
4. app/Models/Task.php
   ↓ Task::create() でデータベースに保存
   ↓
5. database/migrations/create_tasks_table.php
   ↓ テーブル構造
```

## 開発時のチェックリスト

新しい機能を追加する際は、以下のファイルを確認・作成してください。

- [ ] `routes/web.php` - ルート定義
- [ ] `app/Http/Controllers/TaskController.php` - コントローラーメソッド
- [ ] `app/Http/Requests/StoreTaskRequest.php` - バリデーション（必要に応じて）
- [ ] `app/Models/Task.php` - モデルメソッド
- [ ] `database/migrations/` - マイグレーション（テーブル変更時）
- [ ] `resources/views/tasks/` - Bladeテンプレート
- [ ] `tests/Feature/` - 機能テスト（推奨）

## Gitで管理しないファイル

以下のファイルは `.gitignore` に記載され、Gitで管理されません。

| ファイル | 理由 |
|---|---|
| `src/.env` | 環境固有の設定（パスワード、APIキーなど） |
| `src/vendor/` | Composerで自動生成 |
| `src/storage/logs/` | 実行時に生成されるログ |
| `src/bootstrap/cache/` | キャッシュファイル |
| `node_modules/` | npm/yarnで自動生成 |
| `.vscode/`, `.idea/` | IDE設定 |

## 参考資料

- [Laravel ディレクトリ構造](https://laravel.com/docs/11.x/structure)
- [Docker ベストプラクティス](https://docs.docker.com/develop/dev-best-practices/)
