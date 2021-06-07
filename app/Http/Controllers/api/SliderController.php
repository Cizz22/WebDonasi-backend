<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class SliderController extends Controller
{
    public function index(){
        $sliders = Slider::latest()->get();

        $response = [
            'success' => true,
            'message' => 'Data Slider',
            'data' => $sliders
        ];

        return response()->json($response, HttpFoundationResponse::HTTP_OK);
    }
}
