<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR Code for Check-In</title>
    <script src="https://unpkg.com/jsqr/dist/jsQR.js"></script>
</head>
<body>
    <h1>Scan QR Code to Check In</h1>
    <video id="qr-video" style="width: 100%; max-width: 500px;"></video>
    <div id="qr-result">
        <p><strong>Peserta:</strong> <span id="name"></span></p>
        <p><strong>NIM:</strong> <span id="nim"></span></p>
        <p><strong>Email:</strong> <span id="email"></span></p>
        <button id="check-in-btn" style="display: none;">Check In</button>
    </div>

    <script>
        const video = document.getElementById('qr-video');
        const resultElement = document.getElementById('qr-result');
        const nameElement = document.getElementById('name');
        const nimElement = document.getElementById('nim');
        const emailElement = document.getElementById('email');
        const checkInBtn = document.getElementById('check-in-btn');

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
                                checkInBtn.style.display = 'block';
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
                                            alert('Checked in successfully!');
                                        } else {
                                            alert('Failed to check in');
                                        }
                                    });
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
