<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: DejaVu Sans, sans-serif; color: #333; }
    h1 { text-align: center; margin-bottom: 1rem; }
    table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
    th, td { border: 1px solid #555; padding: .5rem; text-align: left; }
    th { background-color: #eee; }
    .header { margin-bottom: 2rem; }
    .field { margin-bottom: .5rem; }
    .field span { font-weight: bold; }
  </style>
</head>
<body>
  <h1>Presensi: {{ $report->extra->name }}</h1>

  <div class="header">
    <p class="field"><span>Tanggal:</span> {{ $report->date }}</p>
    <p class="field"><span>Berita Acara:</span> {{ $report->berita_acara }}</p>
    <p class="field"><span>Dibuat oleh:</span> {{ $report->reporter->name }}</p>
    <p class="field"><span>Status:</span> {{ ucfirst($report->status) }}</p>
  </div>

  @if($report->image_path)
    <div style="text-align:center; margin-bottom:1rem;">
      <img src="{{ storage_path('app/public/'.$report->image_path) }}"
           style="max-width: 100%; height: auto;">
    </div>
  @endif

  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Nama Siswa</th>
        <th>Kehadiran</th>
      </tr>
    </thead>
    <tbody>
      @foreach($report->details as $i => $d)
        <tr>
          <td>{{ $i+1 }}</td>
          <td>{{ $d->student->name }}</td>
          <td>{{ ucfirst($d->presence) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
