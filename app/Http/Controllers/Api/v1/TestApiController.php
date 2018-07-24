<?php

namespace App\Http\Controllers\Api\v1;
use App\User as UserModel;

class TestApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function show($id)
    {
        $user = UserModel::findOrFail($id);

        return $this->response->array($user->toArray());
    }
}
