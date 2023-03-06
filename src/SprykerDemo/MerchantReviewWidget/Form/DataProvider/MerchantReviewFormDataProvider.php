<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\MerchantReviewWidget\Form\DataProvider;

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
