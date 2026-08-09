@section('title')
{{ __('messages.t_update_password') }}
@endsection
<section class="py-5 header">
    {{-- Loading indicator --}}
    <div class="fixed-top bg-light opacity-50" style="z-index: 9999; height: 100vh;width: 100%" wire:loading>
      <div role="status" class="d-flex justify-content-center align-items-center" style="height: 100%;"> <svg aria-hidden="true" style="height: 100px;width: 100px;" class="text-primary  spinner-border" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/> <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/> </svg> <span class="sr-only">Loading...</span> </div>
    </div>
    <div class="container py-5">
        <div class="row pt-5">
            <div class="col-md-3" wire:ignore>
                <x-main.account.sidebar />
            </div>
            @php
                $isInvalid = 'border-danger text-danger';
            @endphp

            <div class="col-md-9">
                <!-- Tabs content -->
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade shadow rounded bg-white show active p-5" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <h5 class="fw-bold">{{ __('messages.t_update_password') }}</h5>
                        <p class="text-muted mb-4">{{ __('messages.t_update_password_subtitle') }}</p>
                        <p class="mb-2">
                            <form class="row">
                                
                                
                                {{-- Current password --}}
                                <div class="col-md-12 mb-2">
                                    <div class="form-group">
                                        <label for="account-current_password">{{ __('messages.t_current_password') }}</label>
                                        <input class="form-control @error('current_password'){{$isInvalid}} @enderror" type="password" id="account-current_password" placeholder="{{ __('messages.t_enter_your_current_password') }}" wire:model.defer="current_password" name="current_password">
                                        <span class="text-danger">@error('current_password'){{$message}} @enderror</span>
                                    </div>
                                </div>
                                
                                {{-- new password --}}
                                <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                        <label for="account-new_password">{{ __('messages.t_new_password') }}</label>
                                        <input class="form-control @error('new_password'){{$isInvalid}} @enderror" type="password" id="account-new_password" placeholder="{{ __('messages.t_enter_new_password') }}" wire:model.defer="new_password" name="new_password">
                                        <span class="text-danger">@error('new_password'){{$message}} @enderror</span>
                                    </div>
                                </div>
                                
                                
                                {{-- confirmation password --}}
                                <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                        <label for="account-new_password_confirmation">{{ __('messages.t_password_confirmation') }}</label>
                                        <input class="form-control @error('new_password_confirmation'){{$isInvalid}} @enderror" type="password" id="account-new_password_confirmation" placeholder="{{ __('messages.t_enter_password_confirmation') }}" wire:model.defer="new_password_confirmation" name="new_password_confirmation">
                                        <span class="text-danger">@error('new_password_confirmation'){{$message}} @enderror</span>
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <hr class="mt-2 mb-3">
                                    <div class="d-flex flex-wrap justify-content-end align-items-center">
                                        <button class="btn btn-style-1 btn-primary" wire:click='update' type="button">{{ __('messages.t_update') }}</button>
                                    </div>
                                </div>
                            </form>
                        </p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
