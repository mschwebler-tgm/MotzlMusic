import {starEmpty, starFull, starHalf} from "../../store/modules/myLibrary/helpers/starsSVGs";

export default class StarRating {

    constructor(wrapperElement) {
        this._wrapperElement = wrapperElement;
        this.initMouseMoveListener();
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

    initMouseMoveListener() {
        this._wrapperElement.addEventListener('mousemove', $event => {
            this._handleMouseMove($event);
        })
    }

    _handleMouseMove($event) {
        const starsAmount = this._calculateStarsAmountForMousePosition($event);
        console.log(starsAmount);
    }

    _calculateStarsAmountForMousePosition($event) {
        const starWidth = 24;
        const offsetLeft = $event.pageX - this._wrapperElement.getBoundingClientRect().x;
        const halfStarsAmount = Math.ceil(offsetLeft / (starWidth / 2));

        return halfStarsAmount / 2;
    }
};
