<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Yves\MerchantReviewWidget\Form;

use Generated\Shared\Transfer\MerchantReviewRequestTransfer;
use Spryker\Yves\Kernel\Form\AbstractType;
use SprykerDemo\Yves\MerchantReviewWidget\MerchantReviewWidgetConfig;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

/**
 * @method \SprykerDemo\Yves\MerchantReviewWidget\MerchantReviewWidgetFactory getFactory()
 * @method \SprykerDemo\Yves\MerchantReviewWidget\MerchantReviewWidgetConfig getConfig()
 */
class MerchantReviewForm extends AbstractType
{
    /**
     * @var int
     */
    protected const UNSELECTED_RATING = -1;

    /**
     * @var string
     */
    protected const GLOSSARY_KEY_NOT_BLANC_NICKNAME_RATING_VALIDATION_MESSAGE = 'merchant_review.error.no_blank_nickname';

    /**
     * @var string
     */
    protected const GLOSSARY_KEY_NOT_BLANC_SUMMARY_RATING_VALIDATION_MESSAGE = 'merchant_review.error.no_blank_summary';

    /**
     * @var string
     */
    protected const GLOSSARY_KEY_NOT_BLANC_DESCRIPTION_RATING_VALIDATION_MESSAGE = 'merchant_review.error.no_blank_description';

    /**
     * @var string
     */
    protected const VALIDATION_RATING_MESSAGE = 'validation.choice';

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'merchantReviewForm';
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return $this
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addRatingField($builder)
            ->addNicknameField($builder)
            ->addSummaryField($builder)
            ->addDescriptionField($builder)
            ->addMerchantField($builder);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addRatingField(FormBuilderInterface $builder)
    {
        $builder->add(
            MerchantReviewRequestTransfer::RATING,
            ChoiceType::class,
            [
                'choices' => array_flip($this->getRatingFieldChoices()),
                'label' => 'merchant_review.submit.rating',
                'required' => true,
                'expanded' => false,
                'multiple' => false,
                'constraints' => [
                    new Range(['min' => MerchantReviewWidgetConfig::MERCHANT_REVIEW_MINIMUM_RATING, 'max' => MerchantReviewWidgetConfig::MERCHANT_REVIEW_MAXIMUM_RATING]),
                ],
                'invalid_message' => $this->getConfig()->getInvalidRatingValidationMessageGlossaryKey(),
            ],
        );

        return $this;
    }

    /**
     * Returns a sequence between predefined minimum and maximum as an array with a leading "unselected" element
     * - keys match values
     *
     * @see MerchantReviewForm::UNSELECTED_RATING
     * @see MerchantReviewWidgetConfig::MERCHANT_REVIEW_MINIMUM_RATING
     * @see MerchantReviewWidgetConfig::MERCHANT_REVIEW_MAXIMUM_RATING
     *
     * Example
     *  [-1 => 'none', 1 => 1, 2 => 2]
     *
     * @return array<int, mixed>
     */
    protected function getRatingFieldChoices(): array
    {
        $choiceKeys = $choiceValues = range(MerchantReviewWidgetConfig::MERCHANT_REVIEW_MINIMUM_RATING, MerchantReviewWidgetConfig::MERCHANT_REVIEW_MAXIMUM_RATING);
        array_unshift($choiceKeys, static::UNSELECTED_RATING);
        array_unshift($choiceValues, 'merchant_review.submit.rating.none');

        return array_combine($choiceKeys, $choiceValues);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addSummaryField(FormBuilderInterface $builder)
    {
        $builder->add(
            MerchantReviewRequestTransfer::SUMMARY,
            TextType::class,
            [
                'label' => 'merchant_review.submit.summary',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => static::GLOSSARY_KEY_NOT_BLANC_SUMMARY_RATING_VALIDATION_MESSAGE]),
                    new Length(['min' => 1, 'max' => 255]),
                ],
            ],
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addDescriptionField(FormBuilderInterface $builder)
    {
        $builder->add(
            MerchantReviewRequestTransfer::DESCRIPTION,
            TextareaType::class,
            [
                'label' => 'merchant_review.submit.description',
                'attr' => [
                    'rows' => 5,
                ],
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => static::GLOSSARY_KEY_NOT_BLANC_DESCRIPTION_RATING_VALIDATION_MESSAGE]),
                    new Length(['min' => 1, 'max' => 1000]),
                ],
            ],
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addNicknameField(FormBuilderInterface $builder)
    {
        $builder->add(
            MerchantReviewRequestTransfer::NICKNAME,
            TextType::class,
            [
                'label' => 'merchant_review.submit.nickname',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => static::GLOSSARY_KEY_NOT_BLANC_NICKNAME_RATING_VALIDATION_MESSAGE]),
                    new Length(['min' => 1, 'max' => 255]),
                ],
            ],
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addMerchantField(FormBuilderInterface $builder)
    {
        $builder->add(
            MerchantReviewRequestTransfer::ID_MERCHANT,
            HiddenType::class,
            [
                'required' => true,
            ],
        );

        return $this;
    }
}
