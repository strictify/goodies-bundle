<?php

declare(strict_types=1);

namespace Strictify\Goodies\Goodies\AttributeValueResolver;

use Override;
use Symfony\Component\HttpFoundation\Request;
use Strictify\Goodies\Goodies\Attribute\TurboFrame;
use Strictify\Goodies\Exception\TurboFrameException;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;

class TurboFrameValueResolver implements ValueResolverInterface
{
    #[Override]
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (!$this->getAttribute($argument)) {
            return [];
        }
        $frameId = $request->headers->get('Turbo-Frame');
        if ($frameId === null && !$argument->isNullable()) {
            throw new TurboFrameException();
        }

        yield $frameId;
    }


    private function getAttribute(ArgumentMetadata $argument): TurboFrame|null
    {
        $attributes = $argument->getAttributes(TurboFrame::class, ArgumentMetadata::IS_INSTANCEOF);
        $first = $attributes[0] ?? null;

        return $first instanceof TurboFrame ? $first : null;
    }
}
