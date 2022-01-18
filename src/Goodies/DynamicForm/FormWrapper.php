<?php

declare(strict_types=1);

namespace Strictify\Goodies\Goodies\DynamicForm;

use Traversable;
use IteratorAggregate;
use ReturnTypeWillChange;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\FormConfigInterface;
use Symfony\Component\Form\ClearableErrorsInterface;
use Symfony\Component\PropertyAccess\PropertyPathInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

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

    public function handleRequest(mixed $request = null): static
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

    /**
     * @psalm-suppress InvalidReturnType
     * @psalm-suppress InvalidReturnStatement
     */
    public function offsetGet($offset): FormInterface
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

    public function setParent(FormInterface $parent = null): static
    {
        $this->form->setParent($parent);

        return $this;
    }

    public function getParent(): FormInterface
    {
        return $this->form->getParent();
    }

    public function add($child, string $type = null, array $options = []): static
    {
        $this->form->add($child, $type, $options);

        return $this;
    }

    public function get(string $name): FormInterface
    {
        return $this->form->get($name);
    }

    public function has(string $name): bool
    {
        return $this->form->has($name);
    }

    public function remove(string $name): static
    {
        $this->form->remove($name);

        return $this;
    }

    public function all(): array
    {
        return $this->form->all();
    }


    public function setData($modelData): static
    {
        $this->form->setData($modelData);

        return $this;
    }

    public function getData(): mixed
    {
        return $this->form->getData();
    }

    public function getNormData(): mixed
    {
        return $this->form->getNormData();
    }

    public function getViewData(): mixed
    {
        return $this->form->getViewData();
    }

    public function getExtraData(): array
    {
        return $this->form->getExtraData();
    }

    public function getConfig(): FormConfigInterface
    {
        return $this->form->getConfig();
    }

    public function isSubmitted(): bool
    {
        return $this->form->isSubmitted();
    }

    public function getName(): string
    {
        return $this->form->getName();
    }

    public function getPropertyPath(): ?PropertyPathInterface
    {
        return $this->form->getPropertyPath();
    }

    public function addError(FormError $error): static
    {
        $this->form->addError($error);

        return $this;
    }

    public function isRequired(): bool
    {
        return $this->form->isRequired();
    }

    public function isDisabled(): bool
    {
        return $this->form->isDisabled();
    }

    public function isEmpty(): bool
    {
        return $this->form->isEmpty();
    }

    public function isSynchronized(): bool
    {
        return $this->form->isSynchronized();
    }

    public function getTransformationFailure(): ?TransformationFailedException
    {
        return $this->form->getTransformationFailure();
    }

    public function initialize(): static
    {
        $this->form->initialize();

        return $this;
    }

    public function submit($submittedData, bool $clearMissing = true): static
    {
        $this->form->submit($submittedData, $clearMissing);

        return $this;
    }

    public function getRoot(): FormInterface
    {
        return $this->form->getRoot();
    }

    public function isRoot(): bool
    {
        return $this->form->isRoot();
    }

    public function createView(FormView $parent = null): FormView
    {
        return $this->form->createView($parent);
    }

    /**
     * @return static
     */
    public function clearErrors(bool $deep = false): static
    {
        $this->form->clearErrors($deep);

        return $this;
    }

    /**
     * @return Traversable<mixed, FormInterface>
     */
    public function getIterator(): Traversable
    {
        return $this->form->getIterator();
    }
}
