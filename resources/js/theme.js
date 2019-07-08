// import colors from "vuetify/es5/util/colors";

const theme = {
    primary: '#42A4F5',
    secondary: '#92D050',
    accent: '#1D69A8',
    success: '#92D050',
    warning: '#A3A825',
    error: '#F7615B'
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
