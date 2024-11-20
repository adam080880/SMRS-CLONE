@extends('header')

@section('title', 'Dashboard Pembimbing Akademik')

@section('page')

<div class="flex h-screen">
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

      <!-- Welcome Hero Screen -->
      <div class="flex-1 bg-white flex flex-row items-stretch rounded-[20px] shadow-lg mb-[40px]">
        <div class="flex flex-col flex-1 py-[64px] pl-[40px]">
          <span class="text-[40px] font-[300]">Hello,</span>
          <span class="text-[40px] font-[500] truncate text-wrap">
            {{$userName}}
          </span>
        </div>
        <div class="flex flex-col pl-[20px] relative flex-1">
          <img class="absolute bottom-0 right-0 w-[379px]" src="{{ asset('3d-image.png') }}" />
        </div>
      </div>
      <!-- End Welcome Hero Screen -->

      <!-- Task Board -->
       <div class="flex flex-row justify-start">
        <div class="bg-white px-[24px] py-[12px] pb-[30px] rounded-[20px] mb-[40px] shadow-lg flex flex-col">
          <div class="flex flex-row items-center gap-[16px] mb-[16px]">
            <img src="{{ asset('icons/PADashboard/TaskMenu.png') }}" alt="" class="w-[42px] h-[42px]">
            <span class="text-[24px] font-[500]">Task Board</span>
          </div>

          <a href="{{ route('perwalian.list') }}">
            <div class="min-w-[580px] p-[20px] shadow-md rounded-[20px] hover:shadow-inner">
              <div class="flex flex-row items-center gap-[8px] w-full">
                <div class="flex flex-row items-center flex-1">
                  <img src="{{ asset('icons/PADashboard/Book.png') }}" alt="" class="w-[70px] h-[50px]">
                  <span class="text-[24px] font-[500]">Perwalian</span>
                </div>
                <img src="{{ asset('icons/PADashboard/PlayCircle.png') }}" alt="" class="flex justify-self-end w-[40px] h-[40px]" />
              </div>
            </div>
          </a>

        </div>
       </div>
      <!-- End Task Board -->
    </div>
</div>

<script>
  window.onload = function() {
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
