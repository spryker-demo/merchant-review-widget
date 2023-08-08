<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Yves\MerchantReviewWidget\Widget;

use Generated\Shared\Transfer\MerchantReviewSearchRequestTransfer;
use Generated\Shared\Transfer\RatingAggregationTransfer;
use Spryker\Yves\Kernel\Widget\AbstractWidget;
use SprykerDemo\Yves\MerchantReviewWidget\MerchantReviewWidgetConfig;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @method \SprykerDemo\Yves\MerchantReviewWidget\MerchantReviewWidgetFactory getFactory()
 */
class MerchantReviewWidget extends AbstractWidget
{
    /**
     * @var string
     */
    protected const PARAM_ID_MERCHANT = 'idMerchant';

    /**
     * @var string
     */
    protected const PARAM_FORM = 'form';

    /**
     * @var string
     */
    protected const PARAM_HIDE_FORM = 'hideForm';

    /**
     * @var string
     */
    protected const PARAM_HAS_CUSTOMER = 'hasCustomer';

    /**
     * @var string
     */
    protected const PARAM_MERCHANT_REVIEWS = 'merchantReviews';

    /**
     * @var string
     */
    protected const PARAM_PAGINATION = 'pagination';

    /**
     * @var string
     */
    protected const PARAM_SUMMARY = 'summary';

    /**
     * @var string
     */
    protected const PARAM_MAXIMUM_RATING = 'maximumRating';

    /**
     * @param int $idMerchant
     */
    public function __construct(int $idMerchant)
    {
        $form = $this->getMerchantReviewForm($idMerchant);
        $merchantReviews = $this->findMerchantReviews($idMerchant, $this->getCurrentRequest());
        $ratingAggregationTransfer = (new RatingAggregationTransfer());
        $ratingAggregationTransfer->setRatingAggregation($merchantReviews['ratingAggregation']);
        $this->addParameter(static::PARAM_ID_MERCHANT, $idMerchant)
            ->addParameter(static::PARAM_MAXIMUM_RATING, MerchantReviewWidgetConfig::MERCHANT_REVIEW_MAXIMUM_RATING)
            ->addParameter(static::PARAM_FORM, $form->createView())
            ->addParameter(static::PARAM_HIDE_FORM, !$form->isSubmitted())
            ->addParameter(static::PARAM_HAS_CUSTOMER, $this->hasCustomer())
            ->addParameter(static::PARAM_MERCHANT_REVIEWS, $merchantReviews['merchantReviews'] ?? [])
            ->addParameter(static::PARAM_PAGINATION, $merchantReviews['pagination'])
            ->addParameter(
                static::PARAM_SUMMARY,
                $this->getFactory()
                    ->getMerchantReviewService()
                    ->calculateMerchantReviewSummary($ratingAggregationTransfer),
            );
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
     * @return \Symfony\Component\HttpFoundation\Request|null
     */
    protected function getCurrentRequest(): ?Request
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

    /**
     * @param int $idMerchant
     * @param \Symfony\Component\HttpFoundation\Request $parentRequest
     *
     * @return array
     */
    protected function findMerchantReviews(int $idMerchant, Request $parentRequest): array
    {
        $merchantReviewSearchRequestTransfer = new MerchantReviewSearchRequestTransfer();
        $merchantReviewSearchRequestTransfer->setIdMerchant($idMerchant);
        $merchantReviewSearchRequestTransfer->setRequestParams($parentRequest->query->all());

        return $this->getFactory()
            ->getMerchantReviewSearchClient()
            ->search($merchantReviewSearchRequestTransfer);
    }
}
