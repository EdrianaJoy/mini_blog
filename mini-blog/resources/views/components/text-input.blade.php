@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-pink-300 bg-rose-50 text-pink-900 focus:border-pink-500 focus:ring-rose-500 rounded-md shadow-sm']) }}>
