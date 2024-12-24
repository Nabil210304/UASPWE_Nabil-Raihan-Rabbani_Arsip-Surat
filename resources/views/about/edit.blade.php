@extends('layouts.master')

@section('content')

<div class="p-4 sm:ml-64">
    <div class="p-4 mt-14">
        <div class="container">
            <!-- Breadcrumb -->
            <nav class="flex px-5 py-3 mb-2 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ url(Auth::user()->role.'/home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 block w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="{{ url(Auth::user()->role.'/about') }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">About</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 block w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Edit Profil</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Form Container -->
            <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <div class="border-b border-gray-200 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-bold dark:text-white ms-4">Edit Profil</h3>
                        <a href="{{ url(Auth::user()->role . '/about')  }}" class="flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5 me-4 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            <svg class="w-[24px] h-[24px] dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
                            </svg>
                            <span class="flex-1 ms-1 whitespace-nowrap">Kembali</span>
                        </a>
                    </div>
                </div>
                <div id="defaultTabContent">
                    <form action="{{ url(Auth::user()->role . '/about/update/' . $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mx-10 my-5">
                            <div class="mb-4">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama<span class="text-red-600">*</span></label>
                                <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan Nama" value="{{ old('name', $user->name) }}" required />
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</span></p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="prodi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Program Studi<span class="text-red-600">*</span></label>
                                <input type="text" name="prodi" id="prodi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan Program Studi" value="{{ old('prodi', $user->prodi) }}" required />
                                @error('prodi')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</span></p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="nim" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIM<span class="text-red-600">*</span></label>
                                <input type="text" name="nim" id="nim" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan NIM" value="{{ old('nim', $user->nim) }}" required />
                                @error('nim')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</span></p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="birth_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Lahir<span class="text-red-600">*</span></label>
                                <input type="date" name="birth_date" id="birth_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ old('birth_date', $user->birth_date) }}" required />
                                @error('birth_date')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</span></p>
                                @enderror
                            </div>
                            <!-- Input Foto Profil -->
                            <div class="mb-4">
                                <label for="profile_picture" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Foto Profil<span class="text-red-600">*</span>
                                </label>
                                <input type="file" name="profile_picture" id="profile_picture" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required />
                                <img id="preview" class="mt-4" style="width: 200px; height: 200px;" alt="Preview Foto" hidden>
                            </div>

                            <!-- Cropper Container (hidden initially) -->
                            <div id="crop-container" class="max-w-[200px] max-h-[200px] mx-auto overflow-hidden border border-gray-300 bg-gray-50 rounded-lg p-2" hidden>
                                <img id="crop-image" class="mt-4" style="width: 400px; height: 400px; border-radius: 50%;" alt="Gambar untuk dipotong">
                                <button type="button" id="crop-button" class="mt-4 w-full bg-green-500 text-white font-medium py-1.5 text-sm rounded hover:bg-green-600">
                                    Potong Gambar
                                </button>
                            </div>

                            <button type="submit" class="mt-4 bg-green-500 text-white p-2 rounded" id="submit-button" disabled>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">

<script>
    const profileInput = document.getElementById('profile_picture');
    const preview = document.getElementById('preview');
    const cropImage = document.getElementById('crop-image');
    const cropButton = document.getElementById('crop-button');
    const cropContainer = document.getElementById('crop-container');
    const submitButton = document.getElementById('submit-button');
    let cropper;

    // Saat file diunggah
    profileInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
                cropImage.src = e.target.result;

                // Tampilkan preview dan crop container
                preview.hidden = false;
                cropContainer.hidden = false;

                // Inisialisasi ulang Cropper jika sudah ada
                if (cropper) cropper.destroy();
                cropper = new Cropper(cropImage, { aspectRatio: 1 }); // Rasio 1:1
            };
            reader.readAsDataURL(file);
        }
    });

    // Saat tombol crop ditekan
    cropButton.addEventListener('click', () => {
        if (cropper) {
            const canvas = cropper.getCroppedCanvas({
                width: 300, // Ukuran hasil crop (lebar)
                height: 300 // Ukuran hasil crop (tinggi)
            });

            // Ubah hasil crop ke blob dan tambahkan ke input
            canvas.toBlob((blob) => {
                const file = new File([blob], 'cropped-profile-picture.jpg', { type: 'image/jpeg' });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                profileInput.files = dataTransfer.files;

                // Update preview
                preview.src = canvas.toDataURL();

                // Aktifkan tombol simpan setelah crop selesai
                submitButton.disabled = false;
            });
        }
    });
</script>

@endsection
