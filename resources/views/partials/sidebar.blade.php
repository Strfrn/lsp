<div class="sidebar-wrapper">
    <nav class="mt-2">
      <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ route('jeniskamar.index') }}" class="nav-link" data-route="jeniskamar">
            <i class="nav-icon bi bi-speedometer"></i>
            <p>Jenis Kamar</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('kamar.index') }}" class="nav-link" data-route="kamar">
            <i class="nav-icon bi bi-palette"></i>
            <p>Kamar</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('reservasi.index') }}" class="nav-link" data-route="reservasi">
            <i class="nav-icon bi bi-calendar-check"></i>
            <p>Reservasi</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('laporan.index') }}" class="nav-link" data-route="laporan">
            <i class="nav-icon bi bi-file-earmark-bar-graph"></i>
            <p>Laporan</p>
          </a>
        </li>
      </ul>
    </nav>
</div>
<script>
   document.addEventListener("DOMContentLoaded", function() {
    const navLinks = document.querySelectorAll(".nav-link");
    const baseUrl = window.location.origin;

    // Fungsi untuk set active menu
    function setActiveMenu() {
        const currentPath = window.location.pathname;

        navLinks.forEach(link => {
            const linkPath = new URL(link.href).pathname;
            if (currentPath.startsWith(linkPath)) {
                link.classList.add("bg-success", "text-white");
            } else {
                link.classList.remove("bg-success", "text-white");
            }
        });
    }

    // Inisialisasi pertama
    setActiveMenu();

    // Handle click event
    navLinks.forEach(link => {
        link.addEventListener("click", function(e) {
            // Hentikan default behavior
            e.preventDefault();

            // Set active menu
            navLinks.forEach(nav => nav.classList.remove("bg-success", "text-white"));
            this.classList.add("bg-success", "text-white");

            // Simpan ke localStorage
            localStorage.setItem("activeMenu", this.href);

            // Navigasi manual
            window.location.href = this.href;
        });
    });
});
    </script>

