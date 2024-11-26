@extends('header')

@section('title', 'Dashboard Pembimbing Akademik')

@section('page')

<div class="flex h-auto">
    {{-- Sidebar --}}
    <x-side-bar :active="request()->route()->getName()"></x-side-bar>
    {{-- End Sidebar --}}

    {{-- Main Content --}}
    <div id="main-content" class="flex-1 p-8 bg-red-300 min-h-screen ml-[360px]">

      <!-- Navbar -->
      <div class="flex-1 bg-white px-[24px] py-[12px] rounded-[20px] mb-[40px] shadow-lg">
        <div class="flex flex-1 gap-[16px] items-center flex-row">
          <div class="flex flex-1 gap-[16px] items-center flex-row">
            <img src="{{ asset('alip.jpg') }}" class="w-[52px] h-[52px] rounded-full" />
            <div class="flex-1 flex flex-col">
              <span class="text-[24px] text-[#101828]">{{$userName}}</span>
              <span class="text-[18px] text-[#101828]">NIP : {{ $dosen->nip }}</span>
            </div>
          </div>

          <a href="/logout">
            <button class="rounded-pill bg-red-300 rounded-full px-5 py-2">
              Logout
            </button>
          </a>
        </div>
      </div>
      <!-- End Navbar -->

      <div class="flex flex-1 flex-row justify-between items-center mb-[30px]">
        <div class="flex flex-row items-center gap-[20px]">
          <img class="w-[46px] h-[38px]" src="{{ asset('icons/PADashboard/Desktop.png') }}" alt="">
          <span class="text-[24px]">Perwalian</span>
        </div>
        <a href="/perwalian">
          <img class="w-[51px] h-[51px]" src="{{ asset('icons/PADashboard/BackSquare.png') }}" alt="">
        </a>
      </div>

      <div class="rounded-[20px] p-[25px] pb-[38px] bg-white shadow-lg">
        <span class="text-[30px]">Detail IRS</span>

        <div class="mb-[20px] mt-[10px]">
          <table>
            <tr>
              <td><span class="text-[18px] font-[500]">Nama</span></td>
              <td><span class="text-[18px] font-[500] px-1">:</span></td>
              <td><span class="text-[18px] font-[500]">{{$mahasiswa->nama}}</span></td>
            </tr>
            <tr>
              <td><span class="text-[18px] font-[500]">NIM</span></td>
              <td><span class="text-[18px] font-[500] px-1">:</span></td>
              <td><span class="text-[18px] font-[500]">{{$mahasiswa->nim}}</span></td>
            </tr>
          </table>
        </div>

        <table id="Perwalian" class="table-auto min-w-full bg-white shadow-md mt-[20px] rounded-none border-collapse border-[2px] border-[#000]">
          <thead class="bg-red-300">
            <tr>
              <th class="py-3 px-4 text-center text-sm font-semibold border-collapse border-[2px] border-[#000]">No.</th>
              <th class="py-3 px-4 text-center text-sm font-semibold border-collapse border-[2px] border-[#000]">Hari</th>
              <th class="py-3 px-4 text-center text-sm font-semibold border-collapse border-[2px] border-[#000]">Nama Mata Kuliah</th>
              <th class="py-3 px-4 text-center text-sm font-semibold border-collapse border-[2px] border-[#000]">Ruangan</th>
              <th class="py-3 px-4 text-center text-sm font-semibold border-collapse border-[2px] border-[#000]">Waktu</th>
              <th class="py-3 px-4 text-center text-sm font-semibold border-collapse border-[2px] border-[#000]">SKS</th>
            </tr>
          </thead>
          <tbody>
            @php($i = 0)
            @foreach ($mahasiswaIrsTerpilih as $irs)
              <tr>
                <td class="py-3 px-4 text-center border-collapse border-[2px] border-[#000]">{{++$i}}.</td>
                <td class="py-3 px-4 text-center border-collapse border-[2px] border-[#000]">{{explode(' ', trim($irs->hari_jam))[0]}}</td>
                <td class="py-3 px-4 text-center border-collapse border-[2px] border-[#000]">{{$irs->mata_kuliah}}</td>
                <td class="py-3 px-4 text-center border-collapse border-[2px] border-[#000]">{{$irs->kode}}</td>
                <td class="py-3 px-4 text-center border-collapse border-[2px] border-[#000]">{{str_replace("-", "s/d", explode(' ', trim($irs->hari_jam), 3)[2])}}</td>
                <td class="py-3 px-4 text-center border-collapse border-[2px] border-[#000]">{{$irs->sks}}</td>
              </tr>
            @endforeach
          </tbody>
        </table>

        @if ($mahasiswa->status_pengajuan !== 'Approved' && $mahasiswa->status_pengajuan !== null)
          <div class="w-full flex flex-row mt-[30px]">
            <div class="flex-1 flex justify-center items-center">
              <button class="rounded-[10px] w-[230px] h-[50px] bg-[#FFAAAA] text-[#922929]" onclick="reject()">Reject</button>
            </div>
            <div class="flex-1 flex justify-center items-center" onclick="approve()">
              <button class="rounded-[10px] w-[230px] h-[50px] bg-[#AAFFCC] text-[#299233]">Accept</button>
            </div>
          </div>
        @endif
      </div>
    </div>
</div>

<script>
  window.onload = function() {
    resizeSidebar();

    const tableRuang = $('#Perwalian').DataTable({
        layout: {
            topStart: null,
            topEnd: null,
            bottomStart: 'pageLength',
            bottomEnd: 'paging',
        }
    });

    $('#searchRuang').keyup(function() {
        tableRuang.search($(this).val()).draw();
    });
  };

  window.onresize = function () {
    resizeSidebar();
  };

  const resizeSidebar = function () {
    const sidebarWidth = document.querySelector('aside')?.clientWidth;
    document.querySelector('#main-content').style.marginLeft = `${(sidebarWidth)}px`;
  };

  const approve = async function () {
    if (!window.confirm('Apakah Anda yakin approve irs ini?')) {
      return;
    }

    const payload = {
      _token: "{{csrf_token()}}"
    };

    const response = await fetch("{{ route('api.pa.irs.approve', ['nim' => $mahasiswa->nim ]) }}", {
      method: 'POST',
      body: JSON.stringify(payload),
      headers: {
        'Content-Type': 'application/json', // Konten yang dikirim dalam format JSON
      },
    });

    if (response.ok) {
      alert('Berhasil approve irs');

      window.location.href = "{{route('perwalian.list')}}";
    } else {
      alert('Server Error');
    }
  }

  const reject = async function () {
    if (!window.confirm('Apakah Anda yakin reject irs ini?')) {
      return;
    }

    const payload = {
      _token: "{{csrf_token()}}"
    };

    const response = await fetch("{{ route('api.pa.irs.reject', ['nim' => $mahasiswa->nim ]) }}", {
      method: 'POST',
      body: JSON.stringify(payload),
      headers: {
        'Content-Type': 'application/json', // Konten yang dikirim dalam format JSON
      },
    });

    if (response.ok) {
      alert('Berhasil reject irs');

      window.location.href = "{{route('perwalian.list')}}";
    } else {
      alert('Server Error');
    }
  }
</script>

@endsection
