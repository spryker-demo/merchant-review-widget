<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Yves\MerchantReviewWidget\Plugin\Router;

use Spryker\Yves\Router\Plugin\RouteProvider\AbstractRouteProviderPlugin;
use Spryker\Yves\Router\Route\RouteCollection;

class MerchantReviewWidgetRouteProviderPlugin extends AbstractRouteProviderPlugin
{
    /**
     * @deprecated Use {@link \SprykerDemo\Yves\MerchantReviewWidget\Plugin\Router\MerchantReviewWidgetRouteProviderPlugin::ROUTE_NAME_MERCHANT_REVIEW_INDEX} instead.
     *
     * @var string
     */
    protected const ROUTE_MERCHANT_REVIEW_INDEX = 'merchant-review/index';

    /**
     * @var string
     */
    public const ROUTE_NAME_MERCHANT_REVIEW_INDEX = 'merchant-review/index';

    /**
     * @deprecated Use {@link \SprykerDemo\Yves\MerchantReviewWidget\Plugin\Router\MerchantReviewWidgetRouteProviderPlugin::ROUTE_NAME_MERCHANT_REVIEW_CREATE} instead.
     *
     * @var string
     */
    protected const ROUTE_MERCHANT_REVIEW_CREATE = 'merchant-review/create';

    /**
     * @var string
     */
    public const ROUTE_NAME_MERCHANT_REVIEW_CREATE = 'merchant-review/create';

    /**
     * @var string
     */
    protected const ID_MERCHANT_REGEX = '[1-9][0-9]*';

    /**
     * Specification:
     * - Adds Routes to the RouteCollection.
     *
     * @api
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection = $this->addMerchantReviewRoute($routeCollection);
        $routeCollection = $this->addMerchantReviewCreateRoute($routeCollection);

        return $routeCollection;
    }

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addMerchantReviewRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/merchant-review/index/{idMerchant}', 'MerchantReviewWidget', 'Index', 'indexAction');
        $route = $route->setRequirement('idMerchant', static::ID_MERCHANT_REGEX);
        $routeCollection->add(static::ROUTE_NAME_MERCHANT_REVIEW_INDEX, $route);

        return $routeCollection;
    }

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addMerchantReviewCreateRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/merchant-review/create/{idMerchant}', 'MerchantReviewWidget', 'Create', 'indexAction');
        $route = $route->setRequirement('idMerchant', static::ID_MERCHANT_REGEX);
        $routeCollection->add(static::ROUTE_NAME_MERCHANT_REVIEW_CREATE, $route);

        return $routeCollection;
    }
}
