@extends('layouts.app')

@section('title', 'Notifikasi')
@section('header', 'Notifikasi')

@section('content')
<div class="stat-card" style="padding: 0; overflow: hidden;">
    <div style="padding: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 0.25rem;">Semua Notifikasi</h3>
            <p style="color: #6b7280; font-size: 0.8rem;">Notifikasi dan aktivitas terbaru Anda</p>
        </div>
        <div>
            @if($unreadCount > 0)
            <form action="{{ route('notifications.read-all') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" style="background: #004b23; color: white; padding: 0.4rem 1rem; border: none; border-radius: 6px; cursor: pointer;">
                    <i class="fas fa-check-double"></i> Tandai Semua Dibaca
                </button>
            </form>
            @endif
        </div>
    </div>

    <div>
        @if($notifications->count() > 0)
            @foreach($notifications as $notif)
            <div style="padding: 1rem 1.5rem; border-bottom: 1px solid #f0f0f0; {{ !$notif->is_read ? 'background: #f0fdf4;' : '' }}">
                <div style="display: flex; gap: 1rem; align-items: flex-start;">
                    <div style="flex-shrink: 0;">
                        @if($notif->type == 'success')
                            <div style="width: 40px; height: 40px; background: #dcfce7; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-check-circle" style="color: #10b981;"></i>
                            </div>
                        @elseif($notif->type == 'warning')
                            <div style="width: 40px; height: 40px; background: #fef3c7; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-exclamation-triangle" style="color: #f59e0b;"></i>
                            </div>
                        @elseif($notif->type == 'danger')
                            <div style="width: 40px; height: 40px; background: #fee2e2; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-times-circle" style="color: #ef4444;"></i>
                            </div>
                        @else
                            <div style="width: 40px; height: 40px; background: #e8f3ec; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-info-circle" style="color: #004b23;"></i>
                            </div>
                        @endif
                    </div>
                    <div style="flex: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 0.25rem;">
                            <h4 style="font-size: 0.9rem; font-weight: 600;">{{ $notif->title }}</h4>
                            <span style="font-size: 0.7rem; color: #6b7280;">{{ $notif->created_at->diffForHumans() }}</span>
                        </div>
                        <p style="font-size: 0.8rem; color: #4b5563; margin-bottom: 0.5rem;">{{ $notif->message }}</p>
                        @if($notif->link)
                        <a href="{{ $notif->link }}" style="font-size: 0.7rem; color: #004b23; text-decoration: none;">
                            Lihat detail →
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div style="text-align: center; padding: 3rem;">
                <i class="fas fa-bell-slash" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem; display: block;"></i>
                <p style="color: #6b7280;">Belum ada notifikasi</p>
            </div>
        @endif
    </div>

    @if($notifications->hasPages())
    <div style="padding: 1rem; border-top: 1px solid #f0f0f0;">
        {{ $notifications->links() }}
    </div>
    @endif
</div>
@endsection
