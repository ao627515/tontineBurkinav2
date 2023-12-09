<div id="show-tontine">
    <x-custom.alert />
    <div class="card">
        @if ($tontineInfo)
            <div class="card-body px-sm-5 " id="tontineInfo">
                <div class="card mb-3">
                    <div class="card-header bg-secondary text-center p-2">
                        <i wire:click='closeTontineInfo' class="fa-solid fa-xmark icon-close"></i>
                        <h3>{{ $tontine->name }}</h3>
                        <x-badge :type="$tontine->getStatusBadgeColor()" class="p-1" :text="$tontine->getStatus()" variant="pill" />
                    </div>
                    <div class="card-body bg-light">
                        <ul class="nav flex-column">
                            <li class="nav-item py-2">
                                Créer le <span
                                    class="float-right badge bg-primary">{{ App\Models\Tontine::dateFormat($tontine->created_at) }}</span>
                            </li>
                            <li class="nav-item py-2 font-title">
                                Montant de la cotisation <span class="float-right badge bg-info">{{ $tontine->amount }}
                                    FCFA</span>
                            </li>
                            <li class="nav-item py-2 font-title">
                                Participants <span
                                    class="float-right badge bg-danger">{{ $tontine->currentParticiantsNumber() }} /
                                    {{ $tontine->number_of_members }}</span>
                            </li>
                            <li class="nav-item py-2 font-title">
                                Montant de la prise <span
                                    class="float-right badge bg-info">{{ $tontine->amount * $tontine->number_of_members }}
                                    FCFA</span>
                            </li>
                            <li class="nav-item py-2 font-title">
                                Période <span class="float-right badge bg-danger">{{ $tontine->getPeriode() }}</span>
                            </li>
                            @if (!$tontine->isNotStarted())
                                <li class="nav-item py-2 font-title">
                                    Débute le <span
                                        class="float-right badge bg-primary">{{ App\Models\Tontine::dateFormat($tontine->started_at) }}</span>
                                </li>
                                <li class="nav-item py-2 font-title">
                                    Date de Fin <span
                                        class="float-right badge bg-info">{{ $tontine->finished_at() }}</span>
                                </li>
                                <li class="nav-item py-2 text-center font-title">
                                    <span>Il reste {{ $tontine->remainingTimeInDays() }} jours</span>
                                    <div class="progress rounded-pill mx-2">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="25"
                                            aria-valuemin="0" aria-valuemax="100"
                                            style="width: {{ $tontine->progress() }}%">
                                        </div>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>

                </div>
            </div>
        @endif
        {{-- <div class="card-header bg-light d-flex justify-content-end px-5">
            @if ($tontine->isFull() and $tontine->isNotStarted())
                <button class="btn btn-info mr-3" wire:click="openModal('add-participant')">Participants</button>
            @endif
            <button class="btn btn-primary"
                wire:click="openModal('{{ $callActionModal }}')">{{ $btnCallAction }}</button>
        </div> --}}
        <x-tontine-show.main-button :tontine="$tontine" :page="$page" />
        {{-- <div class="card-header bg-light px-5">
            <x-search-bar name="search" name="avoir" />
        </div> --}}
        <div class="card-body">
            @php
                // Nombre de participant a la tontine
                $participantsNumber = $tontine->participants->count();
            @endphp
            <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="show-tontine-tabBar" role="tablist">
                        <li class="nav-item @if ($participantsNumber >= 1) w-50 @else w-100 @endif text-center">
                            <a wire:click="changePage('tontine-participants')"
                                class="nav-link @if ($page == 'tontine-participants') active @endif"
                                id="tontine-participants-tab" data-toggle="pill" href="#tontine-participants"
                                role="tab" aria-controls="tontine-participants"
                                aria-selected="true">Participants</a>
                        </li>

                        @if ($participantsNumber >= 1)
                            <li class="nav-item w-50 text-center">
                                <a wire:click="changePage('tontine-contributions')"
                                    class="nav-link @if ($page == 'tontine-contributions') active @endif"
                                    id="tontine-contributions-tab" data-toggle="pill" href="#tontine-contributions"
                                    role="tab" aria-controls="tontine-contributions" aria-selected="false">Prise
                                    de
                                    la
                                    cotisation</a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="show-tontine-tabBarContent">
                        <div class="tab-pane fade @if ($page == 'tontine-participants') show active @endif"
                            id="tontine-participants" role="tabpanel" aria-labelledby="tontine-participants-tab">
                            @if ($tontine->status != 'creating')
                                <div class="mx-5 mb-5 text-center">
                                    <span>Il reste {{ $tontine->remainingTimeInDaysForPay() }} jours pour
                                        payer</span>
                                    <div class="progress rounded-pill mx-2">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="25"
                                            aria-valuemin="0" aria-valuemax="100"
                                            style="width: {{ $tontine->progress() }}%">
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                @forelse ($tontine->participants as $participant)
                                    <div class="col-12 col-sm-6 col-lg-4 mb-3">
                                        @if ($tontine->isStarted())
                                            {{-- wire:click="openModal('participant-payments')" --}}
                                            <x-participant-card wire:click="openModal('participant-payments')"
                                                x-on:click="$wire.set('participantId', '{{ $participant->id }}')"
                                                :participant='$participant' :forTontine="true" :tontine="$tontine" />
                                        @else
                                            <x-participant-card :participant='$participant' :forTontine="true"
                                                :tontine="$tontine" />
                                        @endif
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <p class="w-100 lead text-center">Aucun participants</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        @if ($participantsNumber >= 1)
                            <div class="tab-pane fade @if ($page == 'tontine-contributions') show active @endif"
                                id="tontine-contributions" role="tabpanel" aria-labelledby="tontine-contributions-tab">
                                <div class="card">
                                    @php
                                        $pgc = $tontine->participantGetContributions();
                                    @endphp
                                    @if ($pgc != null)
                                        <div class="card-header d-flex justify-content-center ">
                                            <x-participant-card :participant='$pgc' />
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <div class="row">
                                            @forelse ($tontine->getContributions()->orderBy('created_at', 'desc')->get() as $participant)
                                                <div class="col-12 col-3 mb-3" wire:key='{{ $participant->id }}'>
                                                    <x-participant-card :participant='$participant' />
                                                </div>
                                            @empty
                                                <div class="col-12">
                                                    <p class="lead text-center w-100">Vide</p>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>



    @switch($modalOpen)
        @case('add-participant')
            @include('includes.tontine-participants-modal')
        @break

        @case('start-tontine')
            @include('includes.startTontine-modal')
        @break

        @case('participant-payments')
            @include('includes.payments-modal')
        @break

        @case('get-contributions')
            @include('includes.confirm-getContribution-modal')
        @break

        @case('cancel-tontine')
            @include('includes.confirm-cancel-tontine-modal')
        @break

        @case('edit-tontine')
            @include('includes.create-tontine-form')
        @break

        @case('delete-tontine')
        @include('includes.confirm-delete-tontine-modal')
        @break
    @endswitch
</div>
