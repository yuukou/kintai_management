<?php
/**
 * Created by PhpStorm.
 * User: tanakayuko
 * Date: 2018/12/20
 * Time: 14:22
 */

namespace App\Services\Admin;

use App\Services\Service;
use App\Services\TokenService;
use App\Token;
use App\User;

class UserService extends Service
{
    /**
     * @var UserSendMailService
     */
    private $userSendMailService;
    /**
     * @var TokenService
     */
    private $tokenService;

    public function __construct(UserSendMailService $userSendMailService, TokenService $tokenService)
    {
        $this->userSendMailService = $userSendMailService;
        $this->tokenService = $tokenService;
    }

    public function store(array $inputs)
    {
        $data = [
            'name' => $inputs['name'],
            'email' => $inputs['email'],
            ];

        $inputData = $data;
        $inputData['status'] = USER_STATUS_TEMP;
        $result = User::create($inputData);

        $token = $this->tokenService->createRegisterToken($data);
        $userId = $result->id;
        $inputToken['token'] = $token;
        $inputToken['user_id'] = $userId;
        Token::create($inputToken);

        $data['token'] = $token;
        $this->userSendMailService->sendMail($data);

        return $token;
    }
}