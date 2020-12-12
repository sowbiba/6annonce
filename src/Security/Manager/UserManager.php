<?php

namespace App\Security\Manager;

use App\Entity\Role;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use App\Security\Util\PasswordUpdaterInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Traversable;

class UserManager implements UserManagerInterface
{
    /**
     * @var EmailVerifier
     */
    private $emailVerifier;
    /**
     * @var PasswordUpdaterInterface
     */
    private $passwordUpdater;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(
        EmailVerifier $emailVerifier,
        UserPasswordEncoderInterface $passwordEncoder,
        PasswordUpdaterInterface $passwordUpdater,
        EntityManagerInterface $entityManager
    ) {
        $this->emailVerifier = $emailVerifier;
        $this->passwordEncoder = $passwordEncoder;
        $this->passwordUpdater = $passwordUpdater;
        $this->entityManager = $entityManager;
        $this->userRepository = $entityManager->getRepository(User::class);
    }

    /**
     * {@inheritdoc}
     */
    public function registerClient(User $user, bool $sendEmailVerification = false): UserInterface
    {
        $user->addRole($this->getRoleBySlug(Role::ROLE_DEFAULT));

        // encode the plain password
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                $user->getPlainPassword()
            )
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        if ($sendEmailVerification) {
            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('sowbiba@hotmail.com', '6annonce Admin'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
        }
        // do anything else you need here, like send an email

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function registerMember(User $user, bool $sendEmailVerification = false): UserInterface
    {
        $user->addRole($this->getRoleBySlug(Role::ROLE_MEMBER));

        // encode the plain password
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                $user->getPlainPassword()
            )
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        if ($sendEmailVerification) {
            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('sowbiba@hotmail.com', '6annonce Admin'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
        }
        // do anything else you need here, like send an email

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function registerAdmin(User $user, bool $sendEmailVerification = false): UserInterface
    {
        $user->addRole($this->getRoleBySlug(Role::ROLE_SUPER_ADMIN));

        // encode the plain password
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                $user->getPlainPassword()
            )
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        if ($sendEmailVerification) {
            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('sowbiba@hotmail.com', '6annonce Admin'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
        }
        // do anything else you need here, like send an email

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function findUserByEmail($email): UserInterface
    {
        return $this->findUserBy(['email' => $email]);
    }

    /**
     * {@inheritdoc}
     */
    public function findUserByUsername($username): UserInterface
    {
        return $this->findUserBy(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function findUserByUsernameOrEmail($usernameOrEmail): UserInterface
    {
        if (preg_match('/^.+\@\S+\.\S+$/', $usernameOrEmail)) {
            $user = $this->findUserByEmail($usernameOrEmail);
            if (null !== $user) {
                return $user;
            }
        }

        return $this->findUserByUsername($usernameOrEmail);
    }

    /**
     * {@inheritdoc}
     */
    public function findUserByConfirmationToken($token): UserInterface
    {
        return $this->findUserBy(['confirmationToken' => $token]);
    }

    /**
     * {@inheritdoc}
     */
    public function updatePassword(UserInterface $user)
    {
        $this->passwordUpdater->hashPassword($user);
    }

    /**
     * @return PasswordUpdaterInterface
     */
    protected function getPasswordUpdater(): PasswordUpdaterInterface
    {
        return $this->passwordUpdater;
    }

    public function deleteUser(UserInterface $user)
    {
        // TODO: Implement deleteUser() method.
    }

    public function findUserBy(array $criteria): ?UserInterface
    {
        return $this->userRepository->findOneBy($criteria);
    }

    public function findUsers(): Traversable
    {
        return yield from $this->userRepository->findAll();
    }

    public function getClass(): string
    {
        return User::class;
    }

    public function reloadUser(UserInterface $user)
    {
        // TODO: Implement reloadUser() method.
    }

    public function updateUser(UserInterface $user, $andFlush = true)
    {
        // TODO: Implement updateUser() method.
    }

    public function updateCanonicalFields(UserInterface $user)
    {
        // TODO: Implement updateCanonicalFields() method.
    }

    /**
     * @return User
     */
    private function createUser(): User
    {
        $class = $this->getClass();

        return new $class();
    }

    private function getRoleBySlug(string $slug): Role
    {
        return $this->entityManager->getRepository(Role::class)->findOneBy(['name' => $slug]);
    }
}
