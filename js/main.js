try {
  const navItem = document.querySelector(".nav__items"); // Lấy phần tử có class là "nav__items", thường là một danh sách các mục trong menu điều hướng.
  const openNavBtn = document.querySelector("#open__nav-btn"); // Lấy phần tử có ID là "open__nav-btn", thường là nút mở menu.
  const closeNavBtn = document.querySelector("#close__nav-btn"); // Lấy phần tử có ID là "close__nav-btn", thường là nút đóng menu.

  // Hàm mở menu điều hướng
  const openNav = () => {
    navItem.style.display = "flex"; 
    openNavBtn.style.display = "none"; 
    closeNavBtn.style.display = "inline-block"; 
  };

  // Hàm đóng menu điều hướng
  const closeNav = () => {
    navItem.style.display = "none"; 
    openNavBtn.style.display = "inline-block"; 
    closeNavBtn.style.display = "none"; 
  };

  // Thêm sự kiện "click" cho nút mở menu, khi người dùng nhấn, menu sẽ mở
  openNavBtn.addEventListener("click", openNav);
  
  // Thêm sự kiện "click" cho nút đóng menu, khi người dùng nhấn, menu sẽ đóng
  closeNavBtn.addEventListener("click", closeNav);
} catch (error) {
  // Bắt lỗi nếu có bất kỳ lỗi nào trong quá trình thực thi các đoạn mã trên
  // console.error("Error occurred in toggle functionality:", error);
}

if (window.innerWidth <= 600) // Kiểm tra nếu kích thước của cửa sổ trình duyệt nhỏ hơn hoặc bằng 600px (thường là thiết bị di động)
  try {
    const sidebar = document.querySelector("aside"); // Lấy phần tử "aside" (sidebar) từ trang.
    const showSidebarBtn = document.querySelector("#show__sidebar-btn"); // Lấy phần tử có ID là "show__sidebar-btn", nút để hiển thị sidebar.
    const hideSidebarBtn = document.querySelector("#hide__sidebar-btn"); // Lấy phần tử có ID là "hide__sidebar-btn", nút để ẩn sidebar.

    // Hàm hiển thị sidebar
    const showSidebar = () => {
      sidebar.style.left = "0"; 
      showSidebarBtn.style.display = "none"; 
      hideSidebarBtn.style.display = "inline-block"; 
    };

    // Hàm ẩn sidebar
    const hideSidebar = () => {
      sidebar.style.left = "-100%"; 
      showSidebarBtn.style.display = "inline-block"; 
      hideSidebarBtn.style.display = "none"; 
    };

    // Thêm sự kiện "click" cho nút hiển thị sidebar, khi người dùng nhấn, sidebar sẽ được hiển thị
    showSidebarBtn.addEventListener("click", showSidebar);

    // Thêm sự kiện "click" cho nút ẩn sidebar, khi người dùng nhấn, sidebar sẽ bị ẩn
    hideSidebarBtn.addEventListener("click", hideSidebar);

    window.onload = showSidebar; // Khi trang web được tải, tự động hiển thị sidebar
  } catch (error) {
    // Bắt lỗi nếu có bất kỳ lỗi nào trong quá trình thực thi các đoạn mã trên
    // console.error("Error occurred in sidebar functionality:", error);
  }
