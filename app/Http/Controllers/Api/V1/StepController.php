<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Step;
use Illuminate\Http\Request;

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
        if($id) {
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

        if($request->input('file')){
            $name = $request->file('file')->getClientOriginalName();
            $path = $request->file('file')->storeAs('public/files', $name);

            $save = new Document();
            $save->name = $name;
            $save->file_path = $path;
            $save->user_name = $request->input('user_name');
            $save->format = $request->input('format');
            $save->save();
            $step->files()->sync($step->id);
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
        $this->validate($request, [

            'name' => ['required', Rule::unique('inventory_primaries', 'name')
                ->ignore($id)],
            'last_update' => 'required|date_format:Y-m-d',
            'stock' => 'required|numeric',
        ]);

        $input = $request->all();
        $step = Step::findOrFail($id);
        $step->update($input);

        return response(['Step' => $step, 'message' => 'Successful'], 200);
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
            'message' => 'Step Deleted successfully.'
        ], 200);
    }
}
