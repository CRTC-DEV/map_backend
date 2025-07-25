<header class="site-header">
  <link href="{{ asset('css/header-frontend.css') }}" rel="stylesheet">
  <link href="{{ asset('css/modern-menu.css') }}" rel="stylesheet">
  <div class="container">
    <div class="header-wrapper">
      <!-- Logo -->
      <div class="logo">
        <a href="/">
          <img src="{{ asset('logo/logo-main.png') }}" alt="Cam Ranh International Terminal">
        </a>
      </div>
      
      <!-- Menu Toggle Button -->
      <button class="menu-toggle">☰</button>
      <!-- Main Navigation -->
      <nav class="main-navigation">
  <ul class="menu">
    <li>
      <a href="/">KẾT NỐI DOANH NGHIỆP</a>
      <ul class="submenu">
        <li><a href="{{route('connect.business.view',1)}}">THÔNG BÁO MỜI THẦU</a></li>
        <li><a href="{{route('connect.business.view',5)}}">THÔNG BÁO CHÀO GIÁ</a></li>
        <li><a href="{{route('connect.business.view',6)}}">THÔNG TIN CHO NHÀ THẦU</a></li>
      </ul>
    </li>
    <li>
      <a href="/connect-bussinesses/view">HÃNG HÀNG KHÔNG</a>
      <ul class="submenu">
        <li><a href="/airlines/domestic">Hãng Hàng Không Nội Địa</a></li>
        <li><a href="/airlines/international">Hãng Hàng Không Quốc Tế</a></li>
      </ul>
    </li>
    <li><a href="/flights">CHUYẾN BAY</a></li>
    <li>
      <a href="/passengers-services">DỊCH VỤ HÀNH KHÁCH</a>
      <ul class="submenu">
        <li><a href="/services/lounges">Phòng Chờ</a></li>
        <li><a href="/services/assistance">Hỗ Trợ Đặc Biệt</a></li>
      </ul>
    </li>
    <li><a href="/airport-access">TRUY CẬP SÂN BAY</a></li>
    <li>
      <a href="/shop-and-dine">MUA SẮM & ẨM THỰC</a>
      <ul class="submenu">
        <li><a href="/shop">Mua Sắm</a></li>
        <li><a href="/dine">Ẩm Thực</a></li>
      </ul>
    </li>
    <li><a href="/about-us">VỀ CHÚNG TÔI</a></li>
    <li><a href="/map">BẢN ĐỒ</a></li>
  </ul>
</nav>
      
      <!-- Right Side Elements -->
      <div class="header-right">
        <!-- Language Selector -->
        <div class="language-selector">
          <button class="lang-btn">VN <span class="arrow-down"></span></button>
        </div>
        
        <!-- Search Button -->
        <div class="search-button">
          <button><span class="search-icon"></span></button>
        </div>
      </div>
    </div>
  </div>
</header>