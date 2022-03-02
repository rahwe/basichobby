@extends('layouts.app')
@section('title', 'edit Hobby')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Edit hobbies
                    <a href="/hobbies" class="btn btn-link">back</a>
                </div>
                <div class="card-body">
                    <form autocomplete="off" action="/hobbies/{{ $hobby->id }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                          <label for="title">Title</label>
                          <input type="text" class="form-control {{ $errors->has('title') ? ' border-danger' : '' }}" name="title" value="{{$hobby->title ?? old('title') }}">
                          <small class="form-text text-danger">{!! $errors->first('title') !!}</small>
                        </div>

                        @if(file_exists('img/hobbies/'.$hobby->id.'_large.jpg'))
                        <div class="mb-2">
                          <img class="img-fluid" src="/img/hobbies/{{ $hobby->id }}_large.jpg" alt="" style="max-width: 400px; max-height: 300px;">
                          <a class="btn btn-outline-danger float-right" href="/delete-images/hobby/{{ $hobby->id }}">Delete image</a>
                        </div>
                        @endif
                        
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control {{ $errors->has('image') ? ' border-danger' : '' }}" name="image" value="">
                            <small class="form-text text-danger">{!! $errors->first('image') !!}</small>
                          </div>


                        <div class="form-group">
                          <label for="description">Description</label>
                          <textarea class="form-control {{ $errors->has('description') ? ' border-danger' : '' }}" rows="3" name="description">{{$hobby->description ?? old('description') }}</textarea>
                          <small class="form-text text-danger">{!! $errors->first('description') !!}</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                      </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
