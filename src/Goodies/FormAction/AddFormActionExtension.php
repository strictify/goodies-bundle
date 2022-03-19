<?php

declare(strict_types=1);

namespace Strictify\Goodies\Goodies\FormAction;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Form\Extension\Core\Type\FormType;

/**
 * Add `action` to all root forms, even embedded ones.
 */
class AddFormActionExtension extends AbstractTypeExtension
{
    public function __construct(
        private RequestStack $requestStack,
    )
    {
    }

    public static function getExtendedTypes(): iterable
    {
        yield FormType::class;
    }

    /**
     * @psalm-suppress MixedArrayAssignment
     */
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $name = $form->getName();
        if ($name === '_token' || !$form->isRoot()) {
            return;
        }

        $currentRequest = $this->requestStack->getCurrentRequest();
        if (!$currentRequest) {
            return;
        }

        $uri = $currentRequest->getRequestUri();

        $view->vars['attr']['action'] ??= $uri;
    }
}
