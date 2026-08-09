@section('title')
{{ __('messages.t_delivered_work') }}
@endsection
<section class="py-5 header">
    <div class="container py-5">
        <div class="row pt-5">
            <div class="col-md-3" wire:ignore>
                <x-main.account.sidebar />
            </div>

            <div class="col-md-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade shadow rounded bg-white show active p-5" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <h5 class="fw-bold">{{ __('messages.t_delivered_work') }}</h5>
                        <p class="text-muted mb-4">{{ $item->gig->title }}</p>

                        {{-- Delivery history --}}
                        @forelse ($deliveries as $delivery)
                            <div class="card shadow-sm mb-3">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1" style="font-size: 12px;">{{ format_date($delivery->created_at, 'F j, Y h:i A') }}</p>
                                        @if ($delivery->quick_response)
                                            <p class="mb-0">{{ $delivery->quick_response }}</p>
                                        @endif
                                    </div>
                                    @if ($delivery->attached_work)
                                        <a href="{{ url('orders/delivered/download', [request()->query('orderId'), $item->uid, $delivery->id, $delivery->attached_work['id']]) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fa fa-download me-2" aria-hidden="true"></i>{{ __('messages.t_delivered_work') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-light">
                                {{ __('messages.t_no_messages_yet_subtitle') }}
                            </div>
                        @endforelse

                        {{-- Conversation --}}
                        <h6 class="fw-bold mt-5">{{ __('messages.t_messages') }}</h6>
                        <div class="mb-3" style="max-height: 400px; overflow-y:auto;">
                            @forelse ($conversation as $msg)
                                <div class="card shadow-sm mb-2">
                                    <div class="card-body py-2">
                                        <p class="text-muted mb-1" style="font-size: 12px;">{{ $msg->from->username }} &middot; {{ format_date($msg->created_at, 'F j, Y h:i A') }}</p>
                                        <p class="mb-0">{{ $msg->msg_content }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">{{ __('messages.t_no_messages_yet') }}</p>
                            @endforelse
                        </div>

                        <form wire:submit.prevent="send">
                            <div class="mb-3">
                                <textarea wire:model.defer="message" class="form-control" rows="3"></textarea>
                                @error('message') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="send">
                                {{ __('messages.t_send') }}
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
