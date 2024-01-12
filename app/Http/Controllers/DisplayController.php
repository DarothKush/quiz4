<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DisplayController extends Controller
{
    function display($fileName) {
        $folderName = env('BLOCKS_FOLDER_NAME', 'images');
        // it work just fine, ignore err
        $img = Storage::disk('blocks')->path($folderName . '/' . $fileName);

        if (empty($img)) {
            return response()->json([
                'message' => 'Image not found'
            ], 404);
        }

        return response()->file($img);
    }
}
