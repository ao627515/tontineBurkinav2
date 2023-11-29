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
                    <x-badge class="font-sub-sub-title" :type="$badgeType" variant="pill">{{ $status }}</x-badge>
                @endif
            </div>
        </div>
    </div>
</div>
