@extends('layouts.app')

@section('title', 'Pengaturan Sistem')
@section('header', 'Pengaturan')

@section('content')
<style>
    .preview-image {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        padding: 4px;
    }

    .preview-image-small {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        padding: 2px;
    }

    .color-preview {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        border: 2px solid #e5e7eb;
    }
</style>

<div class="max-w-5xl mx-auto">
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Informasi Umum -->
        <div class="stat-card" style="margin-bottom: 1.5rem;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
                <i class="fas fa-info-circle" style="color: #004b23; margin-right: 0.5rem;"></i>
                Informasi Umum
            </h3>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                    Nama Aplikasi
                </label>
                <input type="text" name="app_name" value="{{ old('app_name', $settings['app_name']) }}" required
                       style="width: 100%; padding: 0.6rem; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 0.85rem;">
                <p style="font-size: 0.65rem; color: #6b7280; margin-top: 0.25rem;">Nama yang akan ditampilkan di sidebar dan halaman login</p>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                    Warna Utama
                </label>
                <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                    <input type="color" name="primary_color" value="{{ old('primary_color', $settings['primary_color']) }}"
                           style="width: 60px; height: 40px; border: 1.5px solid #e5e7eb; border-radius: 8px; cursor: pointer;">
                    <input type="text" id="primary_color_text" value="{{ old('primary_color', $settings['primary_color']) }}"
                           style="width: 120px; padding: 0.6rem; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 0.85rem;">
                </div>
                <p style="font-size: 0.65rem; color: #6b7280; margin-top: 0.25rem;">Warna tema utama aplikasi (default: #004b23)</p>
            </div>
        </div>

        <!-- Logo Aplikasi -->
        <div class="stat-card" style="margin-bottom: 1.5rem;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
                <i class="fas fa-image" style="color: #004b23; margin-right: 0.5rem;"></i>
                Logo Aplikasi
            </h3>

            <div style="display: flex; gap: 2rem; flex-wrap: wrap; align-items: flex-start;">
                <div style="text-align: center;">
                    <div style="margin-bottom: 0.5rem;">
                        @if($settings['app_logo'] && Storage::disk('public')->exists($settings['app_logo']))
                            <img src="{{ Storage::url($settings['app_logo']) }}" alt="Logo" class="preview-image">
                        @else
                            <div style="width: 150px; height: 150px; background: #f3f4f6; border-radius: 12px; display: flex; align-items: center; justify-content: center; border: 2px solid #e5e7eb;">
                                <i class="fas fa-building" style="font-size: 3rem; color: #9ca3af;"></i>
                            </div>
                        @endif
                    </div>
                    <p style="font-size: 0.7rem; color: #6b7280;">Preview Logo</p>
                </div>

                <div style="flex: 1;">
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                            Upload Logo Baru
                        </label>
                        <input type="file" name="app_logo" accept="image/png,image/jpg,image/jpeg"
                               style="width: 100%; padding: 0.5rem; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 0.8rem;">
                        <p style="font-size: 0.65rem; color: #6b7280; margin-top: 0.25rem;">Format: PNG, JPG, JPEG. Maks: 2MB. Ukuran ideal: 200x200px</p>
                    </div>

                    @if($settings['app_logo'])
                    <div>
                        <a href="{{ route('admin.settings.reset-logo') }}"
                           onclick="return confirm('Yakin ingin mereset logo ke default?')"
                           style="color: #ef4444; font-size: 0.8rem; text-decoration: none;">
                            <i class="fas fa-trash-alt"></i> Reset ke default
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Background Login -->
        <div class="stat-card" style="margin-bottom: 1.5rem;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
                <i class="fas fa-image" style="color: #004b23; margin-right: 0.5rem;"></i>
                Background Halaman Login
            </h3>

            <div style="display: flex; gap: 2rem; flex-wrap: wrap; align-items: flex-start;">
                <div style="text-align: center;">
                    <div style="margin-bottom: 0.5rem;">
                        @if($settings['login_background'] && Storage::disk('public')->exists($settings['login_background']))
                            <img src="{{ Storage::url($settings['login_background']) }}" alt="Background" class="preview-image" style="width: 250px; height: 150px;">
                        @else
                            <div style="width: 250px; height: 150px; background: linear-gradient(135deg, #004b23 0%, #003518 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; border: 2px solid #e5e7eb;">
                                <i class="fas fa-image" style="font-size: 2rem; color: white;"></i>
                            </div>
                        @endif
                    </div>
                    <p style="font-size: 0.7rem; color: #6b7280;">Preview Background</p>
                </div>

                <div style="flex: 1;">
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                            Upload Background Baru
                        </label>
                        <input type="file" name="login_background" accept="image/png,image/jpg,image/jpeg"
                               style="width: 100%; padding: 0.5rem; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 0.8rem;">
                        <p style="font-size: 0.65rem; color: #6b7280; margin-top: 0.25rem;">Format: PNG, JPG, JPEG. Maks: 5MB. Ukuran ideal: 1920x1080px</p>
                    </div>

                    @if($settings['login_background'])
                    <div>
                        <a href="{{ route('admin.settings.reset-background') }}"
                           onclick="return confirm('Yakin ingin mereset background ke default?')"
                           style="color: #ef4444; font-size: 0.8rem; text-decoration: none;">
                            <i class="fas fa-trash-alt"></i> Reset ke default
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Favicon -->
        <div class="stat-card" style="margin-bottom: 1.5rem;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0;">
                <i class="fas fa-chart-simple" style="color: #004b23; margin-right: 0.5rem;"></i>
                Favicon
            </h3>

            <div style="display: flex; gap: 2rem; flex-wrap: wrap; align-items: flex-start;">
                <div style="text-align: center;">
                    <div style="margin-bottom: 0.5rem;">
                        @if($settings['favicon'] && Storage::disk('public')->exists($settings['favicon']))
                            <img src="{{ Storage::url($settings['favicon']) }}" alt="Favicon" class="preview-image-small">
                        @else
                            <div style="width: 50px; height: 50px; background: #004b23; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-flask" style="font-size: 1.5rem; color: white;"></i>
                            </div>
                        @endif
                    </div>
                    <p style="font-size: 0.7rem; color: #6b7280;">Preview Favicon</p>
                </div>

                <div style="flex: 1;">
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                            Upload Favicon Baru
                        </label>
                        <input type="file" name="favicon" accept="image/png,image/ico"
                               style="width: 100%; padding: 0.5rem; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 0.8rem;">
                        <p style="font-size: 0.65rem; color: #6b7280; margin-top: 0.25rem;">Format: PNG, ICO. Maks: 512KB. Ukuran: 32x32px atau 64x64px</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Simpan -->
        <div style="display: flex; justify-content: flex-end; gap: 1rem;">
            <button type="submit" style="background: #004b23; color: white; padding: 0.6rem 2rem; border: none; border-radius: 8px; cursor: pointer; font-size: 0.85rem;">
                <i class="fas fa-save"></i> Simpan Pengaturan
            </button>
        </div>
    </form>
</div>

<script>
    // Sinkronisasi color picker dengan text input
    const colorPicker = document.querySelector('input[type="color"]');
    const colorText = document.getElementById('primary_color_text');

    if (colorPicker && colorText) {
        colorPicker.addEventListener('change', function() {
            colorText.value = this.value;
        });

        colorText.addEventListener('change', function() {
            colorPicker.value = this.value;
        });
    }

    // Preview logo sebelum upload
    document.querySelector('input[name="app_logo"]')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const preview = document.querySelector('.preview-image');
                if (preview && preview.tagName === 'IMG') {
                    preview.src = event.target.result;
                }
            };
            reader.readAsDataURL(file);
        }
    });

    // Preview background sebelum upload
    document.querySelector('input[name="login_background"]')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const previews = document.querySelectorAll('.preview-image');
                previews.forEach(preview => {
                    if (preview && preview.tagName === 'IMG' && preview.style.width === '250px') {
                        preview.src = event.target.result;
                    }
                });
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
