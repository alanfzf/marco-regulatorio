@props(['id', 'title' => '', 'required' => false, 'disabled' => false, 'value' => null, 'options' => []])

<div class="form-control">
    <label class="label" for="{{ $id }}">
        <span class="label-text">
            {{ $title }}
        </span>
    </label>
    <select id="{{ $id }}" name="{{ $id }}" value="{{ $value }}" class="select select-bordered"
        {{ $disabled ? 'disabled' : '' }}>
        <option value="{{ null }}">Select an option please</option>
        @foreach ($options as $key => $val)
            <option value="{{ $key }}" @selected($key == $value)>{{ $val }}</option>
        @endforeach
    </select>
</div>
