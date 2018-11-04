<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

    <div id="row">
        <div style="">
            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(300)->merge('http://www.enjiwa.com/p-posta.png', .2, true)->generate('Make me into an QrCode!')) !!} ">
        </div>
    </div>
</body>
</html>