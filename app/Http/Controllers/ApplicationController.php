<?php

namespace App\Http\Controllers;

use App\Http\Requests\Application\ApplicationCreateRequest;
use App\Http\Requests\Application\ApplicationUpdateRequest;
use App\Models\Application;
use App\Models\Person;
use App\Models\User;
use App\Models\WorkPlan;
use Carbon\Carbon;
use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;

class ApplicationController extends Controller
{
    public function index()
    {
        if (auth()->user()->rol_id == 1) {
            $applications = Application::all();
        } else {
            $applications = Application::where('student_id', auth()->user()->Person->id)->get();
        }
        return view('applications.index', compact('applications'));
    }

    public function new()
    {
        $user = User::where('id', auth()->user()->id)->first();
        $student = User::where('email', $user->email)->with('Person')->first();
        return view('applications.new', compact('student'));
    }

    public function create(Request $request)
    {
        // TODO: Enviar mail a responsable
        $today = Carbon::now(new \DateTimeZone('America/Argentina/Buenos_Aires'));
        try {
            $student = Person::where('user_id', auth()->user()->id)->first();
            if ($student == null) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al crear la solicitud',
                    'message' => 'El estudiante no existe'
                ], 400);
            }
            // Crear una fecha de inicio y finalización
            $dateFrom = Carbon::createFromFormat('Y-m-d', $request->input('start_date'));
            $dateTo = Carbon::createFromFormat('Y-m-d', $request->input('finish_date'));

            if ($dateFrom > $dateTo) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al crear la solicitud',
                    'message' => 'La fecha de inicio no puede ser mayor a la fecha de finalización'
                ], 400);
            }
            DB::beginTransaction();
            $application = Application::create([
                'student_id' => $student->id,
                'start_date' => $request->input('start_date'),
                'finish_date' => $request->input('finish_date'),
                'description' => $request->input('description'),
                'is_finished' => false,
                'is_approved' => false,
                'created_at' => $today,
                'updated_at' => $today
            ]);

            $file = $request->file('file');
            if ($file->isValid()) {
                $path = $file->store('public/work_plans');
                WorkPlan::create([
                    'application_id' => $application->id,
                    'file_path' => $path,
                    'is_accepted' => false
                ]);
            }
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Solicitud creada correctamente',
                'data' => $application
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'title' => 'Error al crear la solicitud',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function details($id)
    {
        $application = Application::find($id)->load('Student', 'Teacher', 'Responsible', 'WorkPlans', 'WeeklyTrackings', 'FinalReports');

        return view('applications.details', compact('application'));
    }

    public function update(ApplicationUpdateRequest $request)
    {
        $today = Carbon::now(new \DateTimeZone('America/Argentina/Buenos_Aires'));
        try {
            $application = Application::findOrFail($request->input('id'));
            $application->update([
                'student_id' => $request->input('student_id'),
                'responsible_id' => $request->input('responsible_id'),
                'teacher_id' => $request->input('teacher_id'),
                'pps_id' => $request->input('pps_id'),
                'is_finished' => $request->input('is_finished'),
                'is_approved' => $request->input('is_approved'),
                'observation' => $request->input('observation'),
                'updated_at' => $today
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Solicitud editada correctamente',
                'data' => $application
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al editar la solicitud',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function delete($id)
    {
        try {
            $application = Application::findOrFail($id);
            $application->delete();

            return response()->json([
                'success' => true,
                'message' => 'Solicitud eliminada correctamente',
                'data' => $id
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al eliminar la solicitud',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function downloadWorkPlan($id) {
        try {
            $application = Application::find($id);
            $student = Person::where('user_id', auth()->user()->id)->first();
            if ($application->student_id != $student->id) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al descargar el plan de trabajo',
                    'message' => 'No está autorizado a realizar esta descarga'
                ], 400);
            }

            $work_plan = WorkPlan::where('application_id', $application->id)->first();

            if (Storage::exists($work_plan->file_path)) {
                return response()->download(storage_path('app/' . $work_plan->file_path));
            }
            return response()->json([
                'success' => false,
                'title' => 'Error al descargar el plan de trabajo',
                'message' => 'El archivo no existe'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al descargar el plan de trabajo',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
