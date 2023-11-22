<div>
    <!-- Modal -->
    <div class="modal show" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true"
        style="display: block;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center">
                    <h5 wire:click='closeModal' class="modal-title" id="modalLabel"><a role="button"><i
                                class="fa-solid fa-arrow-left mr-4"></i></a> Créer une tontine</h5>
                </div>
                <div class="modal-body">
                    <form wire:submit="storeTontine" id="createTontine">
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="border border-secondary p-1 mb-3">
                                    <div class="bg-orange py-2" id="amount-contribution-taken">
                                        <h5 class="mb-2 font-sub-title text-center font-weight-bold">Montant de la
                                            prise</h5>
                                        <h6 class="m-0 font-title text-center">
                                            <strong>
                                                @if ($tontineForm->amount != '' &&  $tontineForm->number_of_members != '')
                                                    {{ $tontineForm->amount * $tontineForm->number_of_members }}
                                                    @else
                                                    0
                                                @endif
                                            </strong>
                                            Franc cfa
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <x-forms.input wire:model='tontineForm.name' :group="[
                                    'class' => 'mb-3',
                                ]" name="tontineForm.name"
                                    type="text" required :label="[
                                        'text' => 'Nom de la tontine',
                                        'class' => 'font-label',
                                    ]" />
                            </div>
                            <div class="col">
                                <fieldset class="border py-1 px-3 mb-3">
                                    <legend>Périodicité</legend>
                                    <div class="row">
                                        <div class="col">
                                            <x-forms.input wire:model='tontineForm.delay' name="tontineForm.delay"
                                                type="number" />
                                        </div>
                                        <div class="col">
                                            <x-forms.select wire:model='tontineForm.delay_unity'
                                                name="tontineForm.delay_unity" :options="$delay_unity" />
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <x-forms.input wire:model.live.debounce.2000ms='tontineForm.amount'
                                            :group="[
                                                'class' => 'mb-3',
                                            ]" name="tontineForm.amount" type="number" required
                                            :label="[
                                                'text' => 'Montant',
                                                'class' => 'font-label',
                                            ]" />
                                    </div>
                                    <div class="col">
                                        <x-forms.input wire:model='tontineForm.profit' :group="[
                                            'class' => 'mb-3',
                                        ]"
                                            name="tontineForm.profit" type="number" required :label="[
                                                'text' => 'Bénéfice',
                                                'class' => 'font-label',
                                            ]"
                                            placeholder="0" />
                                    </div>
                                    <div class="col">
                                        <x-forms.input wire:model.live.debounce.2000ms='tontineForm.number_of_members'
                                            :group="[
                                                'class' => 'mb-3',
                                            ]" name="tontineForm.number_of_members" type="number"
                                            required :label="[
                                                'text' => 'Membres',
                                                'class' => 'font-label',
                                            ]" placeholder="1" />
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <x-forms.textarea wire:model='tontineForm.description' name="tontineForm.description"
                                    rows="3" :label="[
                                        'text' => 'Description',
                                        'class' => 'font-label',
                                    ]" />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-around">
                    <button type="submit" form="createTontine" class="btn btn-success"><i class="fa fa-check"></i>
                        Créer</button>
                    <button wire:click='closeModal' type="button" class="btn btn-danger"><i class="fa fa-cancel"></i>
                        Annuler</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
</div>
