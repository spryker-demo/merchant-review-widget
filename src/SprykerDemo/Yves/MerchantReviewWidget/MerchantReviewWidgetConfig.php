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
     * @var string
     */
    public const GLOSSARY_KEY_INVALID_RATING_VALIDATION_MESSAGE = 'merchant_review.error.invalid_rating';

    /**
     * @api
     *
     * @return string
     */
    public function getInvalidRatingValidationMessageGlossaryKey(): string
    {
        return static::GLOSSARY_KEY_INVALID_RATING_VALIDATION_MESSAGE;
    }
}
