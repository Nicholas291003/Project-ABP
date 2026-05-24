<div class="grid grid-cols-7 gap-1.5 text-center text-xs font-bold text-gray-400 mb-3">
    <div>A</div><div>B</div><div>C</div><div></div><div>D</div><div>E</div><div>F</div>
</div>
<div class="space-y-2 max-h-[380px] overflow-y-auto pr-1">
    @for ($row = 1; $row <= 20; $row++)
        <div class="grid grid-cols-7 gap-1.5 items-center text-center">
            <button type="button" onclick="toggleSeat('{{ $row }}A')" id="seat-{{ $row }}A" class="h-7 bg-gray-300 text-white rounded text-[11px] font-bold shadow-sm transition">{{ $row }}</button>
            <button type="button" onclick="toggleSeat('{{ $row }}B')" id="seat-{{ $row }}B" class="h-7 bg-gray-300 text-white rounded text-[11px] font-bold shadow-sm transition">{{ $row }}</button>
            <button type="button" onclick="toggleSeat('{{ $row }}C')" id="seat-{{ $row }}C" class="h-7 bg-gray-300 text-white rounded text-[11px] font-bold shadow-sm transition">{{ $row }}</button>
            <div class="text-xs font-bold text-gray-400">{{ $row }}</div>
            <button type="button" onclick="toggleSeat('{{ $row }}D')" id="seat-{{ $row }}D" class="h-7 bg-gray-300 text-white rounded text-[11px] font-bold shadow-sm transition">{{ $row }}</button>
            <button type="button" onclick="toggleSeat('{{ $row }}E')" id="seat-{{ $row }}E" class="h-7 bg-gray-300 text-white rounded text-[11px] font-bold shadow-sm transition">{{ $row }}</button>
            <button type="button" onclick="toggleSeat('{{ $row }}F')" id="seat-{{ $row }}F" class="h-7 bg-gray-300 text-white rounded text-[11px] font-bold shadow-sm transition">{{ $row }}</button>
        </div>
    @endfor
</div>