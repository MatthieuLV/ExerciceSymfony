<?php

namespace App\EventSubscriber;

use App\Repository\BookRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Twig\Environment;

class TwigEventSubscriber implements EventSubscriberInterface
{
    private $twig;
    private $bookRepository;

    public function __construct(Environment $twig, BookRepository $bookRepository)
    {
        $this->twig = $twig;
        $this->bookRepository = $bookRepository;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $this->twig->addGlobal('books', $this->bookRepository->findAll());
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
    }
}
