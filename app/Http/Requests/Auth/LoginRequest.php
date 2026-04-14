<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nip' => ['required', 'string'], // Ganti 'email' jadi 'nip'
            'password' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'nip.required' => 'NIP wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Ganti 'email' jadi 'nip'
        if (! Auth::attempt(['nip' => $this->nip, 'password' => $this->password], $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'nip' => 'NIP atau password salah.', // Ganti 'email' jadi 'nip'
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'nip' => trans('auth.throttle', [ // Ganti 'email' jadi 'nip'
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('nip')) . '|' . $this->ip()); // Ganti 'email' jadi 'nip'
    }
}
