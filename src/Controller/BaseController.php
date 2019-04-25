<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Note;
use App\Entity\Payment;
use App\Entity\Role;
use App\Entity\User;
use App\Helper\Orm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class BaseController
 * @package App\Controller
 */
abstract class BaseController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;
    /**
     * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
     */
    protected $bookRepo;
    /**
     * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
     */
    protected $userRepo;
    /**
     * @ORM\Entity(repositoryClass="App\Repository\PaymentRepository")
     */
    protected $paymentRepo;
    /**
     * @ORM\Entity(repositoryClass="App\Repository\NoteRepository")
     */
    protected $noteRepo;
    /**
     * @var bool
     */
    protected $admin = false;
    /**
     * @var bool
     */
    protected $agent = false;
    /**
     * @var bool
     */
    protected $author = false;
    /**
     * @var bool
     */
    protected $editor = false;
    /**
     * @var bool
     */
    protected $reviewer = false;
    /**
     * @var \Symfony\Component\Security\Core\User\UserInterface
     */
    protected $user;

    /**
     * BaseController constructor.
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getBookRepository()
    {
        return $this->bookRepo = $this->getDoctrine()->getManager()->getRepository(Book::class);
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getUserRepository()
    {
        return $this->userRepo = $this->getDoctrine()->getManager()->getRepository(User::class);
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getPaymentRepository()
    {
        return $this->paymentRepo = $this->getDoctrine()->getManager()->getRepository(Payment::class);
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getNoteRepository()
    {
        return $this->noteRepo = $this->getDoctrine()->getManager()->getRepository(Note::class);
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->admin = $this->isGranted(Role::ROLE_ADMIN);
    }

    /**
     * @return bool
     */
    public function isAgent()
    {
        return $this->agent = $this->isGranted(Role::ROLE_AGENT);
    }

    /**
     * @return bool
     */
    public function isAuthor()
    {
        return $this->author = $this->isGranted(Role::ROLE_AUTHOR);
    }

    /**
     * @return bool
     */
    public function isEditor()
    {
        return $this->editor = $this->isGranted(Role::ROLE_EDITOR);
    }

    /**
     * @return bool
     */
    public function isReviewer()
    {
        return $this->reviewer = $this->isGranted(Role::ROLE_REVIEWER);
    }

    /**
     * @return mixed|null|\Symfony\Component\Security\Core\User\UserInterface
     */
    public function getUser()
    {
        return $this->user = $this->security->getUser();
    }

}