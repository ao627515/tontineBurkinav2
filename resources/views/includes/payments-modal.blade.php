<div class="modal show" tabindex="-1" style="display: block;">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Paiements</h5>
                <button wire:click='closeModal' type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @foreach ($payments->where('id', $participantId) as $payments)
                    <div class="card mb-3 payment-card" style="max-width: 440px;">
                        <div class="modal-header bg-secondary p-1 p-sm-2">
                            <h5 class="modal-title">Paiement {{ $loop->iteration }}</h5>
                            @if ($loop->last)
                                <button wire:click="cancelPayment('{{ $participantId }}')" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            @endif
                        </div>
                        <div class="row no-gutters">
                            <div class="col-9">
                                <div class="card-body">
                                    <h5 class="font-title"><strong>Montant</strong> : {{ $tontine->amount }} Franc cfa</h5>
                                    <h6 class="font-sub-title"><strong>A payé le :</strong>{{ App\Models\Tontine::dateFormat($payments->pivot->created_at) }}</h6>
                                </div>
                            </div>
                            <div class="col-3 p-sm-3 pt-2">
                                {{-- <i class="fa-solid fa-circle-check fa-xl" style="color: #06d039;"></i> --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="img-thumbail img-fluid" heigth="60"
                                    width="60"
                                    viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                                    <path fill="#06d039"
                                        d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                                </svg>
                                {{-- <img src="..." alt="..."> --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <button wire:click='closeModal' type="button" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
                <button wire:click="storePayment('{{ $participantId }}')" type="button"
                    class="btn btn-primary">Enregistré</button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>

@script
    <script>
        setInterval(() => {
            $wire.$refresh()
        }, 2000);
    </script>
@endscript
