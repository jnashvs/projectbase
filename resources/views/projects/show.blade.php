@extends('layouts.app')
@section('content')

<div class="row">

    <div class="col-md-9 col-lg-9 col-sm-9 pull-right">
        <!-- Jumbotron -->
        <div class="well well-lg">
            <h1>{{$project->name}}</h1>
            <p class="lead">
                {{$project->description}}
            </p>



            <!-- <p><a class="btn btn-lg btn-success" href="#" role="button">Get started today</a></p> -->

        </div>
        {{--
    <!-- Example row of columns -->
            <div class="row" style="background: white; padding: 10px; margin: 10px;">
                @foreach($projects as $project)
                <div class="col-md-4 col-lg-4 ">
                    <h2> {{$project->name}}</h2>
        <p> {{$project->description}}</p>
        <p><a class="btn btn-primary" href="/projects/{{$project->id}}" role="button">View project »</a></p>
        <br>
        <br>

    </div>
    @endforeach
</div>

--}}

<div class="container">

<br>
<br>

    @if(count($comments) != 0)
    <div class="row">
        <div class="col-md-8">
            <div class="page-header">
                <h1><small class="pull-right">{{count($comments)}} comments</small> Comments </h1>
            </div>
            <div class="comments-list">

                @foreach($comments as $comment)

                <div class="media">
                    <p class="pull-right"><small>{{$comment->created}}</small></p>
                    <a class="media-left" href="#">
                        <img src="http://lorempixel.com/40/40/people/1/">
                    </a>
                    <div class="media-body">

                        <h4 class="media-heading user_name">{{$comment->user->name}}</h4>
                        {{$comment->body}}

                        <p><small><a href="">Like</a> - <a href="">Share</a></small></p>
                    </div>
                </div>

                @endforeach

            </div>

        </div>
    </div>
    @endif

    <br>
    <br>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-lg-12">

            <form method="post" action="{{ route('comments.store') }}">

                {{ csrf_field() }}

                <input value="{{$project->id}}" type="hidden" name="commentable_id" />
                <input value="App\Project" type="hidden" name="commentable_type" />

                <div class="form-group">
                    <label for="project-description">Description </label>
                    <textarea placeholder="Enter the description" style="resize: vertcical" id="project-content" rows="3" spellcheck="false" class="form-control autosize-target text-left" name="body" spellcheck="false">
                </textarea>
                </div>

                <div class="form-group">
                    <label for="project-description">Url </label>
                    <textarea placeholder="Enter the url" style="resize: vertcical" id="project-content" rows="2" spellcheck="false" class="form-control autosize-target text-left" name="url" spellcheck="false">
                </textarea>
                </div>

                <div class="form-group">

                    <input type="submit" class="btn btn-primary" value="Submit" class="btn pull-right" />

                </div>

            </form>
        </div>

    </div>
</div>




</div>

<div class="col-sm-3 col-md-3 col-lg-3 pull-right">
    <div class="sidebar-module">
        <h4>Actions</h4>
        <ol class="list-unstyled">
            <li><a href="/projects/{{$project->id}}/edit">Edit</a></li>

            <li><a href="/projects/create">Add new project</a></li>

            <li><a href="/projects">My projects</a></li>

            <br>

            @if($project->user_id == Auth::user()->id)

            <li>
                <a href="#" onclick="
                    var result = confirm('Are you sure u want to delete this project?');
                    if(result){
                        event.preventDefault();
                        document.getElementById('delete-form').submit();
                    }
                ">

                    Delete
                </a>
                <form method="post" action="{{ route('projects.destroy', [$project->id]) }}" id="delete-form" style="display:none;">
                    <input type="hidden" name="_method" value="delete">
                    {{ csrf_field() }}

                </form>
            </li>
            @endif
        </ol>
    </div>

</div>
</div>
@endsection