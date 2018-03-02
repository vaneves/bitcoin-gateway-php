<?php 

namespace App\Models\Services;

use App\Models\Entities\User;

class UserService extends AppService
{
    public function get($id)
    {
        $user = User::find($id);
        if (!$user) {
            throw new \AppException('Conta não encontrada', 404);
        }
        return $user;
    }

    public function getByToken($email, $token)
    {
        $user = User::where('email', $email)->where('token', $token)->first();
        return $user;
    }

    public function newToken($id)
    {
        $user = User::find($id);
        if (!$user) {
            throw new \AppException('Conta não encontrada', 404);
        }
        $token = str_random(rand(40, 64));
        $user->token = $token;
        $user->save();
        
        return $token;
    }

    public function sendToken($id)
    {
        $user = User::find($id);
        if (!$user) {
            throw new \AppException('Conta não encontrada', 404);
        }
        
        // send
        
        return $user->email;
    }

    public function updateSettings($id, $data)
    {
        $user = User::find($id);
        if (!$user) {
            throw new \AppException('Conta não encontrada', 404);
        }
        $user->redirect_url = $data['redirect_url'];
        $user->notification_url = $data['notification_url'];
        $user->save();
    }
}