<?php
/**
 * Created by PhpStorm.
 * User: mazaf
 * Date: 08/05/17
 * Time: 16:16
 */
namespace AppBundle\EventListener;

use \Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RequestListener
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $routeName = $request->get('_route');
        if($routeName == "homepage") {
            $url = $this->container->get('router')->generate("sonata_admin_dashboard");
            $response = new RedirectResponse($url);
            $event->setResponse($response);
        } else {
            $bypassCommunity = $this->container->get('session')->get('by_pass_community');
            if ($routeName == "admin_app_event_create" && is_null($bypassCommunity) && !$request->isMethod('POST')) {
                $url = $this->container->get('router')->generate("admin_app_event_community");
                $response = new RedirectResponse($url);
                $event->setResponse($response);
            } else {
                $this->container->get('session')->remove('by_pass_community');
            }
        }
    }
}