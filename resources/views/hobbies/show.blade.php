@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">Hobby Detail</div>

                    <div class="card-body">
                        
                        <div class="row">
                            <div class="col-md-9">

                                <b>{{$hobby->title}}</b>

                                <p>{{$hobby->description}}</p>

                                @if($hobby->tags->count() > 0)

                                    <b>Used Tags:</b> (Click to remove)
                                    <p>
                                        @foreach($hobby->tags as $tag)
                                            <a href="/hobby/{{$hobby->id}}/tag/{{$tag->id}}/detach"><span class="badge badge-success">{{ $tag->name }}</span></a>
                                        @endforeach
                                    </p>
                                @endif

                                @if($availableTags->count() > 0)

                                    <b>Available Tags:</b> (Click to assign)
                                    <p>
                                        @foreach($availableTags as $tag)
                                            <a href="/hobby/{{$hobby->id}}/tag/{{$tag->id}}/attach"><span class="badge badge-success }}">{{ $tag->name }}</span></a>
                                        @endforeach
                                    </p>
                                @endif
                            </div>

                            <div class="col-md-3">
                                
                                @if (Auth::user() && file_exists('img/hobbies/'.$hobby->id.'_large.jpg'))
                                <a href="/img/hobbies/{{ $hobby->id }}_large.jpg" data-lightbox="/img/hobbies/{{ $hobby->id }}_large.jpg" data-title="{{ $hobby->title }}">
                                    <img class="img-fluid" src="/img/hobbies/{{ $hobby->id }}_large.jpg" alt="">
                                </a>
                                @endif

                                @if (!Auth::user() && file_exists('img/hobbies/'.$hobby->id.'_pixelated.jpg'))
                                    <img class="img-fluid" src="/img/hobbies/{{ $hobby->id }}_pixelated.jpg" alt="">
                                @endif

                                <i class="fa fa-search-plus"></i> Click image to enlarge

                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
@endsection