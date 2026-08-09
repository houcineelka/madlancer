@props(['label', 'placeholder', 'model', 'old' => null])

<div class="{{ $errors->first($model) ? 'ckeditor-has-error' : '' }}">

    {{-- Label --}}
    <label for="text-input-component-id-{{ $model }}" class="block text-xs font-medium {{ $errors->first($model) ? 'text-red-600 dark:text-red-500' : 'text-gray-700' }}">{{ $label }}</label>

    {{-- Ckeditor --}}
    <div class="mt-2 relative" wire:ignore>
        <div id="ckeditor-container"></div>
    </div>

    {{-- Error --}}
    @error($model)
        <p class="mt-1 text-xs text-red-600 dark:text-red-500">{{ $errors->first($model) }}</p>
    @enderror

</div>

@pushOnce('scripts')

    {{-- Ckeditor 5 --}}
    <script src="{{ url('public/js/plugins/ckeditor/ckeditor.js') }}"></script>
    <script>ClassicEditor
            .create( document.querySelector( '#ckeditor-container' ), {
                placeholder: '{{ $placeholder }}'
            } )
            .then( editor => {

                @if ($old)
                    editor.setData('{!! str_replace("'", '', $old) !!}');
                @endif

                editor.ui.focusTracker.on( 'change:isFocused', ( evt, name, isFocused ) => {
                    if ( !isFocused ) {
                        @this.set('{{ $model }}', editor.getData());
                    }
                } );
                
            } )
            .catch( error => {
                
            } );
    </script>

@endpushonce