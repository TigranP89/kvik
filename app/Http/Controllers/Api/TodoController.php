<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Models\Todo;

class TodoController extends BaseController
{

  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    try {
      $todos = Todo::orderBy('created_at', 'DESC')->get();

      return response()->json([
        'message' => 'Get all todos',
        'todos' => $todos ?? [],
      ]);
    } catch (\Exception $e){
      $e->getMessage();
    }
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\StoreTodoRequest $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreTodoRequest $request)
  {
    try {
      $validated = $request->validated();
      if (empty($validated)){
        return response()->json([
          'status'=>400
        ]);
      } else {
        Todo::create($validated);

        $todos = Todo::orderBy('created_at', 'DESC')->get();

        return response()->json([
          'status' => 200,
          'todos'  => $todos ?? [],
        ]);
      }
    } catch (\Exception $e){
      $e->getMessage();
    }

  }

  /**
   * Display the specified resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function show(Todo $todo)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Todo $todo)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateTodoRequest $request, Todo $todo)
  {
    try {
      $validated = $request->validated();

      if (empty($validated)){
        return response()->json([
          'status'=>400
        ]);
      } else {
        $todo->completed = $validated['completed'];
        $todo->update();

        $todos = Todo::orderBy('created_at', 'DESC')->get();

        return response()->json([
          'status' => 200,
          'todos'  => $todos ?? [],
        ]);
      }
    } catch (\Exception $e){
      return $e->getMessage();
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @return \Illuminate\Http\Response
   */
  public function destroy(Todo $todo)
  {
    try {
      Todo::destroy($todo->id);

      $todos = Todo::orderBy('created_at', 'DESC')->get();

      return response()->json([
        'status' => 200,
        'todos'  => $todos ?? [],
      ]);
    } catch (\Exception $e){
      $e->getMessage();
    }
  }
}
