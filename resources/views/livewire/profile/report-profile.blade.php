<div class="blocker text-center" style="height:100vh;width:100%;"   >
    <div class="model bc-model modal pt-5" id="login" style="opacity: 1; display: inline-block;" >
        <div id="login-modal">
          <div class="login-form default-form">
            <div class="form-inner">
              <h3>Report user</h3>
                @if(session('error'))
                    <div class="alert alert-danger text-center">{{session('error')}}</div>
                @endif
              <form method="post" class="bravo-form-login" >
                <div class="form-group">
                  <label>Reason</label>
                  <textarea type="text" wire:model.defer="reason" name="reason"></textarea>
                  <span class="text-danger">
                    @error('reason')
                        {{$message}}
                    @enderror
                  </span>
                </div>
                {{-- spinner loading --}}
                <div wire:loading.flex class="text-center justify-content-center mb-3">
                    <span class="spinner-border text-primary"  role="status">
                    </span>
                </div>
                <div class="form-group">
                  <button class="theme-btn btn-style-one" name="report" wire:click.prevent="report()" wire:loading.attr="disabled" >
                    Report
                  </button>
                </div>
              </form>
              <a rel="modal:close" class="close-modal" @click="rep = false" x-show="rep" >Close</a>

            </div>

          </div>
        </div>
      </div>
</div>
