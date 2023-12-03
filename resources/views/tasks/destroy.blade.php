@extends('layouts.app')

@section('content')

    <div class="prose ml-4">
        <h2>タスク削除完了</h2>
        <a class="btn btn-primary" href="{{ route('tasks.index')}}">タスクリストに戻る</a>
    </div>
    
@endsection