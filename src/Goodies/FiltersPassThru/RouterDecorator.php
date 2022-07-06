<?php

declare(strict_types=1);

namespace Strictify\Goodies\Goodies\FiltersPassThru;

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\Component\HttpKernel\CacheWarmer\WarmableInterface;

class RouterDecorator implements RouterInterface, WarmableInterface, ServiceSubscriberInterface
{
    /**
     * @param array<string> $passQueryData
     */
    public function __construct(
        private string $keyword,
        private array $passQueryData,
        private RouterInterface $router,
        private RequestStack $requestStack,
    )
    {
    }

    public function setContext(RequestContext $context): void
    {
        $this->router->setContext($context);
    }

    public function getContext(): RequestContext
    {
        return $this->router->getContext();
    }

    public function getRouteCollection(): RouteCollection
    {
        return $this->router->getRouteCollection();
    }

    public function generate(string $name, array $parameters = [], int $referenceType = self::ABSOLUTE_PATH): string
    {
        $keyword = $this->keyword;
        $request = $this->requestStack->getCurrentRequest();
        if (isset($parameters[$keyword]) && $request) {
            $parameters = $this->doProcess($parameters, $request);
            unset($parameters[$keyword]);
        }

        return $this->router->generate($name, $parameters, $referenceType);
    }

    public function match(string $pathinfo): array
    {
        return $this->router->match($pathinfo);
    }

    private function doProcess(array $parameters, Request $request): array
    {
        foreach ($this->passQueryData as $passQueryDatum) {
            /** @var array<string>|null $values */
            $values = $request->query->all($passQueryDatum);
            if ($values) {
                $parameters[$passQueryDatum] = $values;
            }
        }

        return $parameters;
    }

    /** @return array<string> */
    public function warmUp(string $cacheDir): array
    {
        if ($this->router instanceof WarmableInterface) {
            return $this->router->warmUp($cacheDir);
        }

        return [];
    }

    public static function getSubscribedServices(): array
    {
        return Router::getSubscribedServices();
    }
}
