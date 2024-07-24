<?php

require "connector.php";
session_start();

include 'head.php';
?>

<head>
    <title>My Mellow - About</title>
</head>

<body class="d-flex flex-column">
    <div class="d-block">
        <header>
            <?php include 'navbar.php'; ?>
            <div class="container text-center">
                <h1>About Me</h1>
                <article>
                    <p class="fs-2">Hi! I'm Mehdi and I'm a Full-stack Developer at the Bit Academy.
                        I've always been a tech nerd and enjoy expanding my knowledge in the world of IT! You can find my other projects at my GitHub and portfolio page!</p>
                        <a href="https://github.com/MTech-cmd"><img src="assets/github.png" alt="GitHub" width="50"></a>
                        <a href="https://mtech-cmd.github.io/"><img src="assets/mtech.png" class="img-fluid rotate" alt="MTech logo" width="50"></a>
                        <a href="https://linkedin.com/in/mehdi-el-khallouki"><img src="assets/linkedin.png" alt="LinkedIn" width="50"></a>
                </article>
            </div>
        </header>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>
