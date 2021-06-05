@extends('layouts.app', ['title' => 'Password Confirmation'])


@section('content')
<div class="h-screen bg-gray-300 flex justify-center items-center px-6">
    <div class="w-full max-w-sm bg-white p-6 rounded-md shadow-md">
        <div class="flex justify-center items-center">
            <span class="text-2xl font-bold text-gray-600">CONFIRM PASSWORD</span>
        </div>

        @if (session('status'))
        <div class="bg-green-500 p-3 rounded-md shadow-sm mt-3">
            {{ session('status') }}
        </div>
        @endif

        <form action="{{ route('password.confirm') }}" method="POST">
            @csrf
            <label class="block mt-4" for="">
                <span class="text-gray-600 text-sm">Password</span>
                <input type="password" name="password" class="mt-1 form-text block w-full rounded-md hover:outline-none">
                @error('password')
                <div class="inline-flex rounded-md shadow-md max-w-sm w-full bg-red-300 overflow-hidden mt-2">
                    <div class="px-4 py-2">
                        <span class="text-gray-600 text-sm">{{$message}}</span>
                    </div>
                </div>
                @enderror
            </label>
            <div class="mt-6">
                <button type="submit" class="w-full max-w-sm bg-indigo-600 text-white rounded-md py-2 px-4">Confirm</button>
            </div>
        </form>
    </div>
</div>

@endsection
