<?php
// Initialize the session
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

?>

<?php include('connect.php');?>

<!DOCTYPE html>
<html lang="bg">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Админ панел - Начало</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="admin/dist/css/adminlte.min.css">
  <link rel="icon" href="balik_logo.ico">

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="admin.php" class="nav-link">Начало</a>
        </li>
        <!-- <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Contact</a>
        </li> -->
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      </a>
      <!-- date today -->
      <div class="date-today text-uppercase badge bg-dark rounded-pill py-2 px-3 fw-medium"></div>
      <!-- !date today -->

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="./balik_logo.ico" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?php echo htmlspecialchars($_SESSION["username"]); ?></a>
          </div>
          <!-- logout -->
          <div>
            <a href="logout.php" class="btn btn-danger" title="Излез"><i class="fas fa-arrow-alt-circle-left"></i></a>
          </div>
          <!-- !logout -->
        </div>
     

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="index.php" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Начало
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="add.php" class="nav-link">
              <i class="fas fa-user-cog"></i>
                <p>
                  Добави нов пост
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="admin.php" class="nav-link">
              <i class="fas fa-clipboard"></i>
                <p>
                  Всички заявки
                </p>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a href="reset-password.php" class="nav-link">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                  Смяна на парола
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="register.php" class="nav-link">
                <i class="nav-icon fas fa-address-card"></i>
                <p>
                  Добавяне на Администратор
                </p>
              </a>
            </li> -->
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->

    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-10">
              <!-- Main content -->
              <div class="content">
                  <div class="row">
                
                      <!-- small box -->
                      <div class="small-box bg-info">
                        <div class="inner">
                          <h3> <?php
                                $posts = $conn->query("SELECT * FROM forum ")->num_rows;
                                echo number_format($posts);
                                ?></h3>
                          <p>Общо публикации</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-bag"></i>
                        </div>
                      </div>


                      <!-- kod ot ./opiti/mysql_fetch_assoc -->
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th scope="col">№</th>
                            <th scope="col">Заглавие</th>
                            <th scope="col">Действие</th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php

                          # => PAGINATION START

                          if (isset($_GET['page'])) {
                            $page = $_GET['page'];
                          } else {
                            $page = 1;
                          }
                          $no_of_records_per_page = 5;
                          $offset = ($page - 1) * $no_of_records_per_page;


                          $total_pages_sql = "SELECT COUNT(*) FROM forum";
                          $result = mysqli_query($conn, $total_pages_sql);
                          $total_rows = mysqli_fetch_array($result)[0];
                          $total_pages = ceil($total_rows / $no_of_records_per_page);


                          # => PAGINATION END with   $sql="SELECT * FROM table LIMIT $offset, $no_of_records_per_page";
                          $sql = "SELECT * FROM forum LIMIT $offset, $no_of_records_per_page";
                          $result = $conn->query($sql);


                          if ($result->num_rows > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                              $id = $row['id'];
                              $title = $row['title'];
                           

                              echo ' <tr>
                                  <td>' . $id . '</td>
                                  <td>' . $title . '</td>    
                                  </td>
                                  <td><div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">    
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="post.php?title=' . $id . '"  title="Преглед"><i class="fas fa-eye"> Преглед</i></a>
                                    <a class="dropdown-item" href="edit.php?editid=' . $id . '"  title="Редактирай"><i class="fas fa-pencil-alt"> Редактирай</i></a>
                                    <a class="dropdown-item btn-del" href="delete.php?deleteid=' . $id . '"  title="Изтрий"><i class="fas fa-trash "> Изтрий</i></a> 
                                    </div>
                                  </div></td>
                                </tr>';
                            }
                          }
                          ?>
                        </tbody>
                      </table>

                      <!--PAGINATION -->
                      <nav aria-label="Page navigation example">
                        <ul class="pagination">
                          <li class="page-item"><a class="page-link" href="?page=1">Начало</a></li>
                          <li class="<?php if ($page <= 1) {
                                        echo 'disabled';
                                      } ?>">
                            <a class="page-link" href="<?php if ($page <= 1) {
                                                          echo '#';
                                                        } else {
                                                          echo "?page=" . ($page - 1);
                                                        } ?>">Назад</a>
                          </li>
                          <li class="<?php if ($page >= $total_pages) {
                                        echo 'disabled';
                                      } ?>">
                            <a class="page-link" href="<?php if ($page >= $total_pages) {
                                                          echo '#';
                                                        } else {
                                                          echo "?page=" . ($page + 1);
                                                        } ?>">Напред</a>
                          </li>
                          <li class="page-item"><a class="page-link role=" button" href="?page=<?php echo $total_pages; ?>">Последна</a></li>
                        </ul>
                      </nav>

                

                      <!-- krai na kod ot ./opiti/mysql_fetch_assoc -->


                    </div><!-- /.container-fluid -->
                  </div>
                  <!-- /.content -->
                </div>
                <!-- /.content-wrapper -->
              </div>
              <!-- ./wrapper -->

              <!-- REQUIRED SCRIPTS -->

              <!-- jQuery -->
              <script src="admin/plugins/jquery/jquery.min.js"></script>
              <!-- Bootstrap 4 -->
              <script src="admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
              <!-- AdminLTE App -->
              <script src="admin/dist/js/adminlte.min.js"></script>


            

              <script>
                // Current Date
                var weekday = ["Неделя", "Понеделник", "Вторник", "Сряда", "Четвъртък", "Петък", "Събота"],
                  month = ["Януари", "Февруари", "Март", "Април", "Май", "Юни", "Юли", "Август", "Септември", "Октомври", "Ноември", "Декември"],
                  a = new Date();

                jQuery('.date-today').html(weekday[a.getDay()] + ', ' + month[a.getMonth()] + ' ' + a.getDate());
              </script>

                <script>
                  // SweetAlerts 

                  $('.btn-del').on('click', function(e) {
                    e.preventDefault();
                    const href = $(this).attr('href')

                    Swal.fire({
                      title: 'Сигурни ли сте?',
                      text: 'Потвърждение за изтриване',
                      type: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                    }).then((result) => {
                        if(result.value) {
                          document.location.href = href;
                        }
                    })
                  })
                </script>

</body>

</html>
