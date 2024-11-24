@extends('header')

@section('title', 'Dashboard Pembimbing Akademik')

@section('page')

<div class="flex h-screen">
  {{-- Sidebar --}}
  <x-side-bar :active="request()->route()->getName()"></x-side-bar>
  {{-- End Sidebar --}}

  {{-- Main Content --}}
  <div id="main-content" class="flex-1 p-8 bg-red-300 min-h-screen h-full overflow-auto ml-[360px]">

    <!-- Navbar -->
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
    <!-- End Navbar -->

    <div class="flex flex-1 flex-row justify-between items-center mb-[30px]">
      <div class="flex flex-row items-center gap-[20px]">
        <img class="w-[46px] h-[38px]" src="{{ asset('icons/PADashboard/Desktop.png') }}" alt="">
        <span class="text-[24px]">Akademik</span>
      </div>
      <a href="{{route('mahasiswa.khs')}}">
        <img class="w-[51px] h-[51px]" src="{{ asset('icons/PADashboard/BackSquare.png') }}" alt="">
      </a>
    </div>

    <!-- card section menu -->
    <div class="bg-white pb-[20px] rounded-[20px] mb-[40px] shadow-lg flex flex-col flex-1">
      <!-- nav card -->
       <div class="flex flex-row items-center justify-stretch" style="border-bottom: 1px solid black;">
        <a href="" class="pt-2 flex-1 text-center">
          <div href="{{route('mahasiswa.irs.create')}}" style="border-bottom: 2px solid #FFF;">
            Buat IRS
          </div>
        </a>
        <a href="{{route('mahasiswa.irs')}}" class="pt-2 flex-1 text-center">
          <div class="" style="border-bottom: 2px solid #FFF;">
            IRS
          </div>
        </a>
        <a href="{{route('mahasiswa.khs')}}" class="pt-2 flex-1 text-center">
          <div class="" style="border-bottom: 6px solid #E0A0A0;">
            KHS
          </div>
        </a>
       </div>
      <!-- end nav card -->

      <!-- content start -->
      <div class="px-[24px] w-full overflow-x max-w-full overflow-x-auto">
        <div class="text-center my-[24px] text-[24px] font-[500]">KHS Mahasiswa Semester {{$mahasiswaIrsSemester->semester}}</div>

        <table class="table table-auto w-full border border-collapse overflow=x-scroll">
          <thead class="bg-red-400 text-white">
            <tr>
              <th class="border border-collapse px-[2px] py-[12px]">No.</th>
              <th class="border border-collapse px-[2px] py-[12px]">Kode</th>
              <th class="border border-collapse px-[2px] py-[12px] max-w-[100px] text-wrap">Mata Kuliah</th>
              <th class="border border-collapse px-[2px] py-[12px]">Kelas</th>
              <th class="border border-collapse px-[2px] py-[12px]">SKS</th>
              <th class="border border-collapse px-[2px] py-[12px]">Nilai Huruf</th>
              <th class="border border-collapse px-[2px] py-[12px]">Bobot</th>
              <th class="border border-collapse px-[2px] py-[12px] max-w-[100px] text-wrap">Nama Dosen</th>
            </tr>
          </thead>
          <tbody>
            @foreach($mahasiswaIrs as $index => $irs)
            <tr>
              <td class="px-[2px] py-[12px] border border-collapse text-center">{{$index + 1}}.</td>
              <td class="px-[2px] py-[12px] border border-collapse text-center">{{ $irs->kode }}</td>
              <td class="px-[2px] py-[12px] border border-collapse max-w-[100px] ">{{ $irs->mata_kuliah }}<br />{{ $irs->hari_jam }}</td>
              <td class="px-[2px] py-[12px] border border-collapse text-center">{{ $irs->kelas }}</td>
              <td class="px-[2px] py-[12px] border border-collapse text-center">{{ $irs->sks }}</td>
              <td class="px-[2px] py-[12px] border border-collapse text-center">-</td>
              <td class="px-[2px] py-[12px] border border-collapse text-center">0</td>
              <td class="px-[2px] py-[12px] border border-collapse max-w-[100px] text-wrap text-center">
                {{ $irs->nama_dosen }}
              </td>
            </tr>
            @endforeach
            <tr>
              <td colSpan="4" class="text-right px-[2px] py-[12px]">
                Total:
              </td>
              <td class="px-[2px] py-[12px] text-center">
                {{$totalSksSemesterIni}}
              </td>
              <td class="px-[2px] py-[12px] text-center"></td>
              <td class="px-[2px] py-[12px] text-center">0</td>
              <td class="px-[2px] py-[12px] text-center">0</td>
            </tr>
          </tbody>
        </table>

        <div class="mb-5"></div>

        <table class="table-auto min-w-[400px]">
          <tbody>
            <tr>
              <td>
                <div>
                  <span>IP. Semester</span><br />
                  <span class="text-[#868686]">0/0</span><br />
                  <span class="text-[#868686]">Total (SKS x Bobot) / Total SKS</span>
                  <div class="mb-4"></div>
                </div>
              </td>
              <td class="align-top">:</td>
              <td class="align-top">0,00</td>
            </tr>
            <tr>
              <td>
                <div>
                  <span>IP. Kumulatif</span><br />
                  <span class="text-[#868686]">281/87</span><br />
                  <span class="text-[#868686]">Total (SKS x Bobot) Terbaik / Total SKS Terbaik</span>
                  <div class="mb-4"></div>
                </div>
              </td>
              <td class="align-top">:</td>
              <td class="align-top">4,00</td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- content end -->
    </div>
    <!-- end cart section menu -->
  </div>
</div>

<script>
  window.onload = function () {
    resizeSidebar();
  };

  window.onresize = function () {
    resizeSidebar();
  };

  const resizeSidebar = function () {
    const sidebarWidth = document.querySelector('aside')?.clientWidth;
    document.querySelector('#main-content').style.marginLeft = `${(sidebarWidth)}px`;
  };
</script>

@endsection