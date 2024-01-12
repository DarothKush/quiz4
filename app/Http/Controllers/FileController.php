<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpg,png,jpeg|max:2048',
            'last_name' => 'required',
            'first_name' => 'required',
            'store_in' => 'required',
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $folderName = env('BLOCKS_FOLDER_NAME', 'images');
        // store in enum 'spaces' or 'blocks'
        $path = $file->storeAs($folderName, $fileName, $request->store_in);
        $url = '';
        if ($request->store_in == 'spaces') {
            $url = env('DO_SPACES_FULL_ENDPOINT') . '/' . $path;
        } else if ($request->store_in == 'blocks') {
            $url = $request->getSchemeAndHttpHost() . '/display/' . $fileName;
        }

        DB::table('form')->insert([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'store_in' => $request->store_in,
            'file_name' => $fileName,
            'url' => $url,
        ]);

        return redirect()->back()->with('success', 'File uploaded successfully');
    }

    public function getList()
    {
        $files = DB::table('form')->orderBy('created_at', 'desc')->get();
        return view('list', ['files' => $files]);
    }
}
