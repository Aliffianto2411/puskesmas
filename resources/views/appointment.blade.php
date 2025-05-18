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
          <div class="mb-3">
            <label for="poli" class="form-label">Pilih Poli</label>
            <select class="form-select" id="poli" name="poli_id" required>
              <option selected disabled>-- Pilih Poli --</option>
              @foreach($poli as $poli)
                <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
              @endforeach
            </select>
          </div>

            <!-- Tanggal -->
            <div class="mb-3">
              <label for="tanggal" class="form-label">Tanggal Janji</label>
              <input type="date" class="form-control" name="tanggal" id="tanggal" required>
            </div>

            <div class="mb-3">
              <label class="form-label d-block">Pilih Jam Janji</label>
              <div class="row g-2" id="jam-slot">
                @php
                  $start = strtotime("08:00");
                  $end = strtotime("12:00");
                  $interval = 10 * 60;
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

            <!-- Submit -->
            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-primary">Ambil Antrian</button>
            </div>
          </form>
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
    background-color: #d3d3d3 !important; /* Warna abu-abu */
    color: #808080; /* Warna teks abu-abu */
    border-color: #d3d3d3;
    pointer-events: none; /* Menonaktifkan interaksi */
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const poliSelect = document.getElementById('poli');
    const tanggalInput = document.getElementById('tanggal');
    const jamSlots = document.getElementById('jam-slot');
    const jamSlotContainer = jamSlots.closest('.mb-3'); // Mengambil container card jam

    // Sembunyikan card jam saat halaman dimuat
    jamSlotContainer.style.display = 'none';

    // Fungsi untuk mendapatkan slot yang sudah diambil dari server
    function fetchTakenSlots(poli, tanggal) {
      return fetch(`/appointments/${poli}/${tanggal}`)
        .then(response => response.json())
        .then(data => {
          return data; // Mengembalikan array slot waktu yang sudah diambil
        })
        .catch(error => {
          console.error('Error fetching taken slots:', error);
          return [];
        });
    }

    // Fungsi untuk memperbarui slot yang tersedia
    async function updateAvailableSlots() {
      const selectedDate = tanggalInput.value;
      const selectedPoli = poliSelect.value;

      if (selectedDate && selectedPoli) {
        // Tampilkan card jam
        jamSlotContainer.style.display = 'block';

        // Ambil slot yang sudah terambil dari server
        const takenTimes = await fetchTakenSlots(selectedPoli, selectedDate);
        
        // Reset semua slot untuk diaktifkan
        const allSlots = jamSlots.querySelectorAll('.btn-check');
        allSlots.forEach(slot => {
          const slotTime = slot.value;
          const label = slot.nextElementSibling;

          if (takenTimes.includes(slotTime)) {
            // Nonaktifkan slot yang sudah terambil
            slot.disabled = true;
            label.classList.add('disabled'); // Tambahkan styling disabled
          } else {
            // Aktifkan slot yang belum terambil
            slot.disabled = false;
            label.classList.remove('disabled');
          }
        });
      } else {
        // Sembunyikan card jam jika tanggal atau poli belum dipilih
        jamSlotContainer.style.display = 'none';
      }
    }

    // Event listeners untuk memilih poli dan tanggal
    poliSelect.addEventListener('change', updateAvailableSlots);
    tanggalInput.addEventListener('change', updateAvailableSlots);
  });
</script>