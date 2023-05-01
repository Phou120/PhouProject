<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TypeService;
use App\Http\Requests\TypeRequest;

class TypeController extends Controller
{
    public $typeService;

    public function __construct(TypeService $typeService)
    {
        $this->typeService=$typeService;
    }

    public function addType(TypeRequest $request)
    {
        return $this->typeService->addType($request);
    }

    public function editType(TypeRequest $request)
    {
        return $this->typeService->editType($request);
    }

    public function deleteType(TypeRequest $request)
    {
        return $this->typeService->deleteType($request);
    }

    public function listTypes()
    {
        return $this->typeService->listTypes();
    }
}
