<?php

namespace App\Http\Controllers\SuperAdmin\Driver;

use App\Http\Controllers\Controller;
use App\Http\Requests\Driver\DriverAddFormRequest;
use App\Http\Requests\Driver\DriverEditFormRequest;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class DriverController extends Controller
{
    private Driver $driver;
    private User $user;

    public function __construct(Driver $driver, User $user)
    {
        $this->driver = $driver;
        $this->user   = $user;
    }

    public function index(Request $request)
    {
        try {
            $search  = trim((string) $request->query('search', ''));
            $perPage = (int) $request->query('perPage', 10);
            $perPage = max(1, min($perPage, 100));

            $query = $this->driver->newQuery()->with('user');

            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('fullname', 'like', "%{$search}%")
                        ->orWhere('phone_num', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('no_ktp', 'like', "%{$search}%")
                        ->orWhere('driver_type', 'like', "%{$search}%")
                        ->orWhere('reference_code', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($uq) use ($search) {
                            $uq->where('username', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->orWhere('fullname', 'like', "%{$search}%");
                        });
                });
            }

            $drivers = $query->orderByDesc('id')->paginate($perPage)->withQueryString();

            return view('pages.superadmin.driver.index', compact('drivers'));

        } catch (\Throwable $e) {
            Log::error('[DriverController@index] ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            abort(500, 'Failed to load driver');
        }
    }

    public function create()
    {
        try {
            return view('pages.superadmin.driver.create');
        } catch (\Throwable $e) {
            Log::error('[DriverController@create] ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            abort(500, 'Failed to load driver creation form');
        }
    }

    public function store(DriverAddFormRequest $request)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('ktp_photo')) {
                $ktpPhotoPath = $request->file('ktp_photo')->store('ktp_photos', 'public');
                $data['ktp_photo'] = $ktpPhotoPath;
            }

            $result = DB::transaction(function () use ($data) {
                $user = $this->user->create([
                    'username'   => $data['username'],
                    'fullname'   => $data['user_fullname'],
                    'role'       => 'DRIVER',
                    'phone_num'  => $data['phone_num'] ?? null,
                    'email'      => $data['email'],
                    'password'   => Hash::make($data['password']),
                    'created_by' => auth()->user()->username ?? null,
                ]);

                $driver = $this->driver->create([
                    'user_id'        => $user->id,
                    'fullname'       => $data['driver_fullname'] ?? $data['user_fullname'],
                    'birthday'       => $data['birthday'] ?? null,
                    'place_of_birth' => $data['place_of_birth'] ?? null,
                    'ktp_photo'     => $data['ktp_photo'] ?? null,

                    'address_type'   => $data['address_type'] ?? null,
                    'address'        => $data['address'] ?? null,
                    'rttw'           => $data['rttw'] ?? null,
                    'village'        => $data['village'] ?? null,
                    'sub_district'   => $data['sub_district'] ?? null,
                    'district'       => $data['district'] ?? null,
                    'city'           => $data['city'] ?? null,
                    'province'       => $data['province'] ?? null,
                    'zipcode'        => $data['zipcode'] ?? null,

                    'phone_num'      => $data['phone_num'] ?? null,
                    'email'          => $data['email'] ?? null,

                    'marital_status' => $data['marital_status'] ?? null,
                    'religion'       => $data['religion'] ?? null,
                    'gender'         => $data['gender'] ?? null,
                    'last_education' => $data['last_education'] ?? null,
                    'no_ktp'         => $data['no_ktp'] ?? null,
                    'driver_type'    => $data['driver_type'] ?? null,

                    'status'         => $data['status'],
                    'reference_code' => $data['reference_code'] ?? null,
                    'is_active'      => $data['is_active'],

                    'created_by'     => auth()->user()->username ?? null,
                ]);

                return compact('user', 'driver');
            });

            return $this->successResponse($result, 'Driver stored successfully', 201);

        } catch (\Throwable $e) {
            Log::error('[DriverController@store] ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return $this->errorResponse('Failed to store driver', 500);
        }
    }

    public function edit($id)
    {
        try {
            $driver = $this->driver->with('user')->findOrFail($id);
            return view('pages.superadmin.driver.edit', compact('driver'));
        } catch (\Throwable $e) {
            Log::error('[DriverController@edit] ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            abort(500, 'Failed to load driver edit form');
        }
    }

    public function update(DriverEditFormRequest $request, $id)
    {
        try {
            $data = $request->validated();

            $driver = $this->driver->with('user')->findOrFail($id);
            $user   = $driver->user;

            if ($request->hasFile('ktp_photo')) {
                $ktpPhotoPath = $request->file('ktp_photo')->store('ktp_photos', 'public');
                $data['ktp_photo'] = $ktpPhotoPath;
            }

            $result = DB::transaction(function () use ($data, $driver, $user) {

                $userPayload = [
                    'username'    => $data['username'],
                    'fullname'    => $data['user_fullname'],
                    'email'       => $data['email'],
                    'phone_num'   => $data['phone_num'] ?? null,
                    'modified_by' => auth()->user()->username ?? null,
                ];

                if (!empty($data['password'])) {
                    $userPayload['password'] = Hash::make($data['password']);
                }

                $user->update($userPayload);

                $driver->update([
                    'fullname'       => $data['driver_fullname'] ?? $data['user_fullname'],
                    'birthday'       => $data['birthday'] ?? null,
                    'place_of_birth' => $data['place_of_birth'] ?? null,
                    'ktp_photo'     => $data['ktp_photo'] ?? $driver->ktp_photo,

                    'address_type'   => $data['address_type'] ?? null,
                    'address'        => $data['address'] ?? null,
                    'rttw'           => $data['rttw'] ?? null,
                    'village'        => $data['village'] ?? null,
                    'sub_district'   => $data['sub_district'] ?? null,
                    'district'       => $data['district'] ?? null,
                    'city'           => $data['city'] ?? null,
                    'province'       => $data['province'] ?? null,
                    'zipcode'        => $data['zipcode'] ?? null,

                    'phone_num'      => $data['phone_num'] ?? null,
                    'email'          => $data['email'] ?? null,

                    'marital_status' => $data['marital_status'] ?? null,
                    'religion'       => $data['religion'] ?? null,
                    'gender'         => $data['gender'] ?? null,
                    'last_education' => $data['last_education'] ?? null,
                    'no_ktp'         => $data['no_ktp'] ?? null,
                    'driver_type'    => $data['driver_type'] ?? null,

                    'status'         => $data['status'],
                    'reference_code' => $data['reference_code'] ?? null,
                    'is_active'      => $data['is_active'],

                    'modified_by'    => auth()->user()->username ?? null,
                ]);

                return ['driver' => $driver->fresh('user')];
            });

            return $this->successResponse($result, 'Driver updated successfully', 200);

        } catch (\Throwable $e) {
            Log::error('[DriverController@update] ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return $this->errorResponse('Failed to update driver', 500);
        }
    }

    public function destroy($id)
    {
        try {
            $driver = $this->driver->with('user')->findOrFail($id);

            DB::transaction(function () use ($driver) {
                $driver->user?->delete();
            });

            return $this->successResponse(null, 'Driver deleted successfully', 200);

        } catch (\Throwable $e) {
            Log::error('[DriverController@destroy] ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return $this->errorResponse('Failed to delete driver', 500);
        }
    }

    public function show($id)
    {
        try {
            $driver = $this->driver->with('user')->findOrFail($id);
            return view('pages.superadmin.driver.show', compact('driver'));
        } catch (\Throwable $e) {
            Log::error('[DriverController@show] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            abort(500, 'Failed to load driver detail');
        }
    }
}
