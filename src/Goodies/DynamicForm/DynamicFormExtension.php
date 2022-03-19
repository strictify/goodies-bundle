<?php

declare(strict_types=1);

namespace Strictify\Goodies\Goodies\DynamicForm;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FormType;

class DynamicFormExtension extends AbstractTypeExtension
{
    public static function getExtendedTypes(): iterable
    {
        yield FormType::class;
    }

    /**
     * @param array{dynamic: bool} $options
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     * @psalm-suppress MixedArrayAssignment
     */
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $isDynamic = $options['dynamic'];
        if (!$isDynamic) {
            return;
        }
        $view->vars['row_attr']['data-controller'] = 'dynamic-field';
        $view->vars['attr']['data-action'] = 'change->dynamic-field#onChange';
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'dynamic' => false,
        ]);

        $resolver->setAllowedTypes('dynamic', 'bool');
    }
}
