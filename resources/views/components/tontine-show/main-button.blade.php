<div class="card-header bg-light d-flex justify-content-end px-5">
    {{-- Tontine non commencée --}}
    @if ($tontine->isNotStarted())
        {{-- Tontine non commencée et pleine --}}
        @if ($tontine->isFull())
            <button class="btn btn-info mr-3" wire:click="openModal('add-participant')">
                <i class="fas fa-users mr-2"></i>Participants
            </button>
            <button class="btn btn-success" wire:click="openModal('start-tontine')">
                <i class="fas fa-play mr-2"></i>Commencer
            </button>
        @else
            {{-- Tontine non commencée et non pleine --}}
            <button class="btn btn-success" wire:click="openModal('add-participant')">
                <i class="fas fa-user-plus mr-2"></i>Ajouter
            </button>
        @endif
    {{-- Tontine en cours --}}
    @elseif ($tontine->isStarted())
        {{-- Page des participants --}}
        @if ($page == 'tontine-participants')
            <button class="btn btn-danger" wire:click="openModal('cancel-tontine')">
                <i class="fas fa-times mr-2"></i>Annuler
            </button>
        {{-- Page des contributions --}}
        @elseif ($page == 'tontine-contributions')
            <button class="btn btn-danger mr-3" wire:click="openModal('cancel-tontine')">
                <i class="fas fa-times mr-2"></i>Annuler
            </button>
            {{-- Bouton de validation des contributions si autorisé --}}
            @if ($tontine->canGetContribution())
                <button class="btn btn-success" wire:click="openModal('get-contributions')">
                    <i class="fas fa-check mr-2"></i>Valider
                </button>
            @endif
        @endif
    {{-- Tontine terminée ou annulée --}}
    @elseif ($tontine->isFinish() || $tontine->isCancel())
        <button class="btn btn-info mr-3" wire:click="openModal('tontine-relaunch')">
            <i class="fas fa-redo mr-2"></i>Recommencer
        </button>
    @endif
</div>
