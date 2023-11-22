<div class="card mb-3 rounded tontine-card" style="max-width: 340px;">
        <div class="row no-gutters">
            <div class="col-3 col-sm-3 pt-3">
                <img src="{{ asset('dist/img/tontine_card_2.jpg') }}" alt="..."
                    class="img-thumbnail img-fluid rounded-circle border-0" height="100px" width="100px">
            </div>
            <div class="col-9 col-sm-9">
                <div class="card-body p-3">
                    <h5 class="font mb-1">{{ $tontine->name }}</h5>
                    <h5 class="font mb-1">Membres : {{ $tontine->number_of_members }}</h5>
                    <h5 class="font mb-1">Période : {{ $tontine->delay . ' ' . $tontine->delay_unity }}</h5>
                    <div class="font">
                        <x-badge class="py-1 px-3" :type="$conf['type']" variant="pill">{{ $conf['status'] }}</x-badge>
                    </div>
                </div>
            </div>
            @unless ($tontine->isNotStarted())
                <div class="col px-2 py-1">
                    <div class="d-flex justify-content-between align-items-center text-center">
                        <span class="date w-25">10 nov 2023</span>
                        <div class="progress rounded-pill w-50 mx-2">
                            <div class="progress-bar bg-orange" role="progressbar" aria-valuenow="25" aria-valuemin="0"
                                aria-valuemax="100" style="width: 50%">
                            </div>
                        </div>
                        <span class="date w-25">10 mar 2024</span>
                    </div>
                </div>
            @endunless
        </div>
</div>
