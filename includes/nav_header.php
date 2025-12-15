<!--    IMPRESSIVE NAV HEADER FOR CAFECONNECT  -->

<header class="navbar navbar-expand-md navbar-dark fixed-top shadow-lg mb-auto" style="background: linear-gradient(135deg, #8B4513 0%, #D2691E 50%, #CD853F 100%);">
<style>
.navbar a { text-decoration: none !important; }
.navbar-brand * { text-decoration: none !important; }
</style>
    <div class="container-fluid mx-3">
        <div class="navbar-brand d-flex align-items-center">
            <a href="<?= isset($_SESSION['cid']) ? '/CafeConnect/customer/home.php' : '/CafeConnect/index.php' ?>" class="text-decoration-none">
                <img src="/CafeConnect/assets/img/landing_logo.png" height="55" class="me-3" alt="CafeConnect" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.4)); object-fit: contain;">
            </a>
            <div>
                <h4 class="mb-0 text-white fw-bold" style="font-size: 1.6rem; text-shadow: 2px 2px 6px rgba(0,0,0,0.5); letter-spacing: 1px;">CafeConnect</h4>
                <small class="text-white fst-italic fw-bold" style="font-size: 0.8rem; text-shadow: 1px 1px 3px rgba(0,0,0,0.5); letter-spacing: 0.5px; display: block; margin-top: -2px;">Brewing Connections</small>
            </div>
        </div>
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link px-3 text-white fw-semibold" href="<?= isset($_SESSION['cid']) ? '/CafeConnect/customer/home.php' : '/CafeConnect/index.php' ?>">
                        <i class="bi bi-house-door"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/CafeConnect/customer/shop_list.php" class="nav-link px-3 text-white fw-semibold">
                        <i class="bi bi-shop"></i> Our Cafes
                    </a>
                </li>
                <?php if(isset($_SESSION['cid'])){ ?>
                <li class="nav-item">
                    <a href="/CafeConnect/customer/cust_order_history.php" class="nav-link px-3 text-white fw-semibold">
                        <i class="bi bi-clock-history"></i> My Orders
                    </a>
                </li>
                <?php } ?>
            </ul>
            <div class="d-flex">
                <?php if(!isset($_SESSION['cid'])){ ?>
                <a class="btn btn-outline-light me-2 px-4" href="/CafeConnect/customer/cust_regist.php">
                    <i class="bi bi-person-plus"></i> Join Us
                </a>
                <a class="btn btn-light text-dark px-4 fw-bold" href="/CafeConnect/auth_login.php">
                    <i class="bi bi-cup-hot"></i> Sign In
                </a>
                <?php }else{ ?>


                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a type="button" class="btn btn-outline-light me-2" href="/CafeConnect/customer/cust_cart.php">
                            My Cart
                            <?php
                                $incart_query = "SELECT SUM(ct_amount) AS incart_amt FROM cart WHERE c_id = {$_SESSION['cid']}";
                                $incart_result = $mysqli -> query($incart_query) -> fetch_array(); 
                                $incart_amt = $incart_result["incart_amt"];
                                if($incart_amt>0){
                            ?>
                            <span class="ms-1 badge bg-success">
                                <?php echo $incart_amt;?>
                            </span>
                            <?php }else{ ?>
                                <span class="ms-1 badge bg-secondary">0</span>
                            <?php } ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/CafeConnect/customer/cust_profile.php" class="nav-link px-2 text-white">
                            Welcome, <?=$_SESSION['firstname']?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-person-circle" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                <path fill-rule="evenodd"
                                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                            </svg>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="mx-2 mt-1 mt-md-0 btn btn-outline-light" href="/CafeConnect/includes/logout.php">
                            <i class="bi bi-box-arrow-right"></i> Sign Out
                        </a>
                    </li>
                </ul>
                <?php } ?>
            </div>
        </div>
    </div>
</header>