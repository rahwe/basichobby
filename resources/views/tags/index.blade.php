@extends('layouts.app')
@section('title', 'All tags')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Tags
                    
                    
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @if ($tags)
                            @foreach ($tags as $tag)
                            <li class="list-group-item">
                                {{ $tag->name }}

                                <a href="/hobby/tag/{{ $tag->id }}" class="float-right">Use {{ $tag->hobbies->count() }} time</a>


                                @can('delete', $tag)
                                    <form action="/tags/{{ $tag->id }}" method="post">
                                        @csrf
                                        @method("DELETE")
                                        <input class="btn btn-outline-danger btn-sm" type="submit" value="delete">
                                    </form>
                                @endcan
                                
                                
                            </li>
                            
                            @endforeach

                            

                        @endif
                        
                      </ul>

                        @can('create', $tag)
                            <a href="tags/create" class="btn btn-link">add tags</a>
                        @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
