<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Gate;

class TagController extends Controller
{

    public function __construct(){
        $this->middleware('auth')->except(['index']);
        $this->middleware('admin')->except(['index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();
        return view('tags.index')->with([
            'tags' => $tags
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Tag $tag)
    {
       
        abort_unless(Gate::allows('create', $tag), 403, "You are not allowed");
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tag $tag)
    {

   
        abort_unless(Gate::allows('create', $tag), 403, "You are not allowed");

        $request->validate([
            'name' => 'required|max:50|unique:tags',
        ]);

        $hobby = new Tag([
            'name' => $request['name'],
        ]);

        $hobby->save();
        return redirect('/tags')->with([
            'message_success' => "The tag ".$hobby->name."was created!"
        ]);
    }


    public function edit(Tag $tag){
        abort_unless(Gate::allows('update', $tag), 403);
        return view('tags.edit', [
            'tag' => $tag
        ]);
    }

    public function update(Request $request, Tag $tag){
        abort_unless(Gate::allows('update', $tag), 403);

        $request->validate([
            'name' => 'required|max:50|unique:tags',
        ]);

        $tag->update([
            'name' => $request['name']
        ]);

        return redirect('/tags')->with([
            'message_success' => "The tag is updated"
        ]);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {

        abort_unless(Gate::allows('delete', $tag), 403, "You are not allowed");

        $oldname = $tag->name;
        $tag->delete();
        return redirect('/tags')->with([
            'message_success' => "The tag".$oldname." was deleted."
        ]);
    }
}
