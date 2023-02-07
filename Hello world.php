<meta charset="UTF-8">
<title>Form Processing</title>
</head>

<body>

<form method="GET">
    <input type="text" name="person">
    <button>Submit</button>
</form>

<?php
    $name = $_GET['person'];
    echo $name." Jaimungal"; 
?>

</body>

</html>