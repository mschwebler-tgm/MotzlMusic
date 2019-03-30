const hexToRgba = function (hex, alpha) {
    let chars;
    if (/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)) {
        chars = hex.substring(1).split('');
        if (chars.length === 3) {
            chars = [chars[0], chars[0], chars[1], chars[1], chars[2], chars[2]];
        }
        chars = '0x' + chars.join('');
        const rgbCode = [(chars >> 16) & 255, (chars >> 8) & 255, chars & 255].join(',');

        return `rgba(${rgbCode},${alpha})`;
    }
    throw new Error('Bad Hex');
};

export {hexToRgba};