@extends('header')

@section('title', 'Plot Ruang')

@section('page')

<div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <x-side-bar :active="request()->route()->getName()"></x-side-bar>

    {{-- Main Content --}}
    <div id="main-content" class="w-4/5 bg-red-300 p-8 overflow-y-auto h-screen ml-[20%]">
        <div class="px-8 py-8">
            <div class="bg-white border border-gray-200 rounded-3xl shadow-sm sm:p-6">
                <div class="flex justify-between mb-4">
                    
                    {{-- Dropdown Pilih Prodi --}}
                    <button id="dropdownDefaultButton" data-dropdown-toggle="dropdownProdi" class="text-white bg-red-400 hover:bg-red-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center" type="button">
                        {{ $prodi!=''?$prodi:'Pilih Prodi' }}
                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    
                    {{-- Dropdown Pilihan Program Studi --}}
                    <div id="dropdownProdi" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" data-prodi="Informatika">Informatika</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" data-prodi="Matematika">Matematika</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" data-prodi="Statistika">Statistika</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" data-prodi="Biologi">Biologi</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" data-prodi="Kimia">Kimia</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" data-prodi="Fisika">Fisika</a></li>
                        </ul>
                    </div>
                </div>

                {{-- Tabel Plot Ruang --}}
                <table id="plotRuang" class="min-w-full bg-white rounded-lg shadow-md overflow-hidden">
                    <thead class="bg-red-400 text-white">
                        <tr>
                            <th class="py-3 px-4 text-left text-sm font-semibold">No</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold">No Ruang</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold">Blok Gedung</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold">Lantai</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold">Fungsi</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold">Kapasitas</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold">Status</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-50 divide-y divide-gray-200">
                        @foreach ($data as $ruang)
                        <tr class="hover:bg-gray-100 transition duration-150 ease-in-out">
                            <td class="py-3 px-4">{{ $loop->iteration }}</td>
                            <td class="py-3 px-4">{{ $ruang->noruang }}</td>
                            <td class="py-3 px-4">{{ $ruang->blokgedung }}</td>
                            <td class="py-3 px-4">{{ $ruang->lantai }}</td>
                            <td class="py-3 px-4">{{ $ruang->fungsi }}</td>
                            <td class="py-3 px-4">{{ $ruang->kapasitas }}</td>
                            <td class="py-3 px-4">
                                <span class="{{ 
                                    $ruang->status == 'Pending' ? 'bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full' : 
                                    ($ruang->status == 'Disetujui' ? 'bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full' : 'bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full') }}">
                                    {{ $ruang->status }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <button type="button" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg px-3 py-2 text-xs font-medium text-center rounded-lg delete-btn" data-id="{{ $ruang->id }}">
                                    Delete
                                </button>
                                <form id="delete-form-{{ $ruang->id }}" action="plotruang/{{ $ruang->id }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- DataTables Script --}}
    <script>
        $(document).ready( function () {
            var tableRuang = $('#plotRuang').DataTable({
                pageLength: 10,
                "columnDefs": [
                    { className: "dt-head-center", "targets": [0, 1, 2, 3, 4, 5, 6, 7] },
                    { className: "dt-body-center", "targets": [0, 1, 2, 3, 4, 5, 6, 7] }
                ],
            });

            $('#searchRuang').on('keyup', function() {
                tableRuang.search($(this).val()).draw();
            });

            // Dropdown menu
            $('#dropdownProdi a').click(function (e) {
                e.preventDefault();
                var prodi = $(this).data('prodi'); 

                $('#dropdownDefaultButton').text(prodi);
                $('#dropdownDefaultButton').append(`
                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                `);

                const dropdownButton = document.getElementById('dropdownDefaultButton');
                dropdownButton.click();

                // Send AJAX request to controller
                $.ajax({
                    url: '/prodi',
                    method: 'GET',
                    data: { prodi: prodi },
                    success: function (response) {
                        tableRuang.clear().draw();

                        response.data.forEach(function (ruang, index) {
                            tableRuang.row.add([
                                index + 1, 
                                ruang.noruang,
                                ruang.blokgedung,
                                ruang.lantai,
                                ruang.fungsi,
                                ruang.kapasitas,
                                `<span class="${
                                    ruang.status == 'Pending' ? 'bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full' :
                                    ruang.status == 'Disetujui' ? 'bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full' : 'bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full'
                                }">${ruang.status}</span>`,
                                `<button type="button" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg px-3 py-2 text-xs font-medium text-center rounded-lg delete-btn" data-id="${ruang.id}">
                                    Delete
                                </button>
                                <form id="delete-form-${ruang.id}" action="plotruang/${ruang.id}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>`
                            ]).draw(false);
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching data:', error);
                    }
                });
            });

            // Event delegation for delete confirmation
            $(document).on('click', '.delete-btn', function() {
                var ruangId = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#delete-form-' + ruangId).submit();
                    }
                });
            });
        });
    </script>
@endsection
