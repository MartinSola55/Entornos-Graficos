<?php

namespace App\Http\Controllers;

use App\Mail\UploadFinalReportEmail;
use App\Models\Application;
use App\Models\FinalReport;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class FinalReportController extends Controller
{
    public function download($id)
    {
        try {
            $application = Application::findOrFail($id)->load('FinalReport');
            $fr = $application->FinalReport;
            if (Storage::exists($fr->file_path)) {
                return response()->download(storage_path('app/' . $fr->file_path));
            }
            return response()->json([
                'success' => false,
                'title' => 'Error al descargar el reporte',
                'message' => 'El archivo no existe'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al descargar el reporte',
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
                    'title' => 'Error al subir el reporte',
                    'message' => 'No está autorizado a realizar esta acción'
                ], 400);
            }

            DB::beginTransaction();
            $file = $request->file('file');
            if ($file->isValid()) {
                $path = $file->store('public/final_reports');                
                FinalReport::create([
                    'application_id' => $application->id,
                    'file_path' => $path,
                    'is_accepted' => false,
                    'observations' => ''
                ]);

                Mail::to($application->Teacher->User->email)->send(
                    new UploadFinalReportEmail(
                        $application->Student->lastname . ', ' . $application->Student->name,
                        $application->Student->User->email,
                        $application->id,
                        $application->Teacher->name
                    )
                );
                
                $application->is_finished = true;
                $application->save();

                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Reporte subido correctamente',
                    'data' => $application
                ], 201);
            }
            DB::rollBack();
            return response()->json([
                'success' => false,
                'title' => 'Error al subir el reporte',
                'message' => 'El archivo no es válido'
            ], 400);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'title' => 'Error al subir el reporte',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
