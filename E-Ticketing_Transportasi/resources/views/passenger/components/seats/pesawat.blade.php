<div class="grid grid-cols-7 gap-1.5 text-center text-xs font-black text-slate-400 mb-3 uppercase tracking-wider">
    <div>A</div><div>B</div><div>C</div><div></div><div>D</div><div>E</div><div>F</div>
</div>
<div class="space-y-2 max-h-[380px] overflow-y-auto pr-1 hide-scroll">
    @for ($row = 1; $row <= 20; $row++)
        <div class="grid grid-cols-7 gap-1.5 items-center text-center">
            <button type="button" onclick="toggleSeat('{{ $row }}A')" id="seat-{{ $row }}A" class="h-8 bg-slate-200 text-slate-600 rounded-xl font-bold text-[11px] shadow-sm transition-all duration-150 hover:bg-slate-300 cursor-pointer">{{ $row }}A</button>
            <button type="button" onclick="toggleSeat('{{ $row }}B')" id="seat-{{ $row }}B" class="h-8 bg-slate-200 text-slate-600 rounded-xl font-bold text-[11px] shadow-sm transition-all duration-150 hover:bg-slate-300 cursor-pointer">{{ $row }}B</button>
            <button type="button" onclick="toggleSeat('{{ $row }}C')" id="seat-{{ $row }}C" class="h-8 bg-slate-200 text-slate-600 rounded-xl font-bold text-[11px] shadow-sm transition-all duration-150 hover:bg-slate-300 cursor-pointer">{{ $row }}C</button>
            <div class="text-xs font-black text-slate-400 bg-slate-100 h-6 flex items-center justify-center rounded-lg border border-slate-200/50">{{ $row }}</div>
            <button type="button" onclick="toggleSeat('{{ $row }}D')" id="seat-{{ $row }}D" class="h-8 bg-slate-200 text-slate-600 rounded-xl font-bold text-[11px] shadow-sm transition-all duration-150 hover:bg-slate-300 cursor-pointer">{{ $row }}D</button>
            <button type="button" onclick="toggleSeat('{{ $row }}E')" id="seat-{{ $row }}E" class="h-8 bg-slate-200 text-slate-600 rounded-xl font-bold text-[11px] shadow-sm transition-all duration-150 hover:bg-slate-300 cursor-pointer">{{ $row }}E</button>
            <button type="button" onclick="toggleSeat('{{ $row }}F')" id="seat-{{ $row }}F" class="h-8 bg-slate-200 text-slate-600 rounded-xl font-bold text-[11px] shadow-sm transition-all duration-150 hover:bg-slate-300 cursor-pointer">{{ $row }}F</button>
        </div>
    @endfor
</div>