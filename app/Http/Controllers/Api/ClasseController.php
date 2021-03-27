<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Classes;
use App\Model\Disciplines;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id = null)
    {
        if ($id === null) {
            $classes = Classes::with('discipline')->get();

            foreach ($classes as $classe) {
                $dataClasse[] = [
                    'Id_Discipline' => $classe->discipline->id,
                    'Code' => $classe->discipline->code,
                    'Discipline' => $classe->discipline->name,
                    'Id_Classe' => $classe->id,
                    'Classe' => $classe->name
                ];
            }

            return response()->json($dataClasse);
        }


        $found = Classes::with('discipline')->where('id', $id)->first();
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
            'discipline_id' => 'required',
            'name' => 'required|unique:classes',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Error - " . $validator->getMessageBag()
            ], 400);
        }

        $discipline = Disciplines::find($request['discipline_id']);

        if ($discipline === null) {
            return response()->json([
                "message" => "Discipline not found. Enter a valid discipline"
            ], 404);
        }

        try {
            $classe = new Classes;
            $classe->discipline_id = $request['discipline_id'];
            $classe->name = $request['name'];
            $classe->save();
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Error - Classe not created: " . $e->getMessage()
            ], 400);

        }

        return response()->json([
            "message" => "Success - Classe created"
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
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'discipline_id' => 'required',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Error - " . $validator->getMessageBag()
            ], 400);
        }

        $found = Classes::find($id);

        if ($found === null) {
            return response()->json([
                "message" => "Error - Classe not found"
            ], 404);
        }

        if ($request['name'] == null) {
            return response()->json([
                "message" => "Error - Field cannot be null"
            ], 400);
        }

        $discipline = Disciplines::find($request['discipline_id']);

        if ($discipline === null) {
            return response()->json([
                "message" => "Discipline not found. Enter a valid discipline"
            ], 404);
        }

        try {
            $found->name = $request['discipline_id'];
            $found->name = $request['name'];
            $found->save();
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Error - Classe d'ont updated: " . $e->getMessage()
            ], 400);
        }

        return response()->json([
            "message" => "Success - Classe updated"
        ], 200);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {

        $found = Classes::find($id);

        if ($found === null) {
            return response()->json([
                "message" => "Classe not found"
            ], 404);
        }

        try {
            $destroy = Classes::destroy($found->id);
        } catch (\Exception $ex) {
            return response()->json([
                "message" => "Error - " . $ex->getMessage()
            ], 400);
        }

        return response()->json([
            "message" => "Success - Classe deleted"
        ], 200);

    }

}
