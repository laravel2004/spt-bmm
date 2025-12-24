<?php

namespace App\Http\Controllers\SuperAdmin\SPT;

use App\Http\Controllers\Controller;
use App\Models\MobSPt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SPTController extends Controller
{
    private MobSPt $spt;

    public function __construct(MobSPt $spt)
    {
        $this->spt = $spt;
    }

    public function index(Request $request)
    {
        try {
            $search  = trim((string) $request->query('search', ''));
            $perPage = (int) $request->query('perPage', 10);
            $perPage = max(1, min($perPage, 100));

            $query = $this->spt->newQuery()->where('status', false);

            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('spt_no', 'like', "%{$search}%")
                        ->orWhere('sppb_no', 'like', "%{$search}%")
                        ->orWhere('cust_code', 'like', "%{$search}%");
                });
            }

            $spts = $query
                ->orderByDesc('id')
                ->paginate($perPage)
                ->withQueryString();

            return view('pages.superadmin.spt.index', compact('spts'));
        } catch (\Throwable $e) {
            Log::error('[SPTController@index] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            abort(500, 'Failed to load SPTs');
        }
    }

    public function history(Request $request)
    {
        try {
            $search  = trim((string) $request->query('search', ''));
            $perPage = (int) $request->query('perPage', 10);
            $perPage = max(1, min($perPage, 100));

            $query = $this->spt->newQuery()->where('status', true);

            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('spt_no', 'like', "%{$search}%")
                        ->orWhere('sppb_no', 'like', "%{$search}%")
                        ->orWhere('cust_code', 'like', "%{$search}%");
                });
            }

            $spts = $query
                ->orderByDesc('id')
                ->paginate($perPage)
                ->withQueryString();

            return view('pages.superadmin.spt.index', compact('spts'));
        } catch (\Throwable $e) {
            Log::error('[SPTController@index] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            abort(500, 'Failed to load SPTs');
        }
    }

    public function show($id)
    {
        try {
            $spt = $this->spt->with('driver')->findOrFail($id);

            return view('pages.superadmin.spt.show', compact('spt'));

        } catch (\Throwable $e) {
            Log::error('[SPTController@show] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            abort(500, 'Failed to load SPT details');
        }
    }

    public function transit($id)
    {
        try {

            $spt = $this->spt->findOrFail($id);

            if ($spt->is_transit) {
                $spt->is_transit = false;
            } else {
                $spt->is_transit = true;
            }

            $spt->save();

            return $this->successResponse($spt, 'SPT transit updated successfully', 200);

        } catch (\Throwable $e) {
            Log::error('[SPTController@transit] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->errorResponse('Failed to update SPT transit status', 500);
        }
    }
}
