@extends('layouts.app')
@section('title', 'Hobby create')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Create tags
                    <a href="/tags" class="btn btn-link">back</a>
                </div>
                <div class="card-body">
                    <form action="/tags" method="POST">
                        @csrf
                        <div class="form-group">
                          <label for="title">Name</label>
                          <input type="text" class="form-control {{ $errors->has('name') ? ' border-danger' : '' }}" name="name" value="{{ old('name') }}">
                          <small class="form-text text-danger">{!! $errors->first('name')!!}</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                      </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
