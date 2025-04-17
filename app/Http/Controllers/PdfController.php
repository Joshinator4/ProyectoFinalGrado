<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function generate()
    {
        $data = ['title' => 'Mi primer PDF'];

        // Cargar la vista con los datos y generar el PDF
        $pdf = Pdf::loadView('pdf.document', $data);

        // Descargar el PDF
        return $pdf->download('documento.pdf');
    }
}
