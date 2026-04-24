 @props(['name', 'image'])

 <div id="{{ $imagePreviewId }}"
     style="background-image: url({{ $image }});background-position:center; background-size: cover"
     {{ $attributes->merge(['class' => 'ml-2 mb-2 image-preview']) }}>
     <label for="{{ $imageUploadId }}" id="{{ $imageLabelId }}">Choose File</label>
     <input type="file" name="{{ $name }}" id="{{ $imageUploadId }}" />
 </div>
