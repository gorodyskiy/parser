<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * @var int
     */
    private $user_id;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->user_id = auth()->user()->id;
    }

    /**
     * Delete user and subscriptions.
     * 
     * @return JsonResponse
     */
    public function delete(): JsonResponse
    {
        User::find($this->user_id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'All user data deleted successfully.',
        ], 200);
    }
}
