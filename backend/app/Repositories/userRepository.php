<?php
namespace App\Repositories;

use App\Models\User as UserModel;

class UserRepository
{
    public function findByUsername($useremail)
    {
        $userModel = UserModel::where('useremail', $useremail)->first();
        if ($userModel) {
            return new \App\Entities\User(
                $userModel->id,
                $userModel->username,
                $userModel->gender,
				$userModel->email,
                $userModel->password,
                $userModel->age,
                $userModel->hight,
                $userModel->weight,
                $userModel->goalbody,
                $userModel->action
            );
        }
        return null;
    }
    public function create ($email, $password) {
         // 現在の最大のIDを取得
        $maxId = User::max('id');
        // 新しいIDを決定
        $newId = $maxId ? $maxId + 1 : 1;
        return User::create([
            'id' => $newId,
            'email' => $email,
            'password' => bcrypt($password), //パスワードをハッシュ化
        ]);
    }
}

?>