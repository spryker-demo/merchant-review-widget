<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Yves\MerchantReviewWidget;

use Spryker\Client\Customer\CustomerClientInterface;
use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Yves\Kernel\AbstractFactory;
use SprykerDemo\Client\MerchantReview\MerchantReviewClientInterface;
use SprykerDemo\Client\MerchantReviewStorage\MerchantReviewStorageClientInterface;
use SprykerDemo\Service\MerchantReview\MerchantReviewServiceInterface;
use SprykerDemo\Yves\MerchantReviewWidget\Form\DataProvider\MerchantReviewFormDataProvider;
use SprykerDemo\Yves\MerchantReviewWidget\Form\MerchantReviewForm;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;

/**
 * @method \SprykerDemo\Yves\MerchantReviewWidget\MerchantReviewWidgetConfig getConfig()
 */
class MerchantReviewWidgetFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Client\Customer\CustomerClientInterface
     */
    public function getCustomerClient(): CustomerClientInterface
    {
        return $this->getProvidedDependency(MerchantReviewWidgetDependencyProvider::CLIENT_CUSTOMER);
    }

    /**
     * @return \SprykerDemo\Client\MerchantReview\MerchantReviewClientInterface
     */
    public function getMerchantReviewClient(): MerchantReviewClientInterface
    {
        return $this->getProvidedDependency(MerchantReviewWidgetDependencyProvider::CLIENT_MERCHANT_REVIEW);
    }

    /**
     * @return \SprykerDemo\Client\MerchantReviewStorage\MerchantReviewStorageClientInterface
     */
    public function getMerchantReviewStorageClient(): MerchantReviewStorageClientInterface
    {
        return $this->getProvidedDependency(MerchantReviewWidgetDependencyProvider::CLIENT_MERCHANT_REVIEW_STORAGE);
    }

    /**
     * @return \Symfony\Component\Form\FormFactory
     */
    public function getFormFactory(): FormFactory
    {
        return $this->getProvidedDependency(ApplicationConstants::FORM_FACTORY);
    }

    /**
     * @param int $idMerchant
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createMerchantReviewForm(int $idMerchant): FormInterface
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
     * @return \SprykerDemo\Yves\MerchantReviewWidget\Form\DataProvider\MerchantReviewFormDataProvider
     */
    public function createMerchantReviewFormDataProvider(): MerchantReviewFormDataProvider
    {
        return new MerchantReviewFormDataProvider();
    }

    /**
     * @return \SprykerDemo\Service\MerchantReview\MerchantReviewServiceInterface
     */
    public function getMerchantReviewService(): MerchantReviewServiceInterface
    {
        return $this->getProvidedDependency(MerchantReviewWidgetDependencyProvider::SERVICE_MERCHANT_REVIEW);
    }
}
