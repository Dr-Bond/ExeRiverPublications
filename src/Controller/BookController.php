<?php

namespace App\Controller;

use App\Command\AddBookCommand;
use App\Command\AssignEditorCommand;
use App\Command\ReviewBookCommand;
use App\Entity\Book;
use App\Form\AddBookFormType;
use App\Form\AssignEditorBookFormType;
use App\Form\AssignEditorFormType;
use App\Form\ReviewBookFormType;
use App\Reporting\BookReport;
use phpDocumentor\Reflection\Types\Parent_;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\MessageBusInterface;
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
            $books = $this->getBookRepository()->findApproved($this->getUser());
            $subHeading = Book::ACCEPTED_STATUS. 'Books';
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
}
