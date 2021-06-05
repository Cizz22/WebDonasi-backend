@extends('layouts.auth', ['title' => 'Two Factor challenge'])



@section('content')

<div class="h-screen bg-gray-300 flex justify-center items-center px-6">
    <div class="w-full max-w-sm bg-white p-6 rounded-md shadow-md">
        <div class="flex justify-center items-center">
            <span class="text-2xl font-bold text-gray-600">TWO FACTOR CHALLENGE</span>
        </div>

        @if (session('status'))
        <div class="bg-green-500 p-3 rounded-md shadow-sm mt-3">
            {{ session('status') }}
        </div>
        @endif

        <form class="mt-3" action="{{ url('/two-factor-challenge') }}" method="POST">
            @csrf
            <label class="block">
                <span class="text-gray-700 text-sm">Code</span>
                <input type="text" name="code" value="{{ old('email') }}"
                    class="form-input mt-1 block w-full rounded-md focus:border-indigo-600" placeholder="Code">
                @error('code')
                <div class="inline-flex max-w-sm w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                    <div class="px-4 py-2">
                        <p class="text-gray-600 text-sm">{{ $message }}</p>
                    </div>
                </div>
                @enderror
            </label>

            <p class="text-gray-600">
                <i>Atau Anda dapat memasukkan salah satu recovery code.</i>
            </p>

            <label class="block mt-3">
                <span class="text-gray-700 text-sm">Recovery Code</span>
                <input type="text" name="recovery_code" class="form-input mt-1 block w-full rounded-md focus:border-indigo-600"
                    placeholder="Recovery Code">
                @error('recovery_code')
                <div class="inline-flex max-w-sm w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                    <div class="px-4 py-2">
                        <p class="text-gray-600 text-sm">{{ $message }}</p>
                    </div>
                </div>
                @enderror
            </label>

            <div class="mt-6">
                <button type="submit" class="w-full max-w-sm bg-indigo-600 text-white rounded-md py-2 px-4">Submit</button>
            </div>
        </form>
    </div>
</div>

@endsection
