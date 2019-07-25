// import colors from "vuetify/es5/util/colors";

const theme = {
    dark: true,
    themes: {
        dark: {
            primary: '#42A4F5',
            secondary: '#92D050',
            accent: '#1D69A8',
            success: '#92D050',
            warning: '#A3A825',
            error: '#F7615B'
        },
        light: {
            primary: '#42A4F5',
            secondary: '#92D050',
            accent: '#1D69A8',
            success: '#92D050',
            warning: '#A3A825',
            error: '#F7615B'
        },
    },
    options: {
        customProperties: true,  // generate css variables
    },
};


const setSystemBarColor = function (color) {
    color = color ? theme.themes[theme.dark ? 'dark' : 'light'][color] : theme.themes.dark.primary;

    const appendMetaTag = function (name, color) {
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
