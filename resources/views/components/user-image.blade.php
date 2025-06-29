<div x-data="imagePreview()">
    <input @change="showPreview(event)" type="file" id="image" name="image">
    @if(Auth::check())
    <img id="preview" src="{{ Auth::user()->image ? Auth::user()->image : asset('default-image.jpg') }}" alt="User Image">
    @else
    <img id="preview" src="{{ asset('default-image.jpg') }}" alt="Default Image">
    @endif <script>
        function imagePreview() {
            return {
                showPreview: (event) => {
                    if (event.target.files.length > 0) {
                        var src = URL.createObjectURL(event.target.files[0]);
                        document.getElementById('preview').src = src;
                    }
                }
            }
        }
    </script>
</div>