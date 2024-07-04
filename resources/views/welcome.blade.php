<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-6xl text-white leading-tight text-center uppercase">
            {{ __('Registra tu Asistencia') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-center py-10">
                    <div id="clock" class="text-9xl font-bold mb-10"></div>

                    @if ($errors->any())
                        <div class="mb-4 bg-red-500 border border-red-800 py-2 ">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="text-white font-bold">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="mb-4 bg-green-500 border border-green-800 text-white font-bold py-2 uppercase">
                            {{ session('status') }}
                            <p class=" font-bold text-5xl">{{session('employee_name')}}</p> 
                        </div>
                    @endif

                    <div class="max-w-md mx-auto">
                        <form id="attendance-form" action="{{ route('attendance.store') }}" method="POST" class="bg-white p-8 rounded shadow-md" novalidate>
                            @csrf
                            <input type="text" id="employee_id" name="employee_id" placeholder="Ingresa tu código de empleado" class="w-full mb-4 p-3 border rounded text-lg" required>
                            <input type="submit" value="Registrar Asistencia" class="w-full bg-blue-500 text-white p-3 rounded text-lg cursor-pointer hover:bg-blue-600">
                        </form>
                    </div>
                </div>

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
                    updateClock(); 
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
