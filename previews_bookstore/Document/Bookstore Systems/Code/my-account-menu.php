<div class="col-lg-3 col-md-4">
    <div class="myaccount-tab-menu nav" role="tablist">
        <a href="my-account.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'my-account.php') ? 'class="active"' : ''; ?>>
            <i class="fa fa-user"></i> ข้อมูลส่วนตัว
        </a>
        <a href="my-account-address.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'my-account-address.php') ? 'class="active"' : ''; ?>>
            <i class="fa fa-truck"></i> ที่อยู่
        </a>
        <a href="my-account-wishlist.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'my-account-wishlist.php') ? 'class="active"' : ''; ?>>
            <i class="fa fa-heart"></i> สิ่งที่อยากได้
        </a>
        <a href="my-account-my_order.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'my-account-my_order.php') ? 'class="active"' : ''; ?>>
            <i class="fa fa-clipboard"></i> ประวัติการสั่งซื้อ
        </a>
        <a href="my-account-finder-order.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'my-account-finder-order.php') ? 'class="active"' : ''; ?>>
            <i class="fa fa-search"></i> ประวัติตามหาหนังสือตามสั่ง
        </a>
        <a href="my-account-trancoin.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'my-account-trancoin.php') ? 'class="active"' : ''; ?>>
            <i class="fa  fa-arrow-circle-o-up"></i> โอนเหรียญ
        </a>
        <a href="my-account-trancoin-history.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'my-account-trancoin-history.php') ? 'class="active"' : ''; ?>>
            <i class="fa fa-history"></i> ประวัติการโอนเหรียญ
        </a>
        
        <a href="logout.php"><i class="fa fa-sign-out"></i> ออกจากระบบ</a>
    </div>
</div>
