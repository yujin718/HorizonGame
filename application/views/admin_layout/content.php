<div class="content-wrapper">

    <?php
    switch ($pageName) {
        case "Dashboard":
            include("contents/dashboard.php");
            break;
        case "Settings":
            include("contents/setting.php");
            break;
        case "Users":
            include("contents/users.php");
            break;
        case "UserDetail":
            include("contents/user_detail.php");
            break;
        case "ServerData":
            include("contents/server_data.php");
            break;
        case "ServerCharacterDetail":
            include("contents/server_character_detail.php");
            break;
        case "ServerEquipDetail":
            include("contents/server_equip_detail.php");
            break;
        case "ServerStageDetail":
            include("contents/server_stage_detail.php");
            break;
        case "ServerMonsterDetail":
            include("contents/server_monster_detail.php");
            break;
        case "Gashapons":
            include("contents/gashapon.php");
            break;
        case "Shop":
            include("contents/shop.php");
            break;
        case "AddEmail":
            include("contents/add_mail.php");
            break;
        case "AddGashapon":
            include("contents/add_gashapon.php");
            break;
        case "EditGashapon":
            include("contents/edit_gashapon.php");
            break;
    }
    ?>
</div>
