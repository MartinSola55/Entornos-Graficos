<?php

namespace App\Http\Controllers;

use App\Http\Requests\Person\PersonCreateRequest;
use App\Http\Requests\Person\PersonUpdateRequest;
use App\Models\Application;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            DB::beginTransaction();
            $user = User::create([
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('file_number')),
                'rol_id' => 4,
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
                'message' => 'Responsable y usuario creados correctamente',
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'title' => 'Error al crear el responsable o el usuario',
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
            DB::beginTransaction();
            $responsible = Person::findOrFail($request->input('id'));
            $responsible->update([
                'name' => $request->input('name'),
                'lastname' => $request->input('lastname'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'file_number' => $request->input('file_number'),
            ]);

            $user = $responsible->User;
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
                'message' => 'Responsable editado correctamente',
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'title' => 'Error al editar el responsable',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function delete(Request $request)
    {
        try {
            DB::beginTransaction();
            $responsible = Person::findOrFail($request->input('id'));
            $user = $responsible->User;

            $responsible->delete();
            $user->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Responsable y usuario eliminado correctamente',
                'data' => $request->input('id')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'title' => 'Error al eliminar el responsable o el usuario',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function takeApplication($id) {
        try {
            $application = Application::findOrFail($id);
            if ($application->responsible_id) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al tomar la solicitud',
                    'message' => 'La solicitud ya fue tomada por otro responsable',
                ], 400);
            }
            if ($application->is_finished) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al tomar la solicitud',
                    'message' => 'La solicitud ya fue finalizada',
                ], 400);
            }
            if (auth()->user()->rol_id != 4) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al tomar la solicitud',
                    'message' => 'El usuario no es un responsable',
                ], 400);
            }
            $application->update([
                'responsible_id' => auth()->user()->Person->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Solicitud tomada correctamente'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al tomar la solicitud',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
