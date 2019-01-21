@if($errors->all())
    <div class="alert alert-danger" style="margin-top: 20px;">
        <ul style="text-align: left;">
            @foreach ($errors->all() as $error)
                <li style="font-size: 13px;">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
