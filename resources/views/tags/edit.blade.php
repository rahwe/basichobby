@extends('layouts.app')
@section('title', 'edit tag')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Edit tag
                    <a href="/tags" class="btn btn-link">back</a>
                </div>
                <div class="card-body">
                    <form autocomplete="off" action="/tags/{{ $tag->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                          <label for="name">Name</label>
                          <input type="text" class="form-control {{ $errors->has('name') ? ' border-danger' : '' }}" name="name" value="{{$tag->name ?? old('name') }}">
                          <small class="form-text text-danger">{!! $errors->first('name') !!}</small>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                      </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
