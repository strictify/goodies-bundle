<?php

declare(strict_types=1);

namespace Strictify\Goodies\Goodies\AttributeValueResolver;

use RuntimeException;
use Symfony\UX\Turbo\TurboBundle;
use Symfony\Component\HttpFoundation\Request;
use Strictify\Goodies\Goodies\Attribute\TurboFrame;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;

class TurboFrameValueResolver implements ArgumentValueResolverInterface
{
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        $attributes = $argument->getAttributes(TurboFrame::class, ArgumentMetadata::IS_INSTANCEOF);
        $first = $attributes[0] ?? null;

        return $first instanceof TurboFrame;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $frameId = $request->headers->get('Turbo-Frame');
        if (!$frameId && !$argument->isNullable()) {
            throw new RuntimeException('Turbo-frame not found.');
        }
        yield $frameId;
    }
}
