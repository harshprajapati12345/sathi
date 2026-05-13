      </div><!-- .admin-content -->
    </div><!-- .admin-main -->
  </div><!-- .admin-layout -->
  <script>
  (function () {
    var toggle = document.getElementById('adminSidebarToggle');
    var sidebar = document.getElementById('adminSidebar');
    var backdrop = document.getElementById('adminSidebarBackdrop');
    if (!toggle || !sidebar || !backdrop) return;
    function openM() {
      sidebar.classList.add('is-open');
      backdrop.hidden = false;
      document.body.classList.add('admin-sidebar-open');
    }
    function closeM() {
      sidebar.classList.remove('is-open');
      backdrop.hidden = true;
      document.body.classList.remove('admin-sidebar-open');
    }
    toggle.addEventListener('click', function () {
      if (sidebar.classList.contains('is-open')) closeM();
      else openM();
    });
    backdrop.addEventListener('click', closeM);
    window.addEventListener('resize', function () {
      if (window.matchMedia('(min-width: 1024px)').matches) closeM();
    });

    var navDropdowns = document.querySelectorAll('.admin-nav-dropdown');
    navDropdowns.forEach(function (dropdown) {
      dropdown.addEventListener('toggle', function () {
        if (!this.open) {
          return;
        }
        navDropdowns.forEach(function (other) {
          if (other !== dropdown) {
            other.open = false;
          }
        });
      });
    });
  })();
  </script>
</body>
</html>
