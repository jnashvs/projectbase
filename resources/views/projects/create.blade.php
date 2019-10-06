@extends('layouts.app')
@section('content')

<div class="row">

    <div class="col-md-9 col-lg-9 col-sm-9 pull-left">

        <div class="col-md-12 col-lg-12 col-sm-12" style="background: white; padding: 10px; margin: 10px;">

            <form method="post" action="{{ route('projects.store') }}">

                {{ csrf_field() }}

                <div class="form-group">
                    <label for="project-name">Name <span class="required">*</span> </label>
                    <input placeholder="Enter the name" class="form-control" id="project-name" required name="name" spellcheck="false" />
                </div>

                @if($companies != NULL)

                <div class="form-group">
                    <label for="company-name">Select Company <span class="required"></span> </label>
                    <select name="company_id" id="company">
                        @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>

                @endif

                <div class="form-group">
                    <label for="project-days">Days <span class="required">*</span> </label>
                    <input type="number" placeholder="Enter the days" class="form-control" id="project-days" required name="days" spellcheck="false" />
                </div>

                <div class="form-group">
                    <label for="project-description">Description </label>
                    <textarea placeholder="Enter the description" style="resize: vertcical" id="project-content" rows="5" spellcheck="false" class="form-control autosize-target text-left" name="description" spellcheck="false">
                    </textarea>
                </div>

                <div class="form-group">

                    <input type="submit" class="btn btn-primary" value="Submit" />

                </div>

            </form>

        </div>

    </div>

    <div class="col-sm-3 col-md-3 col-lg-3 pull-right">
        <div class="sidebar-module">
            <h4>Actions</h4>
            <ol class="list-unstyled">
                <li><a href="/projects">My projects</a></li>

        </div>

    </div>


</div>
@endsection