<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cards;
use App\Models\Devices;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'email|string|max:255|unique:users',
            'phone' => 'required|string|max:50|unique:users',
            'picture' => 'string|max:255',
            'password' => 'required|confirmed|string|max:255|min:8',
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors()], 422);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->save();

        $this->create_bonuse_card($user);

        $device = new Devices();
        $device->user_id = User::latest()->first()->id;
        $device->ip_address = $request->ip();
        $device->browser = $request->userAgent();
        $device->save();

        return $this->create_token($user);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:50',
            'password' => 'required|confirmed|string|max:255|min:8',
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors()], 422);
        }

        $creditionals = \request(['phone', 'password']);

        if (Auth::attempt($creditionals)) {
            $user = $request->user();

            $this->create_bonuse_card($user);

            $device = new Devices();
            $device->user_id = $user->id;
            $device->ip_address = $request->ip();
            $device->browser = $request->userAgent();
            $device->save();

            return $this->create_token($user);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response(['success' => 'Successfully Logged out'], 200);
    }

    public function forgetpass(Request $request)
    {
        return "forget Pass";
    }

    public function user(Request $request)
    {
        try {
            return $request->user();
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 422);
        }
    }

    public function create_token(User $user)
    {
        $tokenResult = $user->createToken('Personal access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addYear(1);
        $token->save();

        return response(
            [
                'accessToken' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expiresAt' => Carbon::parse($token->expires_at)->toDateTimeString()
            ],
            200
        );
    }

    public function create_bonuse_card(User $user)
    {
        if (!Cards::where("card_type", 'epin')->where("user_id", $user->id)->first()) {
            return Cards::create([
                'user_id' => $user->id,
                'card_number' => $this->makePinNumb(),
                'card_type' => 'epin',
                'expiry_date' => '∞/∞',
                'category' => 'bonuse',
            ]);
        }
    }

    protected function makePinNumb()
    {
        $code = '111';
        for ($i = 0; $i < 13; $i++) {
            $code .= mt_rand(0, 9);
        }
        return $code;
    }
}
