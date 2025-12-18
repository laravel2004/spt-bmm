<?php

namespace App\Http\Controllers\SuperAdmin\Vehicle;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vehicle\VehicleAddFormRequest;
use App\Http\Requests\Vehicle\VehicleEditFormRequest;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VehicleController extends Controller
{
    private Vehicle $vehicle;

    public function __construct(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    public function index(Request $request)
    {
        try {
            $search  = trim((string) $request->query('search', ''));
            $perPage = (int) $request->query('perPage', 10);
            $perPage = max(1, min($perPage, 100));

            $query = $this->vehicle->newQuery();

            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('vehicle_no', 'like', "%{$search}%")
                        ->orWhere('vehicle_type', 'like', "%{$search}%")
                        ->orWhere('production_year', 'like', "%{$search}%")
                        ->orWhere('created_by', 'like', "%{$search}%")
                        ->orWhere('modified_by', 'like', "%{$search}%")
                        ->orWhere('capacity', 'like', "%{$search}%");
                });
            }

            $vehicles = $query
                ->orderByDesc('id')
                ->paginate($perPage)
                ->withQueryString();

            return view('pages.superadmin.vehicle.index', compact('vehicles'));

        } catch (\Throwable $e) {
            Log::error('[VehicleController@index] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            abort(500, 'Failed to load vehicle');
        }
    }

    public function create()
    {
        try {
            return view('pages.superadmin.vehicle.create');
        } catch (\Throwable $e) {
            Log::error('[VehicleController@create] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            abort(500, 'Failed to load vehicle creation form');
        }
    }

    public function store(VehicleAddFormRequest $request)
    {
        try {
            $data = $request->validated();

            $data['created_by'] = auth()->user()->username;
            $vehicle = $this->vehicle->create($data);

            return $this->successResponse($vehicle, 'Vehicle stored successfully', 201);
        } catch (\Throwable $e) {
            Log::error('[VehicleController@store] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->errorResponse('Failed to store vehicle', 500);
        }
    }

    public function edit($id)
    {
        try {
            $vehicle = $this->vehicle->findOrFail($id);

            return view('pages.superadmin.vehicle.edit', compact('vehicle'));
        } catch (\Throwable $e) {
            Log::error('[VehicleController@edit] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            abort(500, 'Failed to load vehicle edit form');
        }
    }

    public function update(VehicleEditFormRequest $request, $id)
    {
        try {

            $data = $request->validated();

            $vehicle = $this->vehicle->findOrFail($id);

            $data['modified_by'] = auth()->user()->username;
            $vehicle->update($data);

            return $this->successResponse($vehicle, 'Vehicle updated successfully', 200);

        } catch (\Throwable $e) {
            Log::error('[VehicleController@update] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->errorResponse('Failed to update vehicle', 500);
        }
    }

    public function destroy($id)
    {
        try {
            $vehicle = $this->vehicle->findOrFail($id);
            $vehicle->delete();

            return $this->successResponse(null, 'Vehicle deleted successfully', 200);
        } catch (\Throwable $e) {
            Log::error('[VehicleController@destroy] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->errorResponse('Failed to delete vehicle', 500);
        }
    }
}
