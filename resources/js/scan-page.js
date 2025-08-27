import { Html5Qrcode } from "html5-qrcode";

document.addEventListener('DOMContentLoaded', function () {
    const qrReaderDiv = document.getElementById('qr-reader');
    if (!qrReaderDiv) {
        return; // We are not on the scan page
    }

    const startScanBtn = document.getElementById('start-scan-btn');
    const stopScanBtn = document.getElementById('stop-scan-btn');
    const qrScanResult = document.getElementById('qr-scan-result');
    const scannedHivesList = document.getElementById('scanned-hives-list');
    const noHivesMessage = document.getElementById('no-hives-message');
    const bulkActionsContainer = document.getElementById('bulk-actions-container');
    const noActionsMessage = document.getElementById('no-actions-message');

    let html5QrCode;
    const scannedHiveIds = new Set();

    const onScanSuccess = (decodedText, decodedResult) => {
        let hiveSlug;
        try {
            const url = new URL(decodedText);
            const pathSegments = url.pathname.split('/');
            hiveSlug = pathSegments.pop() || pathSegments.pop();
        } catch (e) {
            hiveSlug = decodedText.trim();
        }

        if (hiveSlug) {
            fetch(`/hives/find-by-slug/${hiveSlug}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Colmena no encontrada o no autorizada.');
                    }
                    return response.json();
                })
                .then(hive => {
                    if (scannedHiveIds.has(hive.id)) {
                        qrScanResult.textContent = `La colmena "${hive.name}" ya ha sido escaneada.`;
                        return;
                    }

                    scannedHiveIds.add(hive.id);
                    const listItem = document.createElement('li');
                    listItem.textContent = `Colmena: ${hive.name} (Apiario: ${hive.apiary.name})`;
                    listItem.setAttribute('data-hive-id', hive.id);
                    scannedHivesList.appendChild(listItem);

                    qrScanResult.textContent = `Colmena "${hive.name}" añadida a la lista.`;
                    updateUi();
                })
                .catch(error => {
                    qrScanResult.textContent = error.message;
                });
        }
    };

    const onScanFailure = (error) => {
        // console.warn(`Code scan error = ${error}`);
    };

    const startScanner = () => {
        html5QrCode = new Html5Qrcode("qr-reader");
        const config = {
            fps: 10,
            qrbox: { width: 250, height: 250 },
            rememberLastUsedCamera: true
        };
        html5QrCode.start({ facingMode: "environment" }, config, onScanSuccess, onScanFailure)
            .then(() => {
                startScanBtn.classList.add('hidden');
                stopScanBtn.classList.remove('hidden');
                qrScanResult.textContent = "Escáner iniciado. Apunte la cámara al código QR.";
            })
            .catch(err => {
                console.error("Unable to start scanning.", err);
                qrScanResult.textContent = "No se pudo iniciar el escáner. Verifique los permisos de la cámara.";
            });
    };

    const stopScanner = () => {
        if (html5QrCode && html5QrCode.isScanning) {
            html5QrCode.stop()
                .then(() => {
                    startScanBtn.classList.remove('hidden');
                    stopScanBtn.classList.add('hidden');
                    qrScanResult.textContent = "Escáner detenido.";
                })
                .catch(err => {
                    console.warn("Error stopping the scanner.", err);
                    qrScanResult.textContent = "Error al detener el escáner.";
                });
        }
    };

    const updateUi = () => {
        if (scannedHiveIds.size > 0) {
            noHivesMessage.classList.add('hidden');
            bulkActionsContainer.classList.remove('hidden');
            noActionsMessage.classList.add('hidden');
        } else {
            noHivesMessage.classList.remove('hidden');
            bulkActionsContainer.classList.add('hidden');
            noActionsMessage.classList.remove('hidden');
        }
    };

    startScanBtn.addEventListener('click', startScanner);
    stopScanBtn.addEventListener('click', stopScanner);

    // Bulk actions
    const moveBtn = document.getElementById('bulk-move-btn');
    const deleteBtn = document.getElementById('bulk-delete-btn');
    const printQrBtn = document.getElementById('bulk-print-qr-btn');

    const moveModal = document.getElementById('move-modal');
    const deleteModal = document.getElementById('delete-modal');
    const inspectModal = document.getElementById('inspect-modal');

    const confirmMoveBtn = document.getElementById('confirm-move-button');
    const cancelMoveBtn = document.getElementById('cancel-move-button');
    const confirmDeleteBtn = document.getElementById('confirm-delete-button');
    const cancelDeleteBtn = document.getElementById('cancel-delete-button');
    const moveApiarySelect = document.getElementById('move-apiary-select');
    const inspectBtn = document.getElementById('bulk-inspect-btn');
    const cancelInspectBtn = document.getElementById('cancel-inspect-button');
    const confirmInspectBtn = document.getElementById('confirm-inspect-button');

    moveBtn.addEventListener('click', () => moveModal.classList.remove('hidden'));
    deleteBtn.addEventListener('click', () => deleteModal.classList.remove('hidden'));
    inspectBtn.addEventListener('click', () => inspectModal.classList.remove('hidden'));
    cancelMoveBtn.addEventListener('click', () => moveModal.classList.add('hidden'));
    cancelDeleteBtn.addEventListener('click', () => deleteModal.classList.add('hidden'));
    cancelInspectBtn.addEventListener('click', () => inspectModal.classList.add('hidden'));

    confirmMoveBtn.addEventListener('click', () => {
        const hiveIds = Array.from(scannedHiveIds);
        const apiaryId = moveApiarySelect.value;
        performBulkAction('move', hiveIds, { apiary_id: apiaryId });
    });

    confirmDeleteBtn.addEventListener('click', () => {
        const hiveIds = Array.from(scannedHiveIds);
        performBulkAction('delete', hiveIds);
    });

    confirmInspectBtn.addEventListener('click', () => {
        const inspectionDate = document.getElementById('inspection_date').value;
        if (!inspectionDate) {
            alert('Por favor, seleccione una fecha de inspección.');
            return;
        }

        const hiveIds = Array.from(scannedHiveIds);
        const inspectionData = {
            inspection_date: inspectionDate,
            queen_status: document.getElementById('queen_status').value,
            population: document.getElementById('population').value,
            honey_stores: document.getElementById('honey_stores').value,
            pollen_stores: document.getElementById('pollen_stores').value,
            brood_pattern: document.getElementById('brood_pattern').value,
            behavior: document.getElementById('behavior').value,
            pests_diseases: document.getElementById('pests_diseases').value,
            treatments: document.getElementById('treatments').value,
            notes: document.getElementById('notes').value,
            anomalies: document.getElementById('anomalies').value,
            social_states: document.getElementById('social_states').value,
            season_states: document.getElementById('season_states').value,
            admin_states: document.getElementById('admin_states').value,
        };
        performBulkAction('inspect', hiveIds, inspectionData);
    });

    printQrBtn.addEventListener('click', () => {
        const hiveIds = Array.from(scannedHiveIds);
        if (hiveIds.length > 0) {
            // We need to get slugs for printing, not IDs. We'll need to fetch them or store them.
            // For now, let's assume we need to implement a way to get slugs.
            // A simple way is to store the slug along with the ID when scanning.
            alert('La impresión de QR desde esta página aún no está implementada.');
        } else {
            alert('Por favor, escanee al menos una colmena.');
        }
    });


    function performBulkAction(action, hiveIds, data = {}) {
        if (hiveIds.length === 0) {
            alert('Por favor, escanee al menos una colmena.');
            return;
        }

        // We need to get the CSRF token from the meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/hives/bulk-actions', { // Using the absolute path
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                action: action,
                hive_ids: hiveIds,
                ...data
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Ocurrió un error.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ocurrió un error al procesar la solicitud.');
        });
    }

    updateUi(); // Initial UI state
});
