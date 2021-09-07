<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * User service
 */
class UserService
{
    private UserRepository $userRepository;

    private PaginatorInterface $paginator;

    /**
     * @param UserRepository     $userRepository
     * @param PaginatorInterface $paginator
     */
    public function __construct(UserRepository $userRepository, PaginatorInterface $paginator)
    {
        $this->userRepository = $userRepository;
        $this->paginator = $paginator;
    }

    /**
     * @param User $user
     *
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function saveUser(User $user): void
    {
        $this->userRepository->save($user);
    }

    /**
     * @param User $user
     *
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function deleteUser(User $user): void
    {
        $this->userRepository->delete($user);
    }

    /**
     * @param int $page
     *
     * @return PaginationInterface
     */
    public function createPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->userRepository->findAll(),
            $page,
            UserRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }
}
