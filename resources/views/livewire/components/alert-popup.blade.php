<div class="alert alert-{{$type}} alert-dismissible fade show ms-auto col-7 row" style="" role="alert">
    
    <span class="material-icons-outlined d-inline-block col-1">
        {{$icon}}
    </span>
    {{-- message --}}
    <span class="col-auto">
        {!! $message !!}
    </span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>