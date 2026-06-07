<?php

namespace App\Livewire\Pets;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Pet;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public string $search = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public string $filterStatus = 'all';
    public string $filterType = '';

    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public string $modalMode = 'create';
    public ?int $selectedId = null;

    // Form fields
    public string $name = '';
    public string $type = '';
    public string $breed = '';
    public string $age = '';
    public string $gender = 'male';
    public bool $is_active = true;
    public string $instagram = '';
    public string $facebook = '';
    public string $tiktok = '';
    public $photo = null;          // new upload (Livewire temp file)
    public ?string $existingImage = null; // current saved image path

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }
    public function updatingFilterType(): void { $this->resetPage(); }

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
        $this->reset(['name', 'type', 'breed', 'age', 'instagram', 'facebook', 'tiktok', 'photo', 'selectedId', 'existingImage']);
        $this->gender    = 'male';
        $this->is_active = true;
        $this->modalMode = 'create';
        $this->showModal = true;
        $this->resetValidation();
    }

    public function openEdit(int $id): void
    {
        $pet = Pet::findOrFail($id);
        $this->selectedId    = $id;
        $this->name          = $pet->name;
        $this->type          = $pet->type;
        $this->breed         = $pet->breed ?? '';
        $this->age           = $pet->age !== null ? (string) $pet->age : '';
        $this->gender        = $pet->gender;
        $this->is_active     = $pet->is_active;
        $this->instagram     = $pet->instagram ?? '';
        $this->facebook      = $pet->facebook ?? '';
        $this->tiktok        = $pet->tiktok ?? '';
        $this->existingImage = $pet->image;
        $this->photo         = null;
        $this->modalMode     = 'edit';
        $this->showModal     = true;
        $this->resetValidation();
    }

    public function removeImage(): void
    {
        $this->existingImage = null;
        $this->photo = null;
    }

    public function save(): void
    {
        $this->validate([
            'name'      => 'required|string|max:255',
            'type'      => 'required|string',
            'breed'     => 'nullable|string|max:255',
            'age'       => 'nullable|integer|min:0|max:100',
            'gender'    => 'required|in:male,female',
            'is_active' => 'boolean',
            'photo'     => 'nullable|image|max:2048',
            'instagram' => 'nullable|string|max:255',
            'facebook'  => 'nullable|string|max:255',
            'tiktok'    => 'nullable|string|max:255',
        ]);

        $imagePath = $this->existingImage;

        if ($this->photo) {
            // Delete old image if editing
            if ($this->modalMode === 'edit' && $this->existingImage) {
                Storage::disk('public')->delete($this->existingImage);
            }
            $imagePath = $this->photo->store('pets', 'public');
        } elseif ($this->modalMode === 'edit' && $this->existingImage === null) {
            // User removed the image
            $old = Pet::find($this->selectedId)?->image;
            if ($old) Storage::disk('public')->delete($old);
            $imagePath = null;
        }

        $data = [
            'name'      => $this->name,
            'image'     => $imagePath,
            'type'      => $this->type,
            'breed'     => $this->breed ?: null,
            'age'       => $this->age !== '' ? (int) $this->age : null,
            'gender'    => $this->gender,
            'is_active' => $this->is_active,
            'instagram' => $this->instagram ?: null,
            'facebook'  => $this->facebook ?: null,
            'tiktok'    => $this->tiktok ?: null,
        ];

        if ($this->modalMode === 'create') {
            Pet::create($data);
            session()->flash('success', 'Pet berhasil ditambahkan.');
        } else {
            Pet::findOrFail($this->selectedId)->update($data);
            session()->flash('success', 'Pet berhasil diupdate.');
        }

        $this->showModal = false;
    }

    public function toggleStatus(int $id): void
    {
        $pet = Pet::findOrFail($id);
        $pet->update(['is_active' => !$pet->is_active]);
        session()->flash('success', 'Status pet berhasil diubah.');
    }

    public function confirmDelete(int $id): void
    {
        $this->selectedId = $id;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        $pet = Pet::findOrFail($this->selectedId);
        if ($pet->image) {
            Storage::disk('public')->delete($pet->image);
        }
        $pet->delete();
        $this->showDeleteModal = false;
        session()->flash('success', 'Pet berhasil dihapus.');
    }

    public function render()
    {
        $pets = Pet::query()
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('breed', 'like', '%' . $this->search . '%')
                  ->orWhere('type', 'like', '%' . $this->search . '%');
            }))
            ->when($this->filterStatus === 'active', fn($q) => $q->where('is_active', true))
            ->when($this->filterStatus === 'inactive', fn($q) => $q->where('is_active', false))
            ->when($this->filterType, fn($q) => $q->where('type', $this->filterType))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $totalActive   = Pet::where('is_active', true)->count();
        $totalInactive = Pet::where('is_active', false)->count();
        $types         = Pet::$types;

        return view('livewire.pets.index', compact('pets', 'totalActive', 'totalInactive', 'types'))
            ->layout('layouts.app', ['title' => 'Pets']);
    }
}
