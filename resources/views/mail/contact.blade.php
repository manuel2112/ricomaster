<!DOCTYPE html>
<html>

<head>
    <title>Contact Form Submission</title>
</head>

<body>
    <p>Nombre: {{ $data['name'] }}</p>
    <p>Email: {{ $data['email'] }}</p>
    <p>Asunto: {{ $data['subject'] }}</p>
    <p>Mensaje: {{ $data['message'] }}</p>
</body>

</html>
