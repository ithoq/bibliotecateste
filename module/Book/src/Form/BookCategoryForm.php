<?php

namespace Book\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\ArrayInput;
use Book\Validator\BookExistsValidator;

/**
 * This form is used to collect book's email, full name, password and status. The form
 * can work in two scenarios - 'create' and 'update'. In 'create' scenario, book
 * enters password, in 'update' scenario he/she doesn't enter password.
 */
class BookCategoryForm extends Form
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager = null;


    /**
     * Current user.
     * @var Book\Entity\BookCategory
     */
    private $bookCategory = null;

    /**
     * Constructor.
     */
    public function __construct($entityManager = null, $bookCategory = null)
    {
        // Define form name
        parent::__construct('book-category-form');

        // Set POST method for this form
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'validate');
        $this->setAttribute('role', 'form');

        // Save parameters for internal use.
        $this->entityManager = $entityManager;
        $this->bookCategory = $bookCategory;

        $this->addElements();
        $this->addInputFilter();
    }

    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements()
    {
        // Add "full_name" field
        $this->add([
            'type' => 'text',
            'name' => 'name',
            'options' => [
                'label' => 'Nome',
            ],
        ]);

        // Add the Submit button
        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Salvar'
            ],
        ]);
    }

    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter()
    {
        // Create main input filter
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        // Add input for "full_name" field
        $inputFilter->add([
            'name' => 'name',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 255
                    ],
                ],
            ],
        ]);
    }
}