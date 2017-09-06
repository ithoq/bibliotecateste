<?php

namespace Book\Controller;

use Book\Entity\Book;
use Book\Entity\BookCategory;
use Book\Form\BookCategoryForm;
use Book\Form\BookForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Entity\User;

/**
 * This controller is responsible for user management (adding, editing,
 * viewing users and changing user's password).
 */
class BookCategoryController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * User manager.
     * @var Book\Service\BookCategoryManager
     */
    private $bookCategoryManager;

    /**
     * Constructor.
     */
    public function __construct($entityManager, $bookCategoryManager)
    {
        $this->entityManager = $entityManager;
        $this->bookCategoryManager= $bookCategoryManager;
    }

    /**
     * This is the default "index" action of the controller. It displays the
     * list of users.
     */
    public function indexAction()
    {
        $bookCategories = $this->entityManager->getRepository(BookCategory::class)->findBy([], ['id' => 'ASC']);

        return new ViewModel([
            'bookCategories' => $bookCategories
        ]);
    }

    /**
     * This action displays a page allowing to add a new user.
     */
    public function addAction()
    {
        // Create user form
        $form = new BookCategoryForm($this->entityManager);

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
                $this->bookCategoryManager->addBook($data);

                // Redirect to "view" page
                return $this->redirect()->toRoute('book_category');
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    /**
     * The "view" action displays a page allowing to view user's details.
     */
    public function viewAction()
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id < 1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Find a user with such ID.
        $user = $this->entityManager->getRepository(User::class)
            ->find($id);

        if ($user == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        return new ViewModel([
            'user' => $user
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

        $bookCategory = $this->entityManager->getRepository(BookCategory::class)->find($id);

        if ($bookCategory == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Create user form
        $form = new BookCategoryForm($this->entityManager, $bookCategory);
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
                $this->bookCategoryManager->updateBook($bookCategory, $data);

                // Redirect to "view" page
                return $this->redirect()->toRoute('book_category');
            }
        } else {
            $form->setData(array(
                'name' => $bookCategory->getName()
            ));
        }

        return new ViewModel(array(
            'bookCategory' => $bookCategory,
            'form' => $form
        ));
    }

}