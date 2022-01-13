<?php

namespace Application\BackendBundle\EventListener;
 
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
 
class KernelExceptionListener
{
    private $router;
    private $redirectRouter = 'application_frontend_default_index';
 
    public function __construct(Router $router)
    {
        $this->router = $router;
    }
 
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
 
        if ($exception instanceof NotFoundHttpException) {
            if ($event->getRequest()->get('_route') == $this->redirectRouter) {
                return;
            }
 
            $url = $this->router->generate($this->redirectRouter);
            $response = new RedirectResponse($url);
            $event->setResponse($response);
        }
    }
}
