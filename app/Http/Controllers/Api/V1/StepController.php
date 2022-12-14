<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Step;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StepController extends Controller
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
            $step = Step::findOrFail($id);

            return response(['Step' => $step, 'message' => 'Successful'], 200);
        }
        $steps = Step::all();

        return response(['Step' => $steps, 'message' => 'Successful'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $step = new Step();

        $step->types = $request->input('types');
        $step->fields = $request->input('fields');
        $step->assignee = $request->input('assignee');
        $step->created_by = $request->input('created_by');
        $step->description = $request->input('description');
        $step->save();

        if ($step) {
            $fileId = $request->input('file_id');
            $step->files()->sync($fileId);
        }

        return response(['Step' => $step, 'message' => 'Successful'], 200);
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
        $step = Step::findOrFail($id);
        $step->types = $request->input('types');
        $step->fields = $request->input('fields');
        $step->assignee = $request->input('assignee');
        $step->created_by = $request->input('created_by');
        $step->description = $request->input('description');
        $step->update();

        if ($step) {
            $fileId = $request->input('file_id');
            $step->files()->sync($fileId);
        }

        return response(['Step' => $step, 'message' => 'Successful'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("steps")->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Step Deleted successfully.'
        ], 200);
    }
}
