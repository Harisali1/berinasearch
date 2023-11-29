<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUserAPIRequest;
use App\Http\Resources\UserResource;
use App\Traits\FileHelper;
use App\Models\User;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\AppBaseController;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RegisterAPIController extends AppBaseController
{
    use FileHelper, AuthenticatesUsers;

    /** @var  UserRepository */
    private $usersRepository;

    public function __construct(UserRepository $usersRepo)
    {
        $this->usersRepository = $usersRepo;
    }

    /*** Store a newly created Register in storage.* POST /register*
     * @param CreateUserAPIRequest $request *
     * @return Response
     */

    public function store(CreateUserAPIRequest $request)
    {

        try {
            $user = new User();
            $Validator = $user->validateRegisterRequest($request->all());
            if (!$Validator) return $this->sendError($user->errors);

            $userData = $request->all();
            $userData['blocked'] = false;
            $userData['password'] = Hash::make($request['password']);
            $userData['role_id'] = $userData['role'];
            $role = Role::find($request['role']);

            if (!$role) {
                return $this->sendError('Invalid Role');
            }

            if ($request->get('picture')) {
                $folderPath = "/assets/frontend/img/user";
                $path = $this->saveFileAndGetPath($request->get('picture'), $folderPath);
                $userData['picture'] = $path;
            }

            $users = $this->usersRepository->create($userData);

            $token = JWTAuth::fromUser($users);
            $users->update([
                'api_token' => $token,
            ]);
//            return $this->sendResponse($users, 'User registered successfully');
            return $this->sendResponse(new UserResource($users), 'User registered successfully');

        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }

    }

}
