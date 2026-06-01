import 'flowbite';
import Alpine from "alpinejs";
// import 'preline';

// import { createIcons } from 'lucide';

window.Alpine = Alpine;

Alpine.start();

window.lucide = require('lucide');

function initIcons() {
    window.lucide.createIcons({
        icons: lucide.icons
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initIcons);
} else {
    initIcons();
}
