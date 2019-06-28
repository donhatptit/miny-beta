var id = "#check_title";
let arr_uppercase = [ 'Sách Giáo Khoa', 'Sách giáo Khoa', 'sách giáo khoa', 'sách Giáo Khoa','sách Giáo khoa', 'vật lý', 'Vật Lý', 'Vật lý', 'vật Lý', 'vật lí', 'Vật Lí', 'vật Lí', 'Hóa Học', 'hóa học', 'hóa Học', 'Ngữ Văn', 'ngữ văn', 'ngữ Văn', 'Tiếng Anh', 'tiếng Anh', 'tiếng anh', 'Sinh Học', 'sinh Học', 'sinh học', 'Lịch Sử', 'lịch Sử', 'lịch sử', 'địa lý', 'Địa Lý', 'địa Lý', 'địa lí', 'Địa Lí', 'địa Lí', 'tin học', 'Tin Học', 'tin Học', 'sách bài tập', 'Sách Bài tập', 'Sách Bài Tập', 'Sách bài Tập','SGK','sgk','Sgk','hóa','toán','sinh'
];
$(id).blur(function () {
    let val_input = $(id).val();
    let status = $('#status');
    $('#mesage').html("");
    status.val(0);
    if(val_input!== ''){
        check_title_uppercase(val_input);
        check_sbt(val_input);
        check_subject_chemical(val_input);
        check_subject_biology(val_input);
        check_space(val_input);
        check_first_uppercase(val_input);
    }

    function check_first_uppercase(title){
        if(!/[A-Z]/.test( val_input[0])){
            $('#mesage').append('<li class="text-bold text-red">' + "Chữ cái đầu tiên của tiêu đề phải được viết hoa " + '</li>');
            status.val(-1);
        }
    }

    function check_title_uppercase(title) {
        for (let i = 0; i < arr_uppercase.length; i++) {
            if (title.search(arr_uppercase[i]) !== -1) {
                $('#mesage').append('<li class="text-bold text-red">' + arr_uppercase[i] + " - Phải viết đúng chuẩn của môn học - Ví dụ : Vật lí , Sách giáo khoa" + '</li>');
                status.val(-1);
                break;
            }
        }
    }

    function check_sbt(title) {
        let sbt = title.search(/(?<=Bài\s+)(\d+\.\d+)(?=\s+)/);
        if (sbt !== -1) {
            let is_sbt = title.search('Sách bài tập');
            if (is_sbt == -1) {
                $('#mesage').append('<li class="text-bold text-red">' + "Có thể bạn đã nhập sai loại sách - Mong đợi : Sách bài tập " + '</li>');
                status.val(-1);
            }
        }
    }

    function check_subject_chemical(title) {
        let chemical = title.search(/Hóa(?=\s+\d+)/);
        if (chemical !== -1) {
            $('#mesage').append('<li class="text-bold text-red">' + "Có thể bạn đã nhập sai môn học - Mong đợi : Hóa học " + '</li>');
            status.val(-1);
        }
    }

    function check_subject_biology(title) {
        let chemical = title.search(/Sinh(?=\s+\d+)/);
        if (chemical !== -1) {
            $('#mesage').append('<li class="text-bold text-red">' + "Có thể bạn đã nhập sai môn học - Mong đợi : Sinh học " + '</li>');
            status.val(-1);
        }
    }

    function check_space(title) {
        let space_char = title.search(/(\w+\-\w+)|(\s+\-(\w+|\d+))|((\w+|\d+)\-\s)/);
        if (space_char !== -1) {
            $('#mesage').append('<li class="text-bold text-red">' + "Dấu " + " '-' " + "phải có dấu khoảng trắng " + '</li>');
            status.val(-1);
        }
    }

})
