<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Yves\MerchantReviewWidget;

use Spryker\Client\Customer\CustomerClientInterface;
use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use SprykerDemo\Service\MerchantReview\MerchantReviewServiceInterface;

/**
 * @method \SprykerDemo\Yves\MerchantReviewWidget\MerchantReviewWidgetConfig getConfig()
 */
class MerchantReviewWidgetDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_CUSTOMER = 'CLIENT_CUSTOMER';

    /**
     * @var string
     */
    public const CLIENT_MERCHANT_REVIEW = 'CLIENT_MERCHANT_REVIEW';

    /**
     * @var string
     */
    public const SERVICE_MERCHANT_REVIEW = 'SERVICE_MERCHANT_REVIEW';

    /**
     * @var string
     */
    public const CLIENT_MERCHANT_REVIEW_SEARCH = 'CLIENT_MERCHANT_REVIEW_SEARCH';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container)
    {
        $container = $this->addCustomerClient($container);
        $container = $this->addMerchantReviewClient($container);
        $container = $this->addMerchantReviewService($container);
        $container = $this->addMerchantReviewSearchClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function addMerchantReviewSearchClient(Container $container): Container
    {
        $container->set(static::CLIENT_MERCHANT_REVIEW_SEARCH, function (Container $container) {
            return $container->getLocator()->merchantReviewSearch()->client();
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addCustomerClient(Container $container)
    {
        $container->set(static::CLIENT_CUSTOMER, function (Container $container): CustomerClientInterface {
            return $container->getLocator()->customer()->client();
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addMerchantReviewClient(Container $container): Container
    {
        $container->set(static::CLIENT_MERCHANT_REVIEW, function (Container $container) {
            return $container->getLocator()->merchantReview()->client();
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addMerchantReviewService(Container $container): Container
    {
        $container->set(static::SERVICE_MERCHANT_REVIEW, function (Container $container): MerchantReviewServiceInterface {
            return $container->getLocator()->merchantReview()->service();
        });

        return $container;
    }
}
