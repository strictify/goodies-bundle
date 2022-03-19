<?php

declare(strict_types=1);

namespace Strictify\Goodies\Goodies\StreamBuilder;

use Strictify\Goodies\Goodies\StreamBuilder\Model\AbstractStream;

class SetAttributeStream extends AbstractStream
{
    public function __construct(
        string                  $targetId,
        private string          $name,
        private null|string|int $value = null,
    )
    {
        parent::__construct($targetId);
    }

    protected function getAction(): string
    {
        return 'append';
    }

    protected function getHtml(): string
    {
        if (null === $this->value) {
            return $this->removeAttribute();
        }

        return $this->setAttribute();
    }

    private function setAttribute(): string
    {
        $name = $this->name;
        $value = $this->value;
        $id = $this->getTargetId();

        return <<<HTML
        <meta data-controller="set-attribute" data-set-attribute-id-value="$id" data-set-attribute-name-value="$name" data-set-attribute-value-value="$value">
HTML;
    }

    private function removeAttribute(): string
    {
        $name = $this->name;
        $id = $this->getTargetId();

        return <<<HTML
        <meta data-controller="remove-attribute" data-remove-attribute-id-value="$id" data-remove-attribute-name-value="$name" >
HTML;
    }
}
