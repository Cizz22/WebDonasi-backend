@extends('layouts.app', ['title' => 'Donaturs - Page Admin'])

@section('content')


<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
    <div class="container mx-auto py-6 px-8">
        <div class="flex items-center">
            <div class="relative mx-4">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                    <svg class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </span>
                <form action="{{ route('admin.donatur.index') }}" method="GET">
                    <input class="form-input w-full rounded-lg pl-10 pr-4" type="text" name="q" value="{{ request()->query('q') }}"
                    placeholder="Search">
                </form>
            </div>
        </div>

        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
            <div class="inline-block min-w-full shadow-sm rounded-lg overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="justify-between">
                        <tr class="bg-gray-600 w-full">

                            <th class="px-16 py-2">
                                <span class="text-white">NAMA LENGKAP</span>
                            </th>
                            <th class="px-16 py-2 ">
                                <span class="text-white">EMAIL</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-200">
                        @forelse($donaturs as $index=>$donatur)
                            <tr class="border bg-white">
                                <td class="px-16 py-2">
                                 <p class="text-center">{{ $donatur->name }}</p>
                                </td>

                                <td class="px-16 py-2">
                                    <p class="text-center">{{ $donatur->email}}</p>
                                </td>

                            </tr>
                        @empty
                            <div class="bg-red-500 text-white text-center p-3 rounded-sm shadow-md">
                                Data Belum Tersedia!
                            </div>
                        @endforelse
                    </tbody>
                </table>
                @if ($donaturs->hasPages())
                <div class="bg-white p-3">
                    {{ $donaturs->links('vendor.pagination.tailwind') }}
                </div>
            @endif
            </div>
        </div>
    </div>
</main>

@endsection
