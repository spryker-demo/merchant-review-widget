import Component from 'ShopUi/models/component';
import { EVENT_UPDATE_REVIEW_COUNT } from 'src/ShopUi/components/molecules/product-item/product-item';
import ProductItem, { EVENT_UPDATE_RATING } from 'ShopUi/components/molecules/product-item/product-item';

export default class MerchantRatingSelector extends Component {
    /**
     * The input element.
     */
    input: HTMLInputElement;

    /**
     * Collection of the elements which toggle the steps of the product review.
     */
    steps: HTMLElement[];
    protected productItem: ProductItem;
    protected reviewCount: HTMLElement;

    protected init(): void {
        this.reviewCount = this.getElementsByClassName(`${this.jsName}__review-count`)[0] as HTMLElement;

        super.init();
    }

    protected readyCallback(): void {
        this.input = this.getElementsByClassName(`${this.jsName}__input`)[0] as HTMLInputElement;
        this.steps = Array.from(this.getElementsByClassName(`${this.jsName}__step`)) as HTMLElement[];
        if (this.productItemClassName) {
            this.productItem = this.closest(`.${this.productItemClassName}`) as ProductItem;
        }

        if (!this.readOnly) {
            this.checkInput(this.value);
            this.mapEvents();
        }

        this.mapUpdateRatingEvents();
    }

    protected mapEvents(): void {
        this.mapStepClickEvent();
    }

    protected mapStepClickEvent() {
        this.steps.forEach((step: HTMLElement) => {
            step.addEventListener('click', (event: Event) => this.onStepClick(event));
        });
    }

    protected mapUpdateRatingEvents(): void {
        if (!this.productItem) {
            return;
        }

        this.mapProductItemUpdateRatingCustomEvent();
        this.mapProductItemUpdateReviewCountCustomEvent();
    }

    protected mapProductItemUpdateReviewCountCustomEvent() {
        if (!this.productItem) {
            return;
        }

        this.productItem.addEventListener(EVENT_UPDATE_REVIEW_COUNT, (event: Event) => {
            this.updateReviewCount((event as CustomEvent).detail.reviewCount);
        });
    }

    protected updateReviewCount(value: number): void {
        if (this.reviewCount) {
            this.reviewCount.innerText = `(${value})`;
        }
    }

    protected mapProductItemUpdateRatingCustomEvent() {
        this.productItem.addEventListener(EVENT_UPDATE_RATING, (event: Event) => {
            this.updateRating((event as CustomEvent).detail.rating);
        });
    }

    protected onStepClick(event: Event): void {
        const step = event.currentTarget as HTMLElement;
        const newValue = parseFloat(step.getAttribute('data-step-value'));

        this.checkInput(newValue);
        this.updateRating(newValue);
    }

    /**
     * Toggles the disabled attribute of the input element.
     * @param value A number for checking if the attribute is to be set or removed from the input element.
     */
    checkInput(value: number): void {
        if (!this.disableIfEmptyValue) {
            return;
        }

        if (!value) {
            this.input.setAttribute('disabled', 'disabled');

            return;
        }

        this.input.removeAttribute('disabled');
    }

    /**
     * Sets the value attribute and toggles the special class name.
     * @param value A number for setting the attribute.
     */
    updateRating(value: number): void {
        this.input.setAttribute('value', `${value}`);

        this.steps.forEach((step: HTMLElement) => {
            const stepValue = parseFloat(step.getAttribute('data-step-value'));

            if (value >= stepValue) {
                step.classList.add(`${this.name}__step--active`);

                return;
            }

            step.classList.remove(`${this.name}__step--active`);
        });
    }

    /**
     * Gets an input value.
     */
    get value(): number {
        return parseFloat(this.input.value);
    }

    /**
     * Gets if the element is read-only.
     */
    get readOnly(): boolean {
        return this.hasAttribute('readonly');
    }

    /**
     * Gets if the element has an empty value.
     */
    get disableIfEmptyValue(): boolean {
        return this.hasAttribute('disable-if-empty-value');
    }

    protected get productItemClassName(): string {
        return this.getAttribute('product-item-class-name');
    }
}
