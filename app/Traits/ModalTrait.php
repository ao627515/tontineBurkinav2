<?php
namespace App\Traits;

trait ModalTrait {
    public string $modalOpen = "";

    public function openModal(string $modalName)
    {
        $this->modalOpen = $modalName;
    }

    public function closeModal()
    {
        $this->modalOpen = "";
    }

}
