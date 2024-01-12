<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Yves\MerchantReviewWidget;

use Spryker\Yves\Kernel\AbstractBundleConfig;

class MerchantReviewWidgetConfig extends AbstractBundleConfig
{
    /**
     * @var int
     *
     * @uses \SprykerDemo\Shared\MerchantReview\MerchantReviewConfig::MERCHANT_REVIEW_MAXIMUM_RATING
     */
    public const MERCHANT_REVIEW_MAXIMUM_RATING = 5;

    /**
     * @var int
     *
     * @uses \SprykerDemo\Shared\MerchantReview\MerchantReviewConfig::MERCHANT_REVIEW_MINIMUM_RATING
     */
    public const MERCHANT_REVIEW_MINIMUM_RATING = 1;
}
