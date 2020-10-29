<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">
</script>
    <title>Document</title>
</head>
<body>
<script>

url = 'https://api.feegow.com/v1/api/company/list-unity';
var token  = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJmZWVnb3ciLCJhdWQiOiJwdWJsaWNhcGkiLCJpYXQiOiIxNy0wOC0yMDE4IiwibGljZW5zZUlEIjoiMTA1In0.UnUQPWYchqzASfDpVUVyQY0BBW50tSQQfVilVuvFG38';

function performSignIn() {
    let headers = new Headers();

    headers.append('Content-Type', 'application/json');
    headers.append('Accept', 'application/json');
    headers.append('x-access-token',token);
    headers.append('Origin',url);

    fetch(sign_in, {
        mode: 'cors',
        credentials: 'include',
        method: 'GET',
        headers: headers
    })
    .then(response => response.json())
    .then(json => console.log(json))
    .catch(error => console.log('Authorization failed : ' + error.message));
}
performSignIn();
</script>
    
</body>

</html>
