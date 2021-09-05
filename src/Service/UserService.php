<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class UserService
{
    private UserRepository $userRepository;

    private PaginatorInterface $paginator;

    public function __construct(UserRepository $userRepository, PaginatorInterface $paginator)
    {
        $this->userRepository = $userRepository;
        $this->paginator = $paginator;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function saveUser(User $user)
    {
        $this->userRepository->save($user);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function deleteUser(User $user)
    {
        $this->userRepository->delete($user);
    }

    public function createPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->userRepository->findAll(),
            $page,
            UserRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }
}
