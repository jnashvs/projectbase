@extends('layouts.master')
@section('content')

<div class="row">

<div class="col-md-9 col-lg-9 col-sm-9 pull-left">
    <!-- Jumbotron -->
    <div class="jumbotron">
        <h1>{{$company->name}}</h1>
        <p class="lead">
            {{$company->description}}
        </p>

        <!-- <p><a class="btn btn-lg btn-success" href="#" role="button">Get started today</a></p> -->

    </div>

    <!-- Example row of columns -->
    <div class="row" style="background: white; padding: 10px; margin: 10px;">
        @foreach($company->projects as $project)
        <div class="col-md-4 col-lg-4 ">
            <h2> {{$project->name}}</h2>
            <p> {{$project->description}}</p>
            <p><a class="btn btn-primary" href="/projects/{{$project->id}}" role="button">View project »</a></p>
            <br>
            <br>

        </div>
        @endforeach
    </div>

</div>

<div class="col-sm-3 col-md-3 col-lg-3 pull-right">
    <div class="sidebar-module">
        <h4>Actions</h4>
        <ol class="list-unstyled">
            <li><a href="/companies/{{$company->id}}/edit">Edit</a></li>

            <li><a href="/projects/create/{{$company->id}}">Add project</a></li>

            <li><a href="/companies">List of Companies </a></li>
            
            <li><a href="/companies/create">Add new Company</a></li>


            <li>
                <a href="#" 
                onclick="
                    var result = confirm('Are you sure u want to delete this Company?');
                    if(result){
                        event.preventDefault();
                        document.getElementById('delete-form').submit();
                    }
                "
                >
                    
                Delete
                </a>
                <form method="post" action="{{ route('companies.destroy', [$company->id]) }}" id="delete-form" style="display:none;">
                    <input type="hidden" name="_method" value="delete">
                    {{ csrf_field() }}

                </form>
            </li>
            <li><a href="#">Add User</a></li>
        </ol>
    </div>
    
</div>
</div>
@endsection