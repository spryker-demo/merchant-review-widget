<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Yves\MerchantReviewWidget\Controller;

use Generated\Shared\Transfer\MerchantReviewSearchRequestTransfer;
use Generated\Shared\Transfer\RatingAggregationTransfer;
use SprykerDemo\Yves\MerchantReviewWidget\MerchantReviewWidgetConfig;
use SprykerShop\Yves\ShopApplication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerDemo\Yves\MerchantReviewWidget\MerchantReviewWidgetFactory getFactory()
 */
class IndexController extends AbstractController
{
    /**
     * @var string
     */
    protected const PARAM_ID_MERCHANT = 'idMerchant';

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
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Spryker\Yves\Kernel\View\View
     */
    public function indexAction(Request $request)
    {
        $viewData = $this->executeIndexAction($request);

        return $this->view($viewData, [], '@MerchantReviewWidget/views/review-overview/review-overview.twig');
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array<string, mixed>
     */
    protected function executeIndexAction(Request $request): array
    {
        $idMerchant = $request->attributes->get(static::PARAM_ID_MERCHANT);
        $parentRequest = $this->resolveParentRequest();

        $customer = $this->getFactory()->getCustomerClient()->getCustomer();
        $hasCustomer = $customer !== null;

        $merchantReviewSearchRequestTransfer = new MerchantReviewSearchRequestTransfer();
        $merchantReviewSearchRequestTransfer->setIdMerchant($idMerchant);

        if ($parentRequest) {
            $merchantReviewSearchRequestTransfer->setRequestParams($parentRequest->query->all());
        }

        $merchantReviews = $this->getFactory()
            ->getMerchantReviewSearchClient()
            ->search($merchantReviewSearchRequestTransfer);
        $ratingAggregationTransfer = (new RatingAggregationTransfer());
        $ratingAggregationTransfer->setRatingAggregation($merchantReviews['ratingAggregation']);

        return [
            static::PARAM_HAS_CUSTOMER => $hasCustomer,
            static::PARAM_MERCHANT_REVIEWS => $merchantReviews['merchantReviews'],
            static::PARAM_PAGINATION => $merchantReviews['pagination'],
            static::PARAM_SUMMARY => $this->getFactory()
                ->getMerchantReviewService()
                ->calculateMerchantReviewSummary($ratingAggregationTransfer),
            static::PARAM_MAXIMUM_RATING => MerchantReviewWidgetConfig::MERCHANT_REVIEW_MAXIMUM_RATING,
        ];
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request|null
     */
    protected function resolveParentRequest(): ?Request
    {
        return $this->getRequestStack()->getParentRequest();
    }
}
