<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EmployeesController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:employee')->except('logout');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->input(['id']);
        if ($id) {
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
        $input['password'] = bcrypt($request->password);

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

            'name' => 'required|string|max:50',
            'address' => 'required|string|max:1000',
            'email' => ['required', Rule::unique('employees', 'email')
                ->ignore($id)],
            'role' => 'required|string|max:50',
            'permission' => 'required|numeric',
            'password' => 'required|confirmed'
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
    public function destroy($id)
    {
        DB::table("employees")->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Employee Deleted successfully.'
        ], 200);
    }

    function setEnv($name, $value)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                $name . '=' . env($name), $name . '=' . $value, file_get_contents($path)
            ));
        }
    }

    public function login(Request $request)
    {
        if (Auth::guard('employee')
            ->attempt($request->only(['email', 'password']))) {
            $encrypted = Crypt::encryptString($request->email);

            $this->setEnv('API_TOKEN', $encrypted);
            return response(['message' => 'Successful', 'api_token' => $encrypted], 200);
        }

        return response(['message' => 'inalid'], 401);
    }


}
