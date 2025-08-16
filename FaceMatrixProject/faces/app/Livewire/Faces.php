<?php

namespace App\Livewire;

use Exception;
use App\Models\Face;
use Nette\Utils\Image;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\Rule;
use App\Models\UnrecognizedFaces;
use Illuminate\Support\Facades\DB;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Faces extends Component
{
    use WithFileUploads;


    #[Rule('required|string|max:50')]
    public $firstName;

    #[Rule('required|string|max:50')]
    public $lastName;

    #[Rule('required|email|unique:faces,email')]
    public $email;

    #[Rule('required|in:male,female')]
    public $gender;

    #[Rule('required|date|before:today')]
    public $birth;

    #[Rule('required|image|mimes:png,jpg,jpeg')]
    public $img;

    #[Rule('required|numeric|digits_between:2,19|unique:faces,ref_no')]
    public $ref_no;

    #[Url]
    public $order = 'ASC', $search;




    public function changeOrder()
    {

        $this->order = $this->order == 'asc' ? 'desc' : 'asc';
    }


    public function save()
    {
        $this->validate();

        try {
            Face::create([
                'name' => $this->firstName . ' ' . $this->lastName,
                'email' => $this->email,
                'ref_no' => $this->ref_no,
                'gender' => $this->gender,
                'date_of_birth' => $this->birth,
                'data' => $this->img ? file_get_contents($this->img->getRealPath()) : null,
            ]);
            $this->reset(['firstName', 'ref_no', 'lastName', 'email', 'gender', 'birth', 'img']);
            toastr()->success(__("success"));
        } catch (Exception $e) {
            toastr()->error(__('error') . "<br>" . $e->getMessage());
        }
    }

    public function render()
    {
        $employees = Face::orderBy('id', $this->order)->where('name', 'like', '%' . $this->search . '%')->get();
        return view('livewire.faces',  ['employees' =>  $employees]);
    }
}
