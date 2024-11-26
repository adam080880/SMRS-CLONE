@extends('header')

@section('title', 'Dashboard Pembimbing Akademik')

@section('page')

<div class="flex h-screen">
  {{-- Sidebar --}}
    @if (!$isPrint)
      <x-side-bar :active="request()->route()->getName()"></x-side-bar>
    @endif
  {{-- End Sidebar --}}

  {{-- Main Content --}}
  <div id="main-content" class="flex-1 p-8 bg-red-300 min-h-screen h-full overflow-auto ml-[360px]">

    <!-- Navbar -->
    @if (!$isPrint)
      <div class="flex-1 bg-white px-[24px] py-[12px] rounded-[20px] mb-[40px] shadow-lg">
        <div class="flex flex-1 gap-[16px] items-center flex-row">
          <div class="flex flex-1 gap-[16px] items-center flex-row">
            <img src="{{ asset('alip.jpg') }}" class="w-[52px] h-[52px] rounded-full" />
            <div class="flex-1 flex flex-col">
              <span class="text-[24px] text-[#101828]">{{$userName}}</span>
              <span class="text-[18px] text-[#101828]">NIM : {{$mahasiswa->nim}}</span>
            </div>
          </div>

          <a href="/logout">
            <button class="rounded-pill bg-red-300 rounded-full px-5 py-2">
              Logout
            </button>
          </a>
        </div>
      </div>
    @endif
    <!-- End Navbar -->

    @if (!$isPrint)
      <div class="flex flex-1 flex-row justify-between items-center mb-[30px]">
        <div class="flex flex-row items-center gap-[20px]">
          <img class="w-[46px] h-[38px]" src="{{ asset('icons/PADashboard/Desktop.png') }}" alt="">
          <span class="text-[24px]">Jadwal Kuliah</span>
        </div>
        <a href="{{route('dashboard')}}">
          <img class="w-[51px] h-[51px]" src="{{ asset('icons/PADashboard/BackSquare.png') }}" alt="">
        </a>
      </div>
    @endif

    <!-- card section menu -->
    <div class="bg-white pb-[20px] rounded-[20px] mb-[40px] shadow-lg flex flex-col flex-1">
      <!-- content start -->
      <div class="px-[24px] w-full overflow-x max-w-full overflow-x-auto" id="main-content-print-jadwal">
        <div id="main-content-print-jadwal-title" class="text-center my-[24px] text-[24px] font-[500]">Jadwal Mahasiswa Semester {{$semester}}</div>

        <table class="table table-auto w-full border border-collapse overflow=x-scroll">
          <thead class="bg-red-400 text-white">
            <tr>
              <th class="border border-collapse px-[2px] py-[12px]">No.</th>
              <th class="border border-collapse px-[2px] py-[12px]">Hari</th>
              <th class="border border-collapse px-[2px] py-[12px] max-w-[100px] text-wrap">Mata Kuliah</th>
              <th class="border border-collapse px-[2px] py-[12px]">Ruang</th>
              <th class="border border-collapse px-[2px] py-[12px]">Waktu</th>
              <th class="border border-collapse px-[2px] py-[12px]">SKS</th>
            </tr>
          </thead>
          <tbody>
            @foreach($mahasiswaIrs as $index => $irs)
              @php
                $hariAndJam = explode(' ', $irs->hari_jam, 2);
              @endphp
              <tr>
                <td class="px-[2px] py-[12px] border border-collapse text-center">{{$index + 1}}.</td>
                <td class="px-[2px] py-[12px] border border-collapse text-center">{{ $hariAndJam[0] }}</td>
                <td class="px-[2px] py-[12px] border border-collapse text-center max-w-[100px] ">{{ $irs->mata_kuliah }}</td>
                <td class="px-[2px] py-[12px] border border-collapse text-center">{{ $irs->ruang }}</td>
                <td class="px-[2px] py-[12px] border border-collapse text-center">{{ str_replace("pukul ", " ", str_replace("-", "s/d", $hariAndJam[1])) }}</td>
                <td class="px-[2px] py-[12px] border border-collapse text-center">{{ $irs->sks }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>

        @if (!$isPrint)  
          <div class="flex items-center justify-center w-full mt-[20px]" id="btn-print-jadwal">
            <button onclick="printJadwal()" class="bg-red-400 text-white px-[12px] py-[16px] font-[500] text-[24px] rounded-[10px]">Print Jadwal Kuliah</button>
          </div>
        @endif
      </div>
      <!-- content end -->
    </div>
    <!-- end cart section menu -->
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

<script>
  const isPrint = +{{$isPrint ? $isPrint : 0}};

  window.onload = function () {
    if (isPrint) {
      window.print();
    }

    resizeSidebar();
  };

  window.onresize = function () {
    resizeSidebar();
  };

  const resizeSidebar = function () {
    if (isPrint) {
      document.querySelector('#main-content').style.marginLeft = `0px`;
    } else {
      const sidebarWidth = document.querySelector('aside')?.clientWidth;
      document.querySelector('#main-content').style.marginLeft = `${(sidebarWidth)}px`;
    }
  };

  const printJadwal = async function () {
    const element = document.getElementById('main-content-print-jadwal');

    document.getElementById('btn-print-jadwal').style.display = 'none';
    document.getElementById('main-content-print-jadwal-title').innerHTML = "Jadwal\xa0Mahasiswa\xa0Semester\xa0{{$semester}}";
  
    const options = {
        margin: 10,
        filename: 'Jadwal Mahasiswa Semester {{ $semester }}.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' }
    };

    await html2pdf().set(options).from(element).save();

    document.getElementById('btn-print-jadwal').style.display = '';
  }
</script>

@endsection