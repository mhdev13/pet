<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Validation\Rule;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public string $filterStatus = 'all'; // all | active | inactive

    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public string $modalMode = 'create';
    public ?int $selectedId = null;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $is_active = true;

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function openCreate(): void
    {
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'selectedId']);
        $this->is_active = true;
        $this->modalMode = 'create';
        $this->showModal = true;
        $this->resetValidation();
    }

    public function openEdit(int $id): void
    {
        $user = User::findOrFail($id);
        $this->selectedId = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->is_active = $user->is_active;
        $this->password = '';
        $this->password_confirmation = '';
        $this->modalMode = 'edit';
        $this->showModal = true;
        $this->resetValidation();
    }

    public function save(): void
    {
        if ($this->modalMode === 'create') {
            $this->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
            ]);

            User::create([
                'name'      => $this->name,
                'email'     => $this->email,
                'password'  => bcrypt($this->password),
                'is_active' => $this->is_active,
            ]);

            session()->flash('success', 'User berhasil ditambahkan.');
        } else {
            $this->validate([
                'name'     => 'required|string|max:255',
                'email'    => ['required', 'email', Rule::unique('users', 'email')->ignore($this->selectedId)],
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            $data = [
                'name'      => $this->name,
                'email'     => $this->email,
                'is_active' => $this->is_active,
            ];

            if (!empty($this->password)) {
                $data['password'] = bcrypt($this->password);
            }

            User::findOrFail($this->selectedId)->update($data);
            session()->flash('success', 'User berhasil diupdate.');
        }

        $this->showModal = false;
    }

    public function toggleStatus(int $id): void
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            session()->flash('error', 'Tidak bisa mengubah status akun sendiri.');
            return;
        }

        $user->update(['is_active' => !$user->is_active]);
        session()->flash('success', 'Status user berhasil diubah.');
    }

    public function confirmDelete(int $id): void
    {
        $this->selectedId = $id;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        if ($this->selectedId === auth()->id()) {
            session()->flash('error', 'Tidak bisa menghapus akun sendiri.');
            $this->showDeleteModal = false;
            return;
        }

        User::findOrFail($this->selectedId)->delete();
        $this->showDeleteModal = false;
        session()->flash('success', 'User berhasil dihapus.');
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            }))
            ->when($this->filterStatus === 'active', fn($q) => $q->where('is_active', true))
            ->when($this->filterStatus === 'inactive', fn($q) => $q->where('is_active', false))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $totalActive   = User::where('is_active', true)->count();
        $totalInactive = User::where('is_active', false)->count();

        return view('livewire.users.index', compact('users', 'totalActive', 'totalInactive'))
            ->layout('layouts.app', ['title' => 'Users']);
    }
}
