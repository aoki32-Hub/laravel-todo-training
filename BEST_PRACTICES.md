# Laravel開発ベストプラクティスガイド

このドキュメントは、新人研修におけるLaravel開発の品質と一貫性を保つためのベストプラクティスをまとめたものです。

## 1. コーディング規約

### 1.1. PHPコーディング規約 (PSR-12)

原則として、[PSR-12 (Extended Coding Style Guide)](https://www.php-fig.org/psr/psr-12/) に準拠します。
`laravel/pint` を利用して、コードスタイルを自動で整形することを推奨します。

```bash
# PHPコンテナ内で実行
$ ./vendor/bin/pint
```

### 1.2. 命名規則

一貫性のある命名は、コードの可読性を大幅に向上させます。

| 対象 | 命名規則 | 例 |
|---|---|---|
| **変数** | キャメルケース (`camelCase`) | `$taskTitle`, `$completedTasks` |
| **関数・メソッド** | キャメルケース (`camelCase`) | `getTasks`, `storeTask` |
| **クラス** | アッパーキャメルケース（パスカルケース） (`PascalCase`) | `TaskController`, `StoreTaskRequest` |
| **コントローラー** | `(リソース名)Controller` | `TaskController`, `UserController` |
| **モデル** | 単数形・アッパーキャメルケース | `Task`, `User` |
| **マイグレーション** | `create_(テーブル名)_table` | `create_tasks_table` |
| **テーブル** | スネークケース・複数形 (`snake_case`) | `tasks`, `users` |
| **カラム** | スネークケース (`snake_case`) | `task_title`, `is_completed` |
| **ビュー (Blade)** | スネークケース (`snake_case`) | `index.blade.php`, `create_task.blade.php` |
| **ルート (名前付き)** | スネークケース (`snake_case`) | `tasks.index`, `tasks.store` |

## 2. コントローラーの責務

- **Fat Model, Skinny Controller (太ったモデル、痩せたコントローラー)** を目指します。
- コントローラーは、HTTPリクエストを受け取り、ビジネスロジック（モデルやサービスクラス）を呼び出し、レスポンスを返すことに専念します。
- 複雑なビジネスロジックは、モデルや、必要に応じてサービスクラスに記述します。

**悪い例:**
```php
// TaskController.php
public function store(Request $request)
{
    // バリデーションロジック
    $request->validate([
        'title' => 'required|max:255',
    ]);

    // データベースへの保存ロジック
    $task = new Task();
    $task->title = $request->title;
    $task->description = $request->description;
    $task->status = 'pending'; // ビジネスロジック
    $task->save();

    return redirect()->route('tasks.index');
}
```

**良い例:**
```php
// StoreTaskRequest.php (フォームリクエストでバリデーション)
public function rules()
{
    return [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
    ];
}

// TaskController.php
public function store(StoreTaskRequest $request)
{
    // フォームリクエストでバリデーション済み
    Task::create($request->validated()); // モデルのメソッドでロジックをカプセル化

    return redirect()->route('tasks.index');
}

// Task.php (モデル)
protected $fillable = ['title', 'description'];

// createメソッドが呼ばれると、自動でstatusが設定される
protected static function booted()
{
    static::creating(function ($task) {
        $task->status = 'pending';
    });
}
```

## 3. Eloquent ORM

### 3.1. N+1問題の回避

ループ内で都度クエリが発行される「N+1問題」は、パフォーマンス低下の主要な原因です。
`with()` や `load()` を使って、関連データを一括で読み込み（Eager Loading）ましょう。

**悪い例（N+1問題が発生）:**
```php
// Controller
$tasks = Task::all();

// View (tasks.index.blade.php)
@foreach ($tasks as $task)
    {{-- ループのたびにusersテーブルへのクエリが実行される --}}
    {{ $task->user->name }}
@endforeach
```

**良い例（Eager Loading）:**
```php
// Controller
$tasks = Task::with('user')->get(); // 'user'リレーションを事前に読み込む

// View (tasks.index.blade.php)
@foreach ($tasks as $task)
    {{-- クエリは実行されない --}}
    {{ $task->user->name }}
@endforeach
```

### 3.2. マスアサインメント

`create()` や `update()` メソッドを使う際は、意図しないカラムが更新されるのを防ぐため、モデルの `$fillable` または `$guarded` プロパティを必ず設定してください。

```php
// Task.php

// 許可するカラムを指定（推奨）
protected $fillable = ['title', 'description', 'status'];

// または、許可しないカラムを指定
// protected $guarded = ['id', 'created_at', 'updated_at'];
```

## 4. ルーティング

- **リソースコントローラー** を活用して、CRUD操作のルートを簡潔に記述します。
- ルートには必ず名前（`name()`）を付け、ビューやリダイレクトではURL直書きではなく `route()` ヘルパーを使用します。これにより、将来URLが変更されても修正箇所が最小限になります。

**悪い例:**
```php
// web.php
Route::get('/tasks', [TaskController::class, 'index']);
Route::post('/tasks', [TaskController::class, 'store']);

// view.blade.php
<a href="/tasks">タスク一覧</a>
```

**良い例:**
```php
// web.php
Route::resource('tasks', TaskController::class);

// view.blade.php
<a href="{{ route('tasks.index') }}">タスク一覧</a>
```

## 5. ビュー (Blade)

- **ロジックを記述しない**: ビューには、表示に関するロジック（`if`, `foreach`など）のみを記述し、データ処理などのビジネスロジックは含めません。
- **コンポーネントの活用**: 繰り返し使われるUI部品は、Bladeコンポーネントとして切り出し、再利用性を高めます。
- **エスケープ処理**: ユーザーからの入力を表示する際は、必ず `{{ }}` を使ってXSS（クロスサイトスクリプティング）脆弱性を防ぎます。意図的にHTMLを出力する必要がある場合のみ `{{!! !!}}` を使用し、その際は内容を十分に検証してください。

## 6. セキュリティ

- **SQLインジェクション**: Eloquent ORMやクエリビルダを正しく使っていれば、自動的にプリペアドステートメントが使われるため、原則として安全です。`DB::raw()` などで生のSQLを書く際は、必ずパラメータバインディングを行ってください。
- **クロスサイトスクリプティング (XSS)**: 前述の通り、Bladeの `{{ }}` でエスケープします。
- **クロスサイトリクエストフォージェリ (CSRF)**: Laravelのフォームでは、必ず `@csrf` ディレクティブを記述し、CSRFトークンを埋め込みます。

```html
<form method="POST" action="{{ route('tasks.store') }}">
    @csrf
    ...
</form>
```

## 7. 設定と環境変数

- **設定ファイルに直接値を書かない**: データベースのパスワードなどの機密情報や、環境によって変わる値は、`.env` ファイルに記述し、`config()` ヘルパーで読み込みます。
- **`.env` ファイルをGitで管理しない**: `.env` はローカル環境固有のファイルです。`.gitignore` に追加し、リポジトリに含めないようにします。チームで共有すべき設定は `.env.example` に記述します。

