{{-- Image preview and upload UI --}}
<div class="avatar-upload bg-dark">
    <div class="avatar-preview">
        <div>
            <div class="fileinfo" id="fileinfo_{{ $id }}">
                <div id="filename_{{ $id }}" class="d-inline-block mb-1"></div>
                <div id="fileMemorySize_{{ $id }}" class="d-inline-block mb-1"></div><br>
                <div id="fileSize_{{ $id }}" class="d-inline-block mb-1"></div>
                <div id="maxAlert_{{ $id }}" class="d-inline-block mb-1"></div>
            </div>
            <button type="button" onclick="removeImgSrc_{{ $id }}(this)" class="removeBtn btn btn-danger" id="removeBtn_{{ $id }}"
                style="display: {{ $fileSrc ? 'block' : 'none' }}">x</button>
            <div class="img-box">
                <img src="{{ $fileSrc ? $fileSrc : '' }}" id="imagePreview_{{ $id }}" alt="Image"
                    style="display: {{ $fileSrc ? 'block' : 'none' }}">
            </div>
        </div>
    </div>
    <div class="avatar-edit text-center" id="avatar-edit_{{ $id }}">
        <input type='file' id="imageUpload_{{ $id }}" accept=".png, .jpeg, .jpg" onchange="changePreview_{{ $id }}(this)"
            name="{{ $name }}" />
        <label for="imageUpload_{{ $id }}"> Upload <small>{{ $fileSizeLabel ? '(' . $fileSizeLabel . ')' : '' }}</small></label>
    </div>
</div>

{{-- Script --}}
<script>
    /**
     * Display File size in Unit
     * @param bytes
     * @return "Bytes", "KB", "MB", "GB", "TB" 
     */
    function bytesToSize(bytes) {
        let sizes = ["Bytes", "KB", "MB", "GB", "TB"];
        if (bytes === 0) return "0 Byte";
        let i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i), 2) + " " + sizes[i];
    }

    /**
     * Display new image preview
     * File size validation
     * New src is based on base64  
     */
    function changePreview_{{ $id }}(path) {
        let imagePreview = getID("imagePreview_{{ $id }}");
        console.log('imagePreview', imagePreview);

        // let maxImgSize = 1024 * 600;
        let maxImgSize = 1024 * {{ $fileSize }};

        // Check file size validation
        if (path.files && path.files[0]) {
            if (path.files[0].size < maxImgSize) {
                let reader = new FileReader();

                // Show Image preview
                getID("imagePreview_{{ $id }}").style.display = "block";

                // Show file information (Name, size, dimension, error)
                getID("fileinfo_{{ $id }}").style.display = "block";

                // File name, size unit(KB, MB)
                reader.onload = function(b) {
                    imagePreview.src = b.target.result;
                    getID("filename_{{ $id }}").innerHTML = '<span class="badge bg-dark">' + path.files[0].name +
                        '</span>';
                    getID("fileMemorySize_{{ $id }}").innerHTML = '<span class="badge bg-dark">' + bytesToSize(path.files[0].size) +
                        '</span>';
                    getID("maxAlert_{{ $id }}").innerHTML = "";
                };

                // File dimension
                imagePreview.onload = function() {
                    getID("fileSize_{{ $id }}").innerHTML = '<span class="badge bg-dark">' +
                        imagePreview.naturalWidth + "x" + imagePreview.naturalHeight +
                        '</span>';
                };

                // base64 src
                reader.readAsDataURL(path.files[0]);

                // Show/hide UI elements
                getID("removeBtn_{{ $id }}").style.display = "inline-block";
                getID("avatar-edit").style.display = "none";
            } else {
                // File vailidation error message
                getID("maxAlert_{{ $id }}").innerHTML = '<span class="badge bg-danger">' + bytesToSize(path.files[0].size) + " Not allowed" +
                    '</span>';

                // Empty UI elements
                getID("filename_{{ $id }}").innerHTML = "";
                getID("fileMemorySize_{{ $id }}").innerHTML = "";
                getID("fileSize_{{ $id }}").innerHTML = "";
            }
        }
    }

    /**
     * Remove image src onclick
     */
    function removeImgSrc_{{ $id }}(btn) {
        // Empty image preview
        let imagePreview = getID("imagePreview_{{ $id }}");
        imagePreview.src = "";
        getID("imagePreview_{{ $id }}").style.display = "none";

        // Empty UI elements
        getID("imageUpload_{{ $id }}").value = getID("filename_{{ $id }}").innerHTML =
            getID("fileSize_{{ $id }}").innerHTML = getID("fileMemorySize_{{ $id }}").innerHTML =
            "";

        // Show/hide UI elements   
        getID("avatar-edit_{{ $id }}").style.display = "block";
        getID("fileinfo_{{ $id }}").style.display = "none";
        btn.style.display = "none";
    }

    /**
     * Short function of
     * Get element by id
     */
    function getID(id) {
        return document.getElementById(id);
    }
</script>

{{-- CSS --}}
<style>
    .avatar-upload {
        position: relative;
        max-width: 100%;
        border-radius: 8px;
        overflow: hidden;
    }

    .avatar-upload .avatar-edit {
        right: 12px;
        z-index: 1;
        top: 10px;
    }

    .avatar-upload .avatar-edit input {
        display: none;
    }

    .avatar-upload .avatar-edit input+label {
        display: block;
        margin-bottom: 0;
        background: #2a3042;
        cursor: pointer;
        font-weight: normal;
        transition: all 0.2s ease-in-out;
        padding: 10px 15px;
    }

    .avatar-upload .avatar-edit input+label:hover {
        background: #1a1e27;
    }

    .avatar-upload .img-box {
        height: 120px;
        overflow: hidden;
        width: auto;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .avatar-upload .img-box img {
        max-height: 100%;
    }

    .avatar-preview {
        position: relative;
    }

    .avatar-preview::before {
        position: absolute;
        content: "";
        width: 100%;
        height: 100%;
        background: linear-gradient(180deg, #000000, #0000001c, #00000063);
    }

    .fileinfo {
        position: absolute;
        top: 15px;
        left: 15px;
        width: 90%;
    }

    .removeBtn {
        position: absolute;
        right: 10px;
        top: 10px;
        height: 28px;
        width: 28px;
        line-height: 1;
        padding: 0;
        display: none;
    }
</style>
