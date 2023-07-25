<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //一覧ページを表示するためのアクション
        $goals = Auth::user()->goals;
        //タグの追加
        $tags = Auth::user()->tags;
 
        return view('goals.index', compact('goals', 'tags'));
        //目標とタグのインスタンスを渡す
    }
    /**
     * 現在ログイン中のユーザーが持つ目標をすべて取得し、変数$goalsに代入する
     * view()ヘルパーを使ってビュー［resources/views/goals/index.blade.php（次章で作成）］を表示する
     * view()ヘルパーの第2引数にPHPのcompact()関数を指定し、変数$goalsをビューに渡す
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //作成機能
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title' => 'required',//バリデーション・入力必須
        ]);

        $goal = new Goal();
        $goal->title = $request->input('title');
        $goal->user_id = Auth::id();//ユーザーIDを取得
        $goal->save();

        return redirect()->route('goals.index'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function show(Goal $goal)
    {
        //詳細
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function edit(Goal $goal)
    {
        //編集
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Goal $goal)
    {
        //
        $request->validate([
            'title' => 'required',
        ]);

        $goal->title = $request->input('title');
        $goal->user_id = Auth::id();
        $goal->save();

        return redirect()->route('goals.index');      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Goal $goal)
    {
        //
        $goal->delete();
 
         return redirect()->route('goals.index');  
    }
}
