import {starFull, starHalf} from "../../store/modules/myLibrary/helpers/starsSVGs";

export default class StarRating {
    static getStarSVGs(amount) {
        const stars = [];
        for (let i = 0; i < Math.floor(amount); i++) {
            stars.push(starFull);
        }
        if (amount % 1 === 0.5) {
            stars.push(starHalf);
        }

        return stars;
    }
};
