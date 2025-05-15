@extends('layouts.app')

@section('title', '- Input')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Input Array & Pilih Algoritma</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('sort') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="numbers" class="form-label">Masukkan angka (pisahkan dengan koma):</label>
                            <input type="text" name="numbers" id="numbers"
                                class="form-control @error('numbers') is-invalid @enderror"
                                placeholder="Contoh: 64, 34, 25, 12, 22, 11, 90"
                                value="{{ old('numbers', '64, 34, 25, 12, 22, 11, 90') }}" required>
                            @error('numbers')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="algorithm" class="form-label">Pilih Algoritma:</label>
                            <select name="algorithm" id="algorithm"
                                class="form-select @error('algorithm') is-invalid @enderror">
                                <option value="bubble" {{ old('algorithm') == 'bubble' ? 'selected' : '' }}>Bubble Sort
                                </option>
                                <option value="selection" {{ old('algorithm') == 'selection' ? 'selected' : '' }}>Selection
                                    Sort</option>
                            </select>
                            @error('algorithm')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Mulai Sortir</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Algoritma</h5>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="bubble-tab" data-bs-toggle="tab" data-bs-target="#bubble"
                                type="button" role="tab">Bubble Sort</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="selection-tab" data-bs-toggle="tab" data-bs-target="#selection"
                                type="button" role="tab">Selection Sort</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="blade-tab" data-bs-toggle="tab" data-bs-target="#blade"
                                type="button" role="tab">Blade Template</button>
                        </li>
                    </ul>

                    <div class="tab-content pt-4" id="myTabContent">
                        <div class="tab-pane fade show active" id="bubble" role="tabpanel">
                            <h4>Bubble Sort</h4>
                            <p>Bubble Sort adalah algoritma pengurutan sederhana yang berulang kali melangkah melalui daftar
                                yang akan diurutkan, membandingkan setiap pasang item yang berdekatan dan menukarnya jika
                                mereka dalam urutan yang salah. Langkah ini diulang sampai tidak ada pertukaran yang
                                diperlukan, yang menunjukkan bahwa daftar sudah terurut.</p>

                            <h5>Karakteristik:</h5>
                            <ul>
                                <li>Kompleksitas Waktu: O(n²) - kasus terburuk dan rata-rata</li>
                                <li>Kompleksitas Ruang: O(1) - in-place</li>
                                <li>Stabil: Ya</li>
                            </ul>

                            <h5>Pseudocode:</h5>
                            <div class="code-block">
                                procedure bubbleSort(A : list of sortable items)
                                n = length(A)
                                for i = 0 to n-1
                                for j = 0 to n-i-1
                                if A[j] > A[j+1]
                                swap(A[j], A[j+1])
                                end procedure
                            </div>
                        </div>

                        <div class="tab-pane fade" id="selection" role="tabpanel">
                            <h4>Selection Sort</h4>
                            <p>Selection Sort adalah algoritma pengurutan berdasarkan perbandingan di tempat. Algoritma ini
                                membagi array menjadi dua bagian: bagian yang sudah diurutkan di sebelah kiri dan bagian
                                yang belum diurutkan di sebelah kanan. Pada setiap iterasi, algoritma ini mencari elemen
                                terkecil dari bagian yang belum diurutkan dan menempatkannya di akhir bagian yang telah
                                diurutkan.</p>

                            <h5>Karakteristik:</h5>
                            <ul>
                                <li>Kompleksitas Waktu: O(n²) - kasus terburuk, terbaik, dan rata-rata</li>
                                <li>Kompleksitas Ruang: O(1) - in-place</li>
                                <li>Stabil: Tidak</li>
                            </ul>

                            <h5>Pseudocode:</h5>
                            <div class="code-block">
                                procedure selectionSort(A : list of sortable items)
                                n = length(A)
                                for i = 0 to n-2
                                min_idx = i
                                for j = i+1 to n-1
                                if A[j] < A[min_idx] min_idx=j swap A[i] and A[min_idx] end procedure </div>
                            </div>

                            <div class="tab-pane fade" id="blade" role="tabpanel">
                                <h4>Blade Template</h4>
                                <p>Blade adalah sistem template sederhana namun kuat yang disediakan dengan Laravel. Blade
                                    menggabungkan template dengan perintah kontrol yang kuat dan kompilasi backend untuk
                                    menyederhanakan pembuatan tampilan dinamis.</p>

                                <h5>Fitur Utama Blade:</h5>
                                <ul>
                                    <li><strong>Template Inheritance</strong> - Blade menggunakan konsep layout dan section
                                        untuk memungkinkan template diwarisi antara halaman.</li>
                                    <li><strong>Direktif</strong> - Blade menyediakan direktif khusus untuk kontrol alur
                                        seperti <code>@@if</code>, <code>@@foreach</code>, <code>@@for</code>, dll.</li>
                                    <li><strong>Komponen & Slot</strong> - Blade memungkinkan pembuatan komponen yang dapat
                                        digunakan kembali.</li>
                                    <li><strong>Perlindungan XSS</strong> - Blade secara otomatis menghindari risiko
                                        serangan XSS dengan mengescape output.</li>
                                </ul>

                                {{-- <h5>Contoh Direktif Blade:</h5>
                                <div class="code-block"> --}}
                                    <!-- Layout Inheritance -->
                                    {{-- @extends('layouts.app')

                                    @section('content')
                                    <!-- Konten halaman di sini -->
                                    @endsection

                                    <!-- Kontrol Alur -->
                                    @if($condition)
                                    Tampilkan ini jika kondisi benar
                                    @else
                                    Tampilkan ini jika kondisi salah
                                    @endif

                                    @foreach($items as $item)
                                    Item: {{ $item }}
                                    @endforeach

                                    <!-- Menampilkan Data -->
                                    {{ $variable }} <!-- Dengan escape -->
                                    {!! $htmlContent !!} <!-- Tanpa escape -->

                                    <!-- Include Template Lain -->
                                    @include('partials.header')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
@endsection