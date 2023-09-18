<?php

namespace App\Http\Controllers;

use App\Mail\ApproveWeeklyTrackingEmail;
use App\Mail\UploadWeeklyTrackingEmail;
use App\Models\Application;
use App\Models\Person;
use App\Models\WeeklyTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class WeeklyTrackingController extends Controller
{
    public function delete(Request $request) {
        try {
            $wt = WeeklyTracking::findOrFail($request->input('id'))->load('Application');
            $rol = auth()->user()->rol_id;
            if (($rol != 1 && $rol != 2) || ($rol != 1 && $wt->Application->student_id != auth()->user()->Person->id)) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al eliminar la solicitud',
                    'message' => 'No está autorizado a realizar esta acción'
                ], 400);
            }
            if (Storage::exists($wt->file_path)) {
                Storage::delete($wt->file_path);
            }
            $wt->delete();
            return response()->json([
                'success' => true,
                'message' => 'Seguimiento eliminado correctamente'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al eliminar la seguimiento',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function accept(Request $request)
    {
        try {
            $wt = WeeklyTracking::findOrFail($request->input('id'))->load('Application');
            $application = $wt->Application;
            $rol = auth()->user()->rol_id;
            if ($rol != 3 || $wt->Application->teacher_id != auth()->user()->Person->id) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al aceptar el seguimiento',
                    'message' => 'No está autorizado a realizar esta acción'
                ], 400);
            }
            $wt->is_accepted = true;
            $wt->save();

            Mail::to($application->Student->User->email)->send(
                new ApproveWeeklyTrackingEmail(
                    $application->Student->name,
                    $application->id,
                    $application->Teacher->User->email
                )
            );

            return response()->json([
                'success' => true,
                'message' => 'Seguimiento aceptado correctamente'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al aceptar el seguimiento',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function download($id)
    {
        try {
            $wt = WeeklyTracking::find($id)->load('Application');
            $student = Person::where('user_id', auth()->user()->id)->first();
            if ($wt->Application->student_id != $student->id) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al descargar el plan de trabajo',
                    'message' => 'No está autorizado a realizar esta descarga'
                ], 400);
            }

            if (Storage::exists($wt->file_path)) {
                return response()->download(storage_path('app/' . $wt->file_path));
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

    public function upload(Request $request)
    {
        try {
            $application = Application::find($request->input('application_id'));
            $student = Person::where('user_id', auth()->user()->id)->first();
            if ($application->student_id != $student->id || auth()->user()->rol_id != 2) {
                return response()->json([
                    'success' => false,
                    'title' => 'Error al subir el seguimiento semanal',
                    'message' => 'No está autorizado a realizar esta acción'
                ], 400);
            }

            $file = $request->file('file');
            if ($file->isValid()) {
                $path = $file->store('public/weekly_trackings');
                
                WeeklyTracking::create([ 
                    'application_id' => $application->id,
                    'file_path' => $path,
                    'is_accepted' => false
                ]);
                
                Mail::to($application->Teacher->User->email)->send(
                    new UploadWeeklyTrackingEmail(
                        $application->Student->lastname . ', ' . $application->Student->name,
                        $application->Student->User->email,
                        $application->id,
                        $application->Teacher->name
                    )
                );
                return response()->json([
                    'success' => true,
                    'message' => 'Seguimiento semanal subido correctamente',
                    'data' => $application
                ], 201);
            }
            return response()->json([
                'success' => false,
                'title' => 'Error al subir el seguimiento semanal',
                'message' => 'El archivo no es válido'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al subir el seguimiento semanal',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
