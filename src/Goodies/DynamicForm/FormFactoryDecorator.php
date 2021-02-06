<?php

declare(strict_types=1);

namespace Strictify\Goodies\Goodies\DynamicForm;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormBuilderInterface;

class FormFactoryDecorator implements FormFactoryInterface
{
    public function __construct(private FormFactoryInterface $formFactory)
    {
    }

    /**
     * @inheritDoc
     */
    public function create(string $type = 'Symfony\Component\Form\Extension\Core\Type\FormType', $data = null, array $options = []): FormInterface
    {
        $form =  $this->formFactory->create($type, $data, $options);

        if ($form instanceof Form) {
            return new FormWrapper($form);
        }

        return $form;
    }

    public function createNamed(string $name, string $type = 'Symfony\Component\Form\Extension\Core\Type\FormType', $data = null, array $options = []): FormInterface
    {
        $form = $this->formFactory->createNamed($name, $type, $data, $options);

        if ($form instanceof Form) {
            return new FormWrapper($form);
        }

        return $form;
    }

    public function createForProperty(string $class, string $property, $data = null, array $options = []): FormInterface
    {
        $form =  $this->formFactory->createForProperty($class, $property, $data, $options);

        if ($form instanceof Form) {
            return new FormWrapper($form);
        }

        return $form;
    }

    public function createBuilder(string $type = 'Symfony\Component\Form\Extension\Core\Type\FormType', $data = null, array $options = []): FormBuilderInterface
    {
        return $this->formFactory->createBuilder($type, $data, $options);
    }

    public function createNamedBuilder(string $name, string $type = 'Symfony\Component\Form\Extension\Core\Type\FormType', $data = null, array $options = []): FormBuilderInterface
    {
        return $this->formFactory->createNamedBuilder($name, $type, $data, $options);
    }

    public function createBuilderForProperty(string $class, string $property, $data = null, array $options = []): FormBuilderInterface
    {
        return $this->formFactory->createBuilderForProperty($class, $property, $data, $options);
    }
}
