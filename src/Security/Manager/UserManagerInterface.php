<?php

namespace App\Security\Manager;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Traversable;

interface UserManagerInterface
{
    /**
     * Creates an CLIENT user instance.
     *
     * @param User $user
     * @param bool $sendEmailVerification
     * @return UserInterface
     */
    public function registerClient(User $user, bool $sendEmailVerification = false): UserInterface;

    /**
     * Creates an MEMBER user instance.
     *
     * @param User $user
     * @param bool $sendEmailVerification
     * @return UserInterface
     */
    public function registerMember(User $user, bool $sendEmailVerification = false): UserInterface;

    /**
     * Creates an SUPER_ADMIN user instance.
     *
     * @param User $user
     * @param bool $sendEmailVerification
     * @return UserInterface
     */
    public function registerAdmin(User $user, bool $sendEmailVerification = false): UserInterface;

    /**
     * Deletes a user.
     *
     * @param UserInterface $user
     */
    public function deleteUser(UserInterface $user);

    /**
     * Finds one user by the given criteria.
     *
     * @param array $criteria
     *
     * @return UserInterface|null
     */
    public function findUserBy(array $criteria): ?UserInterface;

    /**
     * Find a user by its username.
     *
     * @param string $username
     *
     * @return UserInterface|null
     */
    public function findUserByUsername(string $username): ?UserInterface;

    /**
     * Finds a user by its email.
     *
     * @param string $email
     *
     * @return UserInterface|null
     */
    public function findUserByEmail(string $email): ?UserInterface;

    /**
     * Finds a user by its username or email.
     *
     * @param string $usernameOrEmail
     *
     * @return UserInterface|null
     */
    public function findUserByUsernameOrEmail(string $usernameOrEmail): ?UserInterface;

    /**
     * Finds a user by its confirmationToken.
     *
     * @param string $token
     *
     * @return UserInterface|null
     */
    public function findUserByConfirmationToken(string $token): ?UserInterface;

    /**
     * Returns a collection with all user instances.
     *
     * @return Traversable
     */
    public function findUsers(): Traversable;

    /**
     * Returns the user's fully qualified class name.
     *
     * @return string
     */
    public function getClass(): string;

    /**
     * Reloads a user.
     *
     * @param UserInterface $user
     */
    public function reloadUser(UserInterface $user);

    /**
     * Updates a user.
     *
     * @param UserInterface $user
     * @param bool $andFlush
     */
    public function updateUser(UserInterface $user, $andFlush = true);

    /**
     * Updates the canonical username and email fields for a user.
     *
     * @param UserInterface $user
     */
    public function updateCanonicalFields(UserInterface $user);

    /**
     * Updates a user password if a plain password is set.
     *
     * @param UserInterface $user
     */
    public function updatePassword(UserInterface $user);
}
