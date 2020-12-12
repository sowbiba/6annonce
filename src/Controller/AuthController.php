<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\RoleRepository;
use App\Security\Manager\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class AuthController extends AbstractController
{
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * @var UserManagerInterface
     */
    private $userManager;

    public function __construct(UserManagerInterface $userManager, RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->userManager = $userManager;
    }

    /**
     * @Route("/registerss", name="auth_register",  methods={"POST"})
     *
     * @param Request $request
     *
     * @return JsonResponse|RedirectResponse
     */
    public function register(Request $request)
    {
        $data = json_decode(
            $request->getContent(),
            true
        );
        $validator = Validation::createValidator();
        $constraint = new Assert\Collection([
            // the keys correspond to the keys in the input array
            'username' => new Assert\Length(['min' => 1]),
            'password' => new Assert\Length(['min' => 1]),
            'email' => new Assert\Email(),
        ]);
        $violations = $validator->validate($data, $constraint);
        if ($violations->count() > 0) {
            return new JsonResponse(['error' => (string) $violations], 500);
        }
        $username = $data['username'];
        $password = $data['password'];
        $email = $data['email'];
        $roleUser = $this->roleRepository->findOneBy(['name' => 'ROLE_USER']);

        $user = new User();
        $user
            ->setUsername($username)
            ->setPlainPassword($password)
            ->setEmail($email)
            ->setEnabled(true)
            ->setRoles([$roleUser])
        ;
        try {
            $this->userManager->updateUser($user, true);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }

        return new JsonResponse(['success' => $user->getUsername() . ' has been registered!'], 200);
    }
}
