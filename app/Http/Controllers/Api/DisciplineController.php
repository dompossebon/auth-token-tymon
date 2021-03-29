<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DisciplineRequest;
use App\Model\Disciplines;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DisciplineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($code = null)
    {
        if ($code === null) {

            $disciplines = Disciplines::all();

            if(count($disciplines) === 0){
                return response()->json([
                    "message" => "Disciplines not found - Disciplines Empty"
                ], 404);
            }

            return response()->json($disciplines);
        }

        $found = Disciplines::where('code', $code)->first();

        if ($found === null) {
            return response()->json([
                "message" => "Discipline not found"
            ], 404);
        }

        return response()->json($found);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:disciplines|max:20',
            'name' => 'required|unique:disciplines|max:100',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Error - " . $validator->getMessageBag()
            ], 400);
        }

        try {
            $newDiscipline = new Disciplines;
            $newDiscipline->code = $request['code'];
            $newDiscipline->name = $request['name'];
            $newDiscipline->description = $request['description'];
            $newDiscipline->save();
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Error - Discipline not created: " . $e->getMessage()
            ], 400);

        }

        return response()->json([
            "message" => "Success - Discipline record created"
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *      * @return \Illuminate\Http\JsonResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $code)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:10',
            'name' => 'required|max:100',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Error - " . $validator->getMessageBag()
            ], 400);
        }

        $found = Disciplines::where('code', $code)->first();

        if ($found === null) {
            return response()->json([
                "message" => "Error - Discipline not found"
            ], 404);
        }

        try {
            $found->code = $request['code'];
            $found->name = $request['name'];
            $found->description = $request['description'];
            $found->save();
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Error - Discipline d'ont updated: " . $e->getMessage()
            ], 400);
        }

        return response()->json([
            "message" => "Success - Disciplines updated"
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($code)
    {
        $found = Disciplines::where('code', $code)->first();

        if ($found === null) {
            return response()->json([
                "message" => "Discipline not found"
            ], 404);
        }

        try {
            $destroy = Disciplines::destroy($found->id);
        } catch (\Exception $ex) {
            return response()->json([
                "message" => "Error - " . $ex->getMessage()
            ], 400);
        }

        return response()->json([
            "message" => "Success - Discipline deleted"
        ], 200);
    }
}
