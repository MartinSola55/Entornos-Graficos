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
            DB::beginTransaction();
            $user = User::create([
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('file_number')),
                'rol_id' => 2,
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
                'message' => 'Estudiante y usuario creados correctamente',
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'title' => 'Error al crear el estudiante o el usuario',
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
            DB::beginTransaction();
            $student = Person::findOrFail($request->input('id'));
            $student->update([
                'name' => $request->input('name'),
                'lastname' => $request->input('lastname'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'file_number' => $request->input('file_number'),
            ]);

            $user = $student->User;
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
                'message' => 'Estudiante editado correctamente',
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'title' => 'Error al editar el estudiante',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function delete(Request $request)
    {
        try {
            DB::beginTransaction();
            $student = Person::findOrFail($request->input('id'));
            $user = $student->User;
            
            $student->delete();
            $user->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Estudiante y usuario eliminado correctamente',
                'data' => $request->input('id')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'title' => 'Error al eliminar el estudiante o el usuario',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
