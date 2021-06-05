@extends('layouts.app', ['title' => 'Create - Page Admin'])

@section('content')

<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
    <div class="mx-auto container py-6 px-8">
            <div class="p-6 bg-white rounded-md shadow-md">
                <div><span class="font-bold text-gray-600 text-2xl">Add Campaign</span></div>
                <hr class="mt-2 mb-4">
                <form action="{{ route('admin.campaign.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label class="block mb-3" for="">
                        <span class="text-gray-700 font-semibold">Campaign Image</span>
                        <input type="file" name="image" class="form-input w-full mt-2 rounded-md bg-gray-100 focus:bg-white p-3" id="">
                        @error('image')
                            <div class="w-full bg-red-300 shadow-md rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{$message}}</p>
                                </div>
                            </div>
                        @enderror
                    </label>

                    <label class="block mb-3" for="">
                        <span class="text-gray-700 font-semibold">Title</span>
                        <input type="text" name="title" class="bg-gray-100 outline-none form-input mt-1 block w-full rounded-md focus:bg-white" id="" value="{{ old('title') }}">
                        @error('title')
                            <div class="w-full bg-red-300 shadow-md rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{$message}}</p>
                                </div>
                            </div>
                        @enderror
                    </label>


                    <label class="block mb-3" for="">
                        <span class="text-gray-700 font-semibold">Description</span>
                        <textarea name="description" class="bg-gray-100 form-input mt-1 p-3 block w-full rounded-md focus:bg-white" id=""></textarea>
                        @error('description')
                        <div class="w-full bg-red-300 shadow-md rounded-md overflow-hidden mt-2">
                            <div class="px-4 py-2">
                                <p class="text-gray-600 text-sm">{{$message}}</p>
                            </div>
                        </div>
                    @enderror
                    </label>

                    <label class="block mb-3" for="">
                        <span class="text-gray-700 font-semibold">Category</span>
                        <select name="category_id" class="bg-gray-100 outline-none form-input mt-1 block w-full rounded-md focus:bg-white" id="">
                            @foreach( $categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="w-full bg-red-300 shadow-md rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{$message}}</p>
                                </div>
                            </div>
                        @enderror
                    </label>

                    <label class="block mb-3" for="">
                        <span class="text-gray-700 font-semibold">Target Donation</span>
                        <input type="text" name="target_donation" class="bg-gray-100 outline-none form-input mt-1 block w-full rounded-md focus:bg-white" id="" value="{{ old('target_donation') }}">
                        @error('target_donation')
                            <div class="w-full bg-red-300 shadow-md rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{$message}}</p>
                                </div>
                            </div>
                        @enderror
                    </label>

                    <label class="block mb-3" for="">
                        <span class="text-gray-700 font-semibold">Max Date</span>
                        <input type="date" name="max_date" class="bg-gray-100 outline-none form-input mt-1 block w-full rounded-md focus:bg-white" id="" value="{{ old('max_date') }}">
                        @error('max_date')
                            <div class="w-full bg-red-300 shadow-md rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{$message}}</p>
                                </div>
                            </div>
                        @enderror
                    </label>
                    <div class="mt-3">
                        <button class="bg-indigo-500 rounded-md px-4 py-2 hover:outline-none text-white">Submit</button>
                    </div>
                </form>
            </div>
    </div>
</main>
<script>
tinymce.init({
    selector: 'textarea',
 });
</script>
@endsection
