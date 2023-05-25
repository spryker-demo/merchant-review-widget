import './merchant-rating-selector.scss';
import register from 'ShopUi/app/registry';
export default register(
    'merchant-rating-selector',
    () =>
        import(
            /* webpackMode: "lazy" */
            /* webpackChunkName: "merchant-rating-selector" */
            './merchant-rating-selector'
        ),
);
