<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Mail\SendContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function get(): View
    {
        return view('public.contact');
    }

    public function send(Request $request)
    {

        try {

            $message = 'Hemos recibido tu mensaje, nos pondremos en contacto contigo lo antes posible.';

            Mail::to('contacto@ricomaster.cl')->send(new SendContact($request));

            return response()->json([
                'success' => true,
                'message' => $message,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el mensaje',
            ], 500);
        }
    }
}
