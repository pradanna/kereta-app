<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\AccessMenu;
use App\Models\AppMenu;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class UserAccessController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->method() === 'POST') {
            DB::beginTransaction();
            try {
                $requestBody = $this->request->request->get('data');
                $dataBody = json_decode($requestBody, true);
                if (!is_array($dataBody)) {
                    return $this->jsonBadRequestResponse('Terjadi Kesalahan Dalam Konversi Request...');
                }
                $userID = $dataBody['user'];
                $access = $dataBody['access'];

                $user = User::with(['role_access.app_menu'])->where('id', '=', $userID)
                    ->first();
                if (!$user) {
                    return $this->jsonNotFoundResponse('Akun Pengguna Tidak Dapat Di Temukan....');
                }
                /** @var Collection $user_access */
                $user_access = $user->role_access;
                /** @var Collection $appMenus */
                $appMenus = AppMenu::with([])->get();
                foreach ($access as $datum) {
                    $slug = $datum['key'];
                    $valueAccess = $datum['value'];
                    /** @var Collection $role */
                    $appMenuExists = $appMenus->where('slug', '=', $slug)->first();
                    if ($appMenuExists) {
                        $role = $user_access->where('app_menu.slug', '=', $slug)->first();
                        if ($role) {
                            $tmpAccess = [
                                'is_granted_create' => false,
                                'is_granted_update' => false,
                                'is_granted_delete' => false
                            ];
                            foreach ($valueAccess as $va) {
                                $ka = 'is_granted_'.$va['access'];
                                $tmpAccess[$ka] = $va['val'];
                            }
                            $role->update($tmpAccess);
                        } else {
                            $dataAccess = [
                                'user_id' => $user->id,
                                'app_menu_id' => $appMenuExists->id,
                                'is_granted_create' => false,
                                'is_granted_update' => false,
                                'is_granted_delete' => false
                            ];
                            foreach ($valueAccess as $va) {
                                $ka = 'is_granted_'.$va['access'];
                                $dataAccess[$ka] = $va['val'];
                            }
                            AccessMenu::create($dataAccess);
                        }
                    }
                }
                DB::commit();
                return $this->jsonSuccessResponse('success');
            }catch (\Exception $e) {
                DB::rollBack();
                return $this->jsonErrorResponse($e->getMessage());
            }
        }
        $users = User::with([])
            ->where('role', '!=', 'superadmin')
            ->orderBy('username', 'ASC')
            ->get();
        return view('admin.user-access.index')
            ->with([
                'users' => $users
            ]);
    }

    public function getAccessMenu()
    {
        try {
            $userID = $this->request->query->get('user');
            $access_menus = AccessMenu::with(['user', 'app_menu'])
                ->where('user_id', '=', $userID)
                ->get();
            return $this->jsonSuccessResponse('success', $access_menus);
        }catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
