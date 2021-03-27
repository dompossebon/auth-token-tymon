<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\AssembledClass;
use Illuminate\Http\Request;

class ClassReportController extends Controller
{

    /**
     * @param $classId
     * @return \Illuminate\Http\JsonResponse
     */
    public function classReport1($classId)
    {

        $assembledClasses = AssembledClass::with(['student', 'classe'])->where('class_id', $classId)->get();

        if (count($assembledClasses) === 0) {
            return response()->json([
                "message" => "The searched class was not found"
            ], 404);
        }

        foreach ($assembledClasses as $assembledClass) {
            $dataAssembledClass[$assembledClass->classe->name][] = [
                'Student_Id' => $assembledClass->student->id,
                'Student_Name' => $assembledClass->student->name,
            ];
        }

        return response()->json($dataAssembledClass);

    }
}
