<?php

declare(strict_types=1);

namespace Strictify\Goodies\Goodies\DynamicForm;

use IteratorAggregate;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\ClearableErrorsInterface;

class FormWrapper implements IteratorAggregate, FormInterface, ClearableErrorsInterface
{
    private bool $isDynamicField = false;

    public function __construct(private Form $form)
    {
    }

    /**
     * Only method that is decorated
     */
    public function isValid(): bool
    {
        if ($this->isDynamicField) {
            $this->form->clearErrors(true);

            return false;
        }

        return $this->form->isValid();
    }

    public function getErrors(bool $deep = false, bool $flatten = true): FormErrorIterator
    {
        return $this->form->getErrors($deep, $flatten);
    }

    public function handleRequest($request = null)
    {
        if ($request instanceof Request && $request->request->has('_dynamic_field')) {
            $this->isDynamicField = true;
            $request->request->remove('_dynamic_field');
        }
        $this->form->handleRequest($request);

        return $this;
    }

    public function offsetExists($offset): bool
    {
        return $this->form->offsetExists($offset);
    }

    public function offsetGet($offset)
    {
        return $this->form->offsetGet($offset);
    }

    public function offsetSet($offset, $value): void
    {
        $this->form->offsetSet($offset, $value);
    }

    public function offsetUnset($offset): void
    {
        $this->form->offsetUnset($offset);
    }

    public function count(): int
    {
        return $this->form->count();
    }

    public function setParent(FormInterface $parent = null): self
    {
        $this->form->setParent($parent);

        return $this;
    }

    public function getParent()
    {
        return $this->form->getParent();
    }

    public function add($child, string $type = null, array $options = [])
    {
        $this->form->add($child, $type, $options);

        return $this;
    }

    public function get(string $name)
    {
        return $this->form->get($name);
    }

    public function has(string $name)
    {
        return $this->form->has($name);
    }

    public function remove(string $name)
    {
        $this->form->remove($name);

        return $this;
    }

    public function all()
    {
        return $this->form->all();
    }


    public function setData($modelData)
    {
        $this->form->setData($modelData);

        return $this;
    }

    public function getData()
    {
        return $this->form->getData();
    }

    public function getNormData()
    {
        return $this->form->getNormData();
    }

    public function getViewData()
    {
        return $this->form->getViewData();
    }

    public function getExtraData()
    {
        return $this->form->getExtraData();
    }

    public function getConfig()
    {
        return $this->form->getConfig();
    }

    public function isSubmitted()
    {
        return $this->form->isSubmitted();
    }

    public function getName()
    {
        return $this->form->getName();
    }

    public function getPropertyPath()
    {
        return $this->form->getPropertyPath();
    }

    public function addError(FormError $error)
    {
        $this->form->addError($error);

        return $this;
    }

    public function isRequired()
    {
        return $this->form->isRequired();
    }

    public function isDisabled()
    {
        return $this->form->isDisabled();
    }

    public function isEmpty()
    {
        return $this->form->isEmpty();
    }

    public function isSynchronized()
    {
        return $this->form->isSynchronized();
    }

    public function getTransformationFailure()
    {
        return $this->form->getTransformationFailure();
    }

    public function initialize()
    {
        $this->form->initialize();

        return $this;
    }

    public function submit($submittedData, bool $clearMissing = true)
    {
        $this->form->submit($submittedData, $clearMissing);

        return $this;
    }

    public function getRoot()
    {
        return $this->form->getRoot();
    }

    public function isRoot()
    {
        return $this->form->isRoot();
    }

    public function createView(FormView $parent = null)
    {
        return $this->form->createView($parent);
    }

    public function clearErrors(bool $deep = false)
    {
        $this->form->clearErrors($deep);

        return $this;
    }

    public function getIterator()
    {
        return $this->form->getIterator();
    }
}
