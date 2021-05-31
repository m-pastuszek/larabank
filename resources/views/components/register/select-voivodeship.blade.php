<div class="relative">
    <select {!! $attributes->merge(['class' => "block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded"]) !!}>
        <option value="">- {{ __('Wybierz województwo') }} -</option>
        @foreach($voivodeships as $voivodeship)
            <option value="{{ $voivodeship->id }}" {{ collect(old('voivodeship'))->contains($voivodeship->id) ? 'selected':'' }}>{{ $voivodeship->name }}</option>
        @endforeach
    </select>
</div>
