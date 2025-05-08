@extends('layouts.app')

@section('title', 'Monitoring Antrian')

@section('content')
<section class="antrian-section bg-success text-white text-center" style="padding-top: calc(100px + 1rem); height: 35vh; display: flex; flex-direction: column; align-items: center; justify-content: center;">
  <div>
    <h1 class="display-4 fw-bold">Monitoring Antrian Poli</h1>
    <p class="lead">Pantau antrian pasien secara real-time</p>
  </div>
</section>

<section class="antrian-section py-5 bg-light">
  <div class="container">
    <div class="row text-center">
      @php
        $polis = [
          [
            'nama' => 'Poli Umum',
            'kode' => 'A',
            'sekarang' => '012',
            'selanjutnya' => ['013', '014']
          ],
          [
            'nama' => 'Poli Gigi',
            'kode' => 'B',
            'sekarang' => '005',
            'selanjutnya' => ['006', '007']
          ],
          [
            'nama' => 'Poli Anak',
            'kode' => 'C',
            'sekarang' => '009',
            'selanjutnya' => ['010', '011']
          ],
          [
            'nama' => 'Poli Lansia',
            'kode' => 'D',
            'sekarang' => '003',
            'selanjutnya' => ['004', '005']
          ],
        ];
      @endphp

      @foreach ($polis as $poli)
      <div class="col-md-6 col-lg-3 mb-4">
        <div class="card border-success shadow h-100">
          <div class="card-header bg-success text-white">
            <h5 class="mb-0">{{ $poli['nama'] }}</h5>
          </div>
          <div class="card-body">
            <p class="fs-6">Nomor Antrian Saat Ini</p>
            <h2 class="display-4 fw-bold text-success">{{ $poli['kode'] . $poli['sekarang'] }}</h2>

            <hr>
            <p class="mb-2 fw-semibold">Antrian Selanjutnya</p>
            <table class="table table-bordered text-center small mb-0">
              <thead class="table-light">
                <tr>
                  <th>No</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($poli['selanjutnya'] as $next)
                <tr>
                  <td>{{ $poli['kode'] . $next }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<style>
  body {
    background-color: #f7f7f7;
  }
  .table th, .table td {
    padding: 0.5rem;
  }
  .antrian-section {
    scroll-margin-top: 100px;
  }
</style>
@endsection