<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
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
        $this->validate($request, [
            'name' => 'required|unique:products,name',
        ]);

        $input = $request->all();
        $product = Product::create($input);

        return response(['Product' => $product, 'message' => 'Successful'], 200);
    }
}
