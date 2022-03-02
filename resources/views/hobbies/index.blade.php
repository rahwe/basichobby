@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">

                    @isset($filter)
                        <div class="card-header">Filtered hobbies by

                            <span style="font-size: 130%;" class="badge badge-success">{{ $filter->name }}</span>
                            <span class="float-right"><a href="/hobbies">Show all Hobbies</a></span>

                        </div>
                    @else
                        <div class="card-header">All the hobbies</div>
                    @endisset

                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($hobbies as $hobby)

                                <li class="list-group-item">
                                    @if (file_exists('img/hobbies/'.$hobby->id.'_thumb.jpg'))
                                    <a title="Show Details" href="/hobbies/{{ $hobby->id }}">
                                        <img src="/img/hobbies/{{ $hobby->id }}_thumb.jpg" alt="thumb">
                                        {{ $hobby->title }}
                                    </a>
                                    @endif
                                    
                                    @auth
                                    <a class="btn btn-sm btn-light ml-5" href="/hobbies/{{ $hobby->id }}/edit"><i class="fas fa-edit"></i> Edit Hobby</a>
                                    @endauth

                                    <span class="mx-2">Posted by: <a href="/user/{{ $hobby->user->id }}">{{ $hobby->user->name }} ({{ $hobby->user->hobbies->count() }} Hobbies)</a>
                                        <a href="/user/{{ $hobby->user->id }}"><img class="rounded" src="/img/thumb_portrait.jpg"></a>
                                    </span>

                                    @auth
                                    <form class="float-right" style="display: inline" action="/hobbies/{{ $hobby->id }}" method="post">
                                        @csrf
                                        @method("DELETE")
                                        <input class="btn btn-sm btn-outline-danger" type="submit" value="Delete">
                                    </form>
                                    @endauth

                                    <span class="float-right mx-2">{{ $hobby->created_at->diffForHumans() }}</span>
                                    <br>

                                    @foreach($hobby->tags as $tag)
                                        <a href="/hobby/tag/{{ $tag->id }}"><span class="badge badge-success">{{ $tag->name }}</span></a>
                                    @endforeach
                                    
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="mt-3">
                    {{ $hobbies->links() }}
                </div>

                @auth

                <div class="mt-2">
                    <a class="btn btn-success btn-sm" href="/hobbies/create"><i class="fas fa-plus-circle"></i> Create new Hobby</a>
                </div>

                @endauth

            </div>

        </div>

    </div>
@endsection