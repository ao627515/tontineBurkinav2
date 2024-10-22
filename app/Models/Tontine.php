<?php

namespace App\Models;

use Carbon\Carbon;
use InvalidArgumentException;
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

    public function isFinish()
    {
        return $this->status == "completed";
    }

    public function isCancel()
    {
        return $this->status == "suspended";
    }

    public function periodeIs(int $delay, string $delayUnity)
    {
        return $this->delay == $delay && $this->delay_unity;
    }

    public function participants()
    {
        return $this->belongsToMany(Participant::class, 'tontine_participants')->withPivot('occupied_places', 'assigned_rank');
    }

    public function payments()
    {
        return $this->belongsToMany(Participant::class, 'tontine_payments')->withPivot('created_at', 'id');
    }

    public function getContributions()
    {
        return $this->belongsToMany(Participant::class, 'tontine_contributions_get')->withPivot('created_at', 'id');
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
        $participantsNumber = $this->participants->count();

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

    // are metre a private

    public function delayInDays(bool $periode = true)
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

        return $periode ? $days : $days * $this->number_of_members;
    }

    public function finished_at()
    {
        if ($this->started_at == null) {
            return 'Tontine non débuté';
        }

        $carbone = new Carbon($this->started_at);

        $finishDate = $carbone->addDays($this->delayInDays(false));

        return $finishDate->format('j M Y');
    }

    private function finish_at($started_at)
    {
        return date("d M Y", strtotime($started_at . " + " . $this->delay . " " . $this->delay_unity));
    }

    // a remetre a private
    public function timeElapsed($dateStart = "")
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
        return $this->delayInDays(false) - $this->timeElapsed($date);
    }

    public function remainingTimeInDaysForPay($date =  "")
    {
        return ($this->delayInDays()) - ($this->timeElapsed($date) - ($this->delayInDays() * $this->numberOfPeriodsElapsed()));
    }

    /** renvoie le nombre jour ecoulé en pourcentage */
    public function progress()
    {
        return ($this->timeElapsed() / ($this->delayInDays() * $this->number_of_members)) * 100;
    }

    public function progressForPeriode()
    {
        return (($this->timeElapsed() - ($this->delayInDays() * $this->numberOfPeriodsElapsed())) / $this->delayInDays()) * 100;
    }

    public function progressForHour()
    {
        // Convertir la base de temps en heures
        $baseTimeInHours = 24; // Si delayInDays() renvoie toujours 1 jour

        // Calculer le progrès en fonction de la base de temps en heures
        return ((($this->timeElapsed() * 24) - ($baseTimeInHours * $this->numberOfPeriodsElapsed())) / $baseTimeInHours) * 100;
    }



    public function startedDateIsValide($startedDate)
    {
        return $this->remainingTimeInDays($startedDate) > 0;
    }

    public function getContributionsDateIsValide($getContributionsDate)
    {
        return;
    }

    public function numberOfPeriods()
    {
        return $this->number_of_members;
    }


    /**
     * Calcule le nombre de périodes écoulées depuis la date de début jusqu'à la date actuelle,
     * en fonction de l'unité de délai spécifiée.
     *
     * @return int Le nombre de périodes écoulées.
     */
    public function numberOfPeriodsElapsed()
    {
        $startedAt = Carbon::parse($this->started_at);

        $numberOfPeriods = 0;

        switch ($this->delay_unity) {
            case 'day':
                $numberOfPeriods = $startedAt->diffInDays(Carbon::now());
                break;
            case 'week':
                $numberOfPeriods = $startedAt->diffInWeeks(Carbon::now());
                break;
            case 'month':
                $numberOfPeriods = $startedAt->diffInMonths(Carbon::now());
                break;
            case 'year':
                $numberOfPeriods = $startedAt->diffInYears(Carbon::now());
                break;
        }

        return intdiv($numberOfPeriods, $this->delay);
    }

    public function currentNumberOfPeriods()
    {
        return $this->numberOfPeriodsElapsed() == $this->numberOfPeriods() ? $this->numberOfPeriods() : $this->numberOfPeriodsElapsed() + 1;
    }

    public function participantGetContributions()
    {
        $rank = 0;
        if ($this->getContributions->count() == 0) {
            $rank = 1;
        } else {
            $participantGetContributions = $this->getContributions()->orderByPivot('created_at', "desc")->first();
            $rank = ++$this->participants()->wherePivot('participant_id', $participantGetContributions->id)->first()->pivot->assigned_rank;
        }

        return $rank > $this->number_of_members ?  null : $this->participants()->wherePivot('assigned_rank', $rank)->first();
    }

    /**
     * Vérifie si un membre peut prendre la cotisation pour la période actuelle de la tontine.
     *
     * @return bool True si le membre peut effectuer sa contribution, sinon False.
     */

    // public function canGetContribution()
    // {
    //     $membersGetContributions = $this->getContributions->count();

    //     $totalMembers = $this->number_of_members;
    //     $nextMembersGetContributions = $membersGetContributions != $totalMembers ? $membersGetContributions + 1 : $membersGetContributions;
    //     $periodPayment = $this->getPeriodePayment($nextMembersGetContributions);

    //     $can = false;

    //     // si tout les membre non pas encore pris la cota
    //     // et
    //     // si tout le monde a payer pour une periode $membersGetContributions + 1

    //     if ($membersGetContributions != $totalMembers && $periodPayment == $totalMembers) {
    //         $can =  true;
    //     }

    //     return $can;
    // }

    // // V3
    // public function canGetContribution()
    // {
    //     $membersGetContributions = $this->getContributions->count();
    //     $totalMembers = $this->number_of_members;
    //     $currentPeriodPayment = $this->getPeriodePayment();
    //     $periodsElapsed = $this->numberOfPeriodsElapsed();

    //     // dump($membersGetContributions == $totalMembers);
    //     // dump($currentPeriodPayment != $totalMembers);
    //     // dump($membersGetContributions == $periodsElapsed);

    //     // si tout le monde pris la cotisation ou
    //     // si la periode en cours n'est pas ecoulé
    //     // si tout le monde a payer pour cette periode et quelqu'un a pris ou
    //     if ($membersGetContributions == $totalMembers || $membersGetContributions == $periodsElapsed || ($currentPeriodPayment != $totalMembers && $membersGetContributions == $periodsElapsed)) {
    //         return false;
    //     }

    //     return true;
    // }

    public function canGetContribution()
    {
        $membersGetContributions = $this->getContributions->count();
        $totalMembers = $this->number_of_members;
        $currentPeriodPayment = $this->getPeriodePayment();
        $periodsElapsed = $this->numberOfPeriodsElapsed();
        $currentPeriod = $this->currentNumberOfPeriods();


        // Déterminez la durée de chaque période
        $dureeParPeriode = $this->delayInDays();
        $started_at = Carbon::parse($this->started_at);
        // $finPeriode = $started_at->addDays($dureeParPeriode * $currentPeriod);

        // $periodIsElapsed = $this->compareDates(now(), '>=', $finPeriode);

        /**
         *  Si tout le monde a payer a une periode et
         *  Si personne n'a pris la cotisation et
         * Si la periode actuelle est ecoulé
         */

        for ($i = 1; $i <= $periodsElapsed; $i++) {
            if ($this->getPeriodePayment($i) == $totalMembers && $membersGetContributions < $i && $this->compareDates(now(), '>=', $started_at->copy()->addDays($dureeParPeriode * $i))) {
                return true;
            }
        }

        return false;
    }

    // V2
    // public function canGetContribution()
    // {
    //     $membersGetContributions =  $this->getContributions->count();

    //     return $membersGetContributions == $this->number_of_members ? false : ($this->tontine?->getPeriodePayment() == $this->number_of_members ? ($membersGetContributions == $this->numberOfPeriodsElapsed() ? false : true) : false);
    // }

    // V1
    // public function canGetContribution() {
    //     $membersGetContributions =  $this->getContributions->count();

    //     return $membersGetContributions == $this->number_of_members ? false : ($membersGetContributions == $this->numberOfPeriodsElapsed() ? false : true);
    // }


    /**
     * Renvoie le nombre de paiement effectuer dans la periode courante
     */
    public function getPeriodePayment(int $periode = null)
    {

        $periode = $periode == null ? $this->currentNumberOfPeriods() : $periode;

        $currentPeriodPayments = 0;

        $participants = $this->participants;

        if ($participants && $participants->isNotEmpty()) {
            foreach ($participants as $participant) {
                $participantPayments = $this->payments()->wherePivot('participant_id', $participant->id)->get()->count();
                if ($participantPayments >= $periode) {
                    ++$currentPeriodPayments;
                }
            }
        }
        // dump($currentPeriodPayments);
        return $currentPeriodPayments;
    }


    // public function compareDatesWithOperator(Carbon $date1, Carbon $date2, string $operateur)
    // {

    //     $date1 = Carbon::parse($date1);
    //     $date2 = Carbon::parse($date2);

    //     switch ($operateur) {
    //         case '>':
    //             return $date1->gt($date2);
    //         case '>=':
    //             return $date1->gte($date2);
    //         case '<':
    //             return $date1->lt($date2);
    //         case '<=':
    //             return $date1->lte($date2);
    //         case '==':
    //             return $date1->eq($date2);
    //         default:
    //             throw new InvalidArgumentException("Opérateur non supporté : $operateur");
    //     }
    // }

    public function compareDates(string|Carbon $date1, string $operateur, string|Carbon $date2)
    {
        if (!($date1 instanceof Carbon)) {
            $date1 = Carbon::parse($date1);
        } elseif (!($date2 instanceof Carbon)) {
            $date2 = Carbon::parse($date2);
        }else{
            $date1 = Carbon::parse($date1);
            $date2 = Carbon::parse($date2);
        }


        switch ($operateur) {
            case '>':
                return $date1->gt($date2);
            case '>=':
                return $date1->gte($date2);
            case '<':
                return $date1->lt($date2);
            case '<=':
                return $date1->lte($date2);
            case '==':
                return $date1->eq($date2);
            default:
                throw new InvalidArgumentException("Opérateur non supporté : $operateur");
        }
    }
}
