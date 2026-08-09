<div>
<div class="card">
    <div class="card-body">
        <div class="m-sm-4">
            <form method="post">
                @if(session('error'))
                <div class="alert alert-danger text-center">
                    {{session('error')}}
                </div>
                @endif
                @if(session('send'))
                <div class="alert alert-success text-center">
                    {{session('send')}}
                </div>
                @endif
                
                {{-- spinner loading --}}
                <div wire:loading.flex class="text-center justify-content-center mb-3">
                    <span class="spinner-border text-primary"  role="status">
                    </span>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control form-control-lg" type="email" wire:model.defer="email" name="email" placeholder="Enter your email">
                    <span class="text text-danger">@error('email')
                        {{$message}}
                    @enderror</span>
                </div>
                <div class="text-center mt-3">
                     <button  class="btn btn-lg btn-primary" wire:click.prevent="send()">Reset password</button>
                     <a  class="btn btn-lg btn-primary" href={{url('/')}}>Back to Home</a>

                </div>
            </form>
        </div>
    </div>
</div></div>