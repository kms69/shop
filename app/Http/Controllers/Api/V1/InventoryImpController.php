<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\InventoryImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class InventoryImpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->input(['id']);
        if($id) {
            $product = InventoryImport::findOrFail($id);

            return response(['InventoryImport' => $product, 'message' => 'Successful'], 200);
        }
        $products = InventoryImport::all();

        return response(['InventoryImport' => $products, 'message' => 'Successful'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:inventory_imports,name',
            'date_imported' => 'required|date_format:Y-m-d',
            'stock' => 'required|numeric',
            'employee_username' => 'required|string',
        ]);

        $input = $request->all();
        $product = InventoryImport::create($input);

        return response(['InventoryImport' => $product, 'message' => 'Successful'], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [

            'name' => ['required', Rule::unique('inventory_imports', 'name')
                ->ignore($id)],
            'date_imported' => 'required|date_format:Y-m-d',
            'stock' => 'required|numeric',
            'employee_username' => 'required|string',
        ]);

        $input = $request->all();
        $product = InventoryImport::findOrFail($id);
        $product->update($input);

        return response(['InventoryImport' => $product, 'message' => 'Successful'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        DB::table("inventory_imports")->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'InventoryImport Deleted successfully.'
        ], 200);
    }
}
