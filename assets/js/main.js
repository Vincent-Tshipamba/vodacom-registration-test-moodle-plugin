import 'flowbite';
import Alpine from "alpinejs";
// import 'preline';

// import { createIcons } from 'lucide';

window.Alpine = Alpine;

Alpine.start();

window.lucide = require('lucide');

document.addEventListener('DOMContentLoaded', () => {
    window.lucide.createIcons({
        icons: lucide.icons
    });
});
