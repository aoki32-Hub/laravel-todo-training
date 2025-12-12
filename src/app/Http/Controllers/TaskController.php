<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        //タスク一覧
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        //タスク作成フォーム
        return view('tasks.create');
    }

    public function store(Request $request)
    { 
        Task::create([
            'title' => $request->title,
        ]);

        return redirect()->route('tasks.index');
    }

}


