 @props(['name', 'image'])

 <div style="background-image: url({{ $image }}); background-size: cover"
     {{ $attributes->merge(['id' => 'image-preview', 'class' => 'ml-2 mb-2']) }}>
     <label for="image-upload" id="image-label">Choose File</label>
     <input type="file" name="{{ $name }}" id="image-upload" />
 </div>
