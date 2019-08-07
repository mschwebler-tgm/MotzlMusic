import {starEmpty, starFull, starHalf} from "../../store/modules/myLibrary/helpers/starsSVGs";

export default class StarRating {
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
