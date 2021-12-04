<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Auth;

class TaskController extends Controller
{
    public function add_task(Request $request){
        $tasktitle = $request->tasktitle;
        $description = $request->description;
        $targetdate = $request->targetdate;
        $user_id = Auth::user()->id;
        $request->validate([
            'tasktitle' => 'required|max:100',
            'description' => 'required|max:200',
            'targetdate' => 'required|max:20',
       ]);

      $find = Task::where('is_deleted', 0)
      ->where('status', 1)
      ->where('user_id', $user_id)
      ->where('task_title', $tasktitle)
      ->first();

      if ($find) {
        return redirect()->back()->with([
            'dup' => 'No Task Duplication'
     ]);
      }
      else{
        $insert =  Task::insert([
            "user_id" => $user_id,
            "task_title" => $tasktitle,
            "task_description"  =>  $description,
            "target_date" => $targetdate
            ]);
            
            if ($insert) {
                return redirect()->back()->with([
                    'message' => 'New Task Successfully Added'
             ]);
            }

      }
        
      
    }

    public static function get_task(){
        $user_id = Auth::user()->id;
        $task = Task::where('is_deleted', 0)
        ->where('user_id', $user_id)
        ->orderBy('id', 'DESC')
        ->get();

        return $task;
    }

    public function deleteTask(Request $request){
        $id = $request->id;
        $dlt = Task::where('id', $id)
				->update([ 'is_deleted' => 1 ]);
        if ($dlt) {
            return 1;
        }
    }

    public function donetask(Request $request){
        $id = $request->id;
        $done = Task::where('id', $id)
				->update([ 'status' => 0 ]);
        if ($done) {
            return 1;
        }
    }

    public function updatetask(Request $request){
        $id = $request->id;
        $find = Task::where('id', $id)
                ->get();
        return $find;
    }

    public function uptask(Request $request){
       $title = $request->title;
       $id = $request->id;
       $description = $request->description;
       $targetdate = $request->targetdate;

       $taskinfo = Task::where('id', $id)
       ->update([ 'task_title' => $title, 'task_description' => $description, 'target_date' => $targetdate ]);

       if ($taskinfo) {
          return 1;
       }
    }
}
