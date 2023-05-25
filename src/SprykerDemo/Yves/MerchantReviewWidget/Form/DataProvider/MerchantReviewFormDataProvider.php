<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Yves\MerchantReviewWidget\Form\DataProvider;

use Generated\Shared\Transfer\MerchantReviewRequestTransfer;

class MerchantReviewFormDataProvider
{
    /**
     * @param int $idMerchant
     *
     * @return \Generated\Shared\Transfer\MerchantReviewRequestTransfer
     */
    public function getData($idMerchant)
    {
        $merchantReviewTransfer = new MerchantReviewRequestTransfer();
        $merchantReviewTransfer->setIdMerchant($idMerchant);

        return $merchantReviewTransfer;
    }

    /**
     * @return array<string, mixed>
     */
    public function getOptions()
    {
        return [
            'data_class' => MerchantReviewRequestTransfer::class,
        ];
    }
}
