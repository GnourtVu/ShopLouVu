  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="/admin/main" class="brand-link">
          <img src="/template/user/images/icons/lv.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
              style="opacity: .8">
          <span class="brand-text font-weight-light">Admin Page</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="/template/user/images/lv1.jpg" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                  <a href="#" class="d-block">LouVu</a>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-item has-treeview">
                      <a href="/admin/main" class="nav-link">
                          <i class="fa-solid fa-gauge-high"></i>
                          <p>
                              Trang chủ
                          </p>
                      </a>
                  </li>
              </ul>
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="fa-solid fa-list"></i>
                          <p>
                              Danh mục
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('create') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Thêm mới</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('list') }}"class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Danh sách</p>
                              </a>
                          </li>

                      </ul>
                  </li>
              </ul>
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="fa-brands fa-product-hunt"></i>
                          <p>
                              Sản phẩm
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="/admin/products/create" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Thêm mới</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="/admin/products/index"class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Danh sách</p>
                              </a>
                          </li>

                      </ul>
                  </li>
              </ul>
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="fa-regular fa-images"></i>
                          <p>
                              Sliders
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="/admin/sliders/create" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Thêm mới</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="/admin/sliders/index"class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Danh sách</p>
                              </a>
                          </li>

                      </ul>
                  </li>
              </ul>
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="fa-solid fa-tags"></i>
                          <p>
                              Giảm giá
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="/admin/discounts/create" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Thêm mới</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="/admin/discounts/list"class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Danh sách</p>
                              </a>
                          </li>

                      </ul>
                  </li>
              </ul>
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="fa-solid fa-users"></i>
                          <p>
                              Khách hàng
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="/admin/customerList"class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Danh sách</p>
                              </a>
                          </li>
                      </ul>
                  </li>
              </ul>
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="fa-solid fa-cart-shopping"></i>
                          <p>
                              Đơn hàng
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="/admin/order"class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Danh sách</p>
                              </a>
                          </li>
                      </ul>
                  </li>
              </ul>
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-item has-treeview">
                      <a href="/admin/statis" class="nav-link">
                          <i class="fa-solid fa-print"></i>
                          <p>
                              Thống kê
                          </p>
                      </a>
                  </li>
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
