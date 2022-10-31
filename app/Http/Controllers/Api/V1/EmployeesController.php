<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeesController extends Controller
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
            $product = Employee::findOrFail($id);

            return response(['Employee' => $product, 'message' => 'Successful'], 200);
        }
        $products = Employee::all();

        return response(['Employee' => $products, 'message' => 'Successful'], 200);
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
            'name' => 'required|string|max:50',
            'address' => 'required|string|max:1000',
            'email' => 'required|email|unique:employees,email',
            'role' => 'required|string|max:50',
            'permission' => 'required|numeric',
        ]);

        $input = $request->all();
        $product = Employee::create($input);

        return response(['Employee' => $product, 'message' => 'Successful'], 200);
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
            'name' => ['required', Rule::unique('products', 'name')
                ->ignore($id)],
        ]);

        $input = $request->all();
        $product = Employee::findOrFail($id);
        $product->update($input);

        return response(['Employee' => $product, 'message' => 'Successful'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $product)
    {
        $product->delete();

        return response()->json([
            "success" => true,
            "message" => "Employee deleted successfully.",
            "data" => $product
        ]);

    }
}
