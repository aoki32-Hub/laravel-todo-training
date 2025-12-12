<h1>New Task</h1>

<form action="{{ route('tasks.store') }}" method="POST">
    @csrf
    
    <label for="name">タスク名</label>
    <input type="text" name="title" id="title" required>

    <button type="submit">登録</button>
</form>
