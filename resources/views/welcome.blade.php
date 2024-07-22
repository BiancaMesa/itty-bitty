<div>
    <form method="POST" action="{{ route('short.url') }}">
        <label for="original_url">Shoten Your URL</label>
        <input type="url" name="original_url" id="original_url">
        <button type="submit">Submit</button>
    </form>
</div>