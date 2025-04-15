import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
import $ from 'jquery';
import 'select2';
import 'select2/dist/css/select2.css';
// Opsional: tema bootstrap
import 'select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css';

// Inisialisasi Select2
$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap-5' // jika menggunakan tema bootstrap
    });
});