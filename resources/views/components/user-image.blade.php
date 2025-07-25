<div x-data="imagePreview()">
    <input @change="showPreview(event)" type="file" id="image" name="image" class="hidden" accept="image/*"> {{-- inputを非表示にする --}}

    <label for="image" class="cursor-pointer"> {{-- labelでinputとimgを紐付け、クリック可能に --}}
        <div class="circle_show"> {{-- ★ circle_show クラスを適用 --}}
            @if(Auth::check())
            <img id="preview" src="{{ Auth::user()->image ? Auth::user()->image : asset('default-image.png') }}" alt="User Image">
            @else
            <img id="preview" src="{{ asset('default-image.png') }}" alt="Default Image">
            @endif
        </div>
    </label>

    <script>
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