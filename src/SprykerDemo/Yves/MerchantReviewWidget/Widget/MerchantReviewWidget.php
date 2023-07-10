<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Yves\MerchantReviewWidget\Widget;

use Generated\Shared\Transfer\MerchantReviewSearchRequestTransfer;
use Generated\Shared\Transfer\MerchantReviewStorageTransfer;
use Generated\Shared\Transfer\PaginationTransfer;
use Generated\Shared\Transfer\RatingAggregationTransfer;
use Spryker\Yves\Kernel\Widget\AbstractWidget;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @method \SprykerDemo\Yves\MerchantReviewWidget\MerchantReviewWidgetFactory getFactory()
 */
class MerchantReviewWidget extends AbstractWidget
{
    /**
     * @param int $idMerchant
     */
    public function __construct(int $idMerchant)
    {
        $form = $this->getMerchantReviewForm($idMerchant);
        $merchantReviews = [];

        $ratingAggregationTransfer = (new RatingAggregationTransfer());
        $ratingAggregationTransfer->setRatingAggregation($merchantReviews['ratingAggregation'] ?? null);

        $this->addParameter('idMerchant', $idMerchant)
            ->addParameter('maximumRating', $this->getMaximumRating())
            ->addParameter('form', $form->createView())
            ->addParameter('hideForm', !$form->isSubmitted())
            ->addParameter('hasCustomer', $this->hasCustomer())
            ->addParameter('merchantReviews', $merchantReviews['merchantReviews'] ?? [])
            ->addParameter(
                'summary',
                $this->getFactory()
                    ->getMerchantReviewService()
                    ->calculateMerchantReviewSummary($ratingAggregationTransfer),
            )
            ->addParameter('maximumRating', $this->getFactory()->getMerchantReviewClient()->getMaximumRating());
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'MerchantReviewWidget';
    }

    /**
     * @return string
     */
    public static function getTemplate(): string
    {
        return '@MerchantReviewWidget/views/merchant-review-widget/merchant-review-widget.twig';
    }

    /**
     * @return int
     */
    protected function getMaximumRating(): int
    {
        return $this->getFactory()
            ->getMerchantReviewClient()
            ->getMaximumRating();
    }

    /**
     * @param int $idMerchant
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function getMerchantReviewForm(int $idMerchant): FormInterface
    {
        $request = $this->getCurrentRequest();

        return $this->getFactory()
            ->createMerchantReviewForm($idMerchant)
            ->handleRequest($request);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function getCurrentRequest(): Request
    {
        return $this->getRequestStack()->getCurrentRequest();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RequestStack
     */
    protected function getRequestStack(): RequestStack
    {
        return $this->getGlobalContainer()->get('request_stack');
    }

    /**
     * @return bool
     */
    protected function hasCustomer(): bool
    {
        $customer = $this->getFactory()->getCustomerClient()->getCustomer();

        return $customer !== null;
    }

    protected function findMerchantReviews($idMerchant)
    {
        return $this->getFactory()
            ->getMerchantReviewStorageClient()
            ->findMerchantReviews($idMerchant);
    }
}
