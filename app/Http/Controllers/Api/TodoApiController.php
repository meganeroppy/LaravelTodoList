<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TodoApiController extends Controller
{
    /**
     * ログインユーザーのToDoリストを取得
     */
    public function index(Request $request)
    {
        $todos = $request->user()->todos()->with('category')->get();
        
        return response()->json([
            'todos' => $todos
        ]);
    }
}
