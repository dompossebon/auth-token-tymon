<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id = null)
    {
        if ($id === null) {

            $students = Students::all();

            if(count($students) === 0){
                return response()->json([
                    "message" => "Students not found - Students Empty"
                ], 404);
            }

            return response()->json($students);
        }

        $foundStudent = Students::where('id', $id)->first();

        if ($foundStudent === null) {
            return response()->json([
                "message" => "Student not found"
            ], 404);
        }

        return response()->json($foundStudent);
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
            'name' => 'required|max:100',
            'email' => 'required|unique:students|max:100|email',
            'birth_date' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Error - " . $validator->getMessageBag()
            ], 400);
        }

        try {
            $newStudent = new Students;
            $newStudent->name = $request['name'];
            $newStudent->email = $request['email'];
            $newStudent->birth_date = $request['birth_date'];
            $newStudent->save();
        } catch (\Exception $exception) {
            return response()->json([
                "message" => "Error - Student not created: " . $exception->getMessage()
            ], 400);
        }

        return response()->json([
            "message" => "Success - Student created"
        ], 201);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'email' => 'required|max:100|email',
            'birth_date' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Error - " . $validator->getMessageBag()
            ], 400);
        }

        $found = Students::find($id);

        if ($found === null) {
            return response()->json([
                "message" => "Error - Student not found"
            ], 404);
        }

        try {
            $found->name = $request['name'];
            $found->email = $request['email'];
            $found->birth_date = $request['birth_date'];
            $found->save();
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Error - Student d'ont updated: " . $e->getMessage()
            ], 400);
        }

        return response()->json([
            "message" => "Success - Student updated"
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
        $found = Students::find($id);

        if ($found === null) {
            return response()->json([
                "message" => "Student not found"
            ], 404);
        }

        try {
            $found->destroy($found->id);
        } catch (\Exception $ex) {
            return response()->json([
                "message" => "Error - " . $ex->getMessage()
            ], 400);
        }

        return response()->json([
            "message" => "Success - Student deleted"
        ], 200);
    }
}
