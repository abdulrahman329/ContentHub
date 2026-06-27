import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { toggleLike } from './features/toggleLike';
import { toggleEdit } from './features/comments';
import { toggleReply } from './features/comments';


window.toggleReply = toggleReply;
window.toggleLike = toggleLike;
window.toggleEdit = toggleEdit;

import './features/theme';

// Check saved theme or system preference
if (
    localStorage.theme === 'dark' ||
    (!('theme' in localStorage) &&
        window.matchMedia('(prefers-color-scheme: dark)').matches)
) {
    document.documentElement.classList.add('dark');
} else {
    document.documentElement.classList.remove('dark');
}

// Update button text and icon
function updateThemeButton() {
    const isDark = document.documentElement.classList.contains('dark');

    const themeIcon = document.getElementById('themeIcon');
    const themeText = document.getElementById('themeText');

    if (themeIcon && themeText) {
        themeIcon.textContent = isDark ? '🌙' : '☀️';
        themeText.textContent = isDark ? 'Dark' : 'Light';
    }
}

// Toggle dark mode
window.toggleDarkMode = function () {
    if (document.documentElement.classList.contains('dark')) {
        document.documentElement.classList.remove('dark');
        localStorage.theme = 'light';
    } else {
        document.documentElement.classList.add('dark');
        localStorage.theme = 'dark';
    }

    updateThemeButton();
};

// Initialize button state on page load
document.addEventListener('DOMContentLoaded', () => {
    updateThemeButton();
});

