<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Response;
use Validator;
use Event;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon;

class LoginAPIController extends AppBaseController
{
    use AuthenticatesUsers;

    /** @var  UserRepository */
    private $usersRepository;

    public function __construct(UserRepository $usersRepo)
    {
        $this->usersRepository = $usersRepo;
        $this->middleware('auth:api', ['except' => ['store', 'socialLogin']]);
    }

    /*** Store a newly created Register in storage.* POST /register*
     * @param CreateRegisterAPIRequest $request *
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $user = new User();
            $Validator = $user->validateLoginRequest($request->all());
            if (!$Validator) return $this->sendError($user->errors);

            $credentials = $request->only('email', 'password');

            if ($token = JWTAuth::attempt($credentials, ['exp' => Carbon\Carbon::now()->addDays(7)->timestamp])) {
                $user = User::where($request->only('email'))->firstOrFail();
                $user->update([
                    'api_token' => $token,
                ]);
                if (!Hash::check($request->get('password'), $user->password))
                    throw new ModelNotFoundException();

                return $this->sendResponse(new UserResource($user), 'Login Successful');
            }
            return $this->sendError('Incorrect Email Or Password');

        } catch (ModelNotFoundException $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function index(Request $request)
    {
        try {
            $this->guard()->logout();
            return $this->sendResponse(null, 'Logged Out');
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

}
