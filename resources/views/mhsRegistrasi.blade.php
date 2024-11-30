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
        <span class="text-[24px]">Registrasi</span>
      </div>
      <a href="{{route('dashboard')}}">
        <img class="w-[51px] h-[51px]" src="{{ asset('icons/PADashboard/BackSquare.png') }}" alt="">
      </a>
    </div>

    <div class="flex flex-1 flex-col items-center gap-[20px]">
      <span class="text-[24px]">Pilih Status Akademik</span>

      <div class="flex flex-row items-start justify-stretch gap-[20px] w-full">
        <div class="py-[16px] px-[20px] min-h-[263px] flex-1 bg-white rounded-[20px] flex flex-col">
          <span class="text-[24px] mb-[16px] uppercase">{{$mahasiswa->status}}</span>

          <div class="flex flex-row items-start flex-1">
            <img src="{{ asset('icons/MahasiswaDashboard/BookIcon.png') }}" alt="" style="width: 120px">

            <div class="flex flex-col items-end gap-[10px] flex-1">
              <span class="text-[20px]">Anda akan mengikuti kegiatan perkuliahan pada semester ini serta mengisi Isian Rencana Studi (IRS)</span>
            </div>
          </div>

          @if ($mahasiswa->status === 'Aktif')
            <div class="px-[30px] py-[10px] bg-[#E3CBCB] text-[#000] rounded-[10px] self-end">Terpilih</div>
          @else
            <button onclick="aktifkan()" class="px-[30px] py-[10px] bg-[#E3CBCB] text-[#000] rounded-[10px] self-end">Aktifkan</button>
          @endif
        </div>
        <div class="py-[16px] px-[20px] min-h-[263px] flex-1 bg-white rounded-[20px] flex flex-col">
          <span class="text-[24px] mb-[16px]">CUTI</span>

          <div class="flex flex-row items-start flex-1">
            <img src="{{ asset('icons/MahasiswaDashboard/BookIcon.png') }}" alt="" style="width: 120px">

            <div class="flex flex-col items-end gap-[10px] flex-1">
              <span class="text-[20px]">Anda akan mengikuti kegiatan perkuliahan pada semester ini serta mengisi Isian Rencana Studi (IRS)</span>
            </div>
          </div>

          <div class="px-[30px] py-[10px] bg-[#E3CBCB] text-gray-700 rounded-[10px] self-end">Tidak Tersedia</div>
        </div>
      </div>

      <div class="py-[16px] px-[20px] min-h-[263px] bg-white rounded-[20px] flex flex-col justify-self-center w-[673px]">
        <span class="text-center text-[24px] mb-[16px]">Informasi Pembayaran Biaya Kuliah Semester</span>

        <div class="flex flex-row items-start flex-1 w-full border border-l-0 border-r-0 py-[16px]">
          <table class="table table-auto w-full">
            <tr>
              <td>Nama Mahasiswa</td>
              <td>:</td>
              <td>{{$mahasiswa->nama}}</td>
            </tr>
            <tr>
              <td>Program Studi</td>
              <td>:</td>
              <td>{{$mahasiswa->prodi}}</td>
            </tr>
            <tr>
              <td>Semester</td>
              <td>:</td>
              <td>{{$mahasiswa->semester_berjalan}}</td>
            </tr>
            <tr>
              <td>Jumlah Tagihan</td>
              <td>:</td>
              <td>Rp {{ number_format(2500000, 2, ',', '.') }}</td>
            </tr>
            <tr>
              <td>Kode Tagihan</td>
              <td>:</td>
              <td>1111 2222 3333 4444</td>
            </tr>
          </table>
        </div>

        @if ($mahasiswa->payment == false)
          <button id="btn-payment-handler" onclick="handlePay()" class="mt-[16px] px-[30px] py-[10px] bg-red-300 font-bold text-gray-700 rounded-[10px] self-center">Bayar</button>
        @else
          <button id="btn-payment-handler" class="mt-[16px] px-[30px] py-[10px] font-bold bg-[#00FF66] text-white rounded-[10px] self-center">Sudah Dibayar</button>
        @endif
      </div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

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

  const aktifkan = async function() {
    try {
      const payload = {
        _token: "{{ csrf_token() }}",
      };

      const response = await fetch("{{ route('api.mahasiswa.aktif') }}", {
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
        
        alert('Berhasil aktifkan status mahasiswa');

        window.location.href = '{{route("mahasiswa.registrasi")}}';
    } catch (error) {
      alert(error.message);
    }
  };

  const handlePay = async function () {
    try {
      const payload = {
        _token: "{{ csrf_token() }}",
      };

      const response = await fetch("{{ route('api.mahasiswa.payment') }}", {
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

      alert('Berhasil melakukan pembayaran');

      window.location.href = '{{route("mahasiswa.registrasi")}}';
    } catch (error) {
      alert(error.message);
    }
  }
</script>

@endsection