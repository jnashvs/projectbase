@extends('layouts.master')
@section('content')

<div class="row">

    <div class="col-md-9 col-lg-9 col-sm-9 pull-left">

        <div class="col-md-12 col-lg-12 col-sm-12" style="background: white; padding: 10px; margin: 10px;">

            <form method="post" action="{{ route('companies.update', [$company->id]) }}">

                {{ csrf_field() }}

                <input type="hidden" name="_method" value="put">

                <div class="form-group">
                    <label for="company-name">Name <span class="required">*</span> </label>
                    <input placeholder="Enter the name" class="form-control" id="company-name" required name="name" spellcheck="false" value="{{ $company->name }}" />
                </div>

                <div class="form-group">
                    <label for="company-description">Description </label>
                    <textarea placeholder="Enter the description" style="resize: vertcical" id="company-content" rows="5" spellcheck="false" class="form-control autosize-target text-left" name="description" spellcheck="false">
                    {{ $company->description }}
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
                <li><a href="/companies/{{$company->id}}">Back list companies</a></li>
                <li><a href="/companies">All companies</a></li>

        </div>

    </div>


</div>
@endsection