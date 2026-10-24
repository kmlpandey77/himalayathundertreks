<?php

namespace App\Http\Controllers;

use App\Package;
use App\Page;
use Dompdf\Dompdf;

use Illuminate\Http\Request;

class PrintController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        $package = Package::where('slug',$slug)->first();
        return view('print', compact('package'));
    }

    public function pdf(Request $request, $slug)
    {

        $package = Package::where('slug',$slug)->first();
        $contact = Page::find(22)->details;
        $view = view('pdf', compact('package', 'contact'));
        // return view('pdf', compact('package', 'contact'));

        $dompdf = new Dompdf();
        $dompdf->loadHtml("$view");
        $dompdf->render();
        $dompdf->stream($slug . ".pdf", array("Attachment" => false));
        // $dompdf->stream($slug . ".pdf");
    }
}
