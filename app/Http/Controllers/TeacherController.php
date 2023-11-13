<?php

namespace App\Http\Controllers;

use App\Http\Requests\Person\PersonCreateRequest;
use App\Http\Requests\Person\PersonUpdateRequest;
use App\Mail\ApproveApplicationEmail;
use App\Models\Application;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
                'password' => bcrypt($request->input('password')),
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

    public function editObservation(Request $request) {
        try {
            $application = Application::findOrFail($request->input('application_id'));
            if (auth()->user()->rol_id == 3 && $application->teacher_id == auth()->user()->Person->id) {
                $application->update([
                    'observation' => $request->input('observation'),
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Observación editada correctamente'
                ], 201);
            }

            return response()->json([
                'success' => false,
                'title' => 'Error al editar la observación',
                'message' => 'No tiene permisos para editar la observación',
            ], 400);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'title' => 'Error al editar la observación',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function approveApplication($id) {
        try {
            $application = Application::findOrFail($id);

            if (auth()->user()->rol_id != 3) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al aprobar la solicitud',
                    'message' => 'El usuario no es un profesor',
                ], 400);
            }
            if (auth()->user()->rol_id == 3 && $application->teacher_id != auth()->user()->Person->id) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al aprobar la solicitud',
                    'message' => 'No tiene permisos para aprobar la solicitud',
                ], 400);
            }
            if ($application->is_finished === false) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al aprobar la solicitud',
                    'message' => 'La solicitud no está finalizada',
                ], 400);
            }
            foreach ($application->WeeklyTrackings as $wt) {
                if ($wt->is_accepted === false) {
                    return response()->json([
                        'success' => false,
                        'title' => 'Error al aprobar la solicitud',
                        'message' => 'Existen seguimientos sin aceptar',
                    ], 400);
                }
            }

            $application->update([
                'is_approved' => true,
            ]);

            Mail::to($application->Student->User->email)->send(
                new ApproveApplicationEmail(
                    $application->Student->name,
                    $application->id,
                    $application->Teacher->User->email
                )
            );

            return response()->json([
                'success' => true,
                'message' => 'Solicitud aprobada correctamente'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'title' => 'Error al aprobar la solicitud',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
