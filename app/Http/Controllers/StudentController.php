<?php

namespace App\Http\Controllers;

use App\Http\Requests\Person\PersonCreateRequest;
use App\Http\Requests\Person\PersonUpdateRequest;
use App\Models\Person;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::where('rol_id', 2)->with('Person')->get();
        return view('students.index', compact('students'));
    }

    public function create(PersonCreateRequest $request)
    {
        try {
            $student = Person::create([
                'name' => $request->input('name'),
                'lastname' => $request->input('lastname'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'file_number' => $request->input('file_number')
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
        $student = Person::find($id);

        return view('students.details', compact('student'));
    }

    public function update(PersonUpdateRequest $request)
    {
        try {
            $student = Person::findOrFail($request->input('id'));
            $student->update([
                'name' => $request->input('name'),
                'lastname' => $request->input('lastname'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'file_number' => $request->input('file_number'),
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
}
