<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Participant extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    public function tontines()
    {
        return $this->belongsToMany(Tontine::class, 'tontine_participants');
    }

    public function payments()
    {
        return $this->belongsToMany(Tontine::class, 'tontine_payments')->withPivot('created_at');
    }

    public function getParticipantStatusAndBadgeType(Tontine $tontine)
    {
        $paymentsList = $this->payments()->wherePivot('tontine_id', $tontine->id);

        // en retard, en avance, à jour, terminé, pas de paiement
        $status = "";

        switch (true) {
            case $paymentsList->count() == $tontine->numberOfPeriods():
                $status = "Terminé";
                break;
            case $paymentsList->count() == 0:
                $status = "Pas de paiement";
                break;
            case $paymentsList->count() > $tontine->currentNumberOfPeriods():
                $status = "En avance";
                break;
            case $paymentsList->count() < $tontine->currentNumberOfPeriods():
                $status = "En retard";
                break;
            case $paymentsList->count() == $tontine->currentNumberOfPeriods():
                $status = "À jour";
                break;
        }

        // Assigner le type de badge en fonction du statut
        switch ($status) {
            case "Terminé":
                $badgeType = 'success';
                break;
            case "Pas de paiement":
                $badgeType = 'danger';
                break;
            case "En avance":
                $badgeType = 'warning';
                break;
            case "En retard":
                $badgeType = 'danger';
                break;
            case "À jour":
                $badgeType = 'primary';
                break;
            default:
                $badgeType = 'secondary';
                break;
        }

        // Retourner un tableau avec le statut et le type de badge
        return ['status' => $status, 'badgeType' => $badgeType];
    }

    public function identity_document_front()
    {
        return Storage::url($this->identity_document_front);
    }

    public function identity_document_back()
    {
        return Storage::url($this->identity_document_back);
    }
}
