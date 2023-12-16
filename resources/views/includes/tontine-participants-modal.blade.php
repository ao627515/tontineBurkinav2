<div class="modal show" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" style="display: block;">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center">
                <h5 wire:click='closeModal' class="modal-title" id="modalLabel"><a role="button"><i
                            class="fa-solid fa-arrow-left mr-4"></i></a>Ajouté un participant</h5>
            </div>
            <div class="card-header">
                <ul class="nav nav-tabs sticky-top" id="tabBar">
                    <li class="nav-item">
                        <a wire:click="addOrCreateAndAdd('add-participant')" class="nav-link @if ($tontineParticipantModal == 'add-participant') active @endif" id="tab1" data-toggle="tab" href="#content1">Ajouter uniquement</a>
                    </li>
                    <li class="nav-item">
                        <a wire:click="addOrCreateAndAdd('add-create-participant')"  class="nav-link @if ($tontineParticipantModal == 'add-create-participant') active @endif" id="tab2" data-toggle="tab" href="#content2">Ajouter et Créer </a>
                    </li>
                </ul>
            </div>
            <div class="modal-body pt-0">

                <div class="tab-content">
                    <div id="content1" class="tab-pane fade @if ($tontineParticipantModal == 'add-participant') show active @endif">
                        <!-- Contenu de l'onglet 1 -->
                        @include('includes.add-tontine-participants')
                    </div>

                    <div id="content2" class="tab-pane px-2 fade @if($tontineParticipantModal == 'add-create-participant') show active @endif">
                        <!-- Contenu de l'onglet 2 -->
                        @include('includes.create-and-add-tontine-participants-from')
                    </div>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-around">
                <button @if ($tontineParticipantModal == 'add-participant') wire:click='addTontineParticipant' @endif type="submit"
                    form="addTontineParticipant" class="btn btn-success"><i class="fa fa-check"></i>
                    Enregisté</button>
                <button wire:click='closeModal' type="button" class="btn btn-danger"><i
                        class="fa fa-cancel"></i>
                    Annuler</button>
                {{-- <button wire:click='closeModal' type="button" class="btn btn-danger"><i class="fa fa-cancel"></i>
                    Annuler</button> --}}
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>

@script
    <script>
        $(document).ready(function() {
            var maxParticipants = {{ $tontine->number_of_members }};
            $('.participant-card').on('click', function() {
                var participantId = $(this).data('participantid');
                // Vérifier si le nombre actuel de cartes sélectionnées est inférieur à la limite
                if ($('.participant-card.active').length < maxParticipants) {
                    // Si l'élément a déjà la classe active, la retirer
                    if ($(this).hasClass('active')) {
                        $(this).removeClass('active');
                        $wire.removeSelected(participantId);
                    } else {
                        // Ajouter la classe active à l'élément
                        $(this).addClass('active');
                        // Ajouter la classe active à tous les éléments ayant la même classe
                        $('.clickable').addClass('active');
                        // Vous pouvez également utiliser la valeur de participantId ici
                        $wire.addSelected(participantId);
                    }
                } else {
                    if ($(this).hasClass('active')) {
                        $(this).removeClass('active');
                        $wire.removeSelected(participantId);
                    }
                }
            });
        });
    </script>
@endscript
