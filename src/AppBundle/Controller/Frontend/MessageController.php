<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Message;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MessageController
 */
class MessageController extends Controller
{
    /**
     * @param Message $message
     *
     * @return Response
     *
     * @Route("message/{id}/delete", name="message_delete")
     * @ParamConverter("message", class="AppBundle\Entity\Message")
     */
    public function deleteMessageAction(Message $message)
    {
        $message->setDeleted(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();

        $count = $this->get('app.user_items_count');

        $count = $count->getCount($this->getUser());

        return $this->render(':frontend/user:show_sent_messages.html.twig', [
            'count' => $count,
        ]);
    }
}
