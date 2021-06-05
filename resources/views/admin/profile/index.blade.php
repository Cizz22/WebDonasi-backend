@extends('layouts.app' , ['title' => 'Profile - Page Admin'])



@section('content')

<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
    <div class="container mx-auto py-6 px-8">
        @if(session('status'))
        <div class="bg-green-500 text-white text-center p-3 rounded-sm shadow-md mt-3">
            @if(session('status') == 'profile-information-updated')
                Profile Has Been Updated
            @endif
            @if (session('status')=='password-updated')
                Password has been updated.
            @endif
            @if (session('status')=='two-factor-authentication-disabled')
                Two factor authentication disabled.
            @endif
            @if (session('status')=='two-factor-authentication-enabled')
                Two factor authentication enabled.
            @endif
            @if (session('status')=='recovery-codes-generated')
                Recovery codes generated.
            @endif
        </div>
        @endif

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mt-4">
            <div>
                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
                <div class="p-6 bg-white rounded-md shadow-md">
                    <h2 class="font-bold text-lg text-gray-600 capitalize">TWO FACTOR AUTHENTICATION</h2>
                    <hr class="mt-4">

                    <div class="mt-4">
                        @if(!Auth()->user()->two_factor_secret)
                            <form action="{{url('user/two-factor-authentication')}}">
                            @csrf

                            <button type="submit" class="py-2 px-4 bg-gray-600 rounded-md hover:bg-gray-700 text-white focus:outline-none focus:bg-gray-700">
                                Enable Two-Factor
                            </button>
                        </form>
                        @else
                        <form action="{{url('user/two-factor-authentication')}}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="py-2 px-4 bg-gray-600 rounded-md hover:bg-gray-700 text-white focus:outline-none focus:bg-gray-700">
                                Disable Two-Factor
                            </button>
                        </form>

                            @if(session('status') == 'two-factor-authentication-enabled')
                                <div class="mt-4">
                                    Otentikasi dua faktor sekarang diaktifkan. Pindai kode QR berikut menggunakan aplikasi
                                    pengautentikasi ponsel Anda.
                                </div>
                                <div class="mt-4 mb-3">
                                    {!! auth()->user()->twoFactorQrCodeSvg() !!}
                                </div>
                            @endif

                            <div class="mt-4">
                                Simpan recovery code ini dengan aman. Ini dapat digunakan untuk memulihkan akses ke akun
                                Anda jika perangkat otentikasi dua faktor Anda hilang.
                            </div>

                            <div style="background: rgb(44, 44, 44);color:white" class="rounded p-3 mb-2 mt-4">
                                @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                                <div>{{ $code }}</div>
                                @endforeach
                            </div>

                            <form method="POST" action="{{ url('user/two-factor-recovery-codes') }}">
                                @csrf

                                <button type="submit"
                                    class="mt-4 px-4 py-2 bg-gray-600 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700">
                                    Regenerate Recovery Codes
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                @endif
            </div>


        </div>

    </div>
    </main>

@endsection
