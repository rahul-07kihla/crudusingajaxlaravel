<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use DataTables;

class PostAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $post = Post::latest()->get();

        if ($request->ajax()) {
            return Datatables::of($post)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                            $btn = '<button class="btn btn-outline-success" onclick="editProject(' . $row->id . ')">Edit</button> ';

                            $btn .= '<button class="btn btn-outline-info" onclick="showProject(' . $row->id . ')">Show</button> ';

                            $btn = $btn.' <button  class="btn btn-outline-danger" onclick="destroyProject(' . $row->id . ')">Delete</button> ';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('postAjax',compact('post'));
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
     */
    public function store(Request $request)
    {
        request()->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        POst::create($request->all());

        return response()->json(['status' => "success"]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::find($id);

        return response()->json(['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = Post::find($id);

        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        $post = Post::find($id);
        $post->update($request->all());
        return response()->json(['status' => "success"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Post::destroy($id);
        return response()->json(['status' => "success"]);
    }
}
