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
                  
                    @if(session('pass'))
                    <div class="alert alert-danger text-center">
                        {{session('pass')}}
                    </div>
                    @endif
                    
                    {{-- spinner loading --}}
                    <div wire:loading.flex class="text-center justify-content-center mb-3">
                        <span class="spinner-border text-primary"  role="status">
                        </span>
                    </div>
                    <div class="form-group">
                        <label>new Password</label>
                        <input class="form-control form-control-lg" type="password" wire:model.defer="password" name="email" placeholder="Enter your new password">
                        <span class="text text-danger">@error('password')
                            {{$message}}
                        @enderror</span>
                    </div>
                    <div class="form-group">
                        <label>confirm Password</label>
                        <input class="form-control form-control-lg" type="password"  wire:model.defer="password_confirmation" name="email" placeholder="confirm password">
                        
                    </div>
                    <div class="text-center mt-3">
                         <button  class="btn btn-lg btn-success" wire:click.prevent="update()">Update password</button>
                        </div>
                </form>
            </div>
        </div>
    </div></div>