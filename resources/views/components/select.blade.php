@props(['id', 'title' => '', 'required' => false, 'disabled' => false, 'value' => null, 'options' => []])

<div class="form-control">
    <label class="label" for="{{ $id }}">
        <span class="label-text">
            {{ $title }}
        </span>
    </label>
    <select id="{{ $id }}" name="{{ $id }}" value="{{ $value }}"
        {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => 'select select-bordered']) }}>
        @foreach ($options as $key => $val)
            <option value="{{ $key }}" @selected($key == $value)>{{ $val }}</option>
        @endforeach
    </select>
</div>
