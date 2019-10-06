
@if(isset($errors) && count($errors)>0)

<div class="alert alert-danger alert-dismissible" role="alert">

    <li>
        <strong> {{ $errors }} </strong> 
    </li>

    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

@endif