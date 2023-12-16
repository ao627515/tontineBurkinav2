<div id="participantIndex" class="pt-3">
    <x-custom.alert />

    <div class="card ">
        <div class="card-header p-3 bg-secondary text-center">
            <h1>Liste des participants</h1>
        </div>
        <div class="card-header bg-light d-flex justify-content-end px-5">
            <button class="btn btn-primary" wire:click="openModal('create-participant')">Créer un participant</button>
        </div>
        <div class="card-header bg-light px-5">
            <x-search-bar wire:model.live.debounce.500ms='search' name='search' placeholder='Nom, Prénom, Numéro' />
        </div>

        <div class="card-body">
            <div class="row">
                @forelse ($participants as $participant)
                    <div wire:click="edit('{{ $participant->id }}')"
                        class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3 d-flex justify-content-center"
                        wire:key='{{ $participant->id }}'>
                        <x-participant-card :participant='$participant' />
                    </div>
                @empty
                    <div class="col-12">
                        <p class="w-100 text-center lead">Vide</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @switch($modalOpen)
        @case('edit-participant')
        @case('create-participant')
            @include('includes.create-update-participant-modal')
        @break

        @case('delete-participant')
            @include('includes.confirm-delete-participant-modal')
        @break
    @endswitch
</div>
