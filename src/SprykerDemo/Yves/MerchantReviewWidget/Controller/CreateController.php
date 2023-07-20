<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Yves\MerchantReviewWidget\Controller;

use Generated\Shared\Transfer\MerchantReviewRequestTransfer;
use SprykerShop\Yves\ShopApplication\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerDemo\Yves\MerchantReviewWidget\MerchantReviewWidgetFactory getFactory()
 */
class CreateController extends AbstractController
{
    /**
     * @deprecated Will be removed without replacement.
     *
     * @var string
     */
    public const ERROR_MESSAGE_NO_CUSTOMER = 'Only customers can use this feature. Please log in.';

    /**
     * @deprecated Will be removed without replacement.
     *
     * @var string
     */
    public const SUCCESS_MESSAGE = 'Review was submitted';

    /**
     * @var string
     */
    public const REQUEST_HEADER_REFERER = 'referer';

    /**
     * @var string
     */
    public const URL_MAIN = '/';

    /**
     * @var string
     */
    protected const GLOSSARY_KEY_SUCCESS_MERCHANT_REVIEW_SUBMITTED = 'merchant_review.submit.success';

    /**
     * @var string
     */
    protected const GLOSSARY_KEY_ERROR_NO_CUSTOMER = 'merchant_review.error.no_customer';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request)
    {
        $this->executeIndexAction($request);

        return $this->redirectResponseExternal($this->getRefererUrl($request));
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return void
     */
    protected function executeIndexAction(Request $request): void
    {
        $idMerchant = $request->attributes->get('idMerchant');
        $form = $this->getFactory()
            ->createMerchantReviewForm($idMerchant)
            ->handleRequest($request);

        if (!$form->isSubmitted()) {
            return;
        }

        $customer = $this->getFactory()->getCustomerClient()->getCustomer();

        if ($customer === null) {
            $this->addErrorMessage(static::GLOSSARY_KEY_ERROR_NO_CUSTOMER);

            return;
        }

        if (!$form->isValid()) {
            /** @var \Symfony\Component\Form\FormError $errorObject */
            foreach ($form->getErrors(true) as $errorObject) {
                $this->addErrorMessage($errorObject->getMessage());
            }

            return;
        }

        $merchantReviewRequestTransfer = $this->getMerchantReviewFormData($form)
            ->setCustomerReference($customer->getCustomerReference())
            ->setLocaleName($this->getLocale());

        $merchantReviewResponseTransfer = $this->getFactory()
            ->getMerchantReviewClient()
            ->submitCustomerReview($merchantReviewRequestTransfer);

        if ($merchantReviewResponseTransfer->getIsSuccess() === false) {
            foreach ($merchantReviewResponseTransfer->getErrors() as $errorTransfer) {
                $message = $errorTransfer->getMessage();
                if (!$message) {
                    continue;
                }
                $this->addErrorMessage($message);
            }

            return;
        }

        $this->addSuccessMessage(static::GLOSSARY_KEY_SUCCESS_MERCHANT_REVIEW_SUBMITTED);
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $form
     *
     * @return \Generated\Shared\Transfer\MerchantReviewRequestTransfer
     */
    protected function getMerchantReviewFormData(FormInterface $form): MerchantReviewRequestTransfer
    {
        return $form->getData();
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return string
     */
    protected function getRefererUrl(Request $request): string
    {
        if ($request->headers->has(static::REQUEST_HEADER_REFERER)) {
            return $request->headers->get(static::REQUEST_HEADER_REFERER) ?? '';
        }

        return static::URL_MAIN;
    }
}
