@extends('header')

@section('title','Buat Jadwal')

@section('page')

<style>
    /* Hilangkan outline pada elemen teks dan cegah pemilihan teks */
    p, span, h1, h2, h3, h4, h5, h6, a {
        outline: none;
        user-select: none;
    }
</style>

<div class="flex h-screen">
            {{-- sidebar --}}
  
            <x-side-bar :active="request()->route()->getName()">
              
            </x-side-bar>
          {{-- end sidebar --}}

    {{-- Main Content --}}
    <div id="main-content" class="flex-1 p-8 bg-gray-200 min-h-screen ml-[340px]">
        <div class="bg-white border border-gray-300 rounded-3xl shadow-md p-6">
            <h1 class="text-3xl font-bold mb-6 text-red-400">Pengajuan Jadwal</h1>
            
            <!-- Input Search -->
            <div class="flex justify-between mb-6">
                <input id="searchRuang" type="text" placeholder="Cari Program Studi" class="bg-gray-100 rounded-lg px-4 py-2 w-2/3">
            </div>
            
            <!-- Table Jadwal -->
            <table id="Ruang" class="min-w-full bg-white rounded-lg shadow-md text-center">
                <thead class="bg-red-300">
                    <tr>
                        <th class="py-3 px-4 text-sm font-semibold">No</th>
                        <th class="py-3 px-4 text-sm font-semibold">Program Studi</th>
                        <th class="py-3 px-4 text-sm font-semibold">Jumlah Jadwal</th>
                        <th class="py-3 px-4 text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $jadwal)
                    <tr class="hover:bg-gray-100">
                        <td class="py-3 px-4">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4">{{ $jadwal->prodi }}</td>
                        <td class="py-3 px-4">{{ $jadwal->jadwal_count }}</td>
                        <td class="py-3 px-4">
                            @if ($jadwal->all_pending)
                                <button id="approve-btn-{{ $loop->iteration }}" type="button" 
                                    onclick="approveJadwal('{{ $jadwal->prodi }}')" 
                                    class="text-white bg-[#2ACD7F] px-3 py-2 text-xs font-medium rounded-lg ml-2">Setuju</button>
                                
                                <button id="reject-btn-{{ $loop->iteration }}" type="button" 
                                    onclick="rejectJadwal('{{ $jadwal->prodi }}')" 
                                    class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 shadow-lg px-3 py-2 text-xs font-medium rounded-lg ml-2">Tolak</button>
                                <a type="button" class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 px-3 py-2 text-xs font-medium rounded-lg ml-2" href = "reviewjadwal/{{ $jadwal->prodi }}">
                                    Detail
                                </a>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $jadwal->belumcount }} Jadwal yang Belum Dibuat !</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function approveJadwal(prodi) {
        if(confirm("Are you sure to approve the schedule for " + prodi + "?")) {
            $.ajax({
                url: "{{ route('jadwal.approve') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    prodi: prodi
                },
                success: function(response) {
                    alert(response.message);
                    location.reload(); // Reload the page to reflect changes
                }
            });
        }
    }

    function rejectJadwal(prodi) {
        if(confirm("Are you sure to reject the schedule for " + prodi + "?")) {
            $.ajax({
                url: "{{ route('jadwal.reject') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    prodi: prodi
                },
                success: function(response) {
                    alert(response.message);
                    location.reload(); // Reload the page to reflect changes
                }
            });
        }
    }

    function reviewjadwal(prodi) {
        window.location.href = `reviewjadwal/${prodi}`;
    }
</script>

{{-- datatable  --}}
<script>
    $(document).ready( function () {
        var tableRuang = $('#Ruang').DataTable({
            layout :{
                topStart: null,
                topEnd: null,
                bottomStart: 'pageLength',
                bottomEnd: 'paging'
            }
        });

        $('#searchRuang').keyup(function() {
            tableRuang.search($(this).val()).draw();
        });
    });
</script>
{{-- datatble_end --}}
@endsection
