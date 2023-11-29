<div id="show-tontine">
    @if (session('success'))
        <x-alert class="alert alert-success" :dismissible='true'>
            {{ session('success') }}
        </x-alert>
    @endif
    @if (session('error'))
        <x-alert class="alert alert-danger" :dismissible='true'>
            {{ session('error') }}
        </x-alert>
    @endif
    <div class="card">
        @if ($tontineInfo)
            <div class="card-body px-5">
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
                            <li class="nav-item py-2">
                                Montant de la cotisation <span class="float-right badge bg-info">{{ $tontine->amount }}
                                    FCFA</span>
                            </li>
                            <li class="nav-item py-2">
                                Participants <span
                                    class="float-right badge bg-danger">{{ $tontine->currentParticiantsNumber() }} /
                                    {{ $tontine->number_of_members }}</span>
                            </li>
                            <li class="nav-item py-2">
                                Montant de la prise <span
                                    class="float-right badge bg-info">{{ $tontine->amount * $tontine->number_of_members }}
                                    FCFA</span>
                            </li>
                            <li class="nav-item py-2">
                                Période <span class="float-right badge bg-danger">{{ $tontine->getPeriode() }}</span>
                            </li>
                            @if ($tontine->isStarted())
                                <li class="nav-item py-2">
                                    Débute le <span
                                        class="float-right badge bg-primary">{{ App\Models\Tontine::dateFormat($tontine->started_at) }}</span>
                                </li>
                                <li class="nav-item py-2">
                                    Date de Fin <span
                                        class="float-right badge bg-info">{{ $tontine->finished_at() }}</span>
                                </li>
                                <li class="nav-item py-2 text-center">
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
        <div class="card-header bg-light d-flex justify-content-end px-5">
            <button class="btn btn-primary"
                wire:click="openModal('{{ $callActionModal }}')">{{ $btnCallAction }}</button>
        </div>
        <div class="card-header bg-light px-5">
            <x-search-bar name="search" name="avoir" />
        </div>
        <div class="card-body">
            <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="show-tontine-tabBar" role="tablist">
                        <li class="nav-item w-50 text-center">
                            <a wire:click="changePage('tontine-participants')"
                                class="nav-link @if ($page == 'tontine-participants') active @endif"
                                id="tontine-participants-tab" data-toggle="pill" href="#tontine-participants"
                                role="tab" aria-controls="tontine-participants" aria-selected="true">Participant</a>
                        </li>
                        <li class="nav-item w-50 text-center">
                            <a wire:click="changePage('tontine-contributions')"
                                class="nav-link @if ($page == 'tontine-contributions') active @endif"
                                id="tontine-contributions-tab" data-toggle="pill" href="#tontine-contributions"
                                role="tab" aria-controls="tontine-contributions" aria-selected="false">Prise de la
                                cotisation</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="show-tontine-tabBarContent">
                        <div class="tab-pane fade @if ($page == 'tontine-participants') show active @endif"
                            id="tontine-participants" role="tabpanel" aria-labelledby="tontine-participants-tab">
                            <div class="mx-5 mb-5 text-center">
                                <span>Il reste {{ $tontine->remainingTimeInDaysForPay() }} jours pour payer</span>
                                <div class="progress rounded-pill mx-2">
                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="25"
                                        aria-valuemin="0" aria-valuemax="100"
                                        style="width: {{ $tontine->progress() }}%">
                                    </div>
                                </div>
                            </div>
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-3">
                                @forelse ($tontine->participants as $participant)
                                    <div class="col mb-3">
                                        @if ($tontine->isStarted())
                                            {{-- wire:click="openModal('participant-payments')" --}}
                                            <x-participant-card wire:click="openModal('participant-payments')"
                                                x-on:click="$wire.set('participantId', '{{ $participant->id }}')"
                                                :participant='$participant' :forTontine="true" :tontine="$tontine" />
                                        @else
                                            <x-participant-card :participant='$participant' :forTontine="true" :tontine="$tontine" />
                                        @endif
                                    </div>
                                @empty
                                    <div class="col-12 d-flex jutify-content-center">
                                        <img src="{{ asset('dist/img/no_tontine.jpeg') }}" alt=""
                                            class="img-fluid">
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="tab-pane fade @if ($page == 'tontine-contributions') show active @endif"
                            id="tontine-contributions" role="tabpanel" aria-labelledby="tontine-contributions-tab">
                            Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut
                            ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur
                            adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere
                            cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis
                            posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere
                            nec nunc. Nunc euismod pellentesque diam.
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
    {{-- @include('includes.payments-modal') --}}

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

        @default
        @break
    @endswitch


</div>
