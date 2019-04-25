<?php

namespace App\Controller;

use App\Command\AddBookCommand;
use App\Command\AssignEditorCommand;
use App\Command\ProcessBookCommand;
use App\Command\ReviewBookCommand;
use App\Command\SearchBookCommand;
use App\Entity\Book;
use App\Form\AddBookFormType;
use App\Form\AssignEditorFormType;
use App\Form\ProcessBookFormType;
use App\Form\ReviewBookFormType;
use App\Form\SearchBookFormType;
use phpDocumentor\Reflection\Types\Void_;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class BookController extends BaseController
{
    /**
     * BookController constructor.
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        parent::__construct($security);
    }

    /**
     * @Route("/books", name="books")
     * Main homepage for most redirects and redirect after login.
     * Books which are shown are dependent on user role
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if ($this->isAdmin()) {
            $books = $this->getBookRepository()->findAll();
            $subHeading = 'All Books';
        } elseif($this->isAgent() or $this->isAuthor()) {
            $books = $this->getBookRepository()->findMyBooks($this->getUser());
            $subHeading = 'My Books';
        } elseif($this->isReviewer()) {
            $books = $this->getBookRepository()->findPendingReview($this->getUser());
            $subHeading = 'Status: '. Book::PENDING_REVIEW_STATUS;
        } elseif($this->isEditor()) {
            $books = $this->getBookRepository()->findPendingEditorProcessing($this->getUser());
            $subHeading = 'Need Processing';
        } else {
            throw new NotFoundHttpException("User Role Not Found");
        }

        return $this->render('book/index.html.twig', [
            'books' => $books,
            'subHeading' => $subHeading
        ]);
    }

    /**
     * @Route("/book/add", name="add_book")
     * @param Request $request
     * @param MessageBusInterface $bus
     * @return mixed \Symfony\Component\HttpFoundation\RedirectResponse \Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait
     * Admin access only, allows adding of the book.
     */
    public function add(Request $request, MessageBusInterface $bus)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $command = new AddBookCommand();

        $form = $this->createForm(AddBookFormType::class, $command);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $bus->dispatch($command);
            return $this->redirect($this->generateUrl('books'));
        } else {
            return $this->render('book/add.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }

    /**
     * @Route("/book/search", name="search_book")
     * @param Request $request
     * @param MessageBusInterface $bus
     * @return mixed \Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait
     * Admin access only, allows adding of the book.
     *  Admin, Reviewer and Editor only, allows searching for book by status.
     */
    public function search(Request $request, MessageBusInterface $bus)
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN','ROLE_REVIEWER','ROLE_EDITOR']);

        $command = new SearchBookCommand();

        $form = $this->createForm(SearchBookFormType::class, $command);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $handle = $bus->dispatch($command);
            $handlestamp = $handle->last(HandledStamp::class);
            $books = $handlestamp->getResult();
            return $this->render('book/search.html.twig', array(
                'form' => $form->createView(),
                'books' => $books
            ));
        }

        return $this->render('book/search.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/book/review/{book}", name="review_book")
     * @param Book $book
     * @param Request $request
     * @param MessageBusInterface $bus
     * @return mixed \Symfony\Component\HttpFoundation\RedirectResponse \Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait
     * Admin access only, allows adding of the book.
     */
    public function review(Book $book, Request $request, MessageBusInterface $bus)
    {
        $this->denyAccessUnlessGranted('ROLE_REVIEWER');

        $command = new ReviewBookCommand($book, $this->getUser());
        $form = $this->createForm(ReviewBookFormType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bus->dispatch($command);
            return $this->redirect($this->generateUrl('books'));
        } else {
            return $this->render('book/review.html.twig', array(
                'form' => $form->createView(),
                'book' => $book
            ));
        }
    }

    /**
     * @Route("/book/assign-editor/{book}", name="assign_editor_book")
     * @param Book $book
     * @param Request $request
     * @param MessageBusInterface $bus
     * @return mixed \Symfony\Component\HttpFoundation\RedirectResponse \Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait
     * Admin access only, assigns the editor.
     */
    public function assignEditor(Book $book, Request $request, MessageBusInterface $bus)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $command = new AssignEditorCommand($book);
        $form = $this->createForm(AssignEditorFormType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bus->dispatch($command);
            return $this->redirect($this->generateUrl('books'));
        } else {
            return $this->render('book/assign-editor.html.twig', array(
                'form' => $form->createView(),
                'book' => $book
            ));
        }
    }

    /**
     * @Route("/book/process/{book}", name="process_book")
     * @param Book $book
     * @param Request $request
     * @param MessageBusInterface $bus
     * @return mixed \Symfony\Component\HttpFoundation\RedirectResponse \Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait
     *  Editor access only to process the book.
     */
    public function processBook(Book $book, Request $request, MessageBusInterface $bus)
    {
        $this->denyAccessUnlessGranted('ROLE_EDITOR');

        $command = new ProcessBookCommand($book, $this->getUser());
        $form = $this->createForm(ProcessBookFormType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bus->dispatch($command);
            return $this->redirect($this->generateUrl('books'));
        } else {
            return $this->render('book/process.html.twig', array(
                'form' => $form->createView(),
                'book' => $book
            ));
        }
    }
}
