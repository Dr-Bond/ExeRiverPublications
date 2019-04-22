<?php

namespace App\Controller;

use App\Command\ClearNotificationCommand;
use App\Command\CreateUserCommand;
use App\Entity\Notification;
use App\Form\CreateUserFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends BaseController
{

    /**
     * @Route("/user/create", name="createUser")
     */
    public function createUser(Request $request, MessageBusInterface $bus)
    {
        $command = new CreateUserCommand();

        $form = $this->createForm(CreateUserFormType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $command->setPlainPassword($form->get('plainPassword')->getData());
            $bus->dispatch($command);
        }
        return $this->render('user/createUser.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('user/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * @Route("/user/clear-notification/{notification}", name="clear_notification")
     */
    public function clearNotification(Notification $notification, MessageBusInterface $bus)
    {
        $command = new ClearNotificationCommand($notification);
        $bus->dispatch($command);
        return $this->redirect($this->generateUrl('books'));
    }
}
