<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\AccessMenu;
use App\Models\AppMenu;
use App\Models\Area;
use App\Models\ServiceUnit;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = User::with(['service_unit'])
                ->where('role', '!=', 'superadmin')
                ->orderBy('created_at', 'DESC')->get();
            return $this->basicDataTables($data);
        }
        return view('admin.user.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            DB::beginTransaction();
            $app_menus = AppMenu::with([])
                ->orderBy('id', 'ASC')
                ->get();
            try {
                $data_request = [
                    'username' => $this->postField('username'),
                    'nickname' => $this->postField('nickname'),
                    'password' => Hash::make($this->postField('password')),
//                    'role' => $this->postField('role'),
                    'role' => 'admin',
                    'service_unit_id' => $this->postField('service_unit'),
                ];
                $user = User::create($data_request);
                foreach ($app_menus as $app_menu) {
                    $data_access = [
                        'user_id' => $user->id,
                        'app_menu_id' => $app_menu->id,
                        'is_granted_create' => false,
                        'is_granted_update' => false,
                        'is_granted_delete' => false
                    ];
                    AccessMenu::create($data_access);
                }
                DB::commit();
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $service_units = ServiceUnit::with([])->orderBy('name','ASC')->get();
        return view('admin.user.add')->with(['service_units' => $service_units]);
    }

    public function patch($id)
    {
        $data = User::with(['area'])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'username' => $this->postField('username'),
                    'nickname' => $this->postField('nickname'),
//                    'role' => $this->postField('role'),
                    'role' => 'admin',
                    'area_id' => $this->postField('area'),
                ];

                if ($this->postField('password') !== '') {
                    $data_request['password'] = Hash::make($this->postField('password'));
                }
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $service_units = ServiceUnit::with([])->orderBy('name','ASC')->get();
        return view('admin.user.edit')->with([
            'data' => $data,
            'service_units' => $service_units
        ]);
    }

    public function destroy($id)
    {
        try {
            User::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
