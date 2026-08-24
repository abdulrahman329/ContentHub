window.theme = function () {
    return {
        isDark: true,

        init() {
            this.isDark = localStorage.getItem('theme')
                ? localStorage.getItem('theme') === 'dark'
                : true;

            this.apply();
        },

        toggleTheme() {
            this.isDark = !this.isDark;

            localStorage.setItem(
                'theme',
                this.isDark ? 'dark' : 'light'
            );

            this.apply();
        },

        apply() {
            document.documentElement.classList.toggle(
                'dark',
                this.isDark
            );
        }
    };
};