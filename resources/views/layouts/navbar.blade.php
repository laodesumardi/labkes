@php
    use App\Models\Notification;

    // Definisikan variabel user
    $user = Auth::user();

    try {
        $unreadCount = Notification::where('user_id', auth()->id())->where('is_read', false)->count();
    } catch (\Exception $e) {
        $unreadCount = 0;
    }
@endphp

<style>
    .top-navbar {
        background: white;
        padding: 0.875rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e5e7eb;
        position: sticky;
        top: 0;
        z-index: 998;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1a1a1a;
        letter-spacing: -0.3px;
    }

    .notification-dropdown {
        position: absolute;
        right: 0;
        top: 100%;
        margin-top: 0.5rem;
        width: 380px;
        max-width: calc(100vw - 20px);
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        display: none;
        max-height: 500px;
        overflow-y: auto;
    }

    .notification-dropdown.show {
        display: block;
        animation: fadeIn 0.2s ease;
    }

    .notification-item-dropdown {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #f3f4f6;
        cursor: pointer;
        transition: background 0.2s;
    }

    .notification-item-dropdown:hover {
        background: #f9fafb;
    }

    .notification-item-dropdown.unread {
        background: #f0fdf4;
    }

    .user-dropdown {
        position: absolute;
        right: 0;
        top: 100%;
        margin-top: 0.5rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        min-width: 200px;
        display: none;
        z-index: 1000;
    }

    .user-dropdown.show {
        display: block;
        animation: fadeIn 0.2s ease;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        color: #374151;
        text-decoration: none;
        transition: background 0.2s;
    }

    .dropdown-item:hover {
        background: #f3f4f6;
    }

    .dropdown-item-danger {
        color: #ef4444;
    }

    .dropdown-item-danger:hover {
        background: #fee2e2;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        .top-navbar {
            padding: 0.75rem 1rem 0.75rem 4rem;
        }
        .page-title {
            font-size: 1.1rem;
        }
        .user-name {
            display: none;
        }
    }

    @media (max-width: 480px) {
        .top-navbar {
            padding: 0.6rem 0.8rem 0.6rem 3.5rem;
        }
        .page-title {
            font-size: 1rem;
        }
        .notification-dropdown {
            width: 320px;
            right: -50px;
        }
    }
</style>

<div class="top-navbar">
    <div>
        <button onclick="toggleSidebar()" class="menu-toggle" style="display: none; background: none; border: none; font-size: 1.25rem; cursor: pointer;">
            <i class="fas fa-bars"></i>
        </button>
        <h1 class="page-title">@yield('header', 'Dashboard')</h1>
    </div>

    <div style="display: flex; align-items: center; gap: 1.5rem;">
        <!-- Notifikasi -->
        <div style="position: relative;" class="notification-menu">
            <button onclick="toggleNotificationDropdown()" style="background: none; border: none; cursor: pointer; position: relative;">
                <i class="fas fa-bell" style="color: #6b7280; font-size: 1.2rem;"></i>
                @if($unreadCount > 0)
                <span class="notification-badge" style="position: absolute; top: -5px; right: -8px; background: #ef4444; color: white; font-size: 0.6rem; padding: 2px 5px; border-radius: 9999px; min-width: 18px; text-align: center;">
                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                </span>
                @endif
            </button>

            <div class="notification-dropdown" id="notificationDropdown">
                <div style="padding: 0.75rem 1rem; border-bottom: 1px solid #e5e7eb; background: #f9fafb;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <strong style="font-size: 0.85rem;">Notifikasi</strong>
                        <a href="{{ route('notifications.index') }}" style="font-size: 0.7rem; color: #004b23; text-decoration: none;">
                            Lihat semua
                        </a>
                    </div>
                </div>
                <div id="notificationList">
                    <div style="text-align: center; padding: 2rem;">
                        <div style="width: 30px; height: 30px; border: 2px solid #e5e7eb; border-top-color: #004b23; border-radius: 50%; animation: spin 0.8s linear infinite; margin: 0 auto;"></div>
                        <p style="font-size: 0.7rem; color: #6b7280; margin-top: 0.5rem;">Memuat...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Menu -->
        <div style="position: relative;" class="user-menu">
            <button onclick="toggleUserMenu()" style="display: flex; align-items: center; gap: 0.75rem; background: none; border: none; cursor: pointer;">
                <div style="width: 38px; height: 38px; background: #004b23; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white;">
                    <span style="font-weight: 600; font-size: 0.9rem;">{{ $user ? substr($user->nama_lengkap, 0, 1) : 'U' }}</span>
                </div>
                <div style="text-align: left;" class="user-name">
                    <div style="font-size: 0.85rem; font-weight: 600; color: #1a1a1a;">{{ $user ? $user->nama_lengkap : 'User' }}</div>
                    <div style="font-size: 0.7rem; color: #6b7280;">{{ $user ? ucfirst($user->role) : 'Guest' }}</div>
                </div>
                <i class="fas fa-chevron-down" style="color: #9ca3af; font-size: 0.75rem;"></i>
            </button>

            <div class="user-dropdown" id="userDropdown">
                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                    <i class="fas fa-user" style="width: 20px;"></i>
                    <span>Profil Saya</span>
                </a>
                <a href="{{ route('notifications.index') }}" class="dropdown-item">
                    <i class="fas fa-bell" style="width: 20px;"></i>
                    <span>Notifikasi</span>
                    @if($unreadCount > 0)
                    <span style="background: #ef4444; color: white; font-size: 0.6rem; padding: 2px 6px; border-radius: 9999px; margin-left: auto;">{{ $unreadCount }}</span>
                    @endif
                </a>
                <div style="height: 1px; background: #f3f4f6; margin: 0.25rem 0;"></div>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="dropdown-item dropdown-item-danger" style="width: 100%; text-align: left;">
                        <i class="fas fa-sign-out-alt" style="width: 20px;"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleNotificationDropdown() {
        const dropdown = document.getElementById('notificationDropdown');
        if (dropdown) {
            if (dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
            } else {
                dropdown.classList.add('show');
                loadNotifications();
            }
        }
    }

    function loadNotifications() {
        // Gunakan URL manual untuk menghindari error route
        fetch('/notifications/unread')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('notificationList');
                if (container) {
                    if (data.notifications && data.notifications.length > 0) {
                        container.innerHTML = data.notifications.map(notif => `
                            <div class="notification-item-dropdown unread" onclick="markAsReadAndRedirect(${notif.id}, '${notif.link || '#'}')">
                                <div style="display: flex; gap: 0.75rem;">
                                    <div style="flex-shrink: 0;">
                                        ${notif.type === 'success' ? '<i class="fas fa-check-circle" style="color: #10b981; font-size: 1rem;"></i>' :
                                          notif.type === 'warning' ? '<i class="fas fa-exclamation-triangle" style="color: #f59e0b; font-size: 1rem;"></i>' :
                                          notif.type === 'danger' ? '<i class="fas fa-times-circle" style="color: #ef4444; font-size: 1rem;"></i>' :
                                          '<i class="fas fa-info-circle" style="color: #004b23; font-size: 1rem;"></i>'}
                                    </div>
                                    <div style="flex: 1;">
                                        <div style="font-size: 0.8rem; font-weight: 600; margin-bottom: 0.25rem;">${escapeHtml(notif.title)}</div>
                                        <div style="font-size: 0.7rem; color: #6b7280;">${escapeHtml(notif.message.substring(0, 80))}${notif.message.length > 80 ? '...' : ''}</div>
                                        <div style="font-size: 0.6rem; color: #9ca3af; margin-top: 0.25rem;">${formatTimeAgo(notif.created_at)}</div>
                                    </div>
                                </div>
                            </div>
                        `).join('');

                        const badge = document.querySelector('.notification-badge');
                        if (badge) {
                            if (data.count > 0) {
                                badge.style.display = 'block';
                                badge.textContent = data.count > 99 ? '99+' : data.count;
                            } else {
                                badge.style.display = 'none';
                            }
                        }
                    } else {
                        container.innerHTML = `
                            <div style="text-align: center; padding: 2rem;">
                                <i class="fas fa-bell-slash" style="font-size: 2rem; color: #d1d5db;"></i>
                                <p style="font-size: 0.7rem; color: #6b7280; margin-top: 0.5rem;">Tidak ada notifikasi</p>
                            </div>
                        `;
                    }
                }
            })
            .catch(error => {
                console.error('Error loading notifications:', error);
                const container = document.getElementById('notificationList');
                if (container) {
                    container.innerHTML = `
                        <div style="text-align: center; padding: 2rem;">
                            <i class="fas fa-exclamation-triangle" style="font-size: 2rem; color: #f59e0b;"></i>
                            <p style="font-size: 0.7rem; color: #6b7280; margin-top: 0.5rem;">Gagal memuat notifikasi</p>
                        </div>
                    `;
                }
            });
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function formatTimeAgo(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const seconds = Math.floor((now - date) / 1000);

        if (seconds < 60) return 'baru saja';
        const minutes = Math.floor(seconds / 60);
        if (minutes < 60) return `${minutes} menit lalu`;
        const hours = Math.floor(minutes / 60);
        if (hours < 24) return `${hours} jam lalu`;
        const days = Math.floor(hours / 24);
        if (days < 7) return `${days} hari lalu`;
        return date.toLocaleDateString('id-ID');
    }

    function markAsReadAndRedirect(id, link) {
        fetch(`/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(() => {
            if (link && link !== '#') {
                window.location.href = link;
            } else {
                location.reload();
            }
        }).catch(() => {
            if (link && link !== '#') {
                window.location.href = link;
            } else {
                location.reload();
            }
        });
    }

    function toggleUserMenu() {
        const dropdown = document.getElementById('userDropdown');
        if (dropdown) {
            dropdown.classList.toggle('show');
        }
    }

    document.addEventListener('click', function(event) {
        if (!event.target.closest('.user-menu')) {
            const userDropdown = document.getElementById('userDropdown');
            if (userDropdown) userDropdown.classList.remove('show');
        }
        if (!event.target.closest('.notification-menu')) {
            const notifDropdown = document.getElementById('notificationDropdown');
            if (notifDropdown) notifDropdown.classList.remove('show');
        }
    });

    // Auto refresh notifikasi setiap 30 detik
    setInterval(() => {
        const dropdown = document.getElementById('notificationDropdown');
        if (dropdown && dropdown.classList.contains('show')) {
            loadNotifications();
        }
    }, 30000);

    // Tampilkan menu toggle pada mobile
    if (window.innerWidth <= 768) {
        const menuToggle = document.querySelector('.menu-toggle');
        if (menuToggle) menuToggle.style.display = 'block';
    }
</script>
