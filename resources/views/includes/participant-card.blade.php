<div class="participant-card @if (in_array($participant->id, $selected)) active @endif  card mb-0"
    style="width: 340px;" data-participantid={{ $participant->id }}>
    <div class="row no-gutters">
        <div class="col-3 ">
            <img src="https://eu.ui-avatars.com/api/?name={{ $participant->last_name . ' ' . $participant->fist_name }}&background=random&size=45"
                alt="..." class="img-thumbnail img-fluid rounded-circle">
        </div>
        <div class="col-9">
            <div class="card-body tontine-participant-card-body p-2">
                <h5 class="font-title mb-1">{{ $participant->last_name . ' ' . $participant->first_name }}</h5>
                <h6 class="font-sub-title mb-1">+226 {{ $participant->phone_number }}</h6>
            </div>
        </div>
    </div>
</div>


