import "./bootstrap";
import "../sass/app.scss";
import "laravel-datatables-vite";
import DataTables from 'datatables.net';

window.DataTable = DataTables;
$('#myTable').DataTable();