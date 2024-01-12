<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function upload(Request $request)
    {
        $path = '';
        $file = $request->file('file');
        $folderName = "store";
        $fileName = $file->getClientOriginalName();
        if ($request->store == "1")
            $path = $file->storeAs($folderName, $fileName, 'spaces');
        else
            $path = Storage::disk('block')->put('store', $file);
        DB::table('users')->insert([
            'first' =>  $request->first,
            'last' => $request->last,
            'path' => $path,
            'store' => $request->store
        ]);
        return response()->json(['path' => $path]);
    }
    public function show()
    {
        $data = DB::table('users')->get();
        return view('show', compact('data'));
    }
}