<?php

namespace App\Http\Controllers\SuperAdmin\SJ;

use App\Http\Controllers\Controller;
use App\Models\MobSj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SJController extends Controller
{
    private MobSj $mobSj;

    public function __construct(MobSj $mobSj)
    {
        $this->mobSj = $mobSj;
    }

    public function index(Request $request)
    {
        try {
            $search  = trim((string) $request->query('search', ''));
            $perPage = (int) $request->query('perPage', 10);
            $perPage = max(1, min($perPage, 100));

            $query = $this->mobSj->newQuery()->where('status', false);

            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('sj_no', 'like', "%{$search}%")
                        ->orWhere('cust_name', 'like', "%{$search}%")
                        ->orWhere('cust_code', 'like', "%{$search}%");
                });
            }

            $sjs = $query
                ->orderByDesc('id')
                ->paginate($perPage)
                ->withQueryString();

            return view('pages.superadmin.sj.index', compact('sjs'));
        } catch (\Throwable $e) {
            Log::error('[SJController@index] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            abort(500, 'Failed to load SJs');
        }
    }

    public function history(Request $request)
    {
        try {
            $search  = trim((string) $request->query('search', ''));
            $perPage = (int) $request->query('perPage', 10);
            $perPage = max(1, min($perPage, 100));

            $query = $this->mobSj->newQuery()->where('status', true);

            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('sj_no', 'like', "%{$search}%")
                        ->orWhere('cust_name', 'like', "%{$search}%")
                        ->orWhere('cust_code', 'like', "%{$search}%");
                });
            }

            $sjs = $query
                ->orderByDesc('id')
                ->paginate($perPage)
                ->withQueryString();

            return view('pages.superadmin.sj.index', compact('sjs'));
        } catch (\Throwable $e) {
            Log::error('[SJController@index] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            abort(500, 'Failed to load SJs');
        }
    }
}
