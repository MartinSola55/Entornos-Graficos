<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\StudentCreateRequest;
use App\Http\Requests\Student\StudentUpdateRequest;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        // dd($clients);
        return view('students.index', compact('students'));
    }

    public function create(StudentCreateRequest $request)
    {
        try {
            $student = Student::create([
                'name' => $request->input('name'),
                'lastname' => $request->input('lastname'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'dni' => $request->input('dni'),
                'file_number' => $request->input('file_number'),
                'observation' => $request->input('observation'),
                'is_active' => 1
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Estudiante creado correctamente',
                'data' => $student
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al crear el estudiante',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function details($id)
    {
        $student = Student::find($id);

        return view('students.details', compact('student'));
    }

    public function update(StudentUpdateRequest $request)
    {
        try {
            $student = Student::findOrFail($request->input('id'));
            $student->update([
                'name' => $request->input('name'),
                'lastname' => $request->input('lastname'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'dni' => $request->input('dni'),
                'file_number' => $request->input('file_number'),
                'observation' => $request->input('observation')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Estudiante editado correctamente',
                'data' => $student
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al editar el estudiante',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function setIsActive(Request $request)
    {
        try {
            $student = Student::find($request->input("id"));
            $student = $student->update([
                'is_active' => !$student->is_active
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Estado del estudiante actualizado correctamente',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al actualizar el estado del estudiante',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
