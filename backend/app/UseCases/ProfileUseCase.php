<?php
namespace App\UseCases;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileUseCase
{
	protected $userRepository;
	protected $authService;
	
	public function __construct(UserRepository $userRepository, AuthService $authService) {
		$this->userRepository = $userRepository;
		$this->authService = $authService;
	}
	public function execute($request) {
		if ($this->userRepository->findByUsername($request->email)) {
			throw new \Exception('既に同じメールアドレスで登録されています。別のメールアドレスで登録してください。');
		}

		$user = Auth::user();
		$user->username = $request->username;
		$user->email = $request->email;
		$user->password = Hash::make($request->password);
		$user->save();
		return $user;
	}
}
?>