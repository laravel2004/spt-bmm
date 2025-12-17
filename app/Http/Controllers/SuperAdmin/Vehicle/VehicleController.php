<?php

namespace App\Http\Controllers\SuperAdmin\Vehicle;

use App\Http\Controllers\Controller;
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
}
