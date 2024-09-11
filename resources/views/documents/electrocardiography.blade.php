@extends('layouts.document')
@section('content')
    <div class="section">
        <table class="right-aligned-table">
            <tr>
                <td><strong>Medical Record No.</strong></td>
                <td><strong>:</strong> {{ $mrn ?? '000000' }}</td>
            </tr>
            <tr>
                <td><strong>Patient Name</strong></td>
                <td><strong>:</strong> {{ $patient_name ?? 'John Doe' }}</td>
            </tr>
            <tr>
                <td><strong>Date of Birth (Age)</strong></td>
                <td><strong>:</strong> {{ $dob ?? '01 Jan 1970 (50 years)' }}</td>
            </tr>
            <tr>
                <td><strong>Gender</strong></td>
                <td><strong>:</strong> {{ $gender ?? 'Male' }}</td>
            </tr>
        </table>
    </div>
    <div class="section">
        <h4 class="text-center" style="padding: 0;margin: -10px">
            ELECTROCARDIOGRAPHY RESULT
        </h4>
    </div>
    <div class="section">
        <table class="table-disable-border">
            <tr>
                <td style="width: 150px;">Dokter Perujuk</td>
                <td>: {{ $doctor_referal ?? 'Dr. John Doe' }}</td>
            </tr>
            <tr>
                <td style="width: 150px;">Diagnosis Klinis</td>
                <td>: {{ $diagnosis ?? 'Normal' }}</td>
            </tr>
        </table>
        <table class="table-electrocardiography">
            <tr>
                <td style="width: 10px">1</td>
                <td style="width: 150px">Irama Dasar</td>
                <td></td>
                <td>{{ $irama ?? 'Sinus' }}</td>
            </tr>
            <tr>
                <td style="width: 10px" rowspan="2">2</td>
                <td style="width: 150px" rowspan="2">Rate</td>
                <td style="width: 150px">Ventrikel</td>
                <td>{{ $rate_ventrikel ?? '60-100' }}</td>
            </tr>
            <tr>
                <td style="width: 150px">Atrium</td>
                <td>{{ $rate_atrium ?? '60-100' }}</td>
            </tr>
            <tr>
                <td rowspan="3">3</td>
                <td rowspan="3">Gelombang P</td>
                <td>Bentuk</td>
                <td>{{ $bentuk_p ?? 'Normal' }}</td>
            </tr>
            <tr>
                <td>Durasi</td>
                <td>{{ $durasi_p ?? '0.08' }}</td>
            </tr>
            <tr>
                <td>Aksis</td>
                <td>{{ $aksis_p ?? 'Normal' }}</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Interval PR</td>
                <td></td>
                <td>{{ $interval_pr ?? '0.12' }}</td>
            </tr>
            <tr>
                <td rowspan="3">5</td>
                <td rowspan="3">Kompleks QRS</td>
                <td>Bentuk</td>
                <td>{{ $bentuk_qrs ?? 'Normal' }}</td>
            </tr>
            <tr>
                <td>Durasi</td>
                <td>{{ $durasi_qrs ?? '0.08' }}</td>
            </tr>
            <tr>
                <td>Aksis</td>
                <td>{{ $aksis_qrs ?? 'Normal' }}</td>
            </tr>
            <tr>
                <td rowspan="3">6</td>
                <td rowspan="3">Segment ST</td>
                <td>Isoelektris</td>
                <td>{{ $isoelektris ?? 'Normal' }}</td>
            </tr>
            <tr>
                <td>Elevasi</td>
                <td>{{ $elevasi ?? '0.08' }}</td>
            </tr>
            <tr>
                <td>Depresi</td>
                <td>{{ $depresi ?? '0.08' }}</td>
            </tr>
            <tr>
                <td>7</td>
                <td>Gelombang T</td>
                <td></td>
                <td>{{ $gelombang_t ?? 'Normal' }}</td>
            </tr>
            <tr>
                <td>8</td>
                <td>Interval QT</td>
                <td></td>
                <td>{{ $interval_qt ?? '0.40' }}</td>
            </tr>
            <tr>
                <td>9</td>
                <td>Interval QoTc</td>
                <td></td>
                <td>{{ $interval_qtc ?? '0.42' }}</td>
            </tr>
            <tr>
                <td>10</td>
                <td>Gelombang U</td>
                <td></td>
                <td>{{ $gelombang_u ?? 'Normal' }}</td>
            </tr>
            <tr>
                <td>11</td>
                <td>Lain-lain</td>
                <td></td>
                <td>{{ $lain_lain ?? 'Normal' }}</td>
            </tr>
            <tr>
                <td rowspan="4">12</td>
                <td>Kesimpulan</td>
                <td></td>
                <td>{{ $kesimpulan ?? 'Normal' }}</td>
            </tr>
            <tr>
                <td>Hipertrofi</td>
                <td></td>
                <td>{{ $hipertrofi ?? 'Normal' }}</td>
            </tr>
            <tr>
                <td>Aritmia</td>
                <td></td>
                <td>{{ $aritmia ?? 'Normal' }}</td>
            </tr>
            <tr>
                <td>Gangguan Konduksi</td>
                <td></td>
                <td>{{ $gangguan_konduksi ?? 'Normal' }}</td>
            </tr>
        </table>
    </div>
    <div class="section">
        <table class="table-disable-border">
            <tr>
                <td style="width: 150px;">Kesimpulan</td>
                <td>: {{ $kesimpulan ?? 'Normal' }}</td>
            </tr>
            <tr>
                <td style="width: 150px;">Saran</td>
                <td>: {{ $saran ?? 'Normal' }}</td>
            </tr>
        </table>
        <p>Medan, {{ $date ?? date('d F Y') }}</p>
        <p style="margin-top: 60px;"><strong>Cardiologist<br>{{ $doctor_cardiologist ?? 'Dr. Jane Doe' }}</strong></p>
    </div>
@endsection

@push('styles')
    <style>
        .table-electrocardiography {
            width: 100%;
            border-collapse: collapse;
        }

        .table-electrocardiography th, .table-electrocardiography td {
            border: 1px solid #000;
            padding: 2px;
            text-align: left;
        }
    </style>
@endpush
