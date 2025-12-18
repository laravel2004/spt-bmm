<?php

namespace App\Http\Controllers\SuperAdmin\Transportir;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transportir\TransportirAddFormRequest;
use App\Models\Tranportir;
use App\Models\Transportir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransportirController extends Controller
{
    private Transportir $tranportir;

    public function __construct(Transportir $tranportir)
    {
        $this->tranportir = $tranportir;
    }

    public function index(Request $request)
    {
        try {
            $search  = trim((string) $request->query('search', ''));
            $perPage = (int) $request->query('perPage', 10);
            $perPage = max(1, min($perPage, 100));

            $query = $this->tranportir->newQuery();

            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', "%{$search}%")
                        ->orWhere('tranportir_name', 'like', "%{$search}%");
                });
            }

            $transportirs = $query
                ->orderByDesc('id')
                ->paginate($perPage)
                ->withQueryString();

            return view('pages.superadmin.transportir.index', compact('transportirs'));
        } catch (\Throwable $e) {
            Log::error('[TransportirController@index] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            abort(500, 'Failed to load transportirs');
        }
    }

    public function create()
    {
        try {
            return view('pages.superadmin.transportir.create');
        } catch (\Throwable $e) {
            Log::error('[TransportirController@create] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            abort(500, 'Failed to load create transportir page');
        }
    }

    public function store(TransportirAddFormRequest $request)
    {
        try {
            $data = $request->validated();
            $data['processed_by'] = auth()->user()->username;
            $data['processed_date'] = date('Y-m-d H:i:s');
            $transportir = $this->tranportir->create($data);

            return $this->successResponse($transportir, 'Transportir created successfully', 201 );
        } catch (\Throwable $e) {
            Log::error('[TransportirController@store] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->errorResponse('Failed to store transportir', 500 );
        }
    }

    public function edit($id)
    {
        try {
            $transportir = $this->tranportir->findOrFail($id);
            return view('pages.superadmin.transportir.edit', compact('transportir'));

        } catch (\Throwable $e) {
            Log::error('[TransportirController@edit] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            abort(500, 'Failed to load edit transportir page');
        }
    }

    public function update(TransportirAddFormRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $data['processed_by'] = auth()->user()->username;
            $data['processed_date'] = date('Y-m-d H:i:s');

            $transportir = $this->tranportir->findOrFail($id);
            $transportir->update($data);

            return $this->successResponse($transportir, 'Transportir updated successfully', 200 );
        } catch (\Throwable $e) {
            Log::error('[TransportirController@update] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->errorResponse('Failed to update transportir', 500 );
        }
    }

    public function destroy($id)
    {
        try {
            $transportir = $this->tranportir->findOrFail($id);
            $transportir->delete();

            return $this->successResponse(null, 'Transportir deleted successfully', 200 );
        } catch (\Throwable $e) {
            Log::error('[TransportirController@destroy] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->errorResponse('Failed to delete transportir', 500 );
        }
    }

}
