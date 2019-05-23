import colors from "vuetify/es5/util/colors";

const theme = {
    primary: colors.blue.lighten1,
    secondary: colors.lime.base,
    accent: colors.blue.accent2,
};

const setSystemBarColor = function (color) {
    color = color ? theme[color] : theme.primary;

    const appendMetaTag = function(name, color) {
        const meta = document.createElement('meta');
        meta.name = name;
        meta.content = color;
        document.getElementsByTagName('head')[0].appendChild(meta);
    };

    appendMetaTag('theme-color', color);
    appendMetaTag('msapplication-navbutton-color', color);
    appendMetaTag('apple-mobile-web-app-status-bar-style', color);
};

export {setSystemBarColor};
export default theme;
