<?php

namespace App\Api\v1;
use App\User as UserModel;
use App\Api\v1\ApiBaseController;

class TestApiController extends ApiBaseController
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
        $user = UserModel::first();

        return $this->response->array($user->toArray());
    }
}
