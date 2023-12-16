<form wire:submit='storeAndAddParticipant' id="addTontineParticipant">
    <div class="row row-cols-1">
        <div class="col">
            <x-forms.input wire:model='participantForm.last_name' :group="[
                'class' => 'mb-3',
            ]" name="participantForm.last_name"
                type="text" required :label="[
                    'text' => 'Nom',
                    'class' => 'font-label',
                ]" />
        </div>
        <div class="col">
            <x-forms.input wire:model='participantForm.first_name' :group="[
                'class' => 'mb-3',
            ]" name="participantForm.first_name"
                type="text" required :label="[
                    'text' => 'Prénom (s)',
                    'class' => 'font-label',
                ]" />
        </div>

        <div class="col">
            <x-forms.input wire:model='participantForm.phone_number' :group="[
                'class' => 'mb-3',
            ]"
                name="participantForm.phone_number" type="number" required :label="[
                    'text' => 'Numéro',
                    'class' => 'font-label',
                ]" />
        </div>

        <fieldset class="border">
            <legend class="ml-3">CNIB (optionel)</legend>
            <div class="col">
                <x-forms.upload wire:model='participantForm.identity_document_front' class="mb-3 custom-file-input"
                    name="participantForm.identity_document_front" placeholder="CNIB face" />
                @if ($participantForm->identity_document_front instanceof Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                    <img src="{{ $participantForm->identity_document_front->temporaryUrl() }}"
                        class="img-fluid img-thumbnail mb-3">
                @else
                    @if ($participantForm->identity_document_front)
                        <img src="{{ asset($participantForm->identity_document_front) }}" class="img-fluid img-thumbnail mb-3">
                    @endif
                @endif
            </div>
            <div class="col">
                <x-forms.upload class="mb-3 custom-file-input" wire:model='participantForm.identity_document_back'
                    name="participantForm.identity_document_back" placeholder="CNIB recto" />
                @if ($participantForm->identity_document_back instanceof Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                    <img src="{{ $participantForm->identity_document_back->temporaryUrl() }}" class="img-fluid img-thumbnail mb-3">
                @else
                    @if ($participantForm->identity_document_back)
                        <img src="{{ asset($participantForm->identity_document_back) }}" class="img-fluid img-thumbnail mb-3">
                    @endif
                @endif
            </div>
        </fieldset>
    </div>
</form>
