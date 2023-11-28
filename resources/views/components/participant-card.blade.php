@php
    if ($forTontine) {
        $imgSize = 60;
        $max_width = 'max-width: 440px;';
    } else {
        $imgSize = 45;
        $max_width = 'width: 340px;';
    }
@endphp
<div class="@if ($forTontine) tontine-participant-card @else participant-card @endif @if (in_array($participant->id, $selected)) active @endif  card mb-0"
    style="{{ $max_width }}" data-participantid={{ $participant->id }} {{ $attributes }}>
    <div class="row no-gutters">
        <div class="col-3 ">
            <img src="https://eu.ui-avatars.com/api/?name={{ $participant->last_name . ' ' . $participant->fist_name }}&background=random&size={{ $imgSize }}"
                alt="..." class="img-thumbnail img-fluid rounded-circle">
        </div>
        <div class="col-9">
            <div class="card-body tontine-participant-card-body p-2">
                <h5 class="font-title mb-1">{{ $participant->last_name . ' ' . $participant->first_name }}</h5>
                <h6 class="font-sub-title mb-1">+226 {{ $participant->phone_number }}</h6>
                @if ($forTontine)
                    <x-badge class="font-sub-sub-title" :type="'success'" variant="pill">Statut</x-badge>
                @endif
            </div>
        </div>
    </div>
</div>


    {{-- <script>
        $(document).ready(function() {
            $('.participant-card').on('click', function() {
                var participantId = $(this).data('participantid');

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
            });
        });
    </script> --}}
