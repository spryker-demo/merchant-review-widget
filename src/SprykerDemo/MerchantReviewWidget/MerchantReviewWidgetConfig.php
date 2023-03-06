<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\MerchantReviewWidget;

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
