<h1>Загрузка excel файла</h1>
<form action="uploadFile" method="POST">
    @csrf
    <input type="file" name="filePath" id="">
    <input type="submit" value="Загрузить">
</form>