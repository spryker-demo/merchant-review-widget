<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\MerchantReviewWidget;

use Pyz\Client\MerchantReview\MerchantReviewClientInterface;
use Pyz\Client\MerchantReviewStorage\MerchantReviewStorageClientInterface;
use Pyz\Yves\MerchantReview\MerchantReviewFactory as SprykerMerchantReviewFactory;
use Pyz\Yves\MerchantReviewWidget\Form\DataProvider\MerchantReviewFormDataProvider;
use Pyz\Yves\MerchantReviewWidget\Form\MerchantReviewForm;
use Spryker\Client\Customer\CustomerClientInterface;
use Spryker\Shared\Application\ApplicationConstants;

/**
 * @method \Pyz\Yves\MerchantReviewWidget\MerchantReviewWidgetConfig getConfig()
 */
class MerchantReviewWidgetFactory extends SprykerMerchantReviewFactory
{
    /**
     * @return \Spryker\Client\Customer\CustomerClientInterface
     */
    public function getCustomerClient(): CustomerClientInterface
    {
        return $this->getProvidedDependency(MerchantReviewWidgetDependencyProvider::CLIENT_CUSTOMER);
    }

    /**
     * @return \Pyz\Client\MerchantReview\MerchantReviewClientInterface
     */
    public function getMerchantReviewClient(): MerchantReviewClientInterface
    {
        return $this->getProvidedDependency(MerchantReviewWidgetDependencyProvider::CLIENT_MERCHANT_REVIEW);
    }

    /**
     * @return \Pyz\Client\MerchantReviewStorage\MerchantReviewStorageClientInterface
     */
    public function getMerchantReviewStorageClient(): MerchantReviewStorageClientInterface
    {
        return $this->getProvidedDependency(MerchantReviewWidgetDependencyProvider::CLIENT_MERCHANT_REVIEW_STORAGE);
    }

    /**
     * @return \Symfony\Component\Form\FormFactory
     */
    public function getFormFactory()
    {
        return $this->getProvidedDependency(ApplicationConstants::FORM_FACTORY);
    }

    /**
     * @param int $idMerchant
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createMerchantReviewForm($idMerchant)
    {
        $dataProvider = $this->createMerchantReviewFormDataProvider();
        $form = $this->getFormFactory()->create(
            MerchantReviewForm::class,
            $dataProvider->getData($idMerchant),
            $dataProvider->getOptions(),
        );

        return $form;
    }

    /**
     * @return \Pyz\Yves\MerchantReviewWidget\Form\DataProvider\MerchantReviewFormDataProvider
     */
    public function createMerchantReviewFormDataProvider()
    {
        return new MerchantReviewFormDataProvider();
    }
}
