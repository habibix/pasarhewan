<form action="{{ url('post' . $post->id) }}" method="PUT" enctype="multipart/form-data">
    <input name="_token" type="hidden" value="{{ csrf_token() }}">
    <input name="post_type" type="hidden" value="sell">
    <div class="form-group">
        <input type="text" name="post_title" class="form-control" placeholder="Jual apa?">
    </div>
    <div class="form-group">
        <input type="text" name="post_price" class="form-control" placeholder="Berapa harganya?">
    </div>
    <div class="form-group">
        <textarea name="post_text" id="" cols="30" rows="2" class="form-control" placeholder="Keterangan?"></textarea>
    </div>

    <div class="form-group">
        <select name="post_category" class="form-control">
            <option>-- Kategori --</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ ucfirst($category->category) }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="file">Photo</label>
        <input name="post_image[]" type="file" multiple id="gallery-photo-sell" class="form-control-file">
        <div class="gallery mt-2"></div>
    </div>
    <div class="form-group align-right">
        <button type="submit" class="btn btn-primary">Post</button>
    </div>
</form>