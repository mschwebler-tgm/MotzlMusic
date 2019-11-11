import {starEmpty, starFull, starHalf} from "./starsSVGs";

export default class StarRating {

    constructor(wrapperElement) {
        this._wrapperElement = wrapperElement;
        this._wrapperElementOffsetX = wrapperElement.getBoundingClientRect().x;
        this._previousStarsAmount = null;
        this._onRateCallback = () => console.warn('[warning] no callback for star rating input defined');
        this._onRateHoverCallback = () => console.warn('[warning] no callback for star rating hover defined');
        this.initMouseEventListeners();
    }

    initMouseEventListeners() {
        this._wrapperElement.addEventListener('mousemove', $event => {
            this._handleMouseMove($event);
        });
        this._wrapperElement.addEventListener('click', () => this._handleMouseClick());
    }

    _handleMouseMove($event) {
        const starsAmount = this._calculateStarsAmountForMousePosition($event);
        if (starsAmount !== this._previousStarsAmount) {
            this._previousStarsAmount = starsAmount;
            this._onRateHoverCallback(starsAmount);
        }
    }

    _calculateStarsAmountForMousePosition($event) {
        const starWidth = 24;
        const offsetLeft = $event.pageX - this._wrapperElementOffsetX;
        const halfStarsAmount = Math.ceil((offsetLeft - 2) / (starWidth / 2));  // -2px for usability reasons

        return Math.min(halfStarsAmount / 2, 5);
    }

    _handleMouseClick() {
        this._onRateCallback(this._previousStarsAmount);
    }

    onRateHover(callback) {
        this._onRateHoverCallback = callback;
    }

    onRate(callback) {
        this._onRateCallback = callback;
    }

    static getStarSVGs(amount, fillWithEmptyStars = false) {
        const stars = [];
        for (let i = 0; i < Math.floor(amount); i++) {
            stars.push(starFull);
        }
        if (amount % 1 === 0.5) {
            stars.push(starHalf);
        }
        if (fillWithEmptyStars) {
            const remainingStars = 5 - stars.length;
            for (let i = 0; i < remainingStars; i++) {
                stars.push(starEmpty);
            }
        }

        return stars;
    }
};
