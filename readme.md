
# Miny2

## Cài đặt

1. Clone Project từ Repository 

    `git clone git@gitlab.com:vnp-education/miny-beta.git`
    
    (Nếu là lần đầu sử dụng Gitlab, lưu ý để Clone hoặc Pull Request từ Gitlab cần [tạo SSH Keys](https://gitlab.com/help/ssh/README) trước tiên)

    Fetch về dữ liệu của tất cả các branch của repository trên remote server:  

    `git fetch origin`

    Trên local chuyển về nhánh develop và pull về nhánh develop tương ứng trên remote

2. Cài đặt các thư viện sử dụng trong Project

    `composer install` 
    
    Composer sẽ kiểm tra file `composer.json` được đẩy lên  và cài đặt tất cả các packages cần thiết
    
    `npm install`
    
    Tương tự như Composer, npm (Node Package Manager) sẽ đọc file `package.json` để cài đặt các packages Node cần thiết
    
3. Tạo file `.env`  

    File `.env` không được commit lên Git, file `.env.example` là một  của file `.env`, do vậy ta tạo file `.env` bằng cách copy file `.env.example` trên terminal, ta dùng lệnh: 
    
    `cp .env.example .env`

    Tạo một Database trong phpmyadmin và cấu hình lại file `.env` vừa tạo (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, ...) để kết nối với Database
    
4. Tạo khoá mã hoá
    
    Laravel yêu cầu phải có một khóa mã hóa ứng dụng thường được tạo và lưu trữ ngẫu nhiên trong file `.env`. Ứng dụng sẽ sử dụng khóa mã hóa này để mã hóa các yếu tố khác nhau từ cookie đến hash mật khẩu và hơn thế nữa.
    
    Trong terminal, ta dùng lệnh: `php artisan key:generate`

5. Compile Resources

    Laravel sẽ không đọc scss, javascript, ảnh hay font trong thư mục resources, ta cần biên dịch lại sang thư mục public, trong terminal, dùng lệnh:
    
    `npm run dev`
    
6. Database

    Tạo database theo cấu trúc được thiết kế dành cho Project, sử dụng Migration và Seeds của Laravel
    
    `php artisan migrate`
    
    `php artisan db:seed`
    
    
##### ***Về cơ bản đã xong, giờ hãy chạy thử và tìm hiểu Project***