<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;


class DocumentsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        if ($file = $request->file('file')) {
           $name = $request->file('file')->getClientOriginalName();
            $hash_name =  Crypt::encryptString($name);
            $path = $request->file('file')->storeAs('public/files', $name);

            $save = new Document();
            $save->name = $hash_name;
            $save->file_path = $path;
            $save->user_name = $request->input('user_name');
            $save->format = $request->input('format');
            $save->save();

            return response(['Product' => $save, 'message' => 'Successful'], 200);
        }
    }


    /**
     * download the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function download($fileId)
    {
        $entry = document::where('id', '=', $fileId)->firstOrFail();
        $name = Crypt::decryptString($entry->name);
        $pathToFile = public_path("storage/files/") . $name;

        return response()->download($pathToFile);

    }

//
}
