<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        return ResponseFormatter::success($user, 'Data user');
    }
}
