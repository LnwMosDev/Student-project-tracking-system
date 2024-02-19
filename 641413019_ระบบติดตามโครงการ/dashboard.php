<?php

/*******************************************************************************
 * ระบบจัดการใบแจ้งหนี้                                                  *
 *                                                                              *
 * เวอร์ชัน: 1.0                                                               *
 * ผู้พัฒนา: อภิชเชษฐ์ ราช                                                    *
 *******************************************************************************/

include 'header.php';
include 'functions.php';
include_once "includes/config.php";

?>

<section class="content">
  <!-- กล่องเล็ก (กล่องสถิติ) -->
  <div class="row">
    <!-- มูลค่าโครงการทั้งหมด -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-green">
        <div class="inner">
          <h3><?php
              $result = mysqli_query($mysqli, 'SELECT SUM(project_value) AS value_sum FROM project');
              $row = mysqli_fetch_assoc($result);
              $sum = $row['value_sum'];
              echo number_format($sum, 2);
              ?></h3>
          <p>มูลค่าโครงการทั้งหมด</p>
        </div>
        <div class="icon">
          <i class="ion ion-social-usd"></i>
        </div>
      </div>
    </div>

    <!-- โครงการทั้งหมด -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-purple">
        <div class="inner">
          <h3><?php
              $sql = "SELECT * FROM project";
              $query = $mysqli->query($sql);
              echo $query->num_rows;
              ?></h3>
          <p>โครงการทั้งหมด</p>
        </div>
        <div class="icon">
          <i class="ion ion-ios-paper"></i>
        </div>
      </div>
    </div>

    <!-- โครงการที่กำลังดำเนินการ -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?php
              $sql = "SELECT * FROM project WHERE project_status = 1";
              $query = $mysqli->query($sql);
              echo $query->num_rows;
              ?></h3>
          <p>โครงการที่กำลังดำเนินการ</p>
        </div>
        <div class="icon">
          <i class="ion ion-load-a"></i>
        </div>
      </div>
    </div>

    <!-- โครงการที่เสร็จสมบูรณ์ -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-olive">
        <div class="inner">
          <h3><?php
              $sql = "SELECT * FROM project WHERE project_status = 2";
              $query = $mysqli->query($sql);
              echo $query->num_rows;
              ?></h3>
          <p>โครงการที่เสร็จสมบูรณ์</p>
        </div>
        <div class="icon">
          <i class="ion ion-checkmark"></i>
        </div>
      </div>
    </div>

    <!-- มูลค่าโครงการที่กำลังดำเนินการ -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-teal">
        <div class="inner">
          <h3><?php
              $result = mysqli_query($mysqli, 'SELECT SUM(project_value) AS value_sum FROM project WHERE project_status = 1');
              $row = mysqli_fetch_assoc($result);
              $sum = $row['value_sum'];
              echo number_format($sum, 2);
              ?></h3>
          <p>มูลค่าโครงการที่กำลังดำเนินการ</p>
        </div>
        <div class="icon">
          <i class="ion ion-social-usd"></i>
        </div>
      </div>
    </div>

    <!-- พนักงานทั้งหมด -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-primary">
        <div class="inner">
          <h3><?php
              $sql = "SELECT * FROM employee";
              $query = $mysqli->query($sql);
              echo $query->num_rows;
              ?></h3>
          <p>พนักงานทั้งหมด</p>
        </div>
        <div class="icon">
          <i class="ion ion-person"></i>
        </div>
      </div>
    </div>

    <!-- ลูกค้าทั้งหมด -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-maroon">
        <div class="inner">
          <h3><?php
              $sql = "SELECT * FROM customer";
              $query = $mysqli->query($sql);
              echo $query->num_rows;
              ?></h3>
          <p>ลูกค้าทั้งหมด</p>
        </div>
        <div class="icon">
          <i class="ion ion-ios-people"></i>
        </div>
      </div>
    </div>

  </div>
</section>
<!-- /.content -->

<?php
include 'footer.php';
?>