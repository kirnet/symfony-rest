<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\EventListener;


use App\Shared\Domain\Security\UserFetcherInterface;
use App\Users\Infrastructure\Controller\UpdateUserAction;
use App\Users\Infrastructure\Roles;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final class EventControllerSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly UserFetcherInterface $userFetcher)
    {
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        if ($request->attributes->get('_controller') === UpdateUserAction::class) {
            $user = $this->userFetcher->getAuthUser();
            if (!in_array(Roles::ADMIN->value, $user->getRoles()) && $user->getId() !== intval($request->get('id'))) {
                throw new AccessDeniedException();
            }
        }

    }

    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onKernelRequest'
        ];
    }
}