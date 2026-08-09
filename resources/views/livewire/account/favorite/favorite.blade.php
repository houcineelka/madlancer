@section('title')
{{ __('messages.t_favorite_list') }}
@endsection
<section class="py-5 header">
    <div class="container py-5">
        <div class="row pt-5">
            <div class="col-md-3" wire:ignore>
                <x-main.account.sidebar />
            </div>

            <div class="col-md-9">
                <!-- Tabs content -->
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade shadow rounded bg-white show active p-5" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <h5 class="fw-bold">{{ __('messages.t_favorite_list') }}</h5>
                        <p class="text-muted mb-4">{{ __('messages.t_favorite_list_subtitle') }}</p>
                        <p class="mb-2">
                           {{-- favorite gigs --}}
                           <div class="table-responsive">
                           
                           <table class="table table-hover">
                            <thead class="bg-light">
                              <tr>
                                <th scope="col">{{ __('messages.t_gig') }}</th>
                                <th scope="col">{{ __('messages.t_date') }}</th>
                                <th scope="col">{{ __('messages.t_options') }}</th>
                              </tr>
                            </thead>
                            <tbody>
                            @forelse ($list as $l)
                                <tr>
                                    {{-- GIGS --}}
                                    <td>
                                        <a href="{{ url('service', $l->gig->slug) }}" target="_blank" class="d-flex align-items-center">
                                            <div class="col-4 rounded d-flex align-items-center justify-content-center" style="height: 70px; width: 200px; overflow: hidden;">
                                                <img class="rounded" style="width: 100%" src="{{ src($l->gig->thumbnail) }}" alt="{{ $l->gig->title }}" />
                                            </div>
                                            <div class="p-2 col-8">
                                                <p class="overflow-hidden"><b>I will {{ $l->gig->title }}</b></p>
                                                <p class="text-muted small pt-2">@money($l->gig->price, settings('currency')->code, true)</p>
                                            </div>
                                        </a>
                                    </td>
                                    {{-- Date --}}
                                    <td class="">
                                        <span class="text-muted small">{{ format_date($l->created_at, 'ago') }}</span>
                                    </td>
                                    {{-- option --}}
                                    <td>
                                        <button class="btn btn-sm btn-danger" wire:click="delete('{{ $l->id }}')" wire:loading.remove wire:target="delete('{{ $l->id }}')">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" type="button" disabled wire:loading wire:target="delete('{{ $l->id }}')">
                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                Loading...
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th scope="row" colspan="3" class="p-0">
                                        <div class="alert alert-light text-center" role="alert">
                                            <strong>Empty</strong>
                                        </div>
                                        
                                    </th>
                                </tr>
                            @endforelse 
                              
                              
                            </tbody>
                          </table>

                        </div>
                        </p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>


