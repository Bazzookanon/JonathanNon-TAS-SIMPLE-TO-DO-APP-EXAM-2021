<?php
use App\Http\Controllers\TaskController;  
?>
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(Session::has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ Session::get('message') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if(Session::has('dup'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>{{ Session::get('dup') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h4>To Do List</h4>
                </div>
                <div class="card-body">
                    <strong>Welcome: {{Auth::user()->name}}</strong>
                    <button type="button" class="btn btn-primary float-right" onclick="addmodal()">
                        <i class="fa fa-calendar-plus-o" style="font-size:36px"></i>
                    </button>
                    <br>
                    <br>
                    <br>
                    <div class="cont">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Task</th>
                                    <th>Task Description</th>
                                    <th>Target Finish Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($task = TaskController::get_task())
                                @foreach($task as $tk)
                                <tr id="tr_{{$tk->id}}">
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                onclick="doneTask({{$tk->id}})" id="ck_{{$tk->id}}"
                                                {{ $tk->status != 1 ? 'checked' : ''}}
                                                {{ $tk->status != 1 ? 'disabled' : ''}}>
                                        </div>
                                    </td>
                                    <td style="{{ $tk->status != 1 ? 'text-decoration-line: line-through;' : ''}}"
                                        id="tl_{{$tk->id}}">{{$tk->task_title}}</td>
                                    <td style="{{ $tk->status != 1 ? 'text-decoration-line: line-through;' : ''}}"
                                        id="td_{{$tk->id}}">{{$tk->task_description}}</td>
                                    <td style="{{ $tk->status != 1 ? 'text-decoration-line: line-through;' : ''}}"
                                        id="tt_{{$tk->id}}">{{$tk->target_date}}</td>
                                    <td>
                                        <button class="btn btn-info" id="up_{{$tk->id}}"
                                            onclick="updateTask({{$tk->id}})" {{ $tk->status != 1 ? 'disabled' : ''}}><i
                                                class="fa fa-edit" aria-hidden="true"></i></button>
                                        <button class="btn btn-danger" onclick="deleteTask({{$tk->id}})"><i
                                                class="fa fa-trash" aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mtitle" style="color: black;">Add New Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('posttask') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address
                            @error('tasktitle')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </label>
                        <input type="text" class="form-control" id="tasktitle" name="tasktitle"
                            aria-describedby="emailHelp" placeholder="Enter Task Title">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Task Description
                            @error('description')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Target Date to Finish
                            @error('targetdate')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </label>
                        <input type="date" class="form-control" id="targetdate" name="targetdate"
                            placeholder="Enter Target Date">
                        <input type="hidden" id="hid">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="save">Save changes</button>
                <button type="button" class="btn btn-info" id="update" style="display:none" onclick="upTask()">Update
                    changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
