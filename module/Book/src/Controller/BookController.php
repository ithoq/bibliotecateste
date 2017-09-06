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
        $books = $this->entityManager->getRepository(Book::class)->findBy([], ['id' => 'ASC']);

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

        $user = $this->entityManager->getRepository(User::class)
            ->find($id);

        if ($user == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Create user form
        $form = new UserForm('update', $this->entityManager, $user);

        // Get the list of all available roles (sorted by name).
        $allCategories = $this->entityManager->getRepository(Role::class)
            ->findBy([], ['name' => 'ASC']);
        $categoryList = [];
        foreach ($allCategories as $category) {
            $categoryList[$category->getId()] = $category->getName();
        }

        $form->get('roles')->setValueOptions($categoryList);

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
                $this->bookManager->updateUser($user, $data);

                // Redirect to "view" page
                return $this->redirect()->toRoute('users',
                    ['action' => 'view', 'id' => $user->getId()]);
            }
        } else {
            $form->setData(array(
                'full_name' => $user->getFullName(),
                'email' => $user->getEmail(),
                'status' => $user->getStatus(),
                'roles' => $userRoleIds
            ));
        }

        return new ViewModel(array(
            'user' => $user,
            'form' => $form
        ));
    }

}