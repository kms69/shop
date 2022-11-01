<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;


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
            $path = md5_file($file->getRealPath());
            $name = $file->getClientOriginalName();

            $save = new Document();
            $save->name = $name;
            $save->hash_name = $path;
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
    public function download($fileId){
        $entry = document::where('file_id', '=', $fileId)->firstOrFail();
        $pathToFile=storage_path()."/app/".$entry->filename;
        return response()->download($pathToFile);

    }
}
