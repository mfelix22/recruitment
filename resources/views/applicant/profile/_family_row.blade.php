<tr>
    <input type="hidden" name="family[{{ $idx }}][family_type]" value="{{ $type }}">
    <td class="border px-1 py-1">
        <input type="text" name="family[{{ $idx }}][relation]" value="{{ $fm->relation }}"
            placeholder="{{ $type === 'immediate' ? 'Istri/Suami/Anak' : 'Ayah/Ibu/Kakak' }}"
            class="w-full text-xs border-0 focus:ring-1 rounded">
    </td>
    <td class="border px-1 py-1">
        <input type="text" name="family[{{ $idx }}][name]" value="{{ $fm->name }}"
            class="w-full text-xs border-0 focus:ring-1 rounded">
    </td>
    <td class="border px-1 py-1">
        <select name="family[{{ $idx }}][gender]" class="w-full text-xs border-0 focus:ring-1 rounded">
            <option value="L" @selected($fm->gender === 'L')>L</option>
            <option value="P" @selected($fm->gender === 'P')>P</option>
        </select>
    </td>
    <td class="border px-1 py-1">
        <input type="text" name="family[{{ $idx }}][place_of_birth]" value="{{ $fm->place_of_birth }}"
            placeholder="Tempat" class="w-full text-xs border-0 focus:ring-1 rounded mb-1">
        <input type="date" name="family[{{ $idx }}][date_of_birth]"
            value="{{ $fm->date_of_birth?->format('Y-m-d') }}" class="w-full text-xs border-0 focus:ring-1 rounded">
    </td>
    <td class="border px-1 py-1">
        <select name="family[{{ $idx }}][education]" class="w-full text-xs border-0 focus:ring-1 rounded">
            <option value="">-</option>
            @foreach ($educationLevels as $lvl)
                <option value="{{ $lvl }}" @selected($fm->education === $lvl)>{{ $lvl }}</option>
            @endforeach
        </select>
    </td>
    <td class="border px-1 py-1">
        <input type="text" name="family[{{ $idx }}][occupation]" value="{{ $fm->occupation }}"
            class="w-full text-xs border-0 focus:ring-1 rounded">
    </td>
    <td class="border px-1 py-1">
        <button type="button" onclick="this.closest('tr').remove()" class="text-red-500 text-xs">✕</button>
    </td>
</tr>
