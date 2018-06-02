<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->        

        <ul class="sidebar-menu">
            <?php
            if ($pageName == "Dashboard")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>            
            <a href="<?php echo base_url() . ADMIN_PAGE_DASHBOARD; ?>">
                <i class="fa fa-database"></i> <span>Dashboard</span>            
            </a>
            <?php
            if ($pageName == "Users")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>            
            <a href="<?php echo base_url() . "index.php/AdminController/userPage"; ?>">
                <i class="fa fa-database"></i> <span>Users</span>            
            </a>
            </li>                         
            <?php
            if ($pageName == "Settings")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>            
            <a href="<?php echo base_url() . "index.php/AdminController/settingPage"; ?>">
                <i class="fa fa-database"></i> <span>Settings</span>            
            </a>
            </li>            
            <?php
            if ($pageName == "Gashapons")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>            
            <a href="<?php echo base_url() . "index.php/AdminController/gashaponPage"; ?>">
                <i class="fa fa-database"></i> <span>Gashapons</span>            
            </a>
            </li>
            <?php
            if ($pageName == "Shop")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>            
            <a href="<?php echo base_url() . "index.php/AdminController/shopPage"; ?>">
                <i class="fa fa-database"></i> <span>Shop</span>            
            </a>
            </li>
            <?php
            if ($pageName == "Server Data")
                echo "<li class='active'>";
            else
                echo "<li>";
            ?>            
            <a href="<?php echo base_url() . "index.php/AdminController/serverDataPage"; ?>">
                <i class="fa fa-database"></i> <span>Server Data</span>            
            </a>
            </li>
        </ul>
        </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>