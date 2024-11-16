<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR Code for Check-In</title>
    <script src="https://unpkg.com/jsqr/dist/jsQR.js"></script>
    <style>
        #modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        #modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            max-width: 500px;
            text-align: center;
        }
        button {
            margin-top: 10px;
            padding: 10px 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Scan QR Code to Check In</h1>
    <video id="qr-video" style="width: 100%; max-width: 500px;"></video>
    
    <!-- Modal -->
    <div id="modal">
        <div id="modal-content">
            <h2>Data Pendaftaran</h2>
            <p><strong>Kode Unik:</strong> <span id="kode-unik"></span></p>
            <p><strong>Peserta:</strong> <span id="name"></span></p>
            <p><strong>NIM:</strong> <span id="nim"></span></p>
            <p><strong>Program Studi:</strong> <span id="program_studi"></span></p>
            <p><strong>Email:</strong> <span id="email"></span></p>
            <button id="check-in-btn">Check In</button>
            <button id="cancel-btn">Batal</button>
        </div>
    </div>

    <script>
        const video = document.getElementById('qr-video');
        const modal = document.getElementById('modal');
        const resultElement = document.getElementById('modal-content');
        const nameElement = document.getElementById('name');
        const nimElement = document.getElementById('nim');
        const emailElement = document.getElementById('email');
        const programStudiElement = document.getElementById('program_studi');
        const kodeUnikElement = document.getElementById('kode-unik');
        const checkInBtn = document.getElementById('check-in-btn');
        const cancelBtn = document.getElementById('cancel-btn');

        // Akses kamera
        navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
            .then((stream) => {
                video.srcObject = stream;
                video.setAttribute('playsinline', true);
                video.play();
                video.addEventListener('play', () => {
                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d');

                    function scanQRCode() {
                        if (video.readyState === video.HAVE_ENOUGH_DATA) {
                            canvas.height = video.videoHeight;
                            canvas.width = video.videoWidth;
                            context.drawImage(video, 0, 0, canvas.width, canvas.height);

                            const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                            const qrCode = jsQR(imageData.data, canvas.width, canvas.height);

                            if (qrCode) {
                                const qrData = JSON.parse(qrCode.data);
                                
                                nameElement.textContent = qrData.name;
                                nimElement.textContent = qrData.nim;
                                emailElement.textContent = qrData.email;
                                programStudiElement.textContent = qrData.program_studi;
                                kodeUnikElement.textContent = qrData.kode_unik;
                                modal.style.display = 'flex';
                                checkInBtn.onclick = function() {
                                    fetch(`/admin/check-in/${qrData.nim}`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({ nim: qrData.nim })
                                    }).then(response => {
                                        if (response.ok) {
                                            const audio = new Audio('/sounds/check-in.mp3');
                                            audio.play();
                                            alert('Checked in successfully!');
                                            modal.style.display = 'none';
                                        } else {
                                            alert('Failed to check in');
                                        }
                                    });
                                };
                                cancelBtn.onclick = function() {
                                    modal.style.display = 'none';
                                };
                            }
                        }
                        requestAnimationFrame(scanQRCode);
                    }

                    scanQRCode();
                });
            })
            .catch((error) => {
                console.error("Error accessing camera: ", error);
            });
    </script>
</body>
</html>
