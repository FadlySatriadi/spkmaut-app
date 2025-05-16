<style>
    .datetime-display {
        font-family: 'Poppins', sans-serif;
        display: inline-block;
        color: #800000;
        font-weight: 500;
    }
</style>
<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <div id="live-clock" class="datetime-display">
            {{ now()->translatedFormat('l, d F Y H:i:s') }}
        </div>

        <script>
            function updateClock() {
                const now = new Date();
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                };
                document.getElementById('live-clock').textContent =
                    now.toLocaleDateString('id-ID', options);
            }

            // Update setiap detik
            setInterval(updateClock, 1000);

            // Jalankan pertama kali
            updateClock();
        </script>
    </div>
    <strong, style="font-family: 'Poppins', sans-serif; font-weight: 700; color: #000000;">Copyright &copy; 2025 <a
            href="https://sig.id", style="color: #800000";>Semen Indonesia (Persero) Tbk.</a></strong> All rights
        reserved.
</footer>
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
