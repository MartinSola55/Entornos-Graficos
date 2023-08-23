<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pps\PpsRequest;
use App\Models\PPS;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PpsController extends Controller
{
    public function index()
    {
        $pps = PPS::all();
        return view('pps.index', compact('pps'));
    }

    public function create(PpsRequest $request)
    {
        $today = Carbon::now(new \DateTimeZone('America/Argentina/Buenos_Aires'));
        try {
            $pps = PPS::create([
                'description' => $request->input('description'),
                'created_at' => $today,
                'updated_at' => $today
            ]);

            return response()->json([
                'success' => true,
                'message' => 'PPS creada correctamente',
                'data' => $pps
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al crear la PPS',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function details($id)
    {
        $pps = PPS::find($id);

        return view('pps.details', compact('pps'));
    }

    public function update(PpsRequest $request)
    {
        $today = Carbon::now(new \DateTimeZone('America/Argentina/Buenos_Aires'));
        try {
            $pps = PPS::findOrFail($request->input('id'));
            $pps->update([
                'description' => $request->input('description'),
                'updated_at' => $today
            ]);

            return response()->json([
                'success' => true,
                'message' => 'PPS editada correctamente',
                'data' => $pps
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al editar la PPS',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function delete($id)
    {
        try {
            $application = PPS::findOrFail($id);
            $application->delete();

            return response()->json([
                'success' => true,
                'message' => 'PPS eliminada correctamente',
                'data' => $id
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'title' => 'Error al eliminar la PPS',
                'message' => 'Intente nuevamente o comuníquese para soporte',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
