<div class="modal show" tabindex="-1" style="display: block;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Recommencer une tontine</h5>
                <button wire:click='closeModal' type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Confirmer vous, vouloir recommencer cette tontine <br>
                    <small>
                        <strong>Nb : </strong>Cela créera une nouvelle tontine avec les mêmes informations et participants.
                    </small>
                </p>
            </div>
            <div class="modal-footer">
                <button wire:click='closeModal' type="button" class="btn btn-secondary"
                    data-dismiss="modal">Non</button>
                <button wire:click="relaunch" type="button" class="btn btn-primary">Oui</button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
