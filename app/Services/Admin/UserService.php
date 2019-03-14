<?php
/**
 * Created by PhpStorm.
 * User: tanakayuko
 * Date: 2018/12/20
 * Time: 14:22
 */

namespace App\Services\Admin;

use App\EmailToken;
use App\Services\SendMailService;
use App\Services\UserService as CommonService;
use App\Services\TokenService;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserService extends CommonService
{
    public function __construct(TokenService $tokenService, SendMailService $sendMailService)
    {
        parent::__construct($tokenService, $sendMailService);
    }

    public function store(array $inputs)
    {
        $data = [
            'name' => $inputs['name'],
            'email' => $inputs['email'],
            ];

        $inputData = $data;
//        $inputData['password'] = $inputs['password'];
        $inputData['password'] = Hash::make($inputs['password']);
        $inputData['status'] = USER_STATUS_TEMP;
        $result = User::create($inputData);

        $token = $this->tokenService->createRegisterToken($data);
        $userId = $result->id;
        $inputToken['token'] = $token;
        $inputToken['user_id'] = $userId;
        EmailToken::create($inputToken);

        $data['token'] = $token;
        $this->sendMailService->sendMail($data);

        return $data = [
            'user_id' => $userId,
            'token' => $token
        ];
    }
}