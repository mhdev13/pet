<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Barryvdh\DomPDF\Facade\Pdf;

class PetVaccineController extends Controller
{
    public function downloadPdf(Pet $pet)
    {
        $vaccines = $pet->vaccines;

        $pdf = Pdf::loadView('pdf.vaccine-book', compact('pet', 'vaccines'))
            ->setPaper('a4', 'portrait');

        $filename = 'buku-vaksin-' . str($pet->name)->slug() . '.pdf';

        return $pdf->download($filename);
    }
}
