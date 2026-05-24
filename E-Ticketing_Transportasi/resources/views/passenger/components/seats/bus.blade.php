<div class="grid grid-cols-5 gap-3 text-center text-xs font-bold text-gray-400 mb-3">
    <div>A</div><div>B</div><div></div><div>C</div><div>D</div>
</div>
<div class="space-y-3">
    @for ($row = 1; $row <= 8; $row++)
        <div class="grid grid-cols-5 gap-3 items-center text-center">
            <button type="button" onclick="toggleSeat('{{ $row }}A')" id="seat-{{ $row }}A" class="h-8 bg-gray-300 text-white rounded font-bold text-xs shadow-sm transition">{{ $row }}</button>
            <button type="button" onclick="toggleSeat('{{ $row }}B')" id="seat-{{ $row }}B" class="h-8 bg-gray-300 text-white rounded font-bold text-xs shadow-sm transition">{{ $row }}</button>
            <div class="text-xs font-bold text-gray-400">{{ $row }}</div>
            <button type="button" onclick="toggleSeat('{{ $row }}C')" id="seat-{{ $row }}C" class="h-8 bg-gray-300 text-white rounded font-bold text-xs shadow-sm transition">{{ $row }}</button>
            <button type="button" onclick="toggleSeat('{{ $row }}D')" id="seat-{{ $row }}D" class="h-8 bg-gray-300 text-white rounded font-bold text-xs shadow-sm transition">{{ $row }}</button>
        </div>
    @endfor
</div>