<div class="modal show" tabindex="-1" style="display: block;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Creer un participants</h5>
                <button wire:click='closeModal' type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form  @if($modalOpen == 'create-participant') wire:submit='store' @else wire:submit="update('{{ $participantId }}')" @endif id="createParticipant">
                    <div class="row row-cols-1">
                        <div class="col">
                            <x-forms.input wire:model='form.last_name' :group="[
                                'class' => 'mb-3',
                            ]" name="form.last_name"
                                type="text" required :label="[
                                    'text' => 'Nom',
                                    'class' => 'font-label',
                                ]" />
                        </div>
                        <div class="col">
                            <x-forms.input wire:model='form.first_name' :group="[
                                'class' => 'mb-3',
                            ]" name="form.first_name"
                                type="text" required :label="[
                                    'text' => 'Prénom (s)',
                                    'class' => 'font-label',
                                ]" />
                        </div>

                        <div class="col">
                            <x-forms.input wire:model='form.phone_number' :group="[
                                'class' => 'mb-3',
                            ]" name="form.phone_number"
                                type="number" required :label="[
                                    'text' => 'Numéro',
                                    'class' => 'font-label',
                                ]" />
                        </div>

                        <fieldset class="border">
                            <legend class="ml-3">CNIB (optionel)</legend>
                            <div class="col">
                                <x-forms.upload wire:model='form.identity_document_front' class="mb-3 custom-file-input"
                                    name="form.identity_document_front" placeholder="CNIB face" />
                            </div>
                            <div class="col">
                                <x-forms.upload class="mb-3 custom-file-input" wire:model='form.identity_document_back'
                                    name="form.identity_document_back" placeholder="CNIB recto" />
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button wire:click='closeModal' type="button" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
                <button wire:click="openModal('delete-participant')" type="button" class="btn btn-danger"
                    data-dismiss="modal">Suprimer</button>
                <button type="submit" form="createParticipant" class="btn btn-primary">@if($modalOpen == 'create-participant') Créer @else Modifier @endif</button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
