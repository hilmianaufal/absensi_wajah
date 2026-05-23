<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-sky-50 via-white to-cyan-100 p-4 lg:p-8">
        <div class="max-w-7xl mx-auto">

            <div class="rounded-[2.5rem] bg-white/80 backdrop-blur-2xl border border-white shadow-2xl p-6 lg:p-10 mb-8 overflow-hidden relative">
                <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 text-blue-600 font-black text-sm mb-4">
                            🤖 Realtime Face Attendance
                        </div>

                        <h1 class="text-4xl lg:text-6xl font-black text-slate-950 tracking-tight">
                            Scan Wajah Otomatis
                        </h1>

                        <p class="text-slate-500 mt-4 max-w-xl font-medium">
                            Kamera akan mengenali wajah karyawan dan menyimpan absensi otomatis.
                        </p>
                    </div>

                    <a href="{{ route('attendances.index') }}"
                       class="inline-flex items-center justify-center px-6 py-4 rounded-2xl bg-slate-950 text-white font-black shadow-xl hover:scale-105 transition">
                        Riwayat Absensi
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 items-start">

                <div class="rounded-[2.5rem] bg-white/90 border border-white shadow-2xl p-5 lg:p-7">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-2xl lg:text-3xl font-black text-slate-950">
                                Live Recognition
                            </h2>
                            <p class="text-slate-400 font-medium mt-1">
                                Arahkan wajah ke kamera.
                            </p>
                        </div>

                        <div id="systemStatus"
                             class="w-fit px-4 py-2 rounded-full bg-yellow-50 text-yellow-600 text-sm font-black border border-yellow-100">
                            Memuat model...
                        </div>
                    </div>

                    <div class="relative aspect-video rounded-[2rem] overflow-hidden bg-slate-950 shadow-2xl border-[6px] border-white">
                        <video id="video" autoplay muted playsinline class="w-full h-full object-cover"></video>
                        <canvas id="overlay" class="absolute inset-0 w-full h-full"></canvas>

                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div class="relative w-52 h-52 md:w-72 md:h-72 rounded-full border-[5px] border-cyan-300 shadow-[0_0_80px_rgba(34,211,238,0.85)]"></div>
                        </div>

                        <div id="cameraBadge"
                             class="absolute right-5 top-5 px-4 py-2 rounded-full bg-yellow-400/90 text-white font-black text-sm shadow-xl">
                            Offline
                        </div>

                        <div id="scanMessage"
                             class="absolute left-5 bottom-5 right-5 px-4 py-3 rounded-2xl bg-white/20 backdrop-blur-xl text-white font-black border border-white/20">
                            Menyiapkan sistem...
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                        <button type="button"
                                onclick="startRealtimeScan()"
                                class="px-6 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-400 text-white font-black shadow-xl hover:scale-105 transition">
                            📹 Mulai Scan Otomatis
                        </button>

                        <button type="button"
                                onclick="stopRealtimeScan()"
                                class="px-6 py-4 rounded-2xl bg-red-50 text-red-600 font-black border border-red-100 hover:bg-red-100 hover:scale-105 transition">
                            ⛔ Stop Kamera
                        </button>
                    </div>
                </div>

                <div class="rounded-[2.5rem] bg-white/95 border border-white shadow-2xl p-6 lg:p-7">
                    <div id="resultCard"
                         class="rounded-[2rem] bg-slate-50 border border-slate-100 p-6 text-center">
                        <div class="w-28 h-28 rounded-full bg-gradient-to-br from-blue-100 to-cyan-100 mx-auto flex items-center justify-center text-5xl shadow-inner">
                            🙂
                        </div>

                        <h3 id="resultName" class="mt-5 text-2xl font-black text-slate-900">
                            Belum Ada Wajah
                        </h3>

                        <p id="resultCode" class="text-slate-400 font-bold mt-1">
                            Menunggu scan...
                        </p>

                        <div id="resultStatus"
                             class="mt-5 inline-flex px-4 py-2 rounded-full bg-yellow-50 text-yellow-600 font-black text-sm">
                            Standby
                        </div>
                    </div>

                    <div class="mt-6 rounded-[2rem] bg-gradient-to-br from-blue-50 to-cyan-50 border border-blue-100 p-5">
                        <p class="font-black text-slate-800">Status Sistem</p>

                        <div class="mt-4 space-y-3 text-sm">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500 font-bold">Model AI</span>
                                <span id="modelStatusText" class="text-yellow-600 font-black">Loading</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-slate-500 font-bold">Data Wajah</span>
                                <span id="descriptorStatusText" class="text-yellow-600 font-black">Loading</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-slate-500 font-bold">Kamera</span>
                                <span id="cameraStatusText" class="text-slate-500 font-black">Offline</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 rounded-[2rem] bg-white border border-slate-100 p-5 shadow-sm">
                        <p class="font-black text-slate-800 mb-4">
                            Mode Absensi
                        </p>

                        <div class="grid grid-cols-2 gap-3">
                            <button type="button"
                                    id="checkinModeBtn"
                                    onclick="setScanMode('checkin')"
                                    class="px-4 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-400 text-white font-black shadow-xl">
                                Check-in
                            </button>

                            <button type="button"
                                    id="checkoutModeBtn"
                                    onclick="setScanMode('checkout')"
                                    class="px-4 py-4 rounded-2xl bg-slate-100 text-slate-600 font-black">
                                Check-out
                            </button>
                        </div>

                        <p id="scanModeText" class="mt-4 text-sm font-bold text-blue-600">
                            Mode aktif: Check-in
                        </p>
                    </div>
                    <div class="mt-6 rounded-[2rem] bg-slate-950 text-white p-5">
                        <p class="font-black">Log Aktivitas</p>
                        <div id="activityLog" class="mt-3 text-sm text-slate-300 space-y-2 max-h-48 overflow-y-auto">
                            <p>Menunggu sistem aktif...</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- TARUH FILE INI DI public/sounds --}}
    <audio id="successSound" src="{{ asset('sounds/success.mp3') }}" preload="auto"></audio>
    <audio id="errorSound" src="{{ asset('sounds/error.mp3') }}" preload="auto"></audio>
    <div id="welcomeOverlay"
        class="fixed inset-0 z-[9999] hidden items-center justify-center bg-slate-950/90 backdrop-blur-2xl">

        <div class="text-center px-6">

            <div class="w-44 h-44 rounded-full overflow-hidden border-[8px] border-white shadow-[0_0_80px_rgba(255,255,255,0.3)] mx-auto mb-8">
                <img id="welcomePhoto"
                    src=""
                    class="w-full h-full object-cover">
            </div>

            <h1 id="welcomeName"
                class="text-5xl lg:text-7xl font-black text-white">
                -
            </h1>

            <p id="welcomeText"
            class="mt-6 text-cyan-300 text-2xl font-black">
                Check-in Berhasil
            </p>

        </div>
    </div>
 <script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

<script>
    const video = document.getElementById('video');
    const overlay = document.getElementById('overlay');

    const systemStatus = document.getElementById('systemStatus');
    const cameraBadge = document.getElementById('cameraBadge');
    const scanMessage = document.getElementById('scanMessage');

    const resultName = document.getElementById('resultName');
    const resultCode = document.getElementById('resultCode');
    const resultStatus = document.getElementById('resultStatus');

    const modelStatusText = document.getElementById('modelStatusText');
    const descriptorStatusText = document.getElementById('descriptorStatusText');
    const cameraStatusText = document.getElementById('cameraStatusText');
    const activityLog = document.getElementById('activityLog');

    const successSound = document.getElementById('successSound');
    const errorSound = document.getElementById('errorSound');

    let stream = null;
    let scanInterval = null;

    let labeledDescriptors = [];
    let employeesData = [];
    let faceMatcher = null;

    let isProcessingAttendance = false;
    let lastRecognizedEmployeeId = null;
    let lastRecognizedAt = 0;

    let currentLatitude = null;
    let currentLongitude = null;

    let scanMode = 'checkin';

    const detectorOptions = new faceapi.TinyFaceDetectorOptions({
        inputSize: 160,
        scoreThreshold: 0.25
    });

    function setScanMode(mode) {

        scanMode = mode;

        const checkinBtn = document.getElementById('checkinModeBtn');
        const checkoutBtn = document.getElementById('checkoutModeBtn');
        const modeText = document.getElementById('scanModeText');

        if (mode === 'checkin') {

            checkinBtn.className =
                'px-4 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-400 text-white font-black shadow-xl';

            checkoutBtn.className =
                'px-4 py-4 rounded-2xl bg-slate-100 text-slate-600 font-black';

            modeText.innerText = 'Mode aktif: Check-in';
            modeText.className = 'mt-4 text-sm font-bold text-blue-600';

            scanMessage.innerText =
                'Mode Check-in aktif. Semua wajah dikenali akan check-in.';

        } else {

            checkoutBtn.className =
                'px-4 py-4 rounded-2xl bg-gradient-to-r from-slate-900 to-slate-700 text-white font-black shadow-xl';

            checkinBtn.className =
                'px-4 py-4 rounded-2xl bg-slate-100 text-slate-600 font-black';

            modeText.innerText = 'Mode aktif: Check-out';
            modeText.className = 'mt-4 text-sm font-bold text-slate-700';

            scanMessage.innerText =
                'Mode Check-out aktif. Semua wajah dikenali akan check-out.';
        }
    }

    function addLog(message) {

        const time = new Date().toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });

        const item = document.createElement('p');

        item.innerText = `[${time}] ${message}`;

        activityLog.prepend(item);
    }

    function setSystemReady() {

        systemStatus.innerText = 'Sistem Siap';

        systemStatus.className =
            'w-fit px-4 py-2 rounded-full bg-green-50 text-green-600 text-sm font-black border border-green-100';
    }

    async function loadModels() {

        try {

            scanMessage.innerText = 'Memuat model AI...';

            await faceapi.nets.tinyFaceDetector.loadFromUri('/models');

            await faceapi.nets.faceLandmark68Net.loadFromUri('/models');

            await faceapi.nets.faceRecognitionNet.loadFromUri('/models');

            modelStatusText.innerText = 'Ready';
            modelStatusText.className = 'text-green-600 font-black';

            addLog('Model AI berhasil dimuat.');

        } catch (error) {

            console.error(error);

            systemStatus.innerText = 'Model Gagal';

            systemStatus.className =
                'w-fit px-4 py-2 rounded-full bg-red-50 text-red-600 text-sm font-black border border-red-100';

            modelStatusText.innerText = 'Error';
            modelStatusText.className = 'text-red-600 font-black';

            scanMessage.innerText = error.message;
        }
    }

    async function loadDescriptors() {

        try {

            scanMessage.innerText = 'Memuat data wajah karyawan...';

            const response =
                await fetch('{{ route('face-recognition.descriptors') }}');

            employeesData = await response.json();

            labeledDescriptors = employeesData
                .filter(employee =>
                    employee.descriptor &&
                    employee.descriptor.length
                )
                .map(employee => {

                    return new faceapi.LabeledFaceDescriptors(
                        String(employee.id),
                        [new Float32Array(employee.descriptor)]
                    );
                });

            if (labeledDescriptors.length === 0) {

                descriptorStatusText.innerText = 'Kosong';
                descriptorStatusText.className = 'text-red-600 font-black';

                scanMessage.innerText =
                    'Belum ada wajah karyawan yang diregistrasi.';

                addLog('Data wajah masih kosong.');

                return;
            }

            faceMatcher =
                new faceapi.FaceMatcher(labeledDescriptors, 0.55);

            descriptorStatusText.innerText =
                labeledDescriptors.length + ' Data';

            descriptorStatusText.className =
                'text-green-600 font-black';

            scanMessage.innerText =
                'Sistem siap. Klik Mulai Scan Otomatis.';

            addLog(
                labeledDescriptors.length +
                ' data wajah berhasil dimuat.'
            );

            setSystemReady();

        } catch (error) {

            console.error(error);

            descriptorStatusText.innerText = 'Error';
            descriptorStatusText.className = 'text-red-600 font-black';

            scanMessage.innerText = 'Gagal memuat data wajah.';
        }
    }

            function getCurrentLocation() {
            return new Promise((resolve, reject) => {
                if (!navigator.geolocation) {
                    reject('Browser tidak mendukung geolocation.');
                    return;
                }

                navigator.geolocation.getCurrentPosition(
                    position => {
                        currentLatitude = position.coords.latitude;
                        currentLongitude = position.coords.longitude;
                        resolve(position.coords);
                    },
                    error => {
                        reject('Gagal mengambil lokasi. Izinkan akses lokasi.');
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            });
        }

    async function startRealtimeScan() {

        if (!faceMatcher) {

            alert(
                'Data wajah belum siap. Pastikan sudah registrasi wajah karyawan.'
            );

            return;
        }
        try {
            scanMessage.innerText = 'Mengambil lokasi GPS...';
            await getCurrentLocation();
            addLog('Lokasi GPS berhasil diambil.');
        } catch (error) {
            alert(error);
            scanMessage.innerText = error;
            return;
        }
        try {

            stream =
                await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'user',
                        width: {
                            ideal: 640
                        },
                        height: {
                            ideal: 480
                        }
                    },
                    audio: false
                });

            video.srcObject = stream;

            await video.play();

            cameraBadge.innerText = 'Online';

            cameraBadge.className =
                'absolute right-5 top-5 px-4 py-2 rounded-full bg-green-400/90 text-white font-black text-sm shadow-xl';

            cameraStatusText.innerText = 'Online';

            cameraStatusText.className =
                'text-green-600 font-black';

            scanMessage.innerText = 'Scanning realtime...';

            addLog(
                'Kamera aktif. Scan realtime dimulai.'
            );

            startRecognitionLoop();

        } catch (error) {

            console.error(error);

            alert(
                'Kamera tidak bisa diakses. Gunakan localhost atau HTTPS.'
            );
        }
    }

    function stopRealtimeScan() {

        if (scanInterval) {

            clearInterval(scanInterval);

            scanInterval = null;
        }

        if (stream) {

            stream.getTracks().forEach(track => track.stop());

            stream = null;
        }

        video.srcObject = null;

        cameraBadge.innerText = 'Offline';

        cameraBadge.className =
            'absolute right-5 top-5 px-4 py-2 rounded-full bg-yellow-400/90 text-white font-black text-sm shadow-xl';

        cameraStatusText.innerText = 'Offline';

        cameraStatusText.className =
            'text-slate-500 font-black';

        scanMessage.innerText = 'Kamera dimatikan.';

        addLog('Kamera dimatikan.');
    }

    function startRecognitionLoop() {

        if (scanInterval) {

            clearInterval(scanInterval);
        }

        scanInterval = setInterval(async () => {

            if (
                !video.srcObject ||
                video.paused ||
                video.ended ||
                isProcessingAttendance
            ) {
                return;
            }

            const displaySize = {
                width: video.clientWidth,
                height: video.clientHeight
            };

            faceapi.matchDimensions(
                overlay,
                displaySize
            );

            const detections =
                await faceapi
                .detectAllFaces(
                    video,
                    detectorOptions
                )
                .withFaceLandmarks()
                .withFaceDescriptors();

            const resized =
                faceapi.resizeResults(
                    detections,
                    displaySize
                );

            const ctx =
                overlay.getContext('2d');

            ctx.clearRect(
                0,
                0,
                overlay.width,
                overlay.height
            );

            if (detections.length === 0) {

                scanMessage.innerText =
                    'Mencari wajah...';

                return;
            }

            resized.forEach((detection, index) => {

                const bestMatch =
                    faceMatcher.findBestMatch(
                        detections[index].descriptor
                    );

                const box =
                    detection.detection.box;

                let labelText =
                    'Tidak dikenal';

                if (
                    bestMatch.label !==
                    'unknown'
                ) {

                    const employee =
                        employeesData.find(
                            item =>
                            String(item.id) ===
                            bestMatch.label
                        );

                    if (employee) {

                        const accuracy =
                            Math.max(
                                0,
                                Math.round(
                                    (1 - bestMatch.distance) * 100
                                )
                            );

                        labelText =
                            `${employee.name} - ${accuracy}%`;
                    }
                }

                const drawBox =
                    new faceapi.draw.DrawBox(
                        box, {
                            label: labelText,
                            boxColor:
                                bestMatch.label !== 'unknown'
                                ?
                                '#22c55e' :
                                '#ef4444',
                            drawLabelOptions: {
                                fontColor: 'white',
                                fontSize: 20,
                                fontStyle: 'bold',
                                padding: 8
                            }
                        });

                drawBox.draw(overlay);

                if (
                    bestMatch.label !==
                    'unknown'
                ) {

                    const employee =
                        employeesData.find(
                            item =>
                            String(item.id) ===
                            bestMatch.label
                        );

                    if (employee) {

                        handleRecognizedEmployee(
                            employee,
                            bestMatch.distance
                        );
                    }

                } else {

                    scanMessage.innerText =
                        'Wajah tidak dikenali.';

                    resultName.innerText =
                        'Tidak Dikenali';

                    resultCode.innerText =
                        'Belum terdaftar';

                    resultStatus.innerText =
                        'Unknown';

                    resultStatus.className =
                        'mt-5 inline-flex px-4 py-2 rounded-full bg-red-50 text-red-600 font-black text-sm';
                }
            });

        }, 1000);
    }

    async function handleRecognizedEmployee(
        employee,
        distance
    ) {

        const now = Date.now();

        if (
            lastRecognizedEmployeeId === employee.id &&
            now - lastRecognizedAt < 15000
        ) {

            scanMessage.innerText =
                `${employee.name} sudah terdeteksi. Cooldown...`;

            return;
        }

        lastRecognizedEmployeeId =
            employee.id;

        lastRecognizedAt = now;

        isProcessingAttendance = true;

        resultName.innerText =
            employee.name;

        resultCode.innerText =
            employee.code ?? '-';

        resultStatus.innerText =
            'Dikenali';

        resultStatus.className =
            'mt-5 inline-flex px-4 py-2 rounded-full bg-green-50 text-green-600 font-black text-sm';

        scanMessage.innerText =
            `Wajah cocok: ${employee.name}`;

        addLog(
            `Wajah dikenali: ${employee.name}`
        );

        try {

            const response =
                await fetch(
                    '{{ route('face-recognition.check') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            employee_id: employee.id,
                            mode: scanMode,
                            snapshot: captureSnapshot(),
                                latitude: currentLatitude,
                                longitude: currentLongitude
                        })
                    });

            const data =
                await response.json();

            if (data.success) {

                successSound.currentTime = 0;
                successSound.play();
                speakAttendance(employee.name, data.type);
                showWelcome(employee, data.type);
                resultStatus.innerText =
                    data.type === 'checkin'
                    ?
                    'Check-in Berhasil' :
                    'Check-out Berhasil';

                resultStatus.className =
                    'mt-5 inline-flex px-4 py-2 rounded-full bg-blue-50 text-blue-600 font-black text-sm';

                scanMessage.innerText =
                    `${data.employee}: ${data.type === 'checkin' ? 'Check-in berhasil' : 'Check-out berhasil'}`;

                addLog(
                    scanMessage.innerText
                );

            } else {

                errorSound.currentTime = 0;
                errorSound.play();

                resultStatus.innerText =
                    'Info';

                resultStatus.className =
                    'mt-5 inline-flex px-4 py-2 rounded-full bg-yellow-50 text-yellow-600 font-black text-sm';

                scanMessage.innerText =
                    data.message;

                addLog(data.message);
            }

        } catch (error) {

            console.error(error);

            scanMessage.innerText =
                'Gagal menyimpan absensi.';

            addLog(
                'Gagal menyimpan absensi.'
            );
        }

        setTimeout(() => {

            isProcessingAttendance = false;

        }, 2500);
    }
        function speakAttendance(name, type) {

            const speech = new SpeechSynthesisUtterance();

            if (type === 'checkin') {
                speech.text = `Selamat datang ${name}, check in berhasil`;
            } else {
                speech.text = `Sampai jumpa ${name}, check out berhasil`;
            }

            speech.lang = 'id-ID';
            speech.rate = 0.9;
            speech.pitch = 1;
            speech.volume = 1;

            window.speechSynthesis.speak(speech);
        }
        function showWelcome(employee, type) {

    const overlay =
        document.getElementById('welcomeOverlay');

    const photo =
        document.getElementById('welcomePhoto');

    const name =
        document.getElementById('welcomeName');

    const text =
        document.getElementById('welcomeText');

    photo.src =
        employee.photo ??
        'https://ui-avatars.com/api/?name=' + encodeURIComponent(employee.name);

    name.innerText = employee.name;

    text.innerText =
        type === 'checkin'
        ? 'Check-in Berhasil'
        : 'Check-out Berhasil';

    overlay.classList.remove('hidden');
    overlay.classList.add('flex');

    setTimeout(() => {

        overlay.classList.add('hidden');
        overlay.classList.remove('flex');

    }, 3500);
}
    loadModels().then(() => {
        loadDescriptors();
    });

    function captureSnapshot() {
    const canvas = document.createElement('canvas');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    const context = canvas.getContext('2d');
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    return canvas.toDataURL('image/jpeg', 0.8);
}
</script>
</x-app-layout>