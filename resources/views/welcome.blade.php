<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 leading-tight text-center uppercase">
            {{ __('Registra tu Asistencia') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-center py-10">
                    <div id="clock" class="text-9xl font-bold mb-10"></div>
                    <div id="camera-container" class="mb-4">
                        <div id="reader" class="w-full h-64 border-2 border-black mx-auto"></div>
                    </div>
                    <div class="max-w-md mx-auto">
                        <form id="attendance-form"  method="POST" class="bg-white p-8 rounded shadow-md">
                            @csrf
                            <input type="hidden" id="employee_id" name="employee_id">
                            <input type="submit" value="Registrar Asistencia" class="w-full bg-blue-500 text-white p-3 rounded text-lg cursor-pointer hover:bg-blue-600">
                        </form>
                    </div>
                </div>

                <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
                <script>
                    function updateClock() {
                        const clockElement = document.getElementById('clock');
                        const now = new Date();
                        const hours = String(now.getHours()).padStart(2, '0');
                        const minutes = String(now.getMinutes()).padStart(2, '0');
                        const seconds = String(now.getSeconds()).padStart(2, '0');
                        clockElement.textContent = `${hours}:${minutes}:${seconds}`;
                    }

                    setInterval(updateClock, 1000);
                    updateClock(); // Initial call to display clock immediately

                    // Initialize the QR code scanner
                    function onScanSuccess(decodedText, decodedResult) {
                        // Handle the result here
                        console.log(`Scan result: ${decodedText}`, decodedResult);
                        document.getElementById('employee_id').value = decodedText;
                        document.getElementById('attendance-form').submit();
                    }

                    function onScanFailure(error) {
                        console.warn(`Scan failed: ${error}`);
                    }

                    window.addEventListener('load', () => {
                        updateClock();
                        // Create a new instance of Html5QrcodeScanner
                        const html5QrCodeScanner = new Html5QrcodeScanner(
                            "reader", 
                            { fps: 10, qrbox: 250 },
                            false);
                        html5QrCodeScanner.render(onScanSuccess, onScanFailure);
                    });
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
