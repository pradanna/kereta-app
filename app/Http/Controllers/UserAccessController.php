<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
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

    public function getAppMenu()
    {
        try {
            $app_menus = AppMenu::with([])
                ->get();
            return $this->jsonSuccessResponse('success', $app_menus);
        }catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
