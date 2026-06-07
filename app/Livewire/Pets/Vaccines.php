<?php

namespace App\Livewire\Pets;

use Livewire\Component;
use App\Models\Pet;
use App\Models\Vaccine;

class Vaccines extends Component
{
    public Pet $pet;

    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public string $modalMode = 'create';
    public ?int $selectedId = null;

    public string $vaccine_name = '';
    public string $vaccine_date = '';
    public string $next_vaccine_date = '';
    public string $administered_by = '';
    public string $clinic = '';
    public string $notes = '';

    public function mount(Pet $pet): void
    {
        $this->pet = $pet;
    }

    public function openCreate(): void
    {
        $this->reset(['vaccine_name', 'vaccine_date', 'next_vaccine_date', 'administered_by', 'clinic', 'notes', 'selectedId']);
        $this->vaccine_date = now()->format('Y-m-d');
        $this->modalMode = 'create';
        $this->showModal = true;
        $this->resetValidation();
    }

    public function openEdit(int $id): void
    {
        $vaccine = Vaccine::findOrFail($id);
        $this->selectedId        = $id;
        $this->vaccine_name      = $vaccine->vaccine_name;
        $this->vaccine_date      = $vaccine->vaccine_date->format('Y-m-d');
        $this->next_vaccine_date = $vaccine->next_vaccine_date?->format('Y-m-d') ?? '';
        $this->administered_by   = $vaccine->administered_by ?? '';
        $this->clinic            = $vaccine->clinic ?? '';
        $this->notes             = $vaccine->notes ?? '';
        $this->modalMode         = 'edit';
        $this->showModal         = true;
        $this->resetValidation();
    }

    public function save(): void
    {
        $this->validate([
            'vaccine_name'      => 'required|string|max:255',
            'vaccine_date'      => 'required|date',
            'next_vaccine_date' => 'nullable|date|after:vaccine_date',
            'administered_by'   => 'nullable|string|max:255',
            'clinic'            => 'nullable|string|max:255',
            'notes'             => 'nullable|string',
        ]);

        $data = [
            'pet_id'            => $this->pet->id,
            'vaccine_name'      => $this->vaccine_name,
            'vaccine_date'      => $this->vaccine_date,
            'next_vaccine_date' => $this->next_vaccine_date ?: null,
            'administered_by'   => $this->administered_by ?: null,
            'clinic'            => $this->clinic ?: null,
            'notes'             => $this->notes ?: null,
        ];

        if ($this->modalMode === 'create') {
            Vaccine::create($data);
            session()->flash('success', 'Vaksin berhasil ditambahkan.');
        } else {
            Vaccine::findOrFail($this->selectedId)->update($data);
            session()->flash('success', 'Vaksin berhasil diupdate.');
        }

        $this->showModal = false;
        $this->pet->refresh();
    }

    public function confirmDelete(int $id): void
    {
        $this->selectedId = $id;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        Vaccine::findOrFail($this->selectedId)->delete();
        $this->showDeleteModal = false;
        $this->pet->refresh();
        session()->flash('success', 'Vaksin berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.pets.vaccines', [
            'vaccines' => $this->pet->vaccines,
        ])->layout('layouts.app', ['title' => 'Buku Vaksin — ' . $this->pet->name]);
    }
}
