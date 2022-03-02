@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">Dashboard</div>
                @auth
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <h2>Hello {{ auth()->user()->name }}</h2>

                            <h5>Your Motto {{ auth()->user()->about_me }}</h5>

                            <p><p>{{ auth()->user()->motto ?? '' }}</p></p>

                            <h5>Your "About Me" -Text</h5>

                            <p><p>{{ auth()->user()->about_me ?? '' }}</p></p>

                        </div>
                        <div class="col-md-3">
                            <img class="img-thumbnail" src="/img/300x400.jpg" alt="">
                        </div>
                    </div>



                    @isset($hobbies)

                        @if($hobbies->count() > 0)
                        <h3>Your Hobbies:</h3>

                    @endif

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
                                    <a class="btn btn-sm btn-light ml-2" href="/hobbies/{{ $hobby->id }}/edit"><i class="fas fa-edit"></i> Edit Hobby</a>
                                @endauth

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
                                    <a href="/hobby/tag/{{ $tag->id }}"><span class="badge badge-success }}">{{ $tag->name }}</span></a>
                                @endforeach
                            </li>

                        @endforeach

                    </ul>

                    @endisset

                    <a class="btn btn-success btn-sm mt-3" href="/hobbies/create"><i class="fas fa-plus-circle"></i> Create new Hobby</a>
                
                </div>

                @endauth

                @guest
                    <div class="card-body">
                        What is Lorem Ipsum?
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
                    </div>
                @endguest
                
            </div>
        </div>
    </div>
</div>

@endsection
