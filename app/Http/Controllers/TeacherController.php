<?php

namespace App\Http\Controllers;

use App\Http\Requests\Person\PersonCreateRequest;
use App\Http\Requests\Person\PersonUpdateRequest;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            DB::beginTransaction();
            $user = User::create([
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('file_number')),
                'rol_id' => 3,
            ]);

            Person::create([
                'name' => $request->input('name'),
                'lastname' => $request->input('lastname'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'file_number' => $request->input('file_number'),
                'user_id' => $user->id,
            ]);

            $user = User::where('email', $request->input('email'))->with('Person')->first();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Docente y usuario creados correctamente',
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'title' => 'Error al crear el docente o el usuario',
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
            DB::beginTransaction();
            $teacher = Person::findOrFail($request->input('id'));
            $teacher->update([
                'name' => $request->input('name'),
                'lastname' => $request->input('lastname'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'file_number' => $request->input('file_number'),
            ]);

            $user = $teacher->User;
            $user->update([
                'email' => $request->input('email'),
            ]);

            if ($request->input('password')) {
                $user->update([
                    'password' => bcrypt($request->input('password')),
                ]);
            }
            DB::commit();
            $user = User::where('email', $request->input('email'))->with('Person')->first();

            return response()->json([
                'success' => true,
                'message' => 'Docente editado correctamente',
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'title' => 'Error al editar el docente',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function delete(Request $request)
    {
        try {
            DB::beginTransaction();
            $teacher = Person::findOrFail($request->input('id'));
            $user = $teacher->User;

            $teacher->delete();
            $user->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Docente y usuario eliminado correctamente',
                'data' => $request->input('id')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'title' => 'Error al eliminar el docente o el usuario',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
