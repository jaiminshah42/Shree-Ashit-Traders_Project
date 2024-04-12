<section class="fnavbar">
    <div class="">
        <nav>
            <div class="nav-wrapper" style="background-color: rgb(0, 166, 255);">
                <a href="index.php" class="brand-logo">SHREE ASIT TRADERS</a>
                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="index.php" class="hvr-grow">Home</a></li>
                    <!-- <li><a href="chunks/aboutus.php" class="hvr-grow">About Us</a></li> -->
                    <li><a href="#" class="hvr-grow" onclick="toggleModal('Contact Info', 'You can contact us directly by calling to this number +91-9925183700. Check the bottom Footer Section of the website for more info.');">Contact</a></li>
                    <?php
                        if (isset($_SESSION['user'])) {
                            echo '<li><a href="#" class="hvr-grow">Hi, '.$_SESSION['user'].'</a></li>
                            <li><a href="logout.php" class="hvr-grow">Logout</a></li>';
                        } else {
                            echo '<li><a href="#modal4" class="modal-trigger hvr-grow">About Us</a></li>
                            <li><a href="#" class="hvr-grow modal-trigger" data-target="modal1">Login</a></li>
                            <li><a href="#" class="hvr-grow modal-trigger" data-target="modal2">Register</a></li>';
                        }
                    ?>
                    <li><a href="admin/index.php" class="hvr-grow">Admin-Login</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <ul class="sidenav" id="mobile-demo">
        <li><a href="index.php">Home</a></li>
        <li><a href="#" onclick="toggleModal('Contact Info', 'You can contact us directly by calling to this number +91-9925183700. Check the bottom Footer Section of the website for more info.');">Contact</a></li>
        <?php
            if (isset($_SESSION['user'])) {
                echo '<li><a href="#">Hi, '.$_SESSION['user'].'</a></li>
                <li><a href="logout.php">Logout</a></li>';
            } else {
                echo '<li><a href="#modal4" class="modal-trigger">About Us</a></li>
                <li><a href="#" class="modal-trigger" data-target="modal1">Login</a></li>
                <li><a href="#" class="modal-trigger" data-target="modal2">Register</a></li>';
            }
        ?>
    </ul>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.modal');
        var instances = M.Modal.init(elems);
    });
</script>
