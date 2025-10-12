<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Get all active sliders
     */
    public function index()
    {
        try {
            $sliders = Slider::orderBy('created_at', 'desc')->get();

            return response()->json([
                'success' => true,
                'data' => $sliders->map(function ($slider) {
                    return [
                        'id' => $slider->id,
                        'link' => $slider->link,
                        'gambar' => $slider->gambar ? asset('storage/' . $slider->gambar) : null,
                        'created_at' => $slider->created_at,
                    ];
                })
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat slider',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
