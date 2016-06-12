<?php


namespace L91\Sulu\Bundle\FormBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestListener
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            // don't do anything if it's not the master request
            return;
        }

        $request = $event->getRequest();

        if ($request->isMethod('post')) {
            // don't do anything iif it's not a post request
            return;
        }
    }
}
