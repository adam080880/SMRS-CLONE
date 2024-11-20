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
              <span class="text-[24px] text-[#101828]">Mochammad Qaynan Mahdaviqya</span>
              <span class="text-[18px] text-[#101828]">NIP : 24060122140170</span>
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

        <div class="mb-[30px]">
          <table>
            <tr>
              <td><span class="text-[18px] font-[500]">Nama</span></td>
              <td><span class="text-[18px] font-[500] px-1">:</span></td>
              <td><span class="text-[18px] font-[500]">Thoriz</span></td>
            </tr>
            <tr>
              <td><span class="text-[18px] font-[500]">NIM</span></td>
              <td><span class="text-[18px] font-[500] px-1">:</span></td>
              <td><span class="text-[18px] font-[500]">1231232112</span></td>
            </tr>
            <tr>
              <td><span class="text-[18px] font-[500]">Pembimbing Akademik</span></td>
              <td><span class="text-[18px] font-[500] px-1">:</span></td>
              <td><span class="text-[18px] font-[500]">Test aja sih ini, S.d</span></td>
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
            <tr>
              <td class="py-3 px-4 text-center border-collapse border-[2px] border-[#000]">1.</td>
              <td class="py-3 px-4 text-center border-collapse border-[2px] border-[#000]">Senin</td>
              <td class="py-3 px-4 text-center border-collapse border-[2px] border-[#000]">Pengembangan Database</td>
              <td class="py-3 px-4 text-center border-collapse border-[2px] border-[#000]">E101</td>
              <td class="py-3 px-4 text-center border-collapse border-[2px] border-[#000]">13:00 s/d 16:20</td>
              <td class="py-3 px-4 text-center border-collapse border-[2px] border-[#000]">2.0</td>
            </tr>
            <tr>
              <td class="py-3 px-4 text-center border-collapse border-[2px] border-[#000]">2.</td>
              <td class="py-3 px-4 text-center border-collapse border-[2px] border-[#000]">Selasa</td>
              <td class="py-3 px-4 text-center border-collapse border-[2px] border-[#000]">Olahraga</td>
              <td class="py-3 px-4 text-center border-collapse border-[2px] border-[#000]">E102</td>
              <td class="py-3 px-4 text-center border-collapse border-[2px] border-[#000]">15:00 s/d 16:20</td>
              <td class="py-3 px-4 text-center border-collapse border-[2px] border-[#000]">2.0</td>
            </tr>
          </tbody>
        </table>
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
</script>

@endsection
