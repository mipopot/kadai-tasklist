@extends('layouts.app')

@section('content')

    <div class="prose ml-4">
        <h2>id = {{ $task->id }} のタスク詳細ページ</h2>
    </div>

    <table class="table w-full my-4">
        <tr>
            <th>id</th>
            <td>{{ $task->id }}</td>
        </tr>
        <tr>
            <th>タイトル</th>
            <td>{{ $task->status }}</td>
        </tr>
        <tr>
            <th>タスク</th>
            <td>{{ $task->content }}</td>
        </tr>
    </table>

    {{-- タスク編集ページへのリンク --}}
    <div class=ml-4>
        <a class="btn btn-outline" href="{{ route('tasks.edit', $task->id) }}">このタスクを編集</a>
    </div>
    
    @if (Auth::id() == $task->user_id)
        {{-- タスク削除フォーム --}}
        <form method="POST" action="{{ route('tasks.destroy', $task->id) }}" class="my-2 ml-4">
            @csrf
            @method('DELETE')
            
            <button type="submit" class="btn btn-error btn-outline" 
                onclick="return confirm('id = {{ $task->id }} のタスクを削除します。よろしいですか？')">削除</button>
        </form>
    @endif

@endsection