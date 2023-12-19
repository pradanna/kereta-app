<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\AccessMenu;
use App\Models\AppMenu;
use App\Models\User;

class UserAccessController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
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
