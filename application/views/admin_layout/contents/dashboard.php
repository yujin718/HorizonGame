
<section class="content-header">
    <h1>
        Dashboard        
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?php echo $countCat; ?></h3>
                    <p>Categories</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?php echo $countRest; ?></h3>

                    <p>Restaurants</p>
                </div>                
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3><?php echo $countUser; ?></h3>

                    <p>Users</p>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3><?php echo $countReserve; ?></h3>

                    <p>Points</p>
                </div>                
            </div>
        </div>
        <!-- ./col -->
    </div>

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Top Users</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Points</th>                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($restaurants as $restaurant) {
                        $i++;
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $restaurant->name; ?></td>
                            <td><?php echo $restaurant->cname; ?></td>                                                                            
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>            
            </table>
        </div>
        <!-- /.box-body -->
    </div>