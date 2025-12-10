# Git運用ガイド

新人研修向けLaravel ToDoアプリケーションのGit運用方法です。

## 初期セットアップ

### 1. ローカルリポジトリの初期化

```bash
# プロジェクトディレクトリに移動
cd laravel-todo-training

# Gitリポジトリを初期化
git init

# ユーザー情報を設定（初回のみ）
git config user.name "Your Name"
git config user.email "your.email@example.com"
```

### 2. 最初のコミット

```bash
# すべてのファイルをステージング
git add .

# 初期コミット
git commit -m "Initial commit: Laravel ToDoアプリケーション環境構築"
```

### 3. リモートリポジトリに接続

```bash
# GitHubでリポジトリを作成後、以下を実行
git remote add origin https://github.com/your-username/laravel-todo-training.git

# メインブランチの名前を確認（main または master）
git branch -M main

# リモートリポジトリにプッシュ
git push -u origin main
```

## 開発ワークフロー

### ブランチ戦略

新人研修では以下のシンプルなブランチ戦略を採用します。

```
main ブランチ
  ↓
  ├─ develop ブランチ（開発用）
  │   ├─ feature/task-model（機能開発用）
  │   ├─ feature/task-controller
  │   ├─ feature/task-view
  │   └─ ...
  │
  └─ release ブランチ（リリース準備用）
```

### 開発フロー例

#### 1. 開発ブランチの作成

```bash
# メインブランチから開発ブランチを作成
git checkout -b develop

# リモートに開発ブランチをプッシュ
git push -u origin develop
```

#### 2. 機能ブランチの作成

```bash
# 開発ブランチから機能ブランチを作成
git checkout develop
git pull origin develop
git checkout -b feature/task-model

# 例：Taskモデルを作成する場合
# docker-compose exec php php artisan make:model Task -m
```

#### 3. コミット

```bash
# 変更をステージング
git add app/Models/Task.php database/migrations/2024_01_01_000000_create_tasks_table.php

# コミット（わかりやすいメッセージを付ける）
git commit -m "feat: Taskモデルとマイグレーション作成

- Taskモデルを作成
- tasksテーブルのマイグレーションを作成
- カラム: id, title, description, status, created_at, updated_at"
```

#### 4. 機能ブランチをリモートにプッシュ

```bash
git push -u origin feature/task-model
```

#### 5. プルリクエスト（Pull Request）の作成

GitHubで以下の情報を記載してプルリクエストを作成します。

```
タイトル: feat: Taskモデルとマイグレーション作成

説明:
## 変更内容
- Taskモデルを作成しました
- tasksテーブルのマイグレーションを作成しました

## 確認項目
- [ ] コードレビュー完了
- [ ] ローカルで動作確認済み
- [ ] テスト実施済み

## 関連するイシュー
#1
```

#### 6. 開発ブランチへのマージ

```bash
# プルリクエストがレビュー・承認されたら、GitHubでマージ
# または、ローカルでマージ
git checkout develop
git pull origin develop
git merge feature/task-model
git push origin develop

# マージ後、機能ブランチを削除
git branch -d feature/task-model
git push origin --delete feature/task-model
```

## コミットメッセージのルール

わかりやすいコミットメッセージを書くために、以下のルールに従います。

### フォーマット

```
<type>(<scope>): <subject>

<body>

<footer>
```

### type（変更の種類）

| type | 説明 |
|---|---|
| `feat` | 新機能の追加 |
| `fix` | バグ修正 |
| `docs` | ドキュメント変更 |
| `style` | コード整形（機能変更なし） |
| `refactor` | リファクタリング |
| `perf` | パフォーマンス改善 |
| `test` | テスト追加・修正 |
| `chore` | ビルド設定・依存パッケージ更新など |

### scope（変更対象）

括弧内に変更対象を記入します。

| scope | 説明 |
|---|---|
| `model` | モデル関連 |
| `controller` | コントローラー関連 |
| `view` | ビュー関連 |
| `migration` | マイグレーション関連 |
| `config` | 設定ファイル関連 |

### subject（主題）

- 命令形で記述（「〜した」ではなく「〜する」）
- 最初の文字は小文字
- 末尾に句点をつけない
- 50文字以内

### body（本文）

- 何を変更したか、なぜ変更したかを記述
- 複数行の場合は、空行で区切る

### footer（フッター）

- 関連するイシュー番号を記入
- 例：`Closes #123`

### コミットメッセージの例

```bash
git commit -m "feat(model): Taskモデルとマイグレーション作成

Taskモデルを新規作成し、tasksテーブルのマイグレーションを実装しました。

カラム構成:
- id: 主キー
- title: タスクのタイトル（最大255文字）
- description: タスクの説明
- status: タスクの状態（pending, completed）
- created_at: 作成日時
- updated_at: 更新日時

Closes #1"
```

## よく使うGitコマンド

### ブランチ操作

```bash
# ブランチ一覧を表示
git branch -a

# ブランチを切り替え
git checkout develop

# ブランチを作成して切り替え
git checkout -b feature/new-feature

# ブランチを削除
git branch -d feature/old-feature

# リモートブランチを削除
git push origin --delete feature/old-feature
```

### 変更確認

```bash
# 変更内容を確認
git status

# 変更内容の詳細を確認
git diff

# ステージング済みの変更を確認
git diff --staged

# コミット履歴を確認
git log

# コミット履歴を1行で表示
git log --oneline

# グラフ表示でブランチの流れを確認
git log --graph --oneline --all
```

### ステージング・コミット

```bash
# ファイルをステージング
git add filename.php

# すべての変更をステージング
git add .

# ステージングを取り消し
git reset filename.php

# 変更を破棄（注意：復元不可）
git checkout -- filename.php
```

### プッシュ・プル

```bash
# リモートの最新を取得
git fetch origin

# リモートの最新をマージ
git pull origin develop

# ローカルをリモートにプッシュ
git push origin develop

# 強制プッシュ（注意：チームで使用する場合は事前相談）
git push -f origin develop
```

### マージ・リベース

```bash
# ブランチをマージ
git merge feature/task-model

# マージを中止
git merge --abort

# リベース（コミット履歴を整理）
git rebase develop

# リベースを中止
git rebase --abort
```

## トラブルシューティング

### コミットメッセージを修正したい

```bash
# 最後のコミットメッセージを修正
git commit --amend -m "新しいメッセージ"

# 既にプッシュしている場合は強制プッシュ
git push -f origin feature/branch-name
```

### 間違ったファイルをコミットした

```bash
# 最後のコミットからファイルを除外
git reset HEAD~1

# ファイルをステージング解除
git reset filename.php

# 正しいファイルだけをコミット
git commit -m "正しいメッセージ"
```

### ブランチを間違えてコミットした

```bash
# 現在のブランチのコミットをコピー
git log -1 --format=%B > commit_message.txt

# 正しいブランチに切り替え
git checkout correct-branch

# コミットを適用
git cherry-pick <commit-hash>

# 元のブランチから削除
git checkout wrong-branch
git reset --hard HEAD~1
```

## 参考資料

- [Git公式ドキュメント](https://git-scm.com/doc)
- [GitHub Guides](https://guides.github.com/)
- [Conventional Commits](https://www.conventionalcommits.org/ja/)
