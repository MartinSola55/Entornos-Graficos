<?php

namespace App\Http\Controllers;

use App\Http\Requests\Person\PersonCreateRequest;
use App\Http\Requests\Person\PersonUpdateRequest;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = User::where('rol_id', 3)->with('Person')->get();
        return view('teachers.index', compact('teachers'));
    }

    public function create(PersonCreateRequest $request)
    {
        try {
            $teacher = Person::create([
                'name' => $request->input('name'),
                'lastname' => $request->input('lastname'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'file_number' => $request->input('file_number')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Profesor creado correctamente',
                'data' => $teacher
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al crear el profesor',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function details($id)
    {
        $teacher = Person::find($id);

        return view('teachers.details', compact('teacher'));
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
                'file_number' => $request->input('file_number')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Profesor editado correctamente',
                'data' => $student
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al editar el profesor',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
