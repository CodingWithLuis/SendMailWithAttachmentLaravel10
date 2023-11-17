<?php

namespace App\Http\Controllers;

use App\Mail\ReportMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ReportController extends Controller
{

    public function report(): View
    {
        return view('reports.index');
    }

    public function sendReport(Request $request)
    {
        $data = [
            'subject' => $request->input('subject'),
            'content' => $request->input('content'),
            'file' => $request->input('file') ?? ''
        ];

        if ($request->hasFile('file')) {

            $file = $request->file('file');

            $filename = $file->getClientOriginalName();

            $file->storeAs('pdfs', $filename);

            $data['file'] = $filename;
        }

        Mail::to($request->input('email'))->send(new ReportMail($data));
    }
}
