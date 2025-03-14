<?php

namespace App\Livewire\Insurers;

use App\Models\Insurer;
use App\Models\InsurerAssignment;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Users extends Component
{
    public $insurer;
    public $id;
    public $insurer_id;
    public $user_id;
    public $status;

    protected $rules = [
        'insurer_id' => 'required|exists:insurers,id',
        'user_id' => 'required|exists:users,id',
        'status' => 'required|string|in:active,inactive',
    ];

    public function addUser()
    {
        try {

            $validatedData = $this->validate();
            InsurerAssignment::create([
                'insurer_id' => $validatedData['insurer_id'],
                'user_id' => $validatedData['user_id'],
                'status' => $validatedData['status'],
                'created_by' => Auth::user()->name,
                'updated_by' => Auth::user()->name,
            ]);
        } catch (Exception $ex) {
            return redirect()->route('insurers.details', $this->id)
                ->with('msg', 'Error: ' . $ex->getMessage())
                ->with('flag', 'danger');
        }
        session()->flash('msg', 'Insurer Assignment created successfully.');
        session()->flash('flag', 'success');
        $this->resetInput();
        return redirect()->route('insurers.details', $this->id);
    }

    public function resetInput()
    {
        $this->insurer_id = '';
        $this->user_id = '';
        $this->status = '';
    }

    public function mount($id)
    {
        $this->id = $id;
        $this->insurer = Insurer::find($this->id);
        $this->insurer_id = $this->id;
    }

    public function render()
    {
        $this->insurer = Insurer::find($this->id);
        return view('livewire.insurers.users', [
            'users' => User::all(),
            'insurer' => $this->insurer,
        ]);
    }
}
