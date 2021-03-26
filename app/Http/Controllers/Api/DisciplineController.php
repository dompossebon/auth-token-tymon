<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Disciplines;
use Illuminate\Http\Request;

class DisciplineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($code = null)
    {
        if ($code === null){

            $disciplines = Disciplines::all();

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


        if ($request['code'] xor $request['name'] xor $request['description'] == null) {
            return response()->json([
                "message" => "Error - Field cannot be null"
            ], 400);
        }

        $data = [
            'code' => $request['code'],
            'name' => $request['name'],
            'description' => $request['description'],
        ];

        try {
            $addSubject = Disciplines::create($data);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Error - Discipline not created: ".$e->getMessage()
            ], 400);

        }

        return response()->json([
            "message" => "Success - Discipline record created"
        ], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

        $found = Disciplines::where('code', $code)->first();

        if ($found === null) {
            return response()->json([
                "message" => "Error - Discipline not found"
            ], 404);
        }

        if ($request['code'] xor $request['name'] xor $request['description'] == null) {
            return response()->json([
                "message" => "Error - Field cannot be null"
            ], 400);
        }

        try {
            $book = Disciplines::find($found->id);
            $book->code = request('code');
            $book->name = request('name');
            $book->description = request('description');
            $book->save();
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Error - Discipline d'ont updated: ".$e->getMessage()
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
        } catch (\Exception $ex){
            return response()->json([
                "message" => "Error - ".$ex->getMessage()
            ], 400);
        }

        return response()->json([
            "message" => "Success - Discipline deleted"
        ], 200);

    }
}
