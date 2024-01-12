<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class FileController extends Controller
{
 public function __invoke($folder, $file)
    {
        $path = $folder.'/'.$file;

        return response()->file(
            Storage::disk('block')->path($path)
        );
    }

}