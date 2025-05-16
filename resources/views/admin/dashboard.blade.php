@extends('layouts.template')
@section('content')
    <div class="card">
        <div class="card-body" style="background-color: beige">
            <div>
                <h4 style="color: #800000;">
                    <i class="fas fa-user-circle mr-2"></i>
                    Hai, Admin <strong>{{ Auth::user()->nama ?? 'Pengguna' }}</strong> !
                </h4>
                <p>
                    Selamat datang di Sistem Pendukung Keputusan Penutupan Batching Plant. Sistem ini akan membantu Anda
                    dalam proses pengambilan keputusan menggunakan metode <em><strong>Multi Attribute Utility Theory.</strong></em>
                </p>
            </div>
            <a href="{{ url('/recommendation/cache-history') }}">
                <button type="button" class="btn btn-primary custom-btn" style="background-color: #800000; border:#800000">
                    <strong>Lihat Hasil Perhitungan &nbsp;&nbsp;&nbsp;</strong><i class="fas fa-arrow-right"></i>
                </button>
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-center" style="background-color: #800000; color:wheat">
            <h3 class="card-title"><strong>PLANT</strong></h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body" style="background-color: beige">
            <div class="row">
                <div class="col-lg-2 col-6">
                    <!-- small box -->
                    <a href="{{ url('/plant') }}" class="small-box bg-info">
                        <div class="inner">
                            <h3 style="text-align: center">{{ App\Models\PlantModel::count() }}</h3>
                            <p style="text-align: center">Total Plant</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-home"></i>
                        </div>
                    </a>
                </div>

                <div class="col-lg-2 col-6">
                    <a href="{{ url('/plant?status=aktif') }}" class="small-box bg-success">
                        <div class="inner">
                            <h3 style="text-align: center">{{ App\Models\PlantModel::where('status', 'aktif')->count() }}
                            </h3>
                            <p style="text-align: center">Plant Aktif</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-checkmark-circled"></i>
                        </div>
                    </a>
                </div>

                <div class="col-lg-2 col-6">
                    <a href="{{ url('/plant?status=nonaktif') }}" class="small-box bg-warning">
                        <div class="inner">
                            <h3 style="text-align: center">{{ App\Models\PlantModel::where('status', 'nonaktif')->count() }}
                            </h3>
                            <p style="text-align: center">Plant Nonaktif</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-alert-circled"></i>
                        </div>
                    </a>
                </div>

                <div class="col-lg-2 col-6">
                    <a href="{{ url('/plant?kodeaub=sbb') }}" class="small-box bg-danger">
                        <div class="inner">
                            <h3 style="text-align: center">{{ App\Models\PlantModel::where('idaub', '1')->count() }}</h3>
                            <p style="text-align: center">Plant SBB</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-alert-circled"></i>
                        </div>
                    </a>
                </div>

                <div class="col-lg-2 col-6">
                    <a href="{{ url('/plant?kodeaub=vub') }}" class="small-box bg-info">
                        <div class="inner">
                            <h3 style="text-align: center">{{ App\Models\PlantModel::where('idaub', '2')->count() }}</h3>
                            <p style="text-align: center">Plant VUB</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-alert-circled"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Kriteria Card - Now takes half width -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-center" style="background-color: #800000; color:wheat">
                    <h3 class="card-title"><strong>KRITERIA PENILAIAN</strong></h3>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body" style="background-color: beige">
                    <div class="row">
                        <div class="col-lg-4 col-6">
                            <a href="{{ url('/kriteria') }}" class="small-box bg-warning">
                                <div class="inner">
                                    <h3 style="text-align: center">{{ App\Models\KriteriaModel::count() }}</h3>
                                    <p style="text-align: center">Jumlah Kriteria</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-alert-circled"></i>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-4 col-6">
                            <a href="{{ url('/kriteria?jeniskriteria=benefit') }}" class="small-box bg-info">
                                <div class="inner">
                                    <h3 style="text-align: center">
                                        {{ App\Models\KriteriaModel::where('jeniskriteria', 'benefit')->count() }}</h3>
                                    <p style="text-align: center">Kriteria Benefit</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-alert-circled"></i>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-4 col-6">
                            <a href="{{ url('/kriteria?jeniskriteria=cost') }}" class="small-box bg-success">
                                <div class="inner">
                                    <h3 style="text-align: center">
                                        {{ App\Models\KriteriaModel::where('jeniskriteria', 'cost')->count() }}</h3>
                                    <p style="text-align: center">Kriteria Cost</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-alert-circled"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- History Card - Now takes half width and appears on the right -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-center" style="background-color: #800000; color:wheat">
                    <h3 class="card-title"><strong>HISTORY PERHITUNGAN</strong></h3>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body" style="background-color: beige">
                    <div class="row">
                        <div class="col-lg-4 col-6">
                            <a href="{{ route('rekomendasi.cache-history') }}" class="small-box bg-purple">
                                <div class="inner">
                                    @php
                                        $cacheKey = 'all_recommendation_history';
                                        $historyCount = count(Cache::get($cacheKey, []));
                                    @endphp
                                    <h3 style="text-align: center">{{ $historyCount }}</h3>
                                    <p style="text-align: center">Total History</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-clock"></i>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-4 col-6">
                            <a href="{{ route('rekomendasi.cache-history') }}?filter=month" class="small-box bg-info">
                                <div class="inner">
                                    @php
                                        $histories = Cache::get($cacheKey, []);
                                        $monthCount = count(
                                            array_filter($histories, function ($item) {
                                                return now()->diffInDays(\Carbon\Carbon::parse($item['date'])) <= 30;
                                            }),
                                        );
                                    @endphp
                                    <h3 style="text-align: center">{{ $monthCount }}</h3>
                                    <p style="text-align: center">30 Hari Terakhir</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-calendar"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-center" style="background-color: #800000; color:wheat">
            <h3 class="card-title"><strong>MORE INFO</strong></h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body" style="background-color: beige">
            <div class="row">
                <div class="col-lg-6 col-6">
                    <div class="card card-primary collapsed-card">
                        <div class="card-header" style="background-color: wheat">
                            <h3 class="card-title" style="color: #800000"><strong>Apa itu Metode MAUT ?</strong></h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-plus" style="color: #800000"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <p class="mb-4">
                                <strong>MAUT (Multi-Attribute Utility Theory)</strong> adalah salah satu metode dalam Sistem
                                Pendukung Keputusan (SPK)
                                yang digunakan untuk memecahkan permasalahan <em>pengambilan keputusan multikriteria</em>.
                                MAUT membantu pengambil keputusan dalam <strong>mengevaluasi beberapa alternatif</strong>
                                berdasarkan sejumlah
                                kriteria yang relevan, dengan cara menghitung nilai <em>utilitas</em> dari setiap
                                alternatif.
                            </p>
                            <p class="mb-4">
                                Metode ini sangat cocok diterapkan ketika setiap kriteria memiliki <strong>tingkat
                                    kepentingan (bobot)</strong> yang berbeda,
                                serta memiliki satuan nilai yang tidak sama — seperti biaya (rupiah), jarak (kilometer),
                                atau kualitas (skala 1-10).
                            </p>

                            <div>Keunggulan Metode MAUT</div>
                            <ul class="list-disc list-inside mb-4 ml-4 space-y-1">
                                <li>Dapat menangani berbagai jenis dan satuan kriteria</li>
                                <li>Memperhitungkan bobot atau preferensi pengambil keputusan</li>
                                <li>Transparan dan mudah dijelaskan</li>
                                <li>Cocok untuk keputusan kompleks dan bersifat strategis</li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-lg-6 col-6">
                    <div class="card card-primary collapsed-card">
                        <div class="card-header" style="background-color: wheat">
                            <h3 class="card-title" style="color: #800000"><strong>Apa peran sistem terhadap perusahaan
                                    ?</strong></h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-plus" style="color: #800000"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <p class="mb-4">
                                PT Semen Indonesia (Persero) Tbk merupakan perusahaan BUMN terkemuka di industri semen dan
                                bahan bangunan di Indonesia. Dalam pengembangan lini bisnis hilirnya, perusahaan ini
                                memiliki dua anak usaha utama yang bergerak di sektor beton siap pakai, yaitu <strong>Solusi
                                    Bangun Beton (SBB)</strong> dan <strong>Varia Usaha Beton (VUB)</strong>. Kedua entitas
                                ini secara aktif mengoperasikan puluhan pabrik <em>batching plant</em> yang tersebar di
                                berbagai wilayah strategis di Indonesia, mulai dari kawasan industri, proyek pembangunan
                                infrastruktur, hingga daerah perkotaan.
                            </p>

                            <p class="mb-4">Sebagai bagian dari strategi perluasan jaringan dan efisiensi operasional,
                                perusahaan secara rutin menghadapi keputusan penting, seperti :</p>
                            <ul class="list-disc ml-6 mb-4">
                                <li>Menentukan lokasi pendirian <em>batching plant</em> baru</li>
                                <li>Menutup atau merelokasi plant yang tidak efisien</li>
                                <li>Mengevaluasi potensi pasar di wilayah tertentu</li>
                                <li>Membandingkan performa antar unit operasional</li>
                            </ul>

                            <p class="mb-4">Namun, proses pengambilan keputusan tersebut seringkali memerlukan waktu yang
                                panjang, karena melibatkan banyak variabel dan kriteria teknis maupun bisnis seperti:</p>
                            <ul class="list-disc ml-6 mb-4">
                                <li>Biaya operasional</li>
                                <li>Akses terhadap proyek konstruksi</li>
                                <li>Potensi pasar lokal</li>
                                <li>Kepadatan lalu lintas dan aksesibilitas lokasi</li>
                                <li>Dukungan infrastruktur dan logistik</li>
                            </ul>

                            <p class="mb-4">
                                Untuk mengatasi kompleksitas ini, diterapkanlah <strong>Sistem Pendukung Keputusan
                                    (SPK)</strong> berbasis web yang memanfaatkan metode <strong>MAUT (Multi-Attribute
                                    Utility Theory)</strong>. Metode ini mampu menyederhanakan proses analisis dengan cara:
                            </p>

                            <div class="text-xl font-semibold mb-2">Keunggulan SPK dengan MAUT :</div>
                            <ul class="list-disc ml-6 mb-6">
                                <li>Membandingkan alternatif lokasi secara objektif berdasarkan data multi-kriteria</li>
                                <li>Menghemat waktu analisis yang biasanya dilakukan secara manual</li>
                                <li>Mengarahkan stakeholder pada keputusan optimal yang berbasis data terstruktur</li>
                                <li>Mendukung transparansi dan akuntabilitas keputusan, terutama dalam forum manajerial
                                    atau pemaparan ke direksi</li>
                            </ul>

                            <p class="mb-6">
                                Dengan sistem ini, stakeholder di PT Semen Indonesia, SBB, maupun VUB dapat secara cepat
                                mendapatkan saran keputusan lokasi atau strategi bisnis berdasarkan perhitungan yang logis,
                                transparan, dan terdokumentasi. Ini menjadi langkah penting dalam mendukung efisiensi
                                operasional dan pengembangan bisnis beton nasional yang lebih adaptif dan berbasis teknologi
                                data.
                            </p>

                            <div class="text-xl font-bold mb-3">Kriteria Penilaian dalam Sistem Pendukung Keputusan (SPK)
                                Pendirian Batching Plant</div>
                            <p class="mb-4">
                                Dalam mendukung keputusan strategis mengenai pendirian atau evaluasi lokasi <em>batching
                                    plant</em>, sistem ini menggunakan <strong>13 kriteria utama</strong> yang telah
                                ditentukan oleh stakeholder dan ahli teknis dari bisnis beton. Masing-masing kriteria
                                diberikan bobot sesuai tingkat kepentingannya, lalu dinormalisasi agar total bobot berjumlah
                                1 (atau 100%).
                            </p>

                            <p class="mb-2 font-semibold">Kriteria Tipe <span class="text-green-600">Benefit</span>
                                (semakin tinggi nilai, semakin baik):</p>
                            <ul class="list-disc ml-6 mb-4">
                                <li><strong>Available Market</strong> - Potensi pasar yang tersedia di sekitar lokasi
                                </li>
                                <li><strong>Utilisasi Plant</strong> - Tingkat penggunaan optimal alat dan tenaga kerja
                                </li>
                                <li><strong>Avail Raw Material</strong> - Kemudahan memperoleh bahan baku</li>
                                <li><strong>Break Even Point</strong> - Kecepatan balik modal</li>
                                <li><strong>Kedekatan dengan Pasar</strong> - Jarak lokasi dengan target konsumen
                                </li>
                                <li><strong>Keamanan Investasi</strong> - Tingkat keamanan aset dan stabilitas wilayah
                                </li>
                            </ul>

                            <p class="mb-2 font-semibold">Kriteria Tipe <span class="text-red-600">Cost</span> (semakin
                                rendah nilai, semakin baik):</p>
                            <ul class="list-disc ml-6 mb-4">
                                <li><strong>Biaya Investasi</strong> - Total biaya awal pembangunan</li>
                                <li><strong>Biaya Operasional</strong> - Biaya berkelanjutan untuk operasional plant</li>
                                <li><strong>Analisis Dampak Lingkungan</strong> - Pengaruh terhadap lingkungan sekitar
                                </li>
                                <li><strong>Kebisingan dan Polusi</strong> - Potensi gangguan lingkungan (Bobot: 3)</li>
                                <li><strong>Kesesuaian dengan Regulasi</strong> - Kepatuhan terhadap perizinan dan aturan
                                </li>
                                <li><strong>Kompetisi Pasar</strong> - Jumlah pesaing di wilayah tersebut (Bobot: 3)</li>
                                <li><strong>Aksesibilitas</strong> - Kemudahan transportasi dan logistik menuju lokasi
                                </li>
                            </ul>

                            <div class="text-lg font-semibold mb-2"><strong>Peran Kriteria Ini dalam Metode MAUT</strong>
                            </div>
                            <p class="mb-4">
                                Masing-masing kriteria di atas akan dinilai untuk setiap alternatif lokasi. Nilai-nilai
                                tersebut kemudian :
                            </p>
                            <ul class="list-decimal ml-6 mb-6">
                                <li>Dinormalisasi menjadi skala 0-1 (tergantung apakah benefit atau cost)</li>
                                <li>Dikalikan dengan bobot masing-masing</li>
                                <li>Dijumlahkan untuk menghasilkan skor akhir <em>(utility score)</em></li>
                            </ul>

                            <p>
                                Alternatif dengan skor tertinggi dianggap sebagai plant yang direkomendasikan untuk ditutup
                                berdasarkan seluruh aspek kriteria diatas.
                            </p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>
@endsection
