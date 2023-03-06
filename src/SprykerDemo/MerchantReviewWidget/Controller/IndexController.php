<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\MerchantReviewWidget\Controller;

use Generated\Shared\Transfer\MerchantReviewSearchRequestTransfer;
use Generated\Shared\Transfer\RatingAggregationTransfer;
use Spryker\Shared\Storage\StorageConstants;
use SprykerShop\Yves\ShopApplication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Yves\MerchantReviewWidget\MerchantReviewWidgetFactory getFactory()
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
        $parentRequest = $this->getParentRequest();
        $idMerchant = $request->attributes->get('idMerchant');

        $customer = $this->getFactory()->getCustomerClient()->getCustomer();
        $hasCustomer = $customer !== null;

        $merchantReviewSearchRequestTransfer = new MerchantReviewSearchRequestTransfer();
        $merchantReviewSearchRequestTransfer->setIdMerchant($idMerchant);
        $merchantReviewSearchRequestTransfer->setRequestParams($parentRequest->query->all());
        $merchantReviews = $this->getFactory()
            ->getMerchantReviewClient()
            ->findMerchantReviewsInSearch($merchantReviewSearchRequestTransfer);

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

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function getParentRequest()
    {
        return $this->getRequestStack()->getParentRequest();
    }
}
