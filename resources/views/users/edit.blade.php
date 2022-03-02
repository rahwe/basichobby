@extends('layouts.app')
@section('title', 'edit Hobby')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Edit User
                    <a href="/home" class="btn btn-link">back</a>
                </div>
                <div class="card-body">
                    <form autocomplete="off" action="/user/{{ $user->id }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                          <label for="motto">Motto</label>
                          <input class="form-control {{ $errors->has('motto') ? ' border-danger' : '' }}" value="{{$user->motto ?? old('motto') }}" name="motto">
                          <small class="form-text text-danger">{!! $errors->first('motto') !!}</small>
                        </div>


                        @if(file_exists('img/users/'.$user->id.'_large.jpg'))
                        <div class="mb-2">
                          <img class="img-fluid" src="/img/users/{{ $user->id }}_large.jpg" alt="" style="max-width: 400px; max-height: 300px;">
                          <a class="btn btn-outline-danger float-right" href="/delete-images/user/{{ $user->id }}">Delete image</a>
                        </div>
                        @endif
                        
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control {{ $errors->has('image') ? ' border-danger' : '' }}" name="image" value="">
                            <small class="form-text text-danger">{!! $errors->first('image') !!}</small>
                        </div>

                        

                        <div class="form-group">
                          <label for="about_me">About Me</label>
                          <textarea class="form-control" rows="3" name="about_me">{{$user->about_me ?? old('about_me') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                      </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
