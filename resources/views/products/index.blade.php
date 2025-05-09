@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Productos</h1>
        <a href="{{ route('products.create') }}"
           class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
           Nuevo Producto
        </a>
    </div>

    @if(session('success'))
        <div class="bg-blue-100 text-blue-800 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border-collapse">
        <thead>
            <tr>
                <th class="border px-2 py-1">ID</th>
                <th class="border px-2 py-1">Nombre</th>
                <th class="border px-2 py-1">Precio</th>
                <th class="border px-2 py-1">Stock</th>
                <th class="border px-2 py-1">Imagen</th>
                <th class="border px-2 py-1">Vender</th>
                <th class="border px-2 py-1">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $p)
            <tr id="row-{{ $p->id }}">
                <td class="border px-2 py-1">{{ $p->id }}</td>
                <td class="border px-2 py-1">{{ $p->name }}</td>
                <td class="border px-2 py-1">${{ number_format($p->price,2) }}</td>
                <td class="border px-2 py-1" id="stock-{{ $p->id }}">{{ $p->stock }}</td>
                <td class="border px-2 py-1">
                    @if($p->image)
                        <img src="{{ asset('storage/'.$p->image) }}" class="h-12" alt="">
                    @else
                        —
                    @endif
                </td>
                <td class="border px-2 py-1">
                    <button 
                      class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 btn-vender"
                      data-id="{{ $p->id }}"
                      data-name="{{ $p->name }}"
                      data-stock="{{ $p->stock }}">
                      Vender
                    </button>
                </td>
                <td class="border px-2 py-1 space-x-2">
                    <a href="{{ route('products.edit', $p) }}"
                       class="text-blue-600 hover:underline">Editar</a>
                    <form action="{{ route('products.destroy', $p) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('¿Eliminar este producto?')"
                                class="text-red-600 hover:underline">
                          Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-4">No hay productos.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Modal de confirmación de venta --}}
<div id="saleModal"
     class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
  <div class="bg-white rounded-lg overflow-hidden w-96 p-4"
       onclick="event.stopPropagation()">
    <h2 class="text-lg font-semibold mb-2">Vender Producto</h2>
    <p><strong>Producto:</strong> <span id="modalProductName"></span></p>
    <p><strong>Stock actual:</strong> <span id="modalProductStock"></span></p>
    <div class="mt-4">
      <label class="block mb-1">Cantidad a vender</label>
      <input type="number"
             id="saleQuantity"
             class="w-full border rounded px-2 py-1"
             min="1">
    </div>
    <div class="mt-4 flex justify-end space-x-2">
      <button id="btnCancelSale"
              class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400">
        Cancelar
      </button>
      <button id="btnConfirmSale"
              class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
        Confirmar
      </button>
    </div>
  </div>
</div>

{{-- Modal de confirmación exitosa --}}
<div id="successModal"
     class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
  <div class="bg-white rounded-lg overflow-hidden w-80 p-6 text-center">
    <h3 class="text-xl font-semibold mb-4">¡Venta exitosa!</h3>
    <p id="successMessage" class="mb-6">Se han vendido las unidades.</p>
    <button id="btnCloseSuccess"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
      Cerrar
    </button>
  </div>
</div>

<script>
(function() {
  // Elementos comunes
  const saleModal    = document.getElementById('saleModal');
  const nameEl       = document.getElementById('modalProductName');
  const stockEl      = document.getElementById('modalProductStock');
  const qtyEl        = document.getElementById('saleQuantity');
  const successModal = document.getElementById('successModal');
  const successMsg   = document.getElementById('successMessage');
  const btnCloseSuccess = document.getElementById('btnCloseSuccess');

  let currentId, currentName;

  // Funciones para abrir/cerrar modales
  function openSaleModal(btn) {
    currentId   = btn.dataset.id;
    currentName = btn.dataset.name;
    nameEl.textContent  = currentName;
    stockEl.textContent = btn.dataset.stock;
    qtyEl.value         = 1;
    qtyEl.max           = btn.dataset.stock;

    saleModal.classList.remove('hidden');
    saleModal.classList.add('flex');
  }
  function closeSaleModal() {
    saleModal.classList.add('hidden');
    saleModal.classList.remove('flex');
  }
  function closeSuccessModal() {
    successModal.classList.add('hidden');
    successModal.classList.remove('flex');
  }

  // Botones Vender
  document.querySelectorAll('.btn-vender').forEach(btn => {
    btn.addEventListener('click', () => openSaleModal(btn));
  });

  // Cancelar venta
  document.getElementById('btnCancelSale')
          .addEventListener('click', closeSaleModal);

  // Confirmar venta
  document.getElementById('btnConfirmSale')
    .addEventListener('click', () => {
      const qty = parseInt(qtyEl.value, 10);
      if (!qty || qty < 1 || qty > parseInt(qtyEl.max,10)) return;

      fetch("{{ route('sales.store') }}", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
          product_id: currentId,
          quantity: qty
        })
      })
      .then(res => res.json())
      .then(data => {
        closeSaleModal();
        // Actualiza stock en la tabla
        document.getElementById(`stock-${data.product_id}`).textContent = data.new_stock;
        // Muestra modal de éxito
        successMsg.textContent = `Vendidas ${data.quantity} unidad(es) de ${data.product_name}.`;
        successModal.classList.remove('hidden');
        successModal.classList.add('flex');
      })
      .catch(console.error);
    });

  // Cerrar modal de éxito
  btnCloseSuccess.addEventListener('click', closeSuccessModal);

  // Cerrar modales al hacer click fuera
  saleModal.addEventListener('click', closeSaleModal);
  successModal.addEventListener('click', closeSuccessModal);
})();
</script>
@endsection
