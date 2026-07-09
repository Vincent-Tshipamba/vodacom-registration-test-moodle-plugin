import 'flowbite';
import Alpine from "alpinejs";
import 'preline';
import QRCode from 'qrcode';

import QrScanner from 'qr-scanner';

window.Alpine = Alpine;

window.QRCode = QRCode;

window.QrScanner = QrScanner;

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
