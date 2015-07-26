<?php
/*
 * This file is part of the "Lost and Found" project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Message;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Frontend MessageController
 *
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 * @author Artem Genvald      <genvaldartem@gmail.com>
 */
class MessageController extends Controller
{
    /**
     * @param Message $message Message
     *
     * @return Response
     *
     * @Method("GET")
     * @Route("message/{id}/delete", name="message_delete", options={"i18n"=false}))
     * @ParamConverter("message", class="AppBundle\Entity\Message")
     */
    public function deleteMessageAction(Message $message)
    {
        $message->setDeleted(true);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $count = $this->get('app.user_items_count');
        $count = $count->getCount($this->getUser());

        return $this->render('frontend/user/show_messages.html.twig', [
            'type'  => 'sent',
            'count' => $count,
        ]);
    }
}
