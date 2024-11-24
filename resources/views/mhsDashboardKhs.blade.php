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
      <a href="/dashboard">
        <img class="w-[51px] h-[51px]" src="{{ asset('icons/PADashboard/BackSquare.png') }}" alt="">
      </a>
    </div>

    <!-- card section menu -->
    <div class="bg-white pb-[20px] rounded-[20px] mb-[40px] shadow-lg flex flex-col flex-1">
      <!-- nav card -->
       <div class="flex flex-row items-center justify-stretch" style="border-bottom: 1px solid black;">
        <a href="{{route('mahasiswa.irs.create')}}" class="pt-2 flex-1 text-center">
          <div class="" style="border-bottom: 2px solid #FFF;">
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
      <div class="px-[24px] w-full">
        <div class="text-center my-[24px] text-[24px] font-[500]">Kartu Hasil Studi (KHS)</div>

        <table class="table table-fixed w-full">
          <tbody>
            @foreach ($mahasiswaSksBySemester as $mahasiswaSks)
            <tr class="border border-collapse border-x-0">
              <td>
                <div class="flex flex-row items-center">
                  <div class="flex-1 flex flex-col px-[4px] py-[20px]">
                    <span class="font-[500] text-[24px]">Semester {{$mahasiswaSks->semester}}</span>
                    <span class="font-[400] text-[22px]">Jumlah SKS {{$mahasiswaSks->sum_sks}}</span>
                  </div>
                  <a href="{{route('mahasiswa.khs.detail', $mahasiswaSks->semester)}}">
                    <button class="text-[20px] font-[500] p-[5px] px-[10px] bg-[#FCA6A6] rounded-[20px]">See Details</button>
                  </a>
                </div>
              </td>
            </tr>
            @endforeach
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