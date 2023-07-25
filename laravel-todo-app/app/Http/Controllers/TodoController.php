<?php

namespace App\Http\Controllers;

use App\Models\Todo;//
use App\Models\Goal;//
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;//

class TodoController extends Controller
{
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Goal $goal) {
        //requestの値を取得　goleインスタンスの値渡す

        $request->validate([//バリデーション：必須
            'content' => 'required',
            'description'=>'required',
        ]);

        $todo = new Todo();//todoインスタンス化
        $todo->content = $request->input('content');//requestの中身をtodoテーブルのcontentにinput
        $todo->description = $request->input('description');//requestの中身をtodoテーブルのdescriptionにinput
        $todo->user_id = Auth::id();//userテーブルのIDを取得しtodoテーブルのuser_idに代入
        $todo->goal_id = $goal->id;//goalテーブルのIDを取得しtodoテーブルのgoal_idに代入

        $todo->done = false;//doneカラムの初期値をfalseに設定
        $todo->save();//セーブ

        $todo->tags()->sync($request->input('tag_ids'));//タグの作成

        return redirect()->route('goals.index');

    }

   

  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Goal $goal, Todo $todo) {
        //
        $request->validate([
            'content' => 'required',
           // 'description'=>'required',
        ]);

        $todo->content = $request->input('content');
        //$todo->description = $request->input('description');
        $todo->user_id = Auth::id();//ログイン
        $todo->goal_id = $goal->id;
        $todo->done = $request->boolean('done', $todo->done);
        $todo->update();

         // 「完了」と「未完了」の切り替え時でないとき（通常の編集時）にのみタグを変更する
         if (!$request->has('done')) {
            $todo->tags()->sync($request->input('tag_ids'));
        };        

        return redirect()->route('goals.index'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Goal $goal, Todo $todo) {        
        //
        $todo->delete();
 
        return redirect()->route('goals.index');        
    }
}
