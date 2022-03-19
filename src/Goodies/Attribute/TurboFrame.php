<?php

declare(strict_types=1);

namespace Strictify\Goodies\Goodies\Attribute;

use Attribute;
use Strictify\Goodies\Goodies\AttributeValueResolver\TurboFrameValueResolver;

/**
 * @see TurboFrameValueResolver::resolve()
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
class TurboFrame
{
}
