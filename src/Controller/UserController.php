<?php

namespace App\Controller;

use App\Command\ClearNotificationCommand;
use App\Command\CreateUserCommand;
use App\Command\DeleteUserCommand;
use App\Entity\Notification;
use App\Entity\User;
use App\Form\CreateUserFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends BaseController
{

    /**
     * @Route("/user/create", name="create_user")
     * @param Request $request
     * @param MessageBusInterface $bus
     * @return mixed \Symfony\Component\HttpFoundation\RedirectResponse \Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait
     *  Admin access only, allows the admin to create a user, due to how the password is protected, the password is set on the command inside the controller.
     */
    public function createUser(Request $request, MessageBusInterface $bus)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $command = new CreateUserCommand();

        $form = $this->createForm(CreateUserFormType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $command->setPlainPassword($form->get('plainPassword')->getData());
            $bus->dispatch($command);
            return $this->redirect($this->generateUrl('users'));
        }
        return $this->render('user/createUser.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/login", name="login")
     * @param AuthenticationUtils $authenticationUtils
     * @return mixed  \Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait
     *  Using login process using symfony's AuthenticationUtil.
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
     * @param Notification $notification
     * @param MessageBusInterface $bus
     * @return mixed \Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait
     *  Author and Agent access only, allows deleting of notifications.
     */
    public function clearNotification(Notification $notification, MessageBusInterface $bus)
    {
        $this->denyAccessUnlessGranted(['ROLE_AUTHOR','ROLE_AGENT']);

        $command = new ClearNotificationCommand($notification);
        $bus->dispatch($command);
        return $this->redirect($this->generateUrl('books'));
    }

    /**
     * @Route("/user/delete/{user}", name="delete_user")
     * @param User $user
     * @param MessageBusInterface $bus
     * @return mixed \Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait
     *  Admin access only, allows deleting of the user.
     */
    public function deleteUser(User $user, MessageBusInterface $bus)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $command = new DeleteUserCommand($user);
        $bus->dispatch($command);
        return $this->redirect($this->generateUrl('users'));
    }

    /**
     * @Route("/users", name="users")
     * @return mixed \Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait
     *  Admin access only, lists all users.
     */
    public function users()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $users = $this->getUserRepository()->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }
}
