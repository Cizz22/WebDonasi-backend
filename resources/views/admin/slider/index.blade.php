@extends('layouts.app', ['title' => 'Slider - Page Admin'])



@section('content')

<main class="overflow-x-hidden overflow-y-auto flex-1 bg-gray-300">
    <div class="container py-6 px-8 mx-auto">
        <div class="bg-white rounded-md shadow-md p-6">
            <h2 class="text-gray-600 font-bold text-lg capitalize">UPLOAD SLIDER</h2>
            <hr class="mt-4">

            <form action="{{ route('admin.slider.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label class="block mt-3" for="">
                    <span class="text-gray-700 font-semibold">IMAGE</span>
                    <input type="file" name="image" class="bg-gray-100 outline-none form-input mt-1 block w-full rounded-md focus:bg-white p-3" id="">
                    @error('image')
                        <div class="w-full bg-red-300 shadow-md rounded-md overflow-hidden mt-2">
                            <div class="px-4 py-2">
                                <p class="text-gray-600 text-sm">{{$message}}</p>
                            </div>
                        </div>
                    @enderror
                </label>
                <label class="block mt-3" for="">
                    <span class="text-gray-700 font-semibold">LINK</span>
                    <input type="text" name="link" class="bg-gray-100 outline-none form-input mt-1 block w-full rounded-md focus:bg-white" id="">
                    @error('link')
                        <div class="w-full bg-red-300 shadow-md rounded-md overflow-hidden mt-2">
                            <div class="px-4 py-2">
                                <p class="text-gray-600 text-sm">{{$message}}</p>
                            </div>
                        </div>
                    @enderror
                </label>
                <div class="mt-3">
                    <button class="rounded-md py-2 px-4 bg-indigo-600 text-white hover:bg-indigo-700" type="submit">UPLOAD</button>
                </div>
            </form>
        </div>

        <div class="mt-8 bg-white rounded-md shadow-md p-6">
            <h2 class="capitalize text-lg text-gray-600 font-bold">SLIDER LIST</h2>
            <hr class="mt-4">

            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto mt-4">
                <div class="inline-block min-w-full shadow-sm rounded-lg overflow-hidden">
                    <table class="min-w-full table-auto">
                        <thead class="justify-between">
                            <tr class="bg-gray-600 w-full">
                                <th class="px-16 py-2">
                                    <span class="text-white">IMAGE</span>
                                </th>
                                <th class="px-16 py-2 text-left">
                                    <span class="text-white">LINK PROMO</span>
                                </th>
                                <th class="px-16 py-2">
                                    <span class="text-white">ACTION</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-200">
                            @forelse($sliders as $slider)
                                <tr class="border bg-white">

                                    <td class="px-16 py-2 flex justify-center">
                                        <img src="{{ $slider->image }}" class="object-fit-cover rounded" style="width: 35%">
                                    </td>
                                    <td class="px-16 py-2">
                                        {{ $slider->link }}
                                    </td>
                                    <td class="px-10 py-2 text-center">
                                        <button id="{{$slider->id}}" onclick="destroy(this.id)" class="bg-red-600 px-4 py-2 rounded shadow-sm text-xs text-white focus:outline-none">HAPUS</button>
                                    </td>
                                </tr>
                            @empty
                                <div class="bg-red-500 text-white text-center p-3 rounded-sm shadow-md">
                                    Data Belum Tersedia!
                                </div>
                            @endforelse
                        </tbody>
                    </table>
                    @if ($sliders->hasPages())
                        <div class="bg-white p-3">
                            {{ $sliders->links('vendor.pagination.tailwind') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    //ajax delete

    function destroy(id) {
            const token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'APAKAH KAMU YAKIN ?',
                text: "INGIN MENGHAPUS DATA INI!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'BATAL',
                confirmButtonText: 'YA, HAPUS!',
            }).then((result) => {
                if (result.isConfirmed) {
                    //ajax delete
                    jQuery.ajax({
                        url: `/admin/slider/${id}`,
                        data: {
                            "id": id,
                            "_token": token
                        },
                        type: 'DELETE',
                        success: function (response) {
                            if (response.status == "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'BERHASIL!',
                                    text: 'DATA BERHASIL DIHAPUS!',
                                    showConfirmButton: false,
                                    timer: 3000
                                }).then(function () {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'GAGAL!',
                                    text: 'DATA GAGAL DIHAPUS!',
                                    showConfirmButton: false,
                                    timer: 3000
                                }).then(function () {
                                    location.reload();
                                });
                            }
                        }
                    });
                }
            })
        }
    </script>

@endsection
