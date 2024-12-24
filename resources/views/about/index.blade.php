@extends('layouts.master')

@section('content')
<div class="p-4 sm:ml-64">
    <div class="p-4 mt-14">
        <div class="container">
            <nav class="flex px-5 py-3 mb-2 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li>
                        <a href="{{ url(Auth::user()->role . '/home') }}" class="text-sm font-medium hover:text-blue-600">
                            Home
                        </a>
                    </li>
                </ol>
            </nav>
            @if (Session::has('success'))
            <div id="toast-success" class="flex items-center w-full p-3 my-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                    </svg>
                    <span class="sr-only">Check icon</span>
                </div>
                <div class="ms-3 text-sm font-normal">{{ Session::get('success') }}</div>
                <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-success" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
            @endif

            <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <div class="border-b border-gray-200 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-bold dark:text-white ms-4">Profil Pengguna</h3>
                    </div>
                </div>
                <div id="defaultTabContent">
                    @foreach ($users as $data)
                    <div class="flex flex-col md:flex-row justify-center items-center md:max-w-xl my-4 mx-auto gap-6">
                      <!-- Foto Profil (Div Terpisah) -->
                      <div class="flex flex-col justify-center items-center mt-4">
                        <img
                            class="rounded-full object-cover mb-4 w-32 h-32 sm:w-48 sm:h-48 md:w-96 md:h-96"
                            src="{{ $data->profile_picture ? asset('images/' . $data->profile_picture) : asset('image/2231730144.jpg') }}"
                            alt="Foto Profil">
                    </div>

                        <div class="flex flex-col md:ml-6 w-full md:w-auto">
                            <div class="mb-4">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                                <div class="w-full bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400" disabled>
                                    {{ $data->name }}
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block my-2 text-sm font-medium text-gray-900 dark:text-white">Prodi</label>
                                <div class="w-full bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400" disabled>
                                    {{ $data->prodi }}
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block my-2 text-sm font-medium text-gray-900 dark:text-white">NIM</label>
                                <div class="w-full bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400" disabled>
                                    {{ $data->nim }}
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block my-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Lahir</label>
                                <div class="w-full bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400" disabled>
                                    {{ \Carbon\Carbon::parse($data->birth_date)->format('d F Y') }}
                                </div>
                            </div>

                            <div>
                                <p class="text-lg text-gray-700">Selamat datang di halaman utama!</p>

                                <!-- Tombol Edit Profil untuk light mode -->
                                <a href="{{  url(Auth::user()->role . '/about/edit/' . $data->id)  }}"
                                   class="mt-4 inline-flex items-center px-4 py-2 text-sm font-medium text-black bg-gray-200 rounded-lg transform transition-transform duration-200 ease-in-out
                                          hover:scale-105 hover:bg-black hover:text-white focus:ring-4 focus:ring-gray-400">
                                    Edit Profil
                                </a>
                            </div>

                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
