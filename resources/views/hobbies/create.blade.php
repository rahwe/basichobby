@extends('layouts.app')
@section('title', 'Hobby create')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Create hobbies
                    <a href="/hobbies" class="btn btn-link">back</a>
                </div>
                <div class="card-body">
                    <form autocomplete="off" action="/hobbies" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                          <label for="title">Title</label>
                          <input type="text" class="form-control {{ $errors->has('title') ? ' border-danger' : '' }}" name="title" value="{{ old('title') }}">
                          <small class="form-text text-danger">{!! $errors->first('title')!!}</small>
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control {{ $errors->has('image') ? ' border-danger' : '' }}" name="image" value="">
                            <small class="form-text text-danger">{!! $errors->first('image')!!}</small>
                          </div>


                        <div class="form-group">
                          <label for="description">Description</label>
                          <textarea class="form-control {{ $errors->has('description') ? ' border-danger' : '' }}" rows="3" name="description">{{ old('description') }}</textarea>
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
