<div class="modal show" tabindex="-1" style="display: block;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Commencé la tontine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Voulez-vous démarré cette tontine ?</p>
                <form wire:submit='startTontine' id="startTontineForm">
                    <x-forms.input wire:model='started_at' type="date" :label="['text' => 'A commencé le (prend la date d\'aujoudhui par defaut) ','class' => 'font-label']"  name="started_at" />
                </form>
                      </div>
            <div class="modal-footer">
                <button wire:click='closeModal' type="button" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
                <button form="startTontineForm" type="submit" class="btn btn-primary">Oui</button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
