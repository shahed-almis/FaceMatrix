<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Admin;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class AdminComponent extends Component
{
    use WithPagination, WithFileUploads;

    public $name, $email, $phone, $password, $img, $admin_id, $search;
    public $updateMode = false;


    public function render()
    {
        $admins = Admin::where('name', 'like', '%' . $this->search . '%')->paginate(10);
        return view('livewire.admin-component', compact('admins'));
    }


    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'phone' => 'required|unique:admins,phone|regex:/^([0-9\s\-\+\(\)]*)$/|digits:10',
            'password' => 'required|min:8',
            'img' => 'required|image|max:1024',
        ]);

        $imageName = $this->img ? $this->img->store('admins', 'public') : 'empty.png';

        Admin::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => bcrypt($this->password),
            'img' => $imageName,
        ]);

        toastr()->success(__("success"));
        $this->resetInputFields();
    }


    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        $this->admin_id = $admin->id;
        $this->name = $admin->name;
        $this->email = $admin->email;
        $this->phone = $admin->phone;
        $this->updateMode = true;
    }

    public function update()
    {

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $this->admin_id,
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|digits:10|unique:admins,phone,' . $this->admin_id,
            'password' => 'nullable|min:8',
            'img' => 'nullable|image|max:1024',
        ]);

        $admin = Admin::findOrFail($this->admin_id);
        $imageName = $this->img ? $this->img->store('admins', 'public') : $admin->img;

        $admin->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password ? bcrypt($this->password) : $admin->password,
            'img' => $imageName,
        ]);

        $this->updateMode = false;
        toastr()->success(__("success"));
        $this->resetInputFields();
    }


    public function setAdminToDelete($id)
    {
        $this->admin_id = $id;
    }
    public function deleteConfirmed()
    {
        Admin::findOrFail($this->admin_id)->delete();
        toastr()->success(__("success"));
    }


    public function resetInputFields()
    {
        $this->updateMode = false;
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->password = '';
        $this->img = '';
    }
}
