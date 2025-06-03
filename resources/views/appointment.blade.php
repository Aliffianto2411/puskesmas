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
        

            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-primary">Ambil Antrian</button>
            </div>
          </form>

  @if (isset($invoice))
  <div class="card mt-4 shadow border-success">
    <div class="card-header bg-success text-white">
      <h5 class="mb-0">Invoice Antrian Berhasil</h5>
    </div>
    <div class="card-body">
      <p><strong>Nama Pasien:</strong> {{ $invoice->detailKeluarga->nama ?? '-' }}</p>
      <p><strong>Poli:</strong> {{ $invoice->poli->nama_poli ?? '-' }}</p>
      <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($invoice->tanggal)->format('d-m-Y') }}</p>
      <p><strong>Jam:</strong> {{ $invoice->jam }}</p>
      <p><strong>Nomor Antrian:</strong> <span class="badge bg-primary fs-6">{{ $invoice->nomor_antrian }}</span></p>
      <p><strong>Status:</strong> {{ $invoice->status }}</p>
      @if ($invoice->status === 'Menunggu')
        <div class="mt-3">
          <form action="{{ route('appointment.checkin', $invoice->id) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-success btn-sm">Check-In</button>
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

    function fetchTakenSlots(poli, tanggal) {
      return fetch(`/appointments/${poli}/${tanggal}`)
        .then(response => response.json())
        .then(data => data)
        .catch(error => {
          console.error('Error fetching taken slots:', error);
          return [];
        });
    }

    async function updateAvailableSlots() {
      const selectedDate = tanggalInput.value;
      const selectedPoli = poliSelect.value;

      if (selectedDate && selectedPoli) {
        jamSlotContainer.style.display = 'block';
        const takenTimes = await fetchTakenSlots(selectedPoli, selectedDate);
        const allSlots = jamSlots.querySelectorAll('.btn-check');
        allSlots.forEach(slot => {
          const slotTime = slot.value;
          const label = slot.nextElementSibling;
          if (takenTimes.includes(slotTime)) {
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
  });
</script>