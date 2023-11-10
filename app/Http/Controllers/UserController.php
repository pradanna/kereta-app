<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Area;
use App\Models\User;
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
            $data = User::with(['area'])
                ->where('role', '!=', 'superadmin')
                ->orderBy('created_at', 'DESC')->get();
            return $this->basicDataTables($data);
        }
        return view('admin.user.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'username' => $this->postField('username'),
                    'nickname' => $this->postField('nickname'),
                    'password' => Hash::make($this->postField('password')),
                    'role' => $this->postField('role'),
                    'area_id' => $this->postField('area'),
                ];
                User::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $areas = Area::all();
        return view('admin.user.add')->with(['areas' => $areas]);
    }

    public function patch($id)
    {
        $data = User::with(['area'])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'username' => $this->postField('username'),
                    'nickname' => $this->postField('nickname'),
                    'role' => $this->postField('role'),
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
        $areas = Area::all();
        return view('admin.user.edit')->with([
            'data' => $data,
            'areas' => $areas
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
