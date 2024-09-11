<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DocumentController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function electrocardiography()
    {
        return view('documents.electrocardiography');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function electrocardiographyPrint(Request $request): Response
    {
        $pdf = Pdf::loadView('documents.electrocardiography', $request->query());
        $pdf->setPaper('a4');
        return $pdf->stream();
    }
}
