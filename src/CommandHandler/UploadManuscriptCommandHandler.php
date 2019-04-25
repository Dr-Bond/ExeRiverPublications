<?php

namespace App\CommandHandler;

use App\Command\UploadManuscriptCommand;
use App\Entity\Book;
use App\Entity\Manuscript;
use App\Helper\Orm;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class UploadManuscriptCommandHandler
 * @package App\CommandHandler
 */
class UploadManuscriptCommandHandler
{
    /**
     * @var Orm
     */
    private $orm;
    /**
     * @var ParameterBagInterface
     */
    private $params;

    /**
     * UploadManuscriptCommandHandler constructor.
     * @param Orm $orm
     * @param ParameterBagInterface $params
     */
    public function __construct(Orm $orm, ParameterBagInterface $params)
    {
        $this->orm = $orm;
        $this->params = $params;
    }

    /**
     * @param UploadManuscriptCommand $command
     * Gets the file location, creating a file name along with adding the extension and then move to the manuscript directory
     * Creates the Manuscript object, adding the name, file location and the book it belongs to.
     * Updates the book status to show that a new Manuscript has been uploaded.
     * Updates the book status to show that a new Manuscript has been uploaded.
     */
    public function __invoke(UploadManuscriptCommand $command)
    {
        $file = $command->getLocation();
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($this->params->get('manuscript_directory'), $fileName);

        $orm = $this->orm;
        $book = $command->getBook();
        $manuscript = new Manuscript(
            $command->getName(),
            $fileName,
            $book
        );
        if($book->getStatus() === Book::REVISION_REQUIRED_STATUS) {
            $book->setStatus(Book::PENDING_EDITOR_REVIEW_STATUS);
            $orm->persist($book);
        } else {
            $book->setStatus(Book::PENDING_REVIEW_STATUS);
            $orm->persist($book);
        }
        $orm->persist($manuscript);
        $orm->flush();
    }
}