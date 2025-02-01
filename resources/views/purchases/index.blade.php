<x-app-layout>
    <div class="mt-6">

        <x-container>
            <div class="mb-4 flex justify-start">
                <button onclick="window.history.back()" class="text-blue-500 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
            </div>

            <div class="card bg-white shadow-md rounded-lg">

                <h1 class="text-2xl font-bold mb-4">Mis compras</h1>

                @if ($purchases->isEmpty())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                            role="alert">
                            <strong class="font-bold">¡No hay compras!</strong>
                            <span class="block sm:inline">No has realizado ninguna compra.</span>
                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            </span>
                    </div>
                    @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="py-3 px-4 border-b border-gray-200 text-center font-semibold">Fecha</th>
                                    <th class="py-3 px-4 border-b border-gray-200 text-center font-semibold">Total</th>
                                    <th class="py-3 px-4 border-b border-gray-200 text-center font-semibold">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchases as $purchase)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4 border-b border-gray-200 text-center">{{ $purchase->created_at->format('d/m/Y') }}</td>
                                        <td class="py-3 px-4 border-b border-gray-200 text-center">${{ number_format($purchase->total, 2) }}</td>
                                        <td class="py-3 px-4 border-b border-gray-200 text-center">
                                            <a href="{{ route('purchases.show', $purchase->id) }}" class="text-blue-500 hover:underline">Ver detalles</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </x-container>
    </div>

</x-app-layout>
