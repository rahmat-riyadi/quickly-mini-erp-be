<?php

namespace App\Livewire\Forms;

use App\Models\Overtime;
use Livewire\Attributes\Rule;
use Livewire\Form;

class OvertimeForm extends Form
{
    public? Overtime $overtime;

    public function setModel(Overtime $overtime){
        $this->overtime = $overtime;
    }
}
