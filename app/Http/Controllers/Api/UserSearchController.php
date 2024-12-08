<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserSearchController extends Controller
{
    public function search(Request $request)
    {
        $user = $request->query('search');
        $users = User::query()
            ->where('name', 'like', "%$user%")
            ->orWhere('email', 'like', "%$user%")
            ->select('name', 'email')
            ->get();

        return response()->json($users);
    }
}
