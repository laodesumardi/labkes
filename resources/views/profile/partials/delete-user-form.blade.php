<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update informasi profil Anda.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
            <x-text-input id="nama_lengkap" name="nama_lengkap" type="text" class="mt-1 block w-full" :value="old('nama_lengkap', $user->nama_lengkap)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('nama_lengkap')" />
        </div>

        <div>
            <x-input-label for="nip" :value="__('NIP')" />
            <x-text-input id="nip" name="nip" type="text" class="mt-1 block w-full" :value="old('nip', $user->nip)" required disabled />
            <x-input-error class="mt-2" :messages="$errors->get('nip')" />
            <p class="mt-1 text-xs text-gray-500">NIP tidak dapat diubah</p>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="no_telepon" :value="__('No. Telepon')" />
            <x-text-input id="no_telepon" name="no_telepon" type="text" class="mt-1 block w-full" :value="old('no_telepon', $user->no_telepon)" />
            <x-input-error class="mt-2" :messages="$errors->get('no_telepon')" />
        </div>

        <div>
            <x-input-label for="alamat" :value="__('Alamat')" />
            <textarea id="alamat" name="alamat" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('alamat', $user->alamat) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
