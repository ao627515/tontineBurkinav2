<div id="home">
    <x-custom.alert />

    <div class="card">
        <div class="card-header bg-light d-flex justify-content-end px-5">
            <button class="btn btn-primary" wire:click="openModal">Créer une tontine</button>
        </div>
        <div class="card-header bg-light px-5">
            <x-search-bar wire:model.live.debounce.500ms='search' name='search' placeholder='Nom de la tontine' />
        </div>

        <div class="card-body">
            <div class="row">
                @forelse ($tontines as $tontine)
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3" wire:key="{{ $tontine->id }}">
                        <a href="{{ route('tontine.show', $tontine) }}" wire:navigate class="text-reset">
                            <x-tontine-card :tontine="$tontine" />
                        </a>
                    </div>
                @empty
                    <div class="col-12 d-flex jutify-content-center">
                        <img src="{{ asset('dist/img/no_tontine.jpeg') }}" alt="" class="img-fluid">
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    @if ($modalIsOpen)
        @include('includes.create-tontine-form')
    @endif

    {{-- fin component --}}
</div>
