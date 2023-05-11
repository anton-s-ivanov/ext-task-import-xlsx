<h1>Загрузка excel файла</h1>
<form action="uploadFile" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" id="">
    <input type="submit" value="Загрузить">
</form>

@include('progressBar')

@if ($errors->any())
    <div style="color:red">
        <h2>Validation errors</h2>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (Session::has('success'))
    <div style="color:green">
    <h2 id="displayProcess">Process ...</h2>
    <h2 id="displayFinished" style="display:none">Finished</h2>
        <ul>
            <li>{!!Session::get('success')!!}</li>
        </ul>
    </div>

    <script src="{{mix('/js/app.js')}}"></script>
@endif
