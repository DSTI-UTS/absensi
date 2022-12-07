<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Structure;

class StructuresController extends Controller
{
    public function index()
    {
        return Structure::all();
    }

    public function role($child_id)
    {
        return Structure::role($child_id);
    }

    public function parent($child_id)
    {
        return Structure::parent($child_id);
    }

    public function parents($child_id)
    {
        return Structure::parents($child_id);
    }

    public function parentWFlow($child_id)
    {
        return Structure::parentWFlow($child_id);
    }

    public function children($child_id)
    {
        return Structure::children($child_id);
    }

    public function childrens($child_id)
    {
        return Structure::childrens($child_id);
    }

    public function childrenWFlow($child_id)
    {
        return Structure::childrenWFlow($child_id);
    }

    public function parentNChildren($child_id)
    {
        return Structure::parentNChildren($child_id);
    }
}
