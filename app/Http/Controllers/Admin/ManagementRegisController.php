<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\RegisDataTable;

class ManagementRegisController extends Controller
{

    public function index(RegisDataTable $regisDataTable)
    {
        return $regisDataTable->render('registrations.index');
    }
}
