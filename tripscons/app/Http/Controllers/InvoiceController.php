<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Traits\SendEmailTrait;
use PDF;

class InvoiceController extends Controller
{
    use SendEmailTrait;

    // Booking Invoice Function
    public function bookingInvoice($booking_id)
    {
        try {
            $detail = $this->InvoicePdf($booking_id);
            $pdf = PDF::loadView('Invoice.booking_detail', compact('detail'));
            // download PDF file with download method
            return $pdf->download('Booking_file.pdf');
            // Webview Booking Page
            // return view('Invoice.Booking', compact('detail'));

        } catch (\Throwable $th) {
            $this->status = 422;
            $this->response['success'] = false;
            $this->response['message'] = 'Invalid booking Id';
            return response()->json($this->response, $this->status);
        }
    }
    // // Booking Invoice Function
    // public function bookingInvoice($booking_id)
    // {
    //     try {
    //         $detail = $this->InvoicePdf($booking_id);
    //         $pdf = PDF::loadView('Invoice.Booking', compact('detail'));
    //         // download PDF file with download method
    //         return $pdf->download('Booking_file.pdf');
    //         // Webview Booking Page
    //         // return view('Invoice.Booking', compact('detail'));

    //     } catch (\Throwable $th) {
    //         $this->status = 422;
    //         $this->response['success'] = false;
    //         $this->response['message'] = 'Invalid booking Id';
    //         return response()->json($this->response, $this->status);
    //     }
    // }

}
