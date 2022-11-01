<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ProcessDefiniton;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcessDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->input(['id']);
        if ($id) {
            $step = ProcessDefiniton::findOrFail($id);

            return response(['ProcessDefiniton' => $step, 'message' => 'Successful'], 200);
        }
        $steps = ProcessDefiniton::all();

        return response(['ProcessDefiniton' => $steps, 'message' => 'Successful'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $processD = ProcessDefiniton::create($input);

        return response(['ProcessDefiniton' => $processD, 'message' => 'Successful'], 200);
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
        $input = $request->all();
        $processD = ProcessDefiniton::findOrFail($id);
        $processD->update($input);

        return response(['ProcessDefiniton' => $processD, 'message' => 'Successful'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("process_definitons")->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'ProcessDefiniton Deleted successfully.'
        ], 200);
    }
}
