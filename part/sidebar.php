<aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index.php" class="brand-link">
          <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 0.8" />
          <span class="brand-text font-weight-light text-uppercase">Pharmacy</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image" />
            </div>
            <div class="info">
              <a href="#" class="d-block">
                <?php 
                  $userName = runQuery("SELECT `name` FROM `store` WHERE `store_id` = '$_SESSION[store_id]'");
                  foreach($userName as $userName){
                    echo $userName['name'];
                  }
                ?>
              </a>
            </div>
          </div>

          <!-- SidebarSearch Form -->
          <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
              <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search" />
              <div class="input-group-append">
                <button class="btn btn-sidebar">
                  <i class="fas fa-search fa-fw"></i>
                </button>
              </div>
            </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
              <li class="nav-item">
                <a href="pos.php" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>POS</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="sales.php" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>Sales</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="return.php" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>Return</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                    Purchase
                    <i class="fas fa-angle-left right"></i>
                    <span class="badge badge-info right">2</span>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="add-purchase.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Add Purchaser</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="manage-purchase.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Order List</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="stock.php" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>Stock</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                    Damages
                    <i class="fas fa-angle-left right"></i>
                    <span class="badge badge-info right">2</span>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="add-damage.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Add Damage</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="damage.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Damage Products</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-header">PRODUCT INFORMATION</li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                    Products
                    <i class="fas fa-angle-left right"></i>
                    <span class="badge badge-info right">2</span>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="add-product.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Add Products</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="manage-products.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Manage Products</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                    Category
                    <i class="fas fa-angle-left right"></i>
                    <span class="badge badge-info right">2</span>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="add-category.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Add Category</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="manage-category.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Manage Category</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                    Brands
                    <i class="fas fa-angle-left right"></i>
                    <span class="badge badge-info right">2</span>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="add-brand.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Add Brands</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="manage-brand.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Manage Brands</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-header">EXPENSES & PAYMENT</li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                    Expenses
                    <i class="fas fa-angle-left right"></i>
                    <span class="badge badge-info right">3</span>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="expense.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Add Expenses</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="manage-expense.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Manage Expenses</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="expense-category.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Expenses Category</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                    Payments
                    <i class="fas fa-angle-left right"></i>
                    <span class="badge badge-info right">2</span>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="add-payment.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Add Payments</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="manage-payment.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Manage Payments</p>
                    </a>
                  </li>
                </ul>
              </li>
              <!-- <li class="nav-header">PROMOTION</li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>Promotion</p>
                </a>
              </li> -->
              <li class="nav-header">PEOPLES</li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                    Customers
                    <i class="fas fa-angle-left right"></i>
                    <span class="badge badge-info right">2</span>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="add-customer.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Add Customers</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="manage-customer.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Manage Customers</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                    Suppliers
                    <i class="fas fa-angle-left right"></i>
                    <span class="badge badge-info right">2</span>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="add-supplier.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Add Suppliers</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="manage-supplier.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Manage Suppliers</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="new-supply.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Add New Supply</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="manage-supply.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Manage Supply</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-header">REPORTS</li>
              <li class="nav-item">
                <a href="today-report.php" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>Today Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="current-month-report.php" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>Current Month Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="summary-report.php" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>Summary Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="daily-report.php" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>Daily Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>Due Customer Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="low-stock-report.php" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>Low Stock Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="top-customer.php" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>Top Customer</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>Purchase Report</p>
                </a>
              </li> -->
              <li class="nav-header"></li>
              <!-- <li class="nav-header">REPORTS</li>
              <li class="nav-item">
                <a href="pos.html" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>Setting</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pos.html" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>Backup</p>
                </a>
              </li> -->
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>