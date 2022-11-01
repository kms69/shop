<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ProcessPipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcessPController extends Controller
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
            $step = ProcessPipe::findOrFail($id);

            return response(['ProcessPipe' => $step, 'message' => 'Successful'], 200);
        }
        $steps = ProcessPipe::all();

        return response(['ProcessPipe' => $steps, 'message' => 'Successful'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $step = new ProcessPipe();

        $step->process_id = $request->input('process_id');
        $step->current_step = $request->input('current_step');
        $step->deadline = $request->input('deadline');
        $step->data = $request->input('data');
        $step->finished = $request->input('finished');
        $step->save();

        if ($step) {
            $fileId = $request->input('file_id');
            $step->files()->sync($fileId);
        }

        return response(['ProcessPipe' => $step, 'message' => 'Successful'], 200);
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
        $step = ProcessPipe::findOrFail($id);
        $step->process_id = $request->input('process_id');
        $step->current_step = $request->input('current_step');
        $step->deadline = $request->input('deadline');
        $step->data = $request->input('data');
        $step->finished = $request->input('finished');
        $step->update();

        if ($step) {
            $fileId = $request->input('file_id');
            $step->files()->sync($fileId);
        }

        return response(['ProcessPipe' => $step, 'message' => 'Successful'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("process_pipes")->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'ProcessPipe Deleted successfully.'
        ], 200);
    }
}
