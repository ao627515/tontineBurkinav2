@php
    $participant = $tontine->participantGetContributions();
@endphp

<div class="modal show" tabindex="-1" style="display: block;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Prise de la cotation</h5>
          <button wire:click='closeModal' type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Voulez vous confirmer que <strong>{{ $participant->last_name.' '.$participant->first_name }}</strong> à pris la cotisation</p>
        </div>
        <div class="modal-footer">
          <button wire:click='closeModal' type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
          <button wire:click="getContributions('{{ $participant->id }}')" type="button" class="btn btn-primary">Oui</button>
        </div>
      </div>
    </div>
  </div>
<div class="modal-backdrop fade show"></div>

