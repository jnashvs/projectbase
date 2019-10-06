@if(session()->has('success'))

<div class="alert alert-success alert-dismissible" role="alert">
  <strong>Success!</strong>  {{ session()->get('success') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

@endif