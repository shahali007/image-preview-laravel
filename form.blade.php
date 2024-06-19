/**
 * Here Bootstrap is used
 * Create custom helper by yourself, if needed
 * If fileSize is MB, please multiply with 1024. (ex: 'fileSize' => 2*1024) 
 * If fileSize is KB, only pass the value. (ex: 'fileSize' => 600) 
 * Shown laravel validation error (Optional)
 */
<div class="form-group mb-4">
    <label>Logo </label>
    @include('dynamic-image-preview', [
        'id' => 'logo',
        'name' => 'logo',
        'fileSrc' => asset(Config::get('helper.uploadImagePath') . $settings->logo), // Create helper by yourself
        'fileSize' => 2 * 1024, // If MB, please multiply with 1024. (ex: 2*1024) 
        'fileSizeLabel' => 'Max 2MB',
    ])
    @if ($errors->has('logo'))
        <span class="text-danger">{{ $errors->first('logo') }}</span>
    @endif
</div>
