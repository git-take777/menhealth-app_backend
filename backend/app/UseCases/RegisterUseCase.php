<?php
namespace App\UseCases;

use App\Repositories\UserRepository;

class RegisterUseCase {
	protected $userRepository;
	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function execute($email, $password)
	{
		// ここではバリデーションを実装しない
		if ($this->userRepository->findByUsername($email)) {
			throw new \Exception('既に同じメールアドレスで登録されています。別のメールアドレスで登録してください。');
		}
		$this->userRepository->create($email, $password);
	}

}
?>