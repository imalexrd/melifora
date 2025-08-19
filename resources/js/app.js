import './bootstrap';

import Alpine from 'alpinejs';

// Dark mode switcher
Alpine.data('themeSwitcher', () => ({
    isDark: false,
    init() {
        this.isDark = localStorage.getItem('darkMode') === 'true';
        this.applyTheme();

        window.addEventListener('dark-mode-toggled', () => {
            this.isDark = localStorage.getItem('darkMode') === 'true';
            this.applyTheme();
        });
    },
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
}));

window.Alpine = Alpine;
Alpine.start();

function initMap() {
    // Placeholder function to prevent Google Maps API error
    console.log('Google Maps API loaded.');
}
window.initMap = initMap;

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
