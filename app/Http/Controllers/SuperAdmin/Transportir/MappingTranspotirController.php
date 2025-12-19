<?php

namespace App\Http\Controllers\SuperAdmin\Transportir;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transportir\MappingTransportirAddFormRequest;
use App\Http\Requests\Transportir\MappingTransportirUpdateFormRequest;
use App\Models\Driver;
use App\Models\MappingTransportir;
use App\Models\Transportir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MappingTranspotirController extends Controller
{
    private MappingTransportir $mappingTransportir;

    public function __construct(MappingTransportir $mappingTransportir)
    {
        $this->mappingTransportir = $mappingTransportir;
    }


    public function index(Request $request)
    {
        try {

            $search  = trim((string) $request->query('search', ''));
            $perPage = (int) $request->query('perPage', 10);
            $perPage = max(1, min($perPage, 100));

            $query = $this->mappingTransportir->newQuery()->with(['driver', 'transportir']);

            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('driver', function ($dq) use ($search) {
                        $dq->where('fullname', 'like', "%{$search}%")
                            ->orWhere('phone_num', 'like', "%{$search}%");
                    })->orWhereHas('transportir', function ($tq) use ($search) {
                        $tq->where('code', 'like', "%{$search}%")
                            ->orWhere('tranportir_name', 'like', "%{$search}%");
                    });
                });
            }

            $mappings = $query->orderByDesc('id')->paginate($perPage)->withQueryString();

            return view('pages.superadmin.mapping_transportir.index', compact('mappings'));

        } catch (\Throwable $e) {
             Log::error('[MappingTranspotirController@index] ' . $e->getMessage(), [
                 'trace' => $e->getTraceAsString(),
             ]);

            abort(500, 'Failed to load mapping transportir');
        }
    }

    public function create()
    {
        try {
            $drivers = Driver::query()
                ->select('id', 'fullname', 'phone_num', 'is_active')
                ->orderBy('fullname')
                ->get();

            $transportirs = Transportir::query()
                ->select('id', 'code', 'tranportir_name', 'is_active')
                ->orderBy('code')
                ->get();

            return view('pages.superadmin.mapping_transportir.create', compact('drivers', 'transportirs'));
        } catch (\Throwable $e) {
            Log::error('[MappingTranspotirController@create] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            abort(500, 'Failed to load create mapping transportir');
        }
    }

    public function store(MappingTransportirAddFormRequest $request)
    {
        try {
            $data = $request->validated();
            $data['modified_by'] = auth()->user()->username ?? 'system';
            $data['transportir_code'] = Transportir::query()
                ->where('id', $data['transportir_id'])
                ->value('code');

            $exist = $this->mappingTransportir->newQuery()
                ->where('driver_id', $data['driver_id'])
                ->where('is_active', true)
                ->first();

            $exist?->update([
                'is_active' => false,
            ]);

            $mappingTransportir = $this->mappingTransportir->create($data);

            return $this->successResponse($mappingTransportir, 'Mapping transportir created successfully', 201);

        } catch (\Throwable $e) {
            Log::error('[MappingTranspotirController@store] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'payload' => $request->all(),
            ]);

            return $this->errorResponse('Failed to store new mapping transportir', 500);
        }
    }

    public function edit($id)
    {
        try {
            $mapping = $this->mappingTransportir->newQuery()
                ->with(['driver', 'transportir'])
                ->findOrFail($id);

            $drivers = Driver::query()
                ->select('id', 'fullname', 'phone_num', 'is_active')
                ->orderBy('fullname')
                ->get();

            $transportirs = Transportir::query()
                ->select('id', 'code', 'tranportir_name', 'is_active')
                ->orderBy('code')
                ->get();

            return view('pages.superadmin.mapping_transportir.edit', compact('mapping', 'drivers', 'transportirs'));
        } catch (\Throwable $e) {
            Log::error('[MappingTranspotirController@edit] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            abort(500, 'Failed to load edit mapping transportir');
        }
    }

    public function update(MappingTransportirUpdateFormRequest $request, $id)
    {
        try {
            $mapping = $this->mappingTransportir->newQuery()->findOrFail($id);

            $data = $request->validated();
            $data['modified_by'] = auth()->user()->username ?? 'system';

            $data['transportir_code'] = Transportir::query()
                ->where('id', $data['transportir_id'])
                ->value('code');

            $exist = $this->mappingTransportir->newQuery()
                ->where('driver_id', $data['driver_id'])
                ->where('is_active', true)
                ->where('id', '!=', $mapping->id)
                ->first();

            $exist?->update([
                'is_active' => false,
            ]);

            $mappingTransportir = $mapping->update($data);

            return $this->successResponse($mappingTransportir, 'Mapping transportir updated successfully', 200);

        } catch (\Throwable $e) {
            Log::error('[MappingTranspotirController@update] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'payload' => $request->all(),
            ]);

            return $this->errorResponse('Failed to update mapping transportir', 500);
        }
    }

    public function destroy($id)
    {
        try {

            $mapping = $this->mappingTransportir->newQuery()->findOrFail($id);
            $mapping->delete();

            return $this->successResponse(null, 'Mapping transportir deleted successfully', 200);

        } catch (\Throwable $e) {
            Log::error('[MappingTranspotirController@destroy] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->errorResponse('Failed to delete mapping transportir', 500);
        }
    }

}
