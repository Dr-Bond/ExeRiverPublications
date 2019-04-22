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

abstract class BaseController extends AbstractController
{
    private $security;
    protected $bookRepo;
    protected $userRepo;
    protected $paymentRepo;
    protected $noteRepo;
    protected $admin = false;
    protected $agent = false;
    protected $author = false;
    protected $editor = false;
    protected $reviewer = false;
    protected $user;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function getBookRepository()
    {
        return $this->bookRepo = $this->getDoctrine()->getManager()->getRepository(Book::class);
    }

    public function getUserRepository()
    {
        return $this->userRepo = $this->getDoctrine()->getManager()->getRepository(User::class);
    }

    public function getPaymentRepository()
    {
        return $this->paymentRepo = $this->getDoctrine()->getManager()->getRepository(Payment::class);
    }

    public function getNoteRepository()
    {
        return $this->noteRepo = $this->getDoctrine()->getManager()->getRepository(Note::class);
    }

    public function isAdmin()
    {
        return $this->admin = $this->isGranted(Role::ROLE_ADMIN);
    }

    public function isAgent()
    {
        return $this->agent = $this->isGranted(Role::ROLE_AGENT);
    }

    public function isAuthor()
    {
        return $this->author = $this->isGranted(Role::ROLE_AUTHOR);
    }

    public function isEditor()
    {
        return $this->editor = $this->isGranted(Role::ROLE_EDITOR);
    }

    public function isReviewer()
    {
        return $this->reviewer = $this->isGranted(Role::ROLE_REVIEWER);
    }

    public function getUser()
    {
        return $this->user = $this->security->getUser();
    }

}