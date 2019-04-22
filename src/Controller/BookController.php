<?php

namespace App\Controller;

use App\Command\AddBookCommand;
use App\Command\AssignEditorCommand;
use App\Command\ProcessBookCommand;
use App\Command\ReviewBookCommand;
use App\Command\SearchBookCommand;
use App\Entity\Book;
use App\EventListener\NotificationEvent;
use App\Form\AddBookFormType;
use App\Form\AssignEditorFormType;
use App\Form\ProcessBookFormType;
use App\Form\ReviewBookFormType;
use App\Form\SearchBookFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class BookController extends BaseController
{
    public function __construct(Security $security)
    {
        parent::__construct($security);
    }

    /**
     * @Route("/books", name="books")
     */
    public function index()
    {
        $user = $this->getUser();
        $userEvent = new NotificationEvent($user);
        $user = $this->get('event_dispatcher')->dispatch('user.book_added', $userEvent)->getUser();

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
     * @Route("/book/add", name="book_add")
     */
    public function upload(Request $request, MessageBusInterface $bus)
    {
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
     */
    public function search(Request $request, MessageBusInterface $bus)
    {
        $command = new SearchBookCommand();

        $form = $this->createForm(SearchBookFormType::class, $command);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $handle = $bus->dispatch($command);
            $handlestamp = $handle->last(HandledStamp::class);
            $books = $handlestamp->getResult();
            dump($books);
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
     */
    public function review(Book $book, Request $request, MessageBusInterface $bus)
    {
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
     */
    public function assignEditor(Book $book, Request $request, MessageBusInterface $bus)
    {
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
     */
    public function processBook(Book $book, Request $request, MessageBusInterface $bus)
    {
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
