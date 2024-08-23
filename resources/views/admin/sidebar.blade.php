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
                      <a href="#" class="nav-link">
                          <i class="fa-solid fa-list"></i>
                          <p>
                              Categories
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('create') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Create Category</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('list') }}"class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>List Categories</p>
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
                              Products
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="/admin/products/create" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Create Product</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="/admin/products/index"class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>List Products</p>
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
                                  <p>Create Slider</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="/admin/sliders/index"class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>List Sliders</p>
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
                              Orders
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="/admin/customer"class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>List orders</p>
                              </a>
                          </li>
                      </ul>
                  </li>
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
