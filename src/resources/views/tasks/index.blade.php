<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>

<h1>Task List</h1>

<ul>
    @foreach ($tasks as $task)
        <li>{{ $task->title }}</li>
    @endforeach
</ul>
