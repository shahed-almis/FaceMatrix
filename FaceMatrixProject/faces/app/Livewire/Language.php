<?php

namespace App\Livewire;

use Livewire\Component;
use App\Livewire\Actions\Logout;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Language extends Component
{

    public $lang = '';

    public function mount()
    {
        $this->lang = LaravelLocalization::getCurrentLocale();
    }

    public function render()
    {
        return view('livewire.language');
    }









    public function changeLang($lang)
    {

        $this->lang = $lang;
    }

    public function save()
    {

        session()->put('locale', $this->lang);
        LaravelLocalization::setLocale($this->lang);
        return redirect()->to('/language');
    }
}
