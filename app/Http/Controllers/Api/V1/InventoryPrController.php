<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\InventoryPrimary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class InventoryPrController extends Controller
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
            $product = InventoryPrimary::findOrFail($id);

            return response(['InventoryPrimary' => $product, 'message' => 'Successful'], 200);
        }
        $products = InventoryPrimary::all();

        return response(['InventoryPrimary' => $products, 'message' => 'Successful'], 200);
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
            'name' => 'required|unique:inventory_primaries,name',
            'last_update' => 'required|date_format:Y-m-d',
            'stock' => 'required|numeric',
        ]);

        $input = $request->all();
        $product = InventoryPrimary::create($input);

        return response(['InventoryPrimary' => $product, 'message' => 'Successful'], 200);
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

            'name' => ['required', Rule::unique('inventory_primaries', 'name')
                ->ignore($id)],
            'last_update' => 'required|date_format:Y-m-d',
            'stock' => 'required|numeric',
        ]);

        $input = $request->all();
        $product = InventoryPrimary::findOrFail($id);
        $product->update($input);

        return response(['InventoryPrimary' => $product, 'message' => 'Successful'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        DB::table("inventory_primaries")->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'InventoryPrimary Deleted successfully.'
        ], 200);
    }
}
