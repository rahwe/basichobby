<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Gate;


use Intervention\Image\Facades\Image;

use Illuminate\Support\Facades\Session;


class UserController extends Controller
{

    public function __construct(){
        $this->middleware('auth')->except(['show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show')->with(['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        abort_unless(Gate::allows('update', $user), 403, "You are not allowed");

        return view('users.edit')->with([
            'user' => $user,
            'message_success' => Session::get('message_success'),
            'message_warning' => Session::get('message_warning')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        abort_unless(Gate::allows('update', $user), 403, "You are not allowed");

            $request->validate([
                'motto' => 'required|min:5',
                'image' => 'mimes:png,jpg,bmp,jpg,gif'
            ]);

            if($request->image){
                $this->saveImage($request->image, $user->id);
            }

            $user->update([
                'motto' => $request['motto'],
                'about_me' => $request['about_me'],
            ]);

            return redirect('/home')->with([
                'message_success' => "The user profile was updated."
            ]);

            
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        abort_unless(Gate::allows('delete', $user), 403, "You are not allowed");
        
    }



    public function saveImage($imageInput, $user_id){

        $image = Image::make($imageInput);

        if($image->width() > $image->height()){
            
            /// landscape
            $image->widen(500)
            ->save(public_path()."/img/users/".$user_id."_large.jpg")
            ->widen(300)->pixelate(12)
            ->save(public_path()."/img/users/".$user_id."_pixelated.jpg");

            $image = Image::make($imageInput);
            $image->widen(60)
            ->save(public_path()."/img/users/".$user_id."_thumb.jpg");


        }else{

            // portrait
            $image->heighten(500)
            ->save(public_path()."/img/users/".$user_id."_large.jpg")
            ->heighten(300)->pixelate(12)
            ->save(public_path()."/img/users/".$user_id."_pixelated.jpg");

            $image = Image::make($imageInput);
            $image->heighten(60)
            ->save(public_path()."/img/users/".$user_id."_thumb.jpg");


        }
    }


    public function deleteImage($user_id){

        if(file_exists(public_path()."/img/users/".$user_id."_large.jpg"))
        unlink(public_path()."/img/users/".$user_id."_large.jpg");

        if(file_exists(public_path()."/img/users/".$user_id."_thumb.jpg"))
        unlink(public_path()."/img/users/".$user_id."_thumb.jpg");

        if(file_exists(public_path()."/img/users/".$user_id."_pixelated.jpg"))
        unlink(public_path()."/img/users/".$user_id."_pixelated.jpg");
        
        return redirect()->back()->with([
            'message_success' => "The image was deleted."
        ]);

    }





}// end user class
