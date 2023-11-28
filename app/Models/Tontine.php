<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tontine extends Model
{
    use HasFactory, HasUuids;
    protected $guarded = [];

    public function isNotStarted()
    {
        return $this->status == "creating";
    }

    public function isStarted()
    {
        return $this->status == "ongoing";
    }

    public function cotisation()
    {
        //
    }

    public function participants()
    {
        return $this->belongsToMany(Participant::class, 'tontine_participants')->withPivot('occupied_places');
    }

    /*
    * Renvoi le nombre de participant courant de la tontine
    */
    public function currentParticiantsNumber()
    {

        $participants = $this->participants;

        if ($participants->count() == 0) {
            return 0;
        }

        $participantCurrentNumber = 0;

        foreach ($participants as $participant) {
            $participantCurrentNumber += $participant->pivot->occupied_places;
        }

        return $participantCurrentNumber;
    }

    /*
    * Répond a la question
    * Est ce que si on ajoute un nouveau participant le tontine sera pleine ?
    * Renvoie vrai ou faux
    */
    public function hasFull(int $newParticipantPlaceOccuped): bool
    {

        return $this->number_of_members < $this->currentParticiantsNumber() + $newParticipantPlaceOccuped;
    }


    /*
    *   Répond a la question
    *   Est ce que la tontine est pleine ?
    */
    public function isFull(): bool
    {
        return $this->number_of_members == $this->currentParticiantsNumber();
    }


    /*
    * Renvoie le rand du prochaine partcipant
    */

    public function participationRank()
    {
        $participantsNumber = $this->participation->count();

        if ($participantsNumber == 0) {
            $rank = 1;
        } else {
            $rank = ++$participantsNumber;
        }

        return $rank;
    }

    public static function dateFormat(string $date)
    {
        $carbone = new Carbon($date);

        return $carbone->format('j M Y');
    }

    public static function dateTimeFormat(string $dateTime)
    {
        $carbone = new Carbon($dateTime);

        return $carbone->format('j M Y à H\h i');
    }

    public function getStatus()
    {
        switch ($this->status) {
            case 'creating':
                return "Non Démarré";
            case 'ongoing':
                return "En Cours";
            case 'suspended':
                return "Suspendu";
            case 'completed':
                return "Terminé";
            default:
                return "Statut Inconnu";
        }
    }

    public function getStatusBadgeColor()
    {
        switch ($this->status) {
            case 'creating':
                return 'secondary';
            case 'ongoing':
                return 'primary';
            case 'suspended':
                return 'warning';
            case 'completed':
                return 'success';
            default:
                return 'secondary';
        }
    }

    public function getPeriode()
    {
        switch ($this->delay_unity) {
            case 'day':
                return $this->delay > 1 ? $this->delay . " Jours" : $this->delay . " Jour";
            case 'week':
                return $this->delay > 1 ? $this->delay . " Semaines" : $this->delay . " Semaine";
            case 'month':
                return $this->delay . " Mois";
            case 'year':
                return $this->delay > 1 ? $this->delay . " Années" : $this->delay . " Année";
            default:
                return 'Période inconnu';
        }
    }

    private function delayInDays()
    {

        // if ($this->started_at == null) {
        //     return 'Tontine non débuté';
        // }

        $delay = $this->delay;

        $delay_unity = $this->delay_unity;

        $days = 0;

        switch ($delay_unity) {
            case 'day':
                $days = $delay;
                break;
            case 'week':
                $days = $delay * 7;
                break;
            case 'month':
                $days = $delay * 30;
                break;
            case 'year':
                $days = $delay * 360;
                break;
        }

        return $days;
    }
    public function finished_at()
    {
        if ($this->started_at == null) {
            return 'Tontine non débuté';
        }

        $carbone = new Carbon($this->started_at);

        $finishDate = $carbone->addDays($this->delayInDays());

        return $finishDate->format('j M Y');
    }

    private function finish_at($started_at)
    {
        return date("d M Y", strtotime($started_at . " + " . $this->delay . " " . $this->delay_unity));
    }

    private function timeElapsed($dateStart = "")
    {
        $startDate = $dateStart == "" ? $this->started_at : $dateStart;
        // Assurez-vous que $this->started_at est une instance de Carbon
        $startedAt = Carbon::parse($startDate);
        // Calculer la différence en jours entre $this->started_at et maintenant
        $daysElapsed = $startedAt->diffInDays(Carbon::now());

        return $daysElapsed;
    }

    public function remainingTimeInDays($date =  "")
    {
        return $this->delayInDays() - $this->timeElapsed($date);
    }

    /** renvoie le nombre jour ecoulé en pourcentage */
    public function progress()
    {
        return ($this->timeElapsed() / $this->delayInDays()) * 100;
    }

    public function startedDateIsValide($startedDate)
    {

        return $this->remainingTimeInDays($startedDate) > 0;
    }
}
