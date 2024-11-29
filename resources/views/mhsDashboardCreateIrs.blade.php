@extends('header')

@section('title', 'Dashboard Pembimbing Akademik')

@section('page')
<div class="flex h-auto overflow-auto">
  {{-- Sidebar --}}
  <x-side-bar :active="request()->route()->getName()"></x-side-bar>
  {{-- End Sidebar --}}

  {{-- Main Content --}}
  <div id="main-content" class="flex-1 p-8 bg-red-300 h-auto overflow-x-auto min-h-screen">

    <!-- Navbar -->
    <div class="flex-1 bg-white px-[24px] py-[12px] rounded-[20px] mb-[40px] shadow-lg h-auto">
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

    <div class="bg-white pb-[20px] rounded-[20px] shadow-lg flex flex-col flex-1 h-auto">
      <!-- nav card -->
      <div class="flex flex-row items-center justify-stretch" style="border-bottom: 1px solid black;">
        <a href="{{route('mahasiswa.irs.create')}}" class="pt-2 flex-1 text-center">
          <div class="" style="border-bottom: 6px solid #E0A0A0;">
            Buat IRS
          </div>
        </a>
        <a href="{{route('mahasiswa.irs')}}" class="pt-2 flex-1 text-center">
          <div class="" style="border-bottom: 2px solid #FFF;">
            IRS
          </div>
        </a>
        <a href="{{route('mahasiswa.khs')}}" class="pt-2 flex-1 text-center">
          <div class="" style="border-bottom: 2px solid #FFF;">
            KHS
          </div>
        </a>
      </div>
      <!-- end nav card -->

      <!-- content start -->
      <div class="px-[24px] flex flex-row w-full flex-1 gap-[16px]">
        <div class="w-[30%] flex flex-col py-[12px] gap-[16px]">
          <div class="flex flex-1 flex-col gap-[12px] bg-[#EBEBEB] p-[12px] w-full rounded-[8px]">
            <span class="text-[#7E7E7E] text-[16px]">Mata Kuliah</span>

            <button data-modal-target="default-modal" data-modal-toggle="default-modal"
              class="block text-[#7E7E7E] bg-white hover:bg-[#cacaca] font-medium rounded-lg text-sm px-5 py-2.5 text-center"
              type="button">
              Pilih Mata Kuliah
            </button>

            <span class="text-[#7E7E7E] text-[16px] pb-[3px] border-[1px] border-x-0 border-t-0 border-[#7E7E7E]">Mata Kuliah Terpilih</span>

            <div id="render-selected-irs" class="flex flex-col gap-[8px]">

            </div>
          </div>

          <div class="bg-[#EBEBEB] p-[12px] rounded-[8px] shadow-lg flex flex-col">
            <table class="table-fixed w-full">
              <tr>
                <td>
                  <div class="flex flex-col items-center justify-center gap-[8px]">
                    <span class="text-[14px] text-gray-500 font-[500] text-center">Semester</span>
                    <span class="text-[18px] font-[500] text-center">{{$mahasiswa->semester_berjalan}}</span>
                  </div>
                </td>
                <td>
                  <div
                    class="flex flex-col items-center justify-center gap-[8px] border-[black] border-[1px] border-collapse border-t-0 border-b-0">
                    <span class="text-[14px] text-gray-500 font-[500] text-center">IPK</span>
                    <span class="text-[18px] font-[500] text-center">{{$ipkAndSksk->ipk}}</span>
                  </div>
                </td>
                <td>
                  <div class="flex flex-col items-center justify-center gap-[8px]">
                    <span class="text-[14px] text-gray-500 font-[500] text-center">SKSk</span>
                    <span class="text-[18px] font-[500] text-center">{{$ipkAndSksk->totalSksTelahDiambil}}</span>
                  </div>
                </td>
              </tr>

              <tr>
                <td colSpan="3">
                  <div class="flex flex-col items-center justify-center gap-[8px] pt-[16px]">
                    <span class="text-[14px] text-gray-500 font-[500] text-center">Maks Beban SKS</span>
                    <span class="text-[18px] font-[500] text-center">{{$ips->maxBebanSksYangDapatDiambil}}</span>
                  </div>
                </td>
              </tr>
            </table>
          </div>

            <button onclick="submitIrs()" class="block text-[black] bg-red-300 hover:bg-[#cacaca] font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
              Simpan IRS
            </button>
        </div>

        <div class="flex flex-1 py-[12px] gap-[16px] flex-col overflow-auto max-w-full">
          <!-- Header -->
          <div class="bg-[#EBEBEB] py-[12px] rounded-[15px] justify-center items-center text-center w-full sticky left-0">
            <span class="text-[24px] font-bold text-center">JADWAL</span>
          </div>

          <!-- Tabel Scrollable -->
          <table class="table table-fixed border-collapse border border-[black] w-full overflow-auto">
            <thead class="bg-[#E0A0A0]">
              <tr>
                <th class="border border-[black] w-[200px] h-[93px] px-4 py-2 text-center">Senin</th>
                <th class="border border-[black] w-[200px] h-[93px] px-4 py-2 text-center">Selasa</th>
                <th class="border border-[black] w-[200px] h-[93px] px-4 py-2 text-center">Rabu</th>
                <th class="border border-[black] w-[200px] h-[93px] px-4 py-2 text-center">Kamis</th>
                <th class="border border-[black] w-[200px] h-[93px] px-4 py-2 text-center">Jum'at</th>
                <th class="border border-[black] w-[200px] h-[93px] px-4 py-2 text-center">Sabtu</th>
                <th class="border border-[black] w-[200px] h-[93px] px-4 py-2 text-center">Minggu</th>
              </tr>
            </thead>
            <tbody id="tbody-schedule">
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Main modal -->
<div id="default-modal" tabindex="-1" aria-hidden="true"
  class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
  <div class="relative p-4 w-full max-w-2xl max-h-full">
    <!-- Modal content -->
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
      <!-- Modal header -->
      <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
          Pilih Mata Kuliah
        </h3>
        <button type="button"
          class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
          data-modal-hide="default-modal">
          <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
          </svg>
          <span class="sr-only">Close modal</span>
        </button>
      </div>
      <!-- Modal body -->
      <div class="p-4">
        <div class="flex flex-col h-[400px] overflow-auto w-100" id="irsListOption">
          @foreach ($irsTersedia as $irs)
          <div class="flex flex-row items-center py-[8px] px-[4px]">
            <input type="checkbox" id="option-{{$irs->kodemk}}" name="{{$irs->kodemk}}" class="select-irs"
              value="{{$irs->kodemk}}" />

            <label class="pl-[12px] w-full" for="option-{{$irs->kodemk}}">
              <span class="text-[12px] text-gray-400">{{$irs->kodemk}} - Ruang {{$irs->ruang}} - {{$irs->hari_jam}} -
                <span class="font-semibold">Semester {{$irs->semester}} ({{$irs->sks}} SKS)</span></span><br />
              <span class="text-black font-semibold">{{$irs->nama}}</span><br />
              <span>{{$irs->nama_dosen}}</span><br />
            </label>
          </div>
          @endforeach
        </div>
      </div>
      <!-- Modal footer -->
      <div class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
        <button onclick="submitChooseIrs()" data-modal-hide="default-modal" type="button"
          class="text-white bg-gray-800 hover:bg-gray-500 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center">Pilih</button>
      </div>
    </div>
  </div>
</div>

<script>
  const maxSks = {{$ips->maxBebanSksYangDapatDiambil}};
  const availIrsOptions = @json($irsTersedia);
  let selectedIrsOptionsRaw = @json($irsTerpilih);
  let selectedIrsOptions = @json($irsTerpilih);

  window.onload = function () {
    if (selectedIrsOptionsRaw.length > 0) {
      renderSelectedIrsRaw(selectedIrsOptionsRaw);
    }

    resizeSidebar();
  };

  window.onresize = function () {
    resizeSidebar();
  };

  const resizeSidebar = function () {
    const sidebarWidth = document.querySelector('aside')?.clientWidth;
    document.querySelector('#main-content').style.marginLeft = `${(sidebarWidth)}px`;
  };

  const deleteSelectedIrs = function(kode) {
    selectedIrsOptionsRaw = selectedIrsOptionsRaw.filter((selectedIrsOption) => selectedIrsOption.kodemk !== kode);
    selectedIrsOptions = selectedIrsOptions.filter((selectedIrsOption) => selectedIrsOption.kodemk !== kode);

    renderSelectedIrsRaw(selectedIrsOptionsRaw);
  }

  const handleConfirmIrs = function(kodeIrs) {
    const irs = availIrsOptions.find((irs) => irs.kode === kodeIrs);

    selectedIrsOptions.push(irs);
    renderSelectedIrsRaw(selectedIrsOptionsRaw);
  }

  const renderSelectedIrsRaw = function (selectedIrs = selectedIrsOptionsRaw) {
    const selectIrs = document.querySelectorAll('.select-irs');

    selectIrs.forEach((v) => {
      if (selectedIrs.map((irs) => irs.kode).includes(v.value)) {
        v.checked = true;
      } else {
        v.checked = false;
      }
    });

    document.getElementById('render-selected-irs').innerHTML = selectedIrs.map((irs) => `
      <div class="flex flex-row items-center">
        <button type="button" onclick="deleteSelectedIrs('${irs.kodemk}')" class="mr-[10px] text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
          <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
          </svg>
          <span class="sr-only">Close modal</span>
        </button>
        <label class="w-full">
          <span class="text-[12px] text-gray-400">${irs.kodemk} - Ruang ${irs.ruang} - ${irs.hari_jam} Semester ${irs.semester} (${irs.sks} SKS)</span><br />
          <span class="text-black font-semibold">${irs.nama}</span><br />
          <span>${irs.nama_dosen}</span><br />
        </label>
      </div>
    `).join('');

    document.getElementById('tbody-schedule').innerHTML = selectedIrs.map((irs) => {
      const [hari, pukul, jam_dari, jam_, jam_ke] = (irs.hari_jam).split(' ');

      const renderCard = (reserveHari) => {
        const choosed = selectedIrsOptions.find((findIrs) => findIrs.kode === irs.kode);
        const isFull = irs.terisi >= irs.kapasitas;

        const bgColor = isFull ? 'bg-[#FF6161]' : (choosed ? 'bg-[#AAFFCC]' : 'bg-[#F5F5F5]');

        return reserveHari.toLowerCase() === hari.toLowerCase() ? `<td class="border border-[black] w-[200px] h-[93px] px-4 py-2">
          <div class="flex flex-col w-full h-full ${bgColor} rounded-[12px] border border-[black] p-2">
            <span class="font-bold text-[12px]">${irs.nama}</span>
            <span class="text-gray-800 text-[8px] font-[300]">Semester ${irs.semester} (${irs.sks} SKS)</span>
            <span class="text-gray-800 text-[8px]">${jam_dari} - ${jam_ke}</span>
            <span class="text-gray-800 text-[8px]">${irs.nama_dosen}</span>
            <span class="text-gray-800 text-[8px]">Kapasitas: ${irs.terisi + (choosed ? 1 : 0)}/${irs.kapasitas}</span>

            <div class="flex flex-row justify-end">
              <button onclick="${choosed || isFull ? 'javascript:void(0)' : `handleConfirmIrs('${irs.kode}')`}" class="${isFull ? 'bg-[#EC1E1E]' : 'bg-[#D6D6D6]'} py-1 px-2 rounded-[10px] text-[10px]">${isFull ? 'Penuh' : choosed ? 'Dipilih' : 'Pilih'}</button>
            </div>
          </div>
        </td>` : `<td class="border border-[black] w-[200px] h-[93px] px-4 py-2">
        </td>`;
      };

      return `
        <tr>
          ${renderCard('senin')}
          ${renderCard('selasa')}
          ${renderCard('rabu')}
          ${renderCard('kamis')}
          ${renderCard('jum\'at')}
          ${renderCard('sabtu')}
          ${renderCard('minggu')}
        </tr>
      `;
    }).join('');
  }

  const submitChooseIrs = function() {
    const getKode = document.querySelectorAll('.select-irs');
    let selectedKode = [];

    getKode.forEach((currV, currI) => {
      if (currV.checked) {
        selectedKode.push(currV.value);
      }
    });

    selectedIrsOptionsRaw = selectedKode.map((kode) => {
      return availIrsOptions.find((option) => {
        return kode === option.kode;
      });
    });

    renderSelectedIrsRaw(selectedIrsOptionsRaw);
  }

  const submitIrs = async function() {
    try {
      if (!selectedIrsOptionsRaw.length) {
        throw Error('Mohon pilih IRS terlebih dahulu');
      }

      if (selectedIrsOptions.length != selectedIrsOptionsRaw.length) {
        throw Error('Ada kartu IRS yang bermasalah dan pilih kartu irs sampai semua kartu irs berwarna hijau');
      }

      let payload = {
        _token: "{{ csrf_token() }}",
        irs: [],
      };

      let totalSks = 0;

      for (const selectedIrsOption of selectedIrsOptions) {
        totalSks += selectedIrsOption.sks;
        payload.irs.push(selectedIrsOption.kode);
      }

      if (totalSks > maxSks) {
        throw Error(`Beban SKS Melebihi batas maksimal, max ${maxSks}`);
      }

      const response = await fetch("{{ route('api.mahasiswa.irs.create') }}", {
        method: 'POST',
        body: JSON.stringify(payload),
        headers: {
          'Content-Type': 'application/json', // Konten yang dikirim dalam format JSON
        },
      });

      if (!response.ok) {
        throw Error('Internal Server Error');
      }

      const createRes = await response.json();

      if (createRes.error) {
        throw Error(createRes.message);
      }
      
      alert('Berhasil simpan IRS');

      window.location.href = '{{route("mahasiswa.irs")}}';
    } catch (err) {
      alert(err.message);
    }
  }
</script>

@endsection