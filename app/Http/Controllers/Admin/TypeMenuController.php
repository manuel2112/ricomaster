<?php

namespace App\Http\Controllers\Admin;

use App\Actions\TypeMenu\ListTypeMenu;
use App\Http\Controllers\Controller;
use App\Utils\ResponseHandler;
use Illuminate\Http\JsonResponse;

class TypeMenuController extends Controller
{
    public function __construct(
        private readonly ListTypeMenu $listTypeMenu,
    ) {
    }

    public function get(): JsonResponse
    {
        try {
            return ResponseHandler::success($this->listTypeMenu->handle(), '+Lista tipos de menú');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }
}
