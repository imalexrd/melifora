import { Html5Qrcode } from "html5-qrcode";

const setupQrScanner = () => {
    const qrScannerModal = document.getElementById('qr-scanner-modal');
    // If the modal doesn't exist, we are not on the hives index page, so do nothing.
    if (!qrScannerModal) {
        return;
    }

    const openQrScannerButton = document.getElementById('scan-qr-button');
    const closeQrScannerButton = document.getElementById('close-qr-scanner-modal');
    const qrScanResult = document.getElementById('qr-scan-result');
    const hiveCheckboxes = document.querySelectorAll('.hive-checkbox');
    const bulkActionsDiv = document.getElementById('bulk-actions');

    // Make sure all elements are present before proceeding
    if (!openQrScannerButton || !closeQrScannerButton || !qrScanResult || !hiveCheckboxes.length || !bulkActionsDiv) {
        console.error("QR Scanner setup failed: one or more required elements are missing from the DOM.");
        return;
    }

    let html5QrCode;

    function updateBulkActionsVisibility() {
        const selectedIds = Array.from(hiveCheckboxes)
                               .filter(checkbox => checkbox.checked)
                               .map(checkbox => checkbox.value);
        bulkActionsDiv.classList.toggle('hidden', selectedIds.length === 0);
    }

    function onScanSuccess(decodedText, decodedResult) {
        let hiveSlug;
        try {
            // Try to parse it as a URL first
            const url = new URL(decodedText);
            const pathSegments = url.pathname.split('/');
            hiveSlug = pathSegments.pop() || pathSegments.pop(); // handle trailing slash
        } catch (e) {
            // If it's not a valid URL, assume the decoded text is the slug itself
            hiveSlug = decodedText.trim();
        }

        if (hiveSlug) {
            const checkbox = document.querySelector(`.hive-checkbox[data-slug="${hiveSlug}"]`);
            if (checkbox) {
                if (!checkbox.checked) {
                    checkbox.checked = true;
                    updateBulkActionsVisibility();
                    qrScanResult.textContent = `Colmena "${hiveSlug}" seleccionada. ¡Listo para el siguiente!`;
                } else {
                    qrScanResult.textContent = `Colmena "${hiveSlug}" ya estaba seleccionada.`;
                }
            } else {
                qrScanResult.textContent = `Colmena "${hiveSlug}" no encontrada en esta página.`;
            }
        } else {
            qrScanResult.textContent = 'El código QR no parece contener un identificador de colmena válido.';
        }
    }


    function onScanFailure(error) {
        // This callback is called frequently, so we don't log anything to avoid spamming the console.
        // console.warn(`Code scan error = ${error}`);
    }

    const startScanner = () => {
        // First, check for camera permissions and availability
        Html5Qrcode.getCameras().then(cameras => {
            if (cameras && cameras.length) {
                // Cameras are available
                html5QrCode = new Html5Qrcode("qr-reader");
                const config = {
                    fps: 10,
                    qrbox: { width: 250, height: 250 },
                    rememberLastUsedCamera: true,
                    supportedScanTypes: [0] // 0 for camera
                };
                html5QrCode.start({ facingMode: "environment" }, config, onScanSuccess, onScanFailure)
                    .catch(err => {
                        console.error("Unable to start scanning.", err);
                        qrScanResult.textContent = "No se pudo iniciar el escáner. ¿Ha concedido permisos de cámara?";
                    });
            } else {
                qrScanResult.textContent = "No se encontraron cámaras. Por favor, conecte una cámara y conceda permisos.";
            }
        }).catch(err => {
            // This error usually means the user has denied camera permissions.
            console.error("Error getting cameras", err);
            qrScanResult.textContent = "Error al acceder a la cámara. Por favor, conceda permisos de cámara en la configuración de su navegador.";
        });
    };

    const stopScanner = () => {
        if (html5QrCode && html5QrCode.isScanning) {
            html5QrCode.stop()
                .then(() => {
                    // console.log("QR Code scanning stopped.");
                })
                .catch(err => {
                    // console.warn("Error stopping the scanner.", err)
                });
        }
    };

    openQrScannerButton.addEventListener('click', () => {
        qrScannerModal.classList.remove('hidden');
        qrScanResult.textContent = "Apunte la cámara al código QR...";
        // Use a short delay to ensure the modal is fully visible before starting the scanner
        setTimeout(startScanner, 100);
    });

    closeQrScannerButton.addEventListener('click', () => {
        stopScanner();
        qrScannerModal.classList.add('hidden');
    });
};

// Wait for the DOM to be fully loaded before setting up the scanner
if (document.readyState === "complete" || document.readyState === "interactive") {
    setupQrScanner();
} else {
    document.addEventListener('DOMContentLoaded', setupQrScanner);
}
