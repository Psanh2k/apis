<?php

namespace App\Services;

use App\Core\BaseResponse;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * Class AuthService.
 */
class AuthService extends BaseResponse
{
    public function handle()
    {
        try {
            // $user = $this->credential($request);
            return $this->errorResponse('Success', 404);

        } catch (\Exception $exception) {
            \Log::channel('api')->error("Login Api at ". now() .  " : " . $exception->getMessage());
        }
    }

    /**
     * Credential Information
     *
     * @return mixed
     */
    protected function credential($request)
    {
        $credential = [
            'email'         => $request->email,
            'deleted_at'    => null,
        ];

        $user = User::where($credential)->first();

        if ($user && Hash::check($request->get('password'), $user->password)) {
            return $user;
        }

        return null;
    }

        /**
     * Get Token
     *
     * @param User $user
     * @param string $salt
     * @return array
     */
    protected function getToken($user)
    {
        $token = $user->createToken(config('app.name') . ' System Personal Access Client');
        // $refreshToken = $this->generateRefreshToken($user);

        return [
            'token_type'    => 'Bearer',
            'access_token'  => $token->accessToken,
            'user_id'       => $user->id,
            'user_name'     => $user->name,
        ];
    }

}
