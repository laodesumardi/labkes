@php
    use App\Models\Setting;

    $user = Auth::user();
    $role = $user ? $user->role : 'guest';
    $currentRoute = request()->route()->getName();

    $appName = Setting::get('app_name', 'Labkes');
    $logo = Setting::get('app_logo');
    $primaryColor = Setting::get('primary_color', '#004b23');
@endphp

<style>
    /* ========== SIDEBAR STYLES ========== */
    .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        bottom: 0;
        width: 280px;
        background: linear-gradient(180deg, {{ $primaryColor }} 0%, {{ $primaryColor }}dd 100%);
        z-index: 1000;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow-y: auto;
        overflow-x: hidden;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Scrollbar styling */
    .sidebar::-webkit-scrollbar {
        width: 4px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 4px;
    }

    /* Sidebar Header */
    .sidebar-header {
        padding: 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar-logo {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .sidebar-logo-icon {
        width: 180px;
        height: 80px;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
        transition: all 0.3s;
    }

    .sidebar-logo-icon img {
        max-width: 220px;
        max-height: 220px;
        width: auto;
        height: auto;
        object-fit: contain;
    }

    .sidebar-logo-icon i {
        font-size: 2.5rem;
        color: white;
    }

    .sidebar-logo-text h2 {
        font-size: 1.25rem;
        font-weight: 600;
        color: white;
        letter-spacing: -0.3px;
        margin-bottom: 0.25rem;
    }

    .sidebar-logo-text p {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.7);
    }

    /* Sidebar Navigation */
    .sidebar-nav {
        padding: 1.5rem 1rem;
    }

    .sidebar-nav-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        margin-bottom: 0.5rem;
        border-radius: 12px;
        color: rgba(255, 255, 255, 0.85);
        transition: all 0.2s;
        font-size: 0.9rem;
        font-weight: 500;
        text-decoration: none;
        white-space: nowrap;
    }

    .sidebar-nav-item i {
        width: 22px;
        font-size: 1rem;
        text-align: center;
    }

    .sidebar-nav-item span {
        flex: 1;
    }

    .sidebar-nav-item:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        transform: translateX(4px);
    }

    .sidebar-nav-item.active {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Sidebar Footer */
    .sidebar-footer {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.5);
        text-align: center;
        background: rgba(0, 0, 0, 0.1);
    }

    /* ========== MAIN CONTENT ========== */
    .main-content {
        margin-left: 280px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        min-height: 100vh;
    }

    /* ========== MOBILE MENU BUTTON ========== */
    .mobile-menu-btn {
        display: none;
        position: fixed;
        top: 1rem;
        left: 1rem;
        z-index: 1100;
        background: {{ $primaryColor }};
        color: white;
        border: none;
        width: 45px;
        height: 45px;
        border-radius: 12px;
        cursor: pointer;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        transition: all 0.3s;
    }

    .mobile-menu-btn:hover {
        transform: scale(1.05);
        background: {{ $primaryColor }}dd;
    }

    .mobile-menu-btn i {
        font-size: 1.25rem;
    }

    /* Overlay untuk mobile */
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
        transition: all 0.3s;
    }

    /* ========== RESPONSIVE BREAKPOINTS ========== */

    /* Tablet (768px - 1024px) */
    @media (max-width: 1024px) {
        .sidebar {
            width: 260px;
        }
        .main-content {
            margin-left: 260px;
        }
    }

    /* Mobile (max 768px) */
    @media (max-width: 768px) {
        .mobile-menu-btn {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar {
            transform: translateX(-100%);
            width: 280px;
            z-index: 1001;
        }

        .sidebar.mobile-open {
            transform: translateX(0);
        }

        .main-content {
            margin-left: 0;
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* Adjust main content padding for mobile */
        .main-content .top-navbar {
            padding-left: 70px;
        }
    }

    /* Small mobile (max 480px) */
    @media (max-width: 480px) {
        .sidebar {
            width: 85%;
            max-width: 280px;
        }

        .sidebar-nav-item {
            padding: 0.7rem 0.9rem;
            font-size: 0.85rem;
        }

        .sidebar-logo-icon {
            width: 70px;
            height: 70px;
        }

        .sidebar-logo-icon img {
            max-width: 45px;
            max-height: 45px;
        }

        .sidebar-logo-text h2 {
            font-size: 1.1rem;
        }
    }

    /* Desktop hover effect */
    @media (min-width: 769px) {
        .sidebar:not(.collapsed) {
            width: 280px;
        }
    }
</style>

<!-- Mobile Menu Button -->
<button class="mobile-menu-btn" id="mobileMenuBtn">
    <i class="fas fa-bars"></i>
</button>

<!-- Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <div class="sidebar-logo-icon">
                @if($logo && Storage::disk('public')->exists($logo))
                    <img src="{{ Storage::url($logo) }}" alt="Logo">
                @else
                    <i class="fas fa-flask"></i>
                @endif
            </div>
            <div class="sidebar-logo-text">
                <h2>{{ $appName }}</h2>
                <p>Laboratorium Kesehatan</p>
            </div>
        </div>
    </div>

  <nav class="sidebar-nav">
    @if($role == 'admin')
        <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-item {{ str_contains($currentRoute, 'admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="sidebar-nav-item {{ str_contains($currentRoute, 'admin.users') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>Manajemen User</span>
        </a>
        <a href="{{ route('admin.parameters.index') }}" class="sidebar-nav-item {{ str_contains($currentRoute, 'admin.parameters') ? 'active' : '' }}">
            <i class="fas fa-microscope"></i>
            <span>Parameter Lab</span>
        </a>
        <a href="{{ route('admin.reports.index') }}" class="sidebar-nav-item {{ str_contains($currentRoute, 'admin.reports') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i>
            <span>Laporan</span>
        </a>
        <a href="{{ route('admin.logs.index') }}" class="sidebar-nav-item {{ str_contains($currentRoute, 'admin.logs') ? 'active' : '' }}">
            <i class="fas fa-history"></i>
            <span>Log Aktivitas</span>
        </a>
        <a href="{{ route('admin.settings') }}" class="sidebar-nav-item {{ str_contains($currentRoute, 'admin.settings') ? 'active' : '' }}">
            <i class="fas fa-cog"></i>
            <span>Pengaturan</span>
        </a>

    @elseif($role == 'dokter')
        <a href="{{ route('dokter.dashboard') }}" class="sidebar-nav-item {{ str_contains($currentRoute, 'dokter.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('dokter.pemeriksaan.index') }}" class="sidebar-nav-item {{ str_contains($currentRoute, 'dokter.pemeriksaan') ? 'active' : '' }}">
            <i class="fas fa-stethoscope"></i>
            <span>Data Pemeriksaan</span>
        </a>
        <a href="{{ route('dokter.rekam-medis.index') }}" class="sidebar-nav-item {{ str_contains($currentRoute, 'dokter.rekam-medis') ? 'active' : '' }}">
            <i class="fas fa-notes-medical"></i>
            <span>Rekam Medis</span>
        </a>
        <a href="{{ route('dokter.validasi.index') }}" class="sidebar-nav-item {{ str_contains($currentRoute, 'dokter.validasi') ? 'active' : '' }}">
            <i class="fas fa-check-circle"></i>
            <span>Validasi Hasil</span>
        </a>

    @elseif($role == 'petugas_lab')
        <a href="{{ route('petugas_lab.dashboard') }}" class="sidebar-nav-item {{ str_contains($currentRoute, 'petugas_lab.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('petugas_lab.pemeriksaan.index') }}" class="sidebar-nav-item {{ str_contains($currentRoute, 'petugas_lab.pemeriksaan') ? 'active' : '' }}">
            <i class="fas fa-vial"></i>
            <span>Pemeriksaan</span>
        </a>
        <a href="{{ route('petugas_lab.antrian.index') }}" class="sidebar-nav-item {{ str_contains($currentRoute, 'petugas_lab.antrian') ? 'active' : '' }}">
            <i class="fas fa-clock"></i>
            <span>Antrian</span>
        </a>
        <a href="{{ route('petugas_lab.cetak.index') }}" class="sidebar-nav-item {{ str_contains($currentRoute, 'petugas_lab.cetak') ? 'active' : '' }}">
            <i class="fas fa-print"></i>
            <span>Cetak Hasil</span>
        </a>

    @elseif($role == 'pasien')
        <a href="{{ route('pasien.dashboard') }}" class="sidebar-nav-item {{ str_contains($currentRoute, 'pasien.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('pasien.riwayat.index') }}" class="sidebar-nav-item {{ str_contains($currentRoute, 'pasien.riwayat') ? 'active' : '' }}">
            <i class="fas fa-history"></i>
            <span>Riwayat Pemeriksaan</span>
        </a>
        <a href="{{ route('pasien.hasil.index') }}" class="sidebar-nav-item {{ str_contains($currentRoute, 'pasien.hasil') ? 'active' : '' }}">
            <i class="fas fa-file-medical"></i>
            <span>Hasil Lab</span>
        </a>
    @endif
</nav>

    <div class="sidebar-footer">
        <i class="fas fa-shield-alt"></i> Secure Access v1.0
    </div>
</div>

<script>
    // ========== SIDEBAR RESPONSIVE SCRIPT ==========

    (function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const mobileBtn = document.getElementById('mobileMenuBtn');

        // Cek apakah di mobile
        function isMobile() {
            return window.innerWidth <= 768;
        }

        // Buka sidebar
        function openSidebar() {
            if (sidebar) {
                sidebar.classList.add('mobile-open');
            }
            if (overlay) {
                overlay.classList.add('active');
            }
            document.body.style.overflow = 'hidden';
        }

        // Tutup sidebar
        function closeSidebar() {
            if (sidebar) {
                sidebar.classList.remove('mobile-open');
            }
            if (overlay) {
                overlay.classList.remove('active');
            }
            document.body.style.overflow = '';
        }

        // Toggle sidebar
        function toggleSidebar() {
            if (sidebar && sidebar.classList.contains('mobile-open')) {
                closeSidebar();
            } else if (isMobile()) {
                openSidebar();
            }
        }

        // Event listener untuk tombol mobile
        if (mobileBtn) {
            mobileBtn.addEventListener('click', toggleSidebar);
        }

        // Event listener untuk overlay (klik di luar sidebar)
        if (overlay) {
            overlay.addEventListener('click', closeSidebar);
        }

        // Tutup sidebar saat resize ke desktop
        window.addEventListener('resize', function() {
            if (!isMobile()) {
                closeSidebar();
            }
        });

        // Tutup sidebar saat link di klik (mobile)
        const navLinks = document.querySelectorAll('.sidebar-nav-item');
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                if (isMobile()) {
                    setTimeout(closeSidebar, 150);
                }
            });
        });

        // Swipe untuk membuka/tutup sidebar (mobile)
        let touchStartX = 0;
        let touchEndX = 0;

        document.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        });

        document.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });

        function handleSwipe() {
            const swipeDistance = touchEndX - touchStartX;

            // Swipe kanan untuk buka (lebih dari 50px)
            if (swipeDistance > 50 && isMobile()) {
                openSidebar();
            }

            // Swipe kiri untuk tutup (kurang dari -50px)
            if (swipeDistance < -50 && isMobile() && sidebar && sidebar.classList.contains('mobile-open')) {
                closeSidebar();
            }
        }
    })();
</script>
