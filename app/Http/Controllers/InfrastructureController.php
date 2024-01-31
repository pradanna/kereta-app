<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\Area;
use App\Models\FacilityLocomotive;
use App\Models\FacilitySpecialEquipment;
use App\Models\FacilityTrain;
use App\Models\FacilityType;
use App\Models\FacilityWagon;
use App\Models\ServiceUnit;
use Illuminate\Database\Eloquent\Builder;

class InfrastructureController extends CustomController
{
    private $formula;

    public function __construct()
    {
        parent::__construct();
        $this->formula = new Formula();
    }

    public function index()
    {
        return view('admin.infrastructure.index');
    }

}
