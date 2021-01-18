<?php

namespace App\EventSubscriber;

use App\Repository\RoomRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Twig\Environment;

class TwigEventSubscriber implements EventSubscriberInterface
{
    private $twig;
    private $roomRepository;

    public function __construct(Environment $twig, RoomRepository $roomRepository)
    {
        $this->twig = $twig;
        $this->roomRepository = $roomRepository;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $this->twig->addGlobal('rooms', $this->roomRepository->findAll());
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
    }
}
