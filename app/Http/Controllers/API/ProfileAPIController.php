<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\GalleryStoreRequest;
use App\Http\Requests\API\UpdatePasswordAPIRequest;
use App\Http\Requests\API\UpdateProfileRequest;
use App\Http\Requests\API\UpdateUserAPIRequest;
use App\Models\Gallery;
use App\Models\User;
use App\Repositories\UserRepository;
use Exception;
//use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Response;

/**
 * Class UserController
 * @package App\Http\Controllers\API
 */
class ProfileAPIController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Update the specified User in storage.
     * PUT/PATCH /users/{id}
     *
     * @param int $id
     * @param UpdateUserAPIRequest $request
     *
     * @return Response
     */
    public function update(UpdateProfileRequest $request)
    {



        if (!Auth::user()) {
            return $this->sendError('User not found');
        }

        $userData = $request->all();


        $user = $this->userRepository->update($userData, Auth::user()->id);


        return $this->sendResponse(new UserResource($user), 'User updated successfully');
    }


    public function forgotPassword(UpdateUserAPIRequest $request)
    {
        try {
            $token = Str::random(16);
            $user = User::where('email', $request->get('email'))->first();
            if (!$user) {
                return $this->sendError('Email not exit');
            }
            $user->update(['forgot_token' => $token]);
            return $this->sendResponse(['token' => $token], 'User updated successfully');
        } catch (Exception $e) {
            return $this->sendError('User not found');
        }
    }


    public function updatePassword(UpdatePasswordAPIRequest $request)
    {
        try {
            $user = User::where('forgot_token', $request->get('token'))->first();
            if (!$user) {
                return $this->sendError('Token not exists');
            }
            $user->update([
                'password'     => bcrypt($request->get('password')),
                'forgot_token' => NULL
            ]);
            return $this->sendResponse([], 'Password updated successfully');
        } catch (Exception $e) {
            return $this->sendError('User not found');
        }
    }

    public function profileImageUpdate(GalleryStoreRequest $request)
    {
        $userImage = [];
        if ($request->get('image')) {
            $folderPath = "/assets/frontend/img/user";
            $image = Str::replace('data:image/png;base64,', '', $request->get('image'));
            $image = Str::replace(' ', '+', $image);
            $imageName = Str::random(10).'.'.'png';
            $userImage = [
                'file_name' => $imageName,
                'path'      => $folderPath .'/'.$imageName,
                'size'      => '2306',
                'format'    => 'png',
                'user_id'   => Auth::user()->id,
            ];

            $gallaries = Gallery::where('user_id', Auth::user()->id)->exists();
            if ($gallaries == true) {
                $gallery = Gallery::where('user_id', Auth::user()->id)->get();
                $gallery = Gallery::findOrFail($gallery[0]->id);
                File::delete(public_path() . $gallery->path);
                $gallery->delete();
            }
            File::put(public_path() . $folderPath. '/' . $imageName, base64_decode($image));
        }
        $gallery = Gallery::create($userImage);
        $response = [
            'id'       => $gallery->id,
            'path'     => $gallery->path,
            'full_url' => env('APP_URL') . $gallery->path,
        ];
        return $this->sendResponse($response, 'Profile Image updated successfully');

    }

}
