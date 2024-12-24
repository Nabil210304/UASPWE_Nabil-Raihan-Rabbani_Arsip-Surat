<div class="relative overflow-x-auto shadow-sm sm:rounded-md">
    <table class="w-full text-sm text-left border rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-base text-gray-700 uppercase bg-gray-300 dark:bg-gray-700 dark:text-gray-400">
            <tr class="text-center">
                <th scope="col" class="px-6 py-3">
                    ID_Kategori
                </th>
                <th scope="col" class="px-6 py-3">
                    Nama Kategori
                </th>
                <th scope="col" class="px-6 py-3">
                    Keterangan
                </th>
                <th scope="col" class="px-6 py-3">
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody class="text-base">
            @foreach ($kategori as $data)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-center">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $loop->iteration }}
                    </th>
                    <td class="px-6 py-4">
                        {{$data->nama_kategori}}
                    </td>
                    <td class="px-6 py-4">
                        {{$data->keterangan}}
                    </td>
                    <td class="px-6 py-4">
                        <div class="inline-flex">
                            <a href="{{ url(Auth::user()->role . '/kategori/edit/' . $data->id_kategori) }}"
                                class="flex items-center focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg px-3 me-2 my-1 py-1.5 dark:focus:ring-yellow-900">
                                 <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                 </svg>
                                 <span class="flex-1 ms-1">Edit</span>
                             </a>
                            <button data-modal-target="delete_kategori_{{ $data->id_kategori }}" data-modal-toggle="delete_kategori_{{ $data->id_kategori }}" class="flex items-center focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg px-3 me-2 my-1 py-1.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" type="button">
                                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                </svg>
                                <span class="flex-1 ms-1">Hapus</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @include('kategori.delete')
            @endforeach
        </tbody>
    </table>
</div>
<div class="py-4">
    {{ $kategori->links() }}
</div>
