<?php
/**
 * Created by PhpStorm.
 * User: mazaf
 * Date: 10/05/17
 * Time: 11:02
 */
namespace AppBundle\Service;

use AppBundle\Entity\Event;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class Message {

    protected $container;

    public function __construct(ContainerInterface $container, EngineInterface $templating)
    {
        $this->container = $container;
        $this->templating = $templating;
    }

    public function sendNotification(Event $event) {
        try {
            $linkToFo = 'http://localhost:42000';
            $message = \Swift_Message::newInstance()
                ->setSubject($event->getTitle())
                ->setFrom('whatawedo@noreply.fr')
                ->setTo($event->participantsToArray())
                ->setBody(
                    $this->templating->render('AppBundle::notification.html.twig', array(
                        'event' => $event,
                        'link'  => $linkToFo,
                    )),
                    'text/html'
                );

            $this->container->get('mailer')->send($message);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}