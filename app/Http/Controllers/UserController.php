<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
       
    }

    public function data_user($param)
    {
        $dparam = json_decode($param);
        $_vars['page'] = $dparam->page;
        $_vars['rows'] = $dparam->rows;
        $_vars['srcvt'] = $dparam->srcvt; 

        $result['total'] = User::get_data_user($_vars, 'total');
        $result['rows'] = User::get_data_user($_vars, 'rows');

        echo json_encode($result);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:155',
            'content' => 'required',
            'status' => 'required'
        ]);

        $post = User::create([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
            'slug' => Str::slug($request->title)
        ]);

        if ($post) {
            return redirect()
                ->route('post.index')
                ->with([
                    'success' => 'New post has been created successfully'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem occurred, please try again'
                ]);
        }
    }



}
