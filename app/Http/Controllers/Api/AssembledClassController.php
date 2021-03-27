<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\AssembledClass;
use App\Model\Classes;
use App\Model\Disciplines;
use App\Model\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class AssembledClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id = null)
    {
        if ($id === null) {
            $assembledClasses = AssembledClass::with(['student', 'classe'])->get();

            foreach ($assembledClasses as $assembledClass) {
                $discipline = Disciplines::find($assembledClass->classe->discipline_id);
                $dataAssembledClass[] = [
                    'Student_Id' => $assembledClass->student->id,
                    'Class_Id' => $assembledClass->classe->id,
                    'Class_Discipline_id' => $assembledClass->classe->discipline_id,
                    'Student_Name' => $assembledClass->student->name,
                    'Class_Discipline_Name' => $discipline->code . ' - ' . $discipline->name,
                    'Class_Name' => $assembledClass->classe->name,
                ];
            }

            return response()->json($dataAssembledClass);
        }

        $found = AssembledClass::with(['student', 'classe'])->where('id', $id)->first();

        if ($found === null) {
            return response()->json([
                "message" => "AssembledClass not found"
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
            'student_id' => 'required',
            'class_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Error - " . $validator->getMessageBag()
            ], 400);
        }

        $student = Students::find($request['student_id']);
        if ($student === null) {
            return response()->json([
                "message" => "Student not found. Enter a number valid for Student"
            ], 404);
        }

        $Classes = Classes::find($request['class_id']);
        if ($Classes === null) {
            return response()->json([
                "message" => "Class not found. Enter a number valid for Class"
            ], 404);
        }


        $assembledClasses = AssembledClass::with(['student', 'classe'])
            ->where('class_id', $request['class_id'])
            ->where('student_id', $request['student_id'])
            ->get();


        if (count($assembledClasses) != 0) {
            return response()->json([
                "message" => "Error - This student has already been enrolled in this class"
            ], 404);
        }

        try {
            $assembledClass = new AssembledClass;
            $assembledClass->student_id = $request['student_id'];
            $assembledClass->class_id = $request['class_id'];
            $assembledClass->save();
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Error - Assembled Class not created: " . $e->getMessage()
            ], 400);
        }

        return response()->json([
            "message" => "Success - Assembled Class created"
        ], 201);

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

        $foundAssembledClass = AssembledClass::find($id);
        if ($foundAssembledClass === null) {
            return response()->json([
                "message" => "Error - Assembled Class not found"
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'student_id' => 'required',
            'class_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Error - " . $validator->getMessageBag()
            ], 400);
        }

        $foundStudents = Students::find($request->student_id);
        if ($foundStudents === null) {
            return response()->json([
                "message" => "Error - Student not found"
            ], 404);
        }

        $foundClasses = Classes::find($request->class_id);
        if ($foundClasses === null) {
            return response()->json([
                "message" => "Error - Class not found"
            ], 404);
        }

        try {
            $foundAssembledClass->student_id = $request->student_id;
            $foundAssembledClass->class_id = $request->class_id;
            $foundAssembledClass->save();
        } catch (\Exception $exception) {
            return response()->json([
                "message" => "Error - Assembled Class d'ont updated: " . $exception->getMessage()
            ], 400);
        }

        return response()->json([
            "message" => "Success - Assembled Class updated"
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
        $found = AssembledClass::find($id);

        if ($found === null) {
            return response()->json([
                "message" => "Assembled Class not found"
            ], 404);
        }

        try {
            $found->delete();
        } catch (\Exception $ex) {
            return response()->json([
                "message" => "Error - " . $ex->getMessage()
            ], 400);
        }

        return response()->json([
            "message" => "Success - Assembled Class deleted"
        ], 200);
    }
}
