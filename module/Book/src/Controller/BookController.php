<?php

namespace Book\Controller;

use Book\Entity\Book;
use Book\Entity\BookCategory;
use Book\Form\BookForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Entity\User;

/**
 * This controller is responsible for user management (adding, editing,
 * viewing users and changing user's password).
 */
class BookController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * User manager.
     * @var Book\Service\BookManager
     */
    private $bookManager;

    /**
     * Constructor.
     */
    public function __construct($entityManager, $bookManager)
    {
        $this->entityManager = $entityManager;
        $this->bookManager = $bookManager;
    }

    /**
     * This is the default "index" action of the controller. It displays the
     * list of users.
     */
    public function indexAction()
    {
        $books = $this->entityManager->getRepository(Book::class)->findBy(['deleted_at' => null], ['id' => 'ASC']);

        return new ViewModel([
            'books' => $books
        ]);
    }

    /**
     * This action displays a page allowing to add a new user.
     */
    public function addAction()
    {
        // Create user form
        $form = new BookForm($this->entityManager);

        // Get the list of all available roles (sorted by name).
        $allCategories = $this->entityManager->getRepository(BookCategory::class)->findBy(['deleted_at' => null], ['name' => 'ASC']);
        $categoryList = [];
        foreach ($allCategories as $category) {
            $categoryList[$category->getId()] = $category->getName();
        }

        $form->get('id_book_category')->setValueOptions($categoryList);

        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {

            // Fill in the form with POST data
            $data = $this->params()->fromPost();

            $form->setData($data);

            // Validate form
            if ($form->isValid()) {

                // Get filtered and validated data
                $data = $form->getData();

                // Add user.
                $user = $this->bookManager->addBook($data);

                // Redirect to "view" page
                return $this->redirect()->toRoute('book');
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    /**
     * The "edit" action displays a page allowing to edit user.
     */
    public function editAction()
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id < 1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $book = $this->entityManager->getRepository(Book::class)->find($id);

        if ($book == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Create user form
        $form = new BookForm($this->entityManager, $book);


        // Get the list of all available roles (sorted by name).
        $allCategories = $this->entityManager->getRepository(BookCategory::class)->findBy(['deleted_at' => null], ['name' => 'ASC']);
        $categoryList = [];
        foreach ($allCategories as $category) {
            $categoryList[$category->getId()] = $category->getName();
        }

        $form->get('id_book_category')->setValueOptions($categoryList);

        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {

            // Fill in the form with POST data
            $data = $this->params()->fromPost();

            $form->setData($data);

            // Validate form
            if ($form->isValid()) {

                // Get filtered and validated data
                $data = $form->getData();

                // Update the user.
                $this->bookManager->updateBook($book, $data);

                // Redirect to "view" page
                return $this->redirect()->toRoute('book');
            }
        } else {
            $form->setData(array(
                'name' => $book->getName(),
                'id_book_category' => $book->getBookCategory()->getId()
            ));
        }

        return new ViewModel(array(
            'user' => $book,
            'form' => $form
        ));
    }

    /**
     * Delete
     * @return void|\Zend\Http\Response|ViewModel
     */
    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id < 1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $bookCategory = $this->entityManager->getRepository(Book::class)->find($id);
        $this->bookManager->deleteBook($bookCategory);

        $this->redirect()->toRoute('book');
    }

}