<?php

namespace App\Http\Controllers;

use App\Http\Requests\Person\PersonCreateRequest;
use App\Http\Requests\Person\PersonUpdateRequest;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;

class ResponsibleController extends Controller
{
    public function index()
    {
        $responsibles = User::where('rol_id', 4)->with('Person')->get();
        return view('responsibles.index', compact('responsibles'));
    }

    public function create(PersonCreateRequest $request)
    {
        try {
            $responsible = Person::create([
                'name' => $request->input('name'),
                'lastname' => $request->input('lastname'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'file_number' => $request->input('file_number')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Responsable creado correctamente',
                'data' => $responsible
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al crear el responsable',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function details($id)
    {
        $responsible = Person::find($id);

        return view('responsibles.details', compact('responsible'));
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
                'message' => 'Responsable editado correctamente',
                'data' => $student
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al editar el responsable',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
