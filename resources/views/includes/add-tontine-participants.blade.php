<div class="card">
    <div class="sticky-top bg-white p-3">
        <x-search-bar wire:model.live.debounce.500ms='searchAddPaticipant' name='searchAddPaticipant'
            placeholder="Nom, Numéro du participant" />
    </div>
    <div class="card-body">
        <div class="row row-cols-1">
            @forelse ($allParticipants as $participant)
                <div class="col d-flex justify-content-center mb-3" wire:key='{{ $participant->id }}'>
                    <x-participant-card :participant="$participant" :selected="$selected" />
                    {{-- @include('includes.participant-card') --}}
                </div>
            @empty
            @endforelse
        </div>
    </div>
</div>



