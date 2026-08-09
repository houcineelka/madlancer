@props(['label', 'placeholder', 'model', 'icon', 'rows' => 8])

<div>

    {{-- Label --}}
    <label for="textarea-input-component-id-{{ $model }}" class="block text-xs font-medium {{ $errors->first($model) ? 'text-red-600 dark:text-red-500' : 'text-gray-700' }}">{{ htmlspecialchars_decode($label) }}</label>
    
    {{-- Form --}}
    <div class="mt-2 relative">

        {{-- Textarea --}}
        <textarea placeholder="{{ htmlspecialchars_decode($placeholder) }}" wire:model.defer="{{ $model }}" rows="{{ $rows }}" id="textarea-input-component-id-{{ $model }}" class="block w-full text-xs rounded border-2 ltr:pr-10 ltr:pl-3 rtl:pl-10 rtl:pr-3 py-3  font-normal resize-none {{ $errors->first($model) ? 'border-red-500 text-red-600 placeholder-red-400 focus:ring-red-500 focus:border-red-500' : 'border-gray-200 placeholder-gray-400 focus:ring-indigo-500 focus:border-indigo-500' }}" {{ $attributes }}></textarea>

        {{-- Icon --}}
        <div class="absolute inset-y-0 ltr:right-0 ltr:pr-3 rtl:left-0 rtl:pl-3 flex items-center pointer-events-none">
            <i class="mdi mdi-{{ $icon }} {{ $errors->first($model) ? 'text-red-400' : 'text-gray-400' }}"></i>
        </div>

    </div>

    {{-- Error --}}
    @error($model)
        <p class="mt-1 text-xs text-red-600 dark:text-red-500">{{ $errors->first($model) }}</p>
    @enderror

</div>