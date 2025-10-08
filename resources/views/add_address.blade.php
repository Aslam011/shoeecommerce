<form action="{{ route('addresses.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label>Address</label>
        <textarea name="address" class="form-control" required></textarea>
    </div>

    <div class="form-group">
        <label>City</label>
        <input type="text" name="city" class="form-control" required>
    </div>

    <div class="form-group">
        <label>State</label>
        <input type="text" name="state" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Postal Code</label>
        <input type="text" name="postal_code" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Country</label>
        <input type="text" name="country" class="form-control" value="India" required>
    </div>

    <div class="form-group">
        <label>Type</label>
        <select name="type" class="form-control" required>
            <option value="home">Home</option>
            <option value="work">Work</option>
            <option value="other">Other</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Save Address</button>
</form>
