<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\AppHelper;
use App\IClass;
use App\Registration;
use App\Result;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * StudentApiController
 *
 * RESTful API controller for student-related data.
 * Provides endpoints for listing, searching, and looking up
 * students and their academic results.
 *
 * @author Mohammed Belmekki
 */
class StudentApiController extends Controller
{
    /**
     * List students with optional filtering and pagination.
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $query = Student::with('registration')
            ->where('status', AppHelper::ACTIVE);

        // Filter by name
        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }

        // Filter by gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        $perPage = min($request->input('per_page', 15), 100);
        $students = $query->orderBy('name', 'asc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data'    => $students->items(),
            'meta'    => [
                'current_page' => $students->currentPage(),
                'last_page'    => $students->lastPage(),
                'per_page'     => $students->perPage(),
                'total'        => $students->total(),
            ],
        ]);
    }

    /**
     * Show a single student by ID.
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $student = Student::with('registration')->find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $student,
        ]);
    }

    /**
     * Lookup a student by registration number.
     * Public endpoint — no authentication required.
     *
     * @param  string $regiNo
     * @return JsonResponse
     */
    public function lookup($regiNo)
    {
        $registration = Registration::where('regi_no', $regiNo)
            ->with(['student', 'class', 'section'])
            ->first();

        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'No student found with this registration number.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'registration_no' => $registration->regi_no,
                'roll_no'         => $registration->roll_no,
                'student_name'    => $registration->student->name ?? 'N/A',
                'class'           => $registration->class->name ?? 'N/A',
                'section'         => $registration->section->name ?? 'N/A',
            ],
        ]);
    }

    /**
     * Get exam results for a specific class and exam.
     * Public endpoint — no authentication required.
     *
     * @param  int $examId
     * @param  int $classId
     * @return JsonResponse
     */
    public function examResults($examId, $classId)
    {
        $results = Result::where('exam_id', $examId)
            ->where('class_id', $classId)
            ->with(['registration.student'])
            ->orderBy('total_point', 'desc')
            ->get();

        if ($results->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No results found for the given exam and class.',
            ], 404);
        }

        $formattedResults = $results->map(function ($result) {
            return [
                'student_name' => $result->registration->student->name ?? 'N/A',
                'roll_no'      => $result->registration->roll_no ?? 'N/A',
                'total_marks'  => $result->total_marks,
                'grade'        => $result->grade,
                'point'        => $result->point,
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $formattedResults,
            'count'   => $formattedResults->count(),
        ]);
    }

    /**
     * List all active classes.
     *
     * @return JsonResponse
     */
    public function classes()
    {
        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->orderBy('order', 'asc')
            ->select('id', 'name', 'numeric_value', 'group', 'status')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $classes,
        ]);
    }
}
