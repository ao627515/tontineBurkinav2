<div class="modal show" tabindex="-1" style="display: block;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Suspendre</h5>
                <button wire:click='closeModal' type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Confirmer vous, vouloir Suspendre la tontine <strong>{{ $tontine->name }}</strong><br>
                    <small>
                        <strong>Nb : </strong>Cette action est irreverible
                    </small>
                </p>

                <x-forms.textarea wire:model.live='suspension_reason' :group="['class' => 'mb-3']" :label="['text' => 'Motif (optionnelle)']" rows="5"/>
            </div>
            <div class="modal-footer">
                <button wire:click='closeModal' type="button" class="btn btn-secondary"
                    data-dismiss="modal">Non</button>
                <button wire:click="cancelTontine()" type="button" class="btn btn-primary">Oui</button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
