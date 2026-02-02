</div> 
</div> 
<footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
        <div class="row">
            <div class="col my-1">
                <p class="m-0">Copyright &copy; <?= date('Y'); ?> <a href="#" target="_blank">E-Lapor Sekolah</a> - Julian.</p>
            </div>
        </div>
    </div>
</footer>

<script src="assets/js/plugins/popper.min.js"></script>
<script src="assets/js/plugins/simplebar.min.js"></script>
<script src="assets/js/plugins/bootstrap.min.js"></script>
<script src="assets/js/fonts/custom-font.js"></script>
<script src="assets/js/script.js"></script>
<script src="assets/js/theme.js"></script>
<script src="assets/js/plugins/feather.min.js"></script>

<script>
    // Script tambahan untuk toggle sidebar di mobile
    document.addEventListener('DOMContentLoaded', function() {
        var toggleBtn = document.querySelector('#mobile-collapse');
        var sidebar = document.querySelector('.pc-sidebar');
        var sidebarHideBtn = document.querySelector('#sidebar-hide');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('mob-sidebar-active');
            });
        }
        if (sidebarHideBtn) {
            sidebarHideBtn.addEventListener('click', function() {
                if (window.innerWidth >= 1025) {
                    sidebar.classList.toggle('pc-sidebar-hide');
                } else {
                    sidebar.classList.remove('mob-sidebar-active');
                }
            });
        }
    });
</script>
</body>
</html>