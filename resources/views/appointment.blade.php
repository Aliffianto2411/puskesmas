@extends('layouts.user')

@section('title', 'Dashboard - Puskesmas Meral')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Form Janji Temu</h5>
        </div>
        <div class="card-body">
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('error') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <form action="{{ route('appointment.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="pasien" class="form-label">Nama Pasien</label>
                <select class="form-select" id="pasien" name="detail_keluarga_id" required>
                  <option selected disabled>-- Pilih Anggota Keluarga --</option>
                  @foreach ($anggota as $pasiensakit)
                    <option value="{{ $pasiensakit->id }}">{{ $pasiensakit->nama }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <label for="poli" class="form-label">Pilih Poli</label>
                <select class="form-select" id="poli" name="poli_id" required>
                  <option selected disabled>-- Pilih Poli --</option>
                  @foreach($poli as $itemPoli)
                    <option value="{{ $itemPoli->id }}">{{ $itemPoli->nama_poli }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="mb-3">
              <label for="tanggal" class="form-label">Tanggal Janji</label>
              <input type="date" class="form-control" name="tanggal" id="tanggal" required min="{{ date('Y-m-d') }}">
            </div>

            <div class="mb-3">
              <label class="form-label d-block">Pilih Jam Janji</label>
              <div class="row g-2" id="jam-slot">
                @php
                  $start = strtotime("08:00");
                  $end = strtotime("12:00");
                  $interval = 15 * 60;
                  $i = 0;
                @endphp

                @for ($time = $start; $time <= $end; $time += $interval)
                  <div class="col-3">
                    <input type="radio" class="btn-check" name="jam" id="jam{{ $i }}" autocomplete="off" value="{{ date('H:i', $time) }}">
                    <label class="btn btn-time w-100" for="jam{{ $i }}">{{ date('H:i', $time) }}</label>
                  </div>
                  @php $i++; @endphp
                @endfor
              </div>
            </div>

            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-primary">Daftar Poli</button>
            </div>
          </form>

          @if (isset($invoice))
          <div class="card mt-4 shadow border-success">
            <div class="card-header bg-success text-white">
              <h5 class="mb-0"> Pendaftaran Poli Berhasil</h5>
            </div>
            <div class="card-body">
              <p><strong>Nama Pasien:</strong> {{ $invoice->detailKeluarga->nama ?? '-' }}</p>
              <p><strong>Poli:</strong> {{ $invoice->poli->nama_poli ?? '-' }}</p>
              <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($invoice->tanggal)->format('d-m-Y') }}</p>
              <p><strong>Jam:</strong> {{ $invoice->jam }}</p>
              <p><strong>Status:</strong> {{ $invoice->status }}</p>

              @if ($invoice->status === 'Menunggu')
              <div class="mt-3">
                <form action="{{ route('appointment.checkin', $invoice->id) }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="btn btn-success btn-sm" id="checkin-button" style="display: none;">Check-In</button>
                </form>
                <form action="{{ route('appointment.cancel', $invoice->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin membatalkan janji temu ini?');">
                  @csrf
                  <button type="submit" class="btn btn-danger btn-sm">Batal</button>
                </form>
              </div>
              @endif

              <div class="mt-3 text-end">
                <a href="{{ route('appointment.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
              </div>
            </div>
          </div>
          @endif

        </div>
      </div>
    </div>
  </div>
</div>
@endsection

<style>
  .btn-time {
    border: 1px solid #0d6efd;
    color: #0d6efd;
    transition: all 0.3s ease;
  }

  .btn-time:hover,
  .btn-check:checked + .btn-time {
    background: linear-gradient(45deg, rgb(4, 103, 184), rgb(0, 255, 149));
    color: white;
    border-color: transparent;
  }

  .btn-time.disabled {
    background-color: #d3d3d3 !important;
    color: #808080;
    border-color: #d3d3d3;
    pointer-events: none;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const poliSelect = document.getElementById('poli');
    const tanggalInput = document.getElementById('tanggal');
    const jamSlots = document.getElementById('jam-slot');
    const jamSlotContainer = jamSlots.closest('.mb-3');
    jamSlotContainer.style.display = 'none';

    // Fungsi: Mendapatkan tanggal hari ini dalam zona WIB
    function getTodayInWIB() {
      const now = new Date();
      const options = {
        timeZone: 'Asia/Jakarta',
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
      };
      const formatter = new Intl.DateTimeFormat('en-CA', options); // Format: YYYY-MM-DD
      return formatter.format(now);
    }

    // Set tanggal minimum input ke hari ini (WIB)
    const today = getTodayInWIB();
    tanggalInput.setAttribute('min', today);

    // Fungsi: Cek apakah jam slot sudah lewat (berdasarkan WIB)
    function isPastToday(dateStr, timeStr) {
      const now = new Date();
      const nowInWIB = new Date(now.toLocaleString('en-US', { timeZone: 'Asia/Jakarta' }));

      const [hours, minutes] = timeStr.split(':');
      const slotTime = new Date(`${dateStr}T${hours}:${minutes}:00+07:00`);

      return slotTime <= nowInWIB;
    }

    // Fungsi: Ambil slot yang sudah terisi dari backend
    function fetchTakenSlots(poli, tanggal) {
      return fetch(`/appointments/${poli}/${tanggal}`)
        .then(response => response.json())
        .catch(error => {
          console.error('Error fetching taken slots:', error);
          return [];
        });
    }

    // Fungsi: Perbarui tampilan slot jam yang tersedia
    async function updateAvailableSlots() {
      const selectedDate = tanggalInput.value;
      const selectedPoli = poliSelect.value;

      if (selectedDate && selectedPoli && selectedDate >= today) {
        jamSlotContainer.style.display = 'block';
        const takenTimes = await fetchTakenSlots(selectedPoli, selectedDate);
        const allSlots = jamSlots.querySelectorAll('.btn-check');

        allSlots.forEach(slot => {
          const slotTime = slot.value;
          const label = slot.nextElementSibling;

          if (takenTimes.includes(slotTime) || isPastToday(selectedDate, slotTime)) {
            slot.disabled = true;
            label.classList.add('disabled');
          } else {
            slot.disabled = false;
            label.classList.remove('disabled');
          }
        });
      } else {
        jamSlotContainer.style.display = 'none';
      }
    }

    poliSelect.addEventListener('change', updateAvailableSlots);
    tanggalInput.addEventListener('change', updateAvailableSlots);

    // Tampilkan tombol check-in jika waktu janji hampir tiba (dalam 5 menit -10 menit)
    <?php if (isset($invoice) && $invoice->status === 'Menunggu'): ?>
      const checkinButton = document.getElementById('checkin-button');
      const janjiDateTime = new Date("{{ \Carbon\Carbon::parse($invoice->tanggal . ' ' . $invoice->jam, 'Asia/Jakarta')->toIso8601String() }}");
      const now = new Date(new Date().toLocaleString('en-US', { timeZone: 'Asia/Jakarta' }));
      const diffInMinutes = (janjiDateTime - now) / 60000;

      if (diffInMinutes <= 5 && diffInMinutes >= -10) {
        checkinButton.style.display = 'inline-block';
      } else {
        checkinButton.style.display = 'none';
      }
    <?php endif; ?>
  });
</script>

