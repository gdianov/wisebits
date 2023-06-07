<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\User;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Psr\Log\LoggerInterface;

#[AsEntityListener(event: Events::postUpdate, method: 'postUpdate', entity: User::class)]
final class UserChangedLogListener
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function postUpdate(User $user, PostUpdateEventArgs $event): void
    {
        $this->logger->info('user.save', [
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'created' => $user->getCreated(),
            'deleted' => $user->getDeleted(),
            'notes' => $user->getNotes(),
        ]);
    }
}
