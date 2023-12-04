<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;    // 追加

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // getでtasks/にアクセスされた場合の「一覧表示処理」
    public function index(Request $request)
    {
        
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの投稿の一覧を作成日時の降順で取得
            // （後のChapterで他ユーザの投稿も取得するように変更しますが、現時点ではこのユーザの投稿のみ取得します）
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
            
            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
             // タスク一覧ビューでそれを表示
            return view('tasks.index', $data);
        }
        
        // dashboardビューでそれらを表示
        return view('dashboard', $data);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // getでtasks/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        $task = new Task;

        // タスク作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // postでtasks/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required|max:255',
        ]);
        
        // タスクを作成
        //$task = new Task;
        //$task->status = $request->status;
        //$task->content = $request->content;
        //$task->save();
        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        // 認証済みユーザを取得　$user = \Auth::user();
        $request->user()->tasks()->create([
            'status' => $request->status,
            'content' => $request->content,
        ]);

        // トップページへリダイレクトさせる
        //return redirect();
        // 前のURLにリダイレクト
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // getでtasks/idにアクセスされた場合の「取得表示処理」
    public function show($id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        if (\Auth::id() === $task->user_id){
            // タスク詳細ビューでそれを表示
            return view('tasks.show', ['task' => $task,]);
        }
        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // getでtasks/id/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        if (\Auth::id() === $task->user_id){
            // タスク編集ビューでそれを表示
            return view('tasks.edit', ['task' => $task,]);
        }
        
        // トップページへリダイレクトさせる
        return redirect('/');
    } 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // putまたはpatchでtasks/idにアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required|max:255',
        ]);
        
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        if (\Auth::id() === $task->user_id){
            // タスクを更新
            $task->status = $request->status;
            $task->content = $request->content;
            $task->save();

            // トップページへリダイレクトさせる
            return redirect('/');
        }
        
        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // deleteでtasks/idにアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        // もしuser_idが一致するユーザの場合指定されたidの$taskデータを削除する
        if (\Auth::id() === $task->user_id){
            // タスクを削除
            $task->delete();
            // 削除後は前のページへリダイレクト
            return redirect()->route('tasks.index');
            // テスト用：削除後はdestroyページを表示
            //return view('tasks.destroy');
        }

        // 認証済みユーザではない場合はトップページへリダイレクトさせる
        return redirect('/');
        // テスト用：削除後はdestroyページを表示
        //return view('tasks.error');
    }
}
