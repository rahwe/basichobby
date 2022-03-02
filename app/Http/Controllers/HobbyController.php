<?php

namespace App\Http\Controllers;

use App\Hobby;
use Illuminate\Http\Request;
use App\Tag;

use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Gate;

use Intervention\Image\Facades\Image;




class HobbyController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hobbies = Hobby::orderBy('created_at','DESC')->paginate(10);
        return view('hobbies.index')->with(['hobbies' => $hobbies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hobbies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|min:5',
            'description' => 'required|min:5',
            'image' => 'mimes:png,jpg,bmp,jpg,gif'
        ]);

        
        $hobby = new Hobby([
            'title' => $request['title'],
            'description' => $request['description'],
            'user_id' => auth()->id()
        ]);

    
        $hobby->save();


        if($request->image){
            $this->saveImage($request->image, $hobby->id);
        }

        return redirect('/hobbies/'.$hobby->id)->with([
            'message_warning' => "Please assign some tags now."
           ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hobby  $hobby
     * @return \Illuminate\Http\Response
     */
    public function show(Hobby $hobby)
    {
        $alltags = Tag::all();

        $usedTag = $hobby->tags;

        $availableTags = $alltags->diff($usedTag);

        return view('hobbies.show')->with([
            'hobby' => $hobby,
            'availableTags' => $availableTags,
            'message_success' => Session::get('message_success'),
            'message_warning' => Session::get('message_warning')
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hobby  $hobby
     * @return \Illuminate\Http\Response
     */
    public function edit(Hobby $hobby)
    {
        abort_unless(Gate::allows('update', $hobby), 403, "You are not allowed");

        return view('hobbies.edit')->with([
            'hobby' => $hobby,
            'message_success' => Session::get('message_success'),
            'message_warning' => Session::get('message_warning')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hobby  $hobby
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hobby $hobby)
    {

        abort_unless(Gate::allows('update', $hobby), 403, "You are not allowed");


        $request->validate([
                'title' => 'required|min:5',
                'description' => 'required|min:5',
                'image' => 'mimes:png,jpg,bmp,jpg,gif'
            ]);

            if($request->image){
                $this->saveImage($request->image, $hobby->id);
            }

        $hobby->update([
            'title' => $request['title'],
            'description' => $request['description']
        ]);

        return redirect('/hobbies')->with([
            'message_success' => "The hobby".$hobby->title."was updated."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hobby  $hobby
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hobby $hobby)
    {

        abort_unless(Gate::allows('delete', $hobby), 403, "You are not allowed");

        $oldname = $hobby->title;
        $hobby->delete();
        return redirect('/hobbies')->with([
            'message_success' => "The hobby".$oldname." was deleted."
        ]);
    }




    public function saveImage($imageInput, $hobby_id){
        $image = Image::make($imageInput);
        if($image->width() > $image->height()){
            
            /// landscape
            $image->widen(1200)
            ->save(public_path()."/img/hobbies/".$hobby_id."_large.jpg")
            ->widen(400)->pixelate(12)
            ->save(public_path()."/img/hobbies/".$hobby_id."_pixelated.jpg");

            $image = Image::make($imageInput);
            $image->widen(60)
            ->save(public_path()."/img/hobbies/".$hobby_id."_thumb.jpg");


        }else{

            // portrait
            $image->heighten(900)
            ->save(public_path()."/img/hobbies/".$hobby_id."_large.jpg")
            ->heighten(400)->pixelate(12)
            ->save(public_path()."/img/hobbies/".$hobby_id."_pixelated.jpg");

            $image = Image::make($imageInput);
            $image->heighten(60)
            ->save(public_path()."/img/hobbies/".$hobby_id."_thumb.jpg");


        }
    }



    public function deleteImage($hobby_id){

        if(file_exists(public_path()."/img/hobbies/".$hobby_id."_large.jpg"))
        unlink(public_path()."/img/hobbies/".$hobby_id."_large.jpg");

        if(file_exists(public_path()."/img/hobbies/".$hobby_id."_thumb.jpg"))
        unlink(public_path()."/img/hobbies/".$hobby_id."_thumb.jpg");

        if(file_exists(public_path()."/img/hobbies/".$hobby_id."_pixelated.jpg"))
        unlink(public_path()."/img/hobbies/".$hobby_id."_pixelated.jpg");
        
        return redirect('/hobbies')->with([
            'message_success' => "The image was deleted."
        ]);

    }


}
