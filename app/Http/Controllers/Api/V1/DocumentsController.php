<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
//        $request['input']->file->store('document', 'public');
//
//        $document = new Document([
//            "name" => $request->get('name'),
//            "hash_name" =>  $request['input']->file->hashName()
//        ]);
//        $document->save();
        $name = $request->file('file')->getClientOriginalName();
        $path = $request->file('file')->storeAs('public/files', $name);

        $attribute = array_merge($request->all());
        $document = Document::create($attribute);

            return response(['Product' => $document, 'message' => 'Successful'], 200);
        }

}
