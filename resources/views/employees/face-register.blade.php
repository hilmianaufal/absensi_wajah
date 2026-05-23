<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-cyan-100 p-4 lg:p-8">
        <div class="max-w-7xl mx-auto">

            <div class="rounded-[2.5rem] bg-white/80 backdrop-blur-2xl shadow-2xl border border-white p-6 lg:p-10 mb-8">
                <a href="{{ route('employees.index') }}" class="text-blue-600 font-black">
                    ← Kembali
                </a>

                <div class="mt-5">
                    <div class="inline-flex px-4 py-2 rounded-full bg-purple-50 text-purple-600 font-black text-sm mb-4">
                        🧠 Registrasi Wajah
                    </div>

                    <h1 class="text-4xl lg:text-6xl font-black text-slate-900">
                        Scan Wajah Karyawan
                    </h1>

                    <p class="text-slate-500 mt-4">
                        Ambil data wajah untuk absensi otomatis realtime.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 items-start">

                <div class="rounded-[2.5rem] bg-white/90 shadow-2xl border border-white p-6 lg:p-8">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-3xl font-black text-slate-900">Kamera Registrasi</h2>
                            <p class="text-slate-400">Pastikan wajah terlihat jelas.</p>
                        </div>

                        <div id="statusBadge" class="px-4 py-2 rounded-full bg-yellow-50 text-yellow-600 font-black text-sm">
                            Model belum siap
                        </div>
                    </div>

                    <div class="relative aspect-video rounded-[2rem] overflow-hidden bg-slate-950 shadow-2xl border-[6px] border-white">
                        <video id="video"
                               autoplay
                               muted
                               playsinline
                               class="w-full h-full object-cover"></video>

                        <canvas id="overlay"
                                class="absolute inset-0 w-full h-full"></canvas>

                        <div class="absolute inset-0 pointer-events-none flex items-center justify-center">
                            <div class="w-56 h-56 md:w-72 md:h-72 rounded-full border-[5px] border-purple-300 shadow-[0_0_80px_rgba(168,85,247,0.8)]"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                        <button type="button"
                                onclick="startCamera()"
                                class="px-6 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-400 text-white font-black shadow-xl">
                            Aktifkan Kamera
                        </button>

                        <button type="button"
                                onclick="registerFace()"
                                class="px-6 py-4 rounded-2xl bg-gradient-to-r from-purple-600 to-fuchsia-500 text-white font-black shadow-xl">
                            Simpan Data Wajah
                        </button>
                    </div>
                </div>

                <div class="rounded-[2.5rem] bg-white/95 shadow-2xl border border-white p-6 lg:p-8">
                    <div class="flex items-center gap-4">
                        <img src="{{ $employee->photo ? asset($employee->photo) : 'https://ui-avatars.com/api/?name='.urlencode($employee->name).'&background=0ea5e9&color=fff' }}"
                             class="w-20 h-20 rounded-3xl object-cover shadow-xl border-4 border-white">

                        <div>
                            <h2 class="text-3xl font-black text-slate-900">
                                {{ $employee->name }}
                            </h2>
                            <p class="text-slate-400 font-bold">
                                {{ $employee->employee_code }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 space-y-4">
                        <div class="rounded-2xl bg-blue-50 p-5">
                            <p class="text-blue-600 font-black">Status Registrasi</p>
                            <p class="text-slate-600 mt-1">
                                {{ $employee->face_descriptor ? 'Wajah sudah terdaftar' : 'Belum ada data wajah' }}
                            </p>
                        </div>

                        <div id="faceInfo" class="rounded-2xl bg-slate-50 p-5 text-slate-500 font-bold">
                            Menunggu kamera aktif...
                        </div>
                    </div>

                    <form method="POST"
                          action="{{ route('employees.face-register.save', $employee) }}"
                          id="faceForm"
                          class="mt-8">
                        @csrf

                        <input type="hidden" name="face_descriptor" id="faceDescriptor">

                        <button id="submitButton"
                                disabled
                                class="w-full px-6 py-5 rounded-2xl bg-slate-300 text-white font-black shadow-xl cursor-not-allowed">
                            Data Wajah Belum Siap
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </div>


<script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

<script>
    const video = document.getElementById('video');
    const overlay = document.getElementById('overlay');
    const statusBadge = document.getElementById('statusBadge');
    const faceInfo = document.getElementById('faceInfo');
    const faceDescriptor = document.getElementById('faceDescriptor');

    let modelsLoaded = false;
    let stream = null;
    let detectionInterval = null;

    const detectorOptions = new faceapi.TinyFaceDetectorOptions({
        inputSize: 160,
        scoreThreshold: 0.25
    });

    const saveDetectorOptions = new faceapi.TinyFaceDetectorOptions({
        inputSize: 224,
        scoreThreshold: 0.15
    });

    async function loadModels() {
        try {
            faceInfo.innerText = 'Memuat model deteksi wajah...';

            await faceapi.nets.tinyFaceDetector.loadFromUri('/models');
            await faceapi.nets.faceLandmark68Net.loadFromUri('/models');
            await faceapi.nets.faceRecognitionNet.loadFromUri('/models');

            modelsLoaded = true;

            statusBadge.innerText = 'Model siap';
            statusBadge.className = 'px-4 py-2 rounded-full bg-green-50 text-green-600 font-black text-sm';

            faceInfo.innerText = 'Model berhasil dimuat. Aktifkan kamera.';
            faceInfo.className = 'rounded-2xl bg-green-50 p-5 text-green-600 font-black';
        } catch (error) {
            console.error(error);

            statusBadge.innerText = 'Model gagal';
            statusBadge.className = 'px-4 py-2 rounded-full bg-red-50 text-red-600 font-black text-sm';

            faceInfo.innerText = error.message;
            faceInfo.className = 'rounded-2xl bg-red-50 p-5 text-red-600 font-black';
        }
    }

    async function startCamera() {
        if (!modelsLoaded) {
            alert('Model belum siap.');
            return;
        }

        try {
            stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: 'user',
                    width: { ideal: 640 },
                    height: { ideal: 480 }
                },
                audio: false
            });

            video.srcObject = stream;
            await video.play();

            statusBadge.innerText = 'Kamera aktif';
            statusBadge.className = 'px-4 py-2 rounded-full bg-blue-50 text-blue-600 font-black text-sm';

            faceInfo.innerText = 'Kamera aktif. Klik Simpan Data Wajah saat wajah terlihat jelas.';
            faceInfo.className = 'rounded-2xl bg-blue-50 p-5 text-blue-600 font-black';

            startDetectionLoop();

        } catch (error) {
            console.error(error);

            statusBadge.innerText = 'Kamera gagal';
            statusBadge.className = 'px-4 py-2 rounded-full bg-red-50 text-red-600 font-black text-sm';

            faceInfo.innerText = 'Kamera tidak bisa diakses. Gunakan localhost atau HTTPS.';
            faceInfo.className = 'rounded-2xl bg-red-50 p-5 text-red-600 font-black';
        }
    }

    function startDetectionLoop() {
        if (detectionInterval) {
            clearInterval(detectionInterval);
        }

        detectionInterval = setInterval(async () => {
            if (!video.srcObject || video.paused || video.ended) {
                return;
            }

            const displaySize = {
                width: video.clientWidth,
                height: video.clientHeight
            };

            faceapi.matchDimensions(overlay, displaySize);

            const detections = await faceapi.detectAllFaces(video, detectorOptions);

            const resized = faceapi.resizeResults(detections, displaySize);

            const ctx = overlay.getContext('2d');
            ctx.clearRect(0, 0, overlay.width, overlay.height);

            faceapi.draw.drawDetections(overlay, resized);

            if (detections.length === 1) {
                statusBadge.innerText = 'Wajah terlihat';
                statusBadge.className = 'px-4 py-2 rounded-full bg-green-50 text-green-600 font-black text-sm';

                faceInfo.innerText = 'Wajah terlihat. Klik Simpan Data Wajah.';
                faceInfo.className = 'rounded-2xl bg-green-50 p-5 text-green-600 font-black';
            } else if (detections.length > 1) {
                statusBadge.innerText = 'Terlalu Banyak Wajah';
                statusBadge.className = 'px-4 py-2 rounded-full bg-yellow-50 text-yellow-600 font-black text-sm';

                faceInfo.innerText = 'Terdeteksi lebih dari 1 wajah. Pastikan hanya 1 orang.';
                faceInfo.className = 'rounded-2xl bg-yellow-50 p-5 text-yellow-600 font-black';
            } else {
                statusBadge.innerText = 'Mencari Wajah';
                statusBadge.className = 'px-4 py-2 rounded-full bg-slate-50 text-slate-500 font-black text-sm';

                faceInfo.innerText = 'Arahkan wajah ke kamera. Jika sudah jelas, klik Simpan Data Wajah.';
                faceInfo.className = 'rounded-2xl bg-slate-50 p-5 text-slate-500 font-bold';
            }
        }, 700);
    }

    async function registerFace() {
        if (!modelsLoaded) {
            alert('Model belum siap.');
            return;
        }

        if (!video.srcObject) {
            alert('Aktifkan kamera dulu.');
            return;
        }

        if (detectionInterval) {
            clearInterval(detectionInterval);
            detectionInterval = null;
        }

        faceInfo.innerText = 'Mencari wajah... tahan posisi sebentar.';
        faceInfo.className = 'rounded-2xl bg-yellow-50 p-5 text-yellow-600 font-black';

        statusBadge.innerText = 'Scanning...';
        statusBadge.className = 'px-4 py-2 rounded-full bg-yellow-50 text-yellow-600 font-black text-sm';

        for (let i = 0; i < 10; i++) {
            const detection = await faceapi
                .detectSingleFace(video, saveDetectorOptions)
                .withFaceLandmarks()
                .withFaceDescriptor();

            if (detection) {
                faceDescriptor.value = JSON.stringify(Array.from(detection.descriptor));

                faceInfo.innerText = 'Wajah terdeteksi. Menyimpan data...';
                faceInfo.className = 'rounded-2xl bg-green-50 p-5 text-green-600 font-black';

                statusBadge.innerText = 'Berhasil';
                statusBadge.className = 'px-4 py-2 rounded-full bg-green-50 text-green-600 font-black text-sm';

                document.getElementById('faceForm').submit();
                return;
            }

            await new Promise(resolve => setTimeout(resolve, 300));
        }

        faceInfo.innerText = 'Wajah belum terdeteksi. Coba dekatkan wajah, tambah cahaya, lalu ulangi.';
        faceInfo.className = 'rounded-2xl bg-red-50 p-5 text-red-600 font-black';

        statusBadge.innerText = 'Gagal Deteksi';
        statusBadge.className = 'px-4 py-2 rounded-full bg-red-50 text-red-600 font-black text-sm';

        startDetectionLoop();
    }

    loadModels();
</script>
</script>

</x-app-layout>