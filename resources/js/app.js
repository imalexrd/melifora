import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Dark mode switcher
const themeSwitcher = {
    init() {
        this.isDark = localStorage.getItem('darkMode') === 'true';
        this.applyTheme();

        window.addEventListener('dark-mode-toggled', () => {
            this.isDark = localStorage.getItem('darkMode') === 'true';
            this.applyTheme();
        });
    },
    isDark: false,
    applyTheme() {
        if (this.isDark) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    },
    toggle() {
        this.isDark = !this.isDark;
        localStorage.setItem('darkMode', this.isDark);
        this.applyTheme();
        window.dispatchEvent(new CustomEvent('dark-mode-toggled'));
    }
};

window.themeSwitcher = themeSwitcher;

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        var calendar = new Calendar(calendarEl, {
            plugins: [ dayGridPlugin ],
            initialView: 'dayGridMonth'
        });
        calendar.render();
    }
});
