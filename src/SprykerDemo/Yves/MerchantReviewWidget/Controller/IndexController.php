<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Yves\MerchantReviewWidget\Controller;

use Generated\Shared\Transfer\MerchantReviewSearchRequestTransfer;
use Generated\Shared\Transfer\RatingAggregationTransfer;
use Spryker\Shared\Storage\StorageConstants;
use SprykerShop\Yves\ShopApplication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerDemo\Yves\MerchantReviewWidget\MerchantReviewWidgetFactory getFactory()
 */
class IndexController extends AbstractController
{
    public const STORAGE_CACHE_STRATEGY = StorageConstants::STORAGE_CACHE_STRATEGY_INACTIVE;

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
     * @return array
     */
    protected function executeIndexAction(Request $request): array
    {
        $idMerchant = $request->attributes->get('idMerchant');

        $customer = $this->getFactory()->getCustomerClient()->getCustomer();
        $hasCustomer = $customer !== null;

        $merchantReviewSearchRequestTransfer = new MerchantReviewSearchRequestTransfer();
        $merchantReviewSearchRequestTransfer->setSearchString($idMerchant);
        $merchantReviewSearchRequestTransfer->setRequestParameters($request->query->all());

        $merchantReviews = $this->getFactory()
            ->getMerchantReviewSearchClient()
            ->search($merchantReviewSearchRequestTransfer);

        $ratingAggregationTransfer = (new RatingAggregationTransfer());
        $ratingAggregationTransfer->setRatingAggregation($merchantReviews['ratingAggregation']);

        return [
            'hasCustomer' => $hasCustomer,
            'merchantReviews' => $merchantReviews['merchantReviews'],
            'pagination' => $merchantReviews['pagination'],
            'summary' => $this->getFactory()
                ->getMerchantReviewClient()
                ->calculateMerchantReviewSummary($ratingAggregationTransfer),
            'maximumRating' => $this->getFactory()->getMerchantReviewClient()->getMaximumRating(),
        ];
    }
}
